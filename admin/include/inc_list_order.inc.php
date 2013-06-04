<?
	global $BaseName;
	// *** REQUETTE POUR LA SUPPRESSION MASSIVE
	// *** API 26/05/05
	
	
	if (isset($_REQUEST['MD']) && $_REQUEST['MD']==1) 
	{
		$RS_liste = mysql_query($_REQUEST['deleteQuery']);
		for($i=0;$i<mysql_num_rows($RS_liste);$i++) 
		{
			if ($_REQUEST['supress_'.mysql_result($RS_liste,$i,0)]==1) 
			{
				// *** => type 3
				if ($CurrentTableName=='_object') 
				{
                                    $delete_ID = mysql_result($RS_liste,$i,0);

					//GESTION DU FILTRE SUR L'ID SELECTIONNE EN MODE MODIF OU SUPPR
					if ($delete_ID) {
				
						$StrSQLGroup = "select o1.id__object, o1.item_table_ref_req, o1.table_ref_req from _object o1 inner join _object o2 on o1._group_gab_id = o2._group_gab_id and o2.id__object = ".$delete_ID;	
						
					}

					$resultGroup = mysql_query($StrSQLGroup);
					
					$index = 0;
					$group_gab = "";
					$group_obj = "";
					while ($myrow = mysql_fetch_array($resultGroup))
					{
						if ($index != 0)
						{
							$group_gab.= ",";
							$group_obj.= ",";
						}
						
						$group_gab.=$myrow["item_table_ref_req"];
						$group_obj.=$myrow["id__object"];
						$index += 1;
					}

					if ($group_gab && $group_obj) 
					{
						
						
						$chaine = "delete from ".mysql_result($resultGroup,0,2)." where id_".mysql_result($resultGroup,0,2)." in (".$group_gab.")";
	
						
	
						$RS_suppress = mysql_query($chaine);

						$chaine = "delete from _object where id__object in (".$group_obj.")";
						
						
						
						
					}


				
				}
				// *** => type 2
				else
				{
					//VF si la table de traduction existe
					$str_check_trad = "SHOW TABLES from ".$BaseName;
					
					$rst_check_trad = mysql_query($str_check_trad);
					$nb_tables = mysql_num_rows($rst_check_trad);
					$check_trad = false;
					
					for ($k=0; $k < $nb_tables; $k++)
					{
						if (mysql_result($rst_check_trad,$k) == _CONST_BO_PREFIX_TABLE_TRAD.$CurrentTableName) 
						{
							$check_trad = true;
						}
					}

					if($check_trad)
					{
						$chaine = "delete t,td from ".$CurrentTableName." as t INNER JOIN "._CONST_BO_PREFIX_TABLE_TRAD.$CurrentTableName." as td ON td.id__".$CurrentTableName."=t.id_".$CurrentTableName;
						$chaine .= " where t.id_".$CurrentTableName."=".mysql_result($RS_liste,$i,0);
						
					}
					else
					{
						$chaine = "delete from ".$CurrentTableName." where id_".$CurrentTableName."=".mysql_result($RS_liste,$i,0);
					}
				}
				$RS_suppress = mysql_query($chaine);
			}
		}
	}
	// *** FIN REQUETTE

	if (empty($mode)) 
	{ 
		//Requete pour l'affichage de la liste
		//requete
		$StrSQL = $SelectListe.$SQLBody;
	}
	else //Requet pour la modification
	{ 
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 1) {
			$StrSQL = $SelectUpdateInsert.$SQLBody;
		}
		else {
			$StrSQL = $SelectModifAjout.$SQLBody;
			$StrSQLBis = $SelectUpdateInsert.$SQLBody;            
		}
		
		//Pour les types 3 (contenu), on fait la jointure sur object et langue
    if ($object_type==3 || $CurrentTableName=='_object')
    {
        $StrSQL .= " inner join _object on _object.item_table_ref_req=".$CurrentTableName.".id_".$CurrentTableName." and _object.id__table_def = ".$TableDef;
        $StrSQL .= " inner join _langue on _langue.id__langue = _object.id__langue";
    } 
	}

	//GESTION DE LA RECHERCHE PAR MOTS CLEFS
	//Si pas de * dans la clause select
	if ($Search && !ereg("\*",$SelectListe) && empty($mode)) 
	{
		$TFields = split(",",eregi_replace("^Select", "", trim($SelectListe)));
		for ($j=0; $j<count($TFields); $j++) 
		{
			if (ereg("as",$TFields[$j])) 
			{
				$pos = strpos($TFields[$j],"as");
				$field_recherche = substr($TFields[$j],0,$pos);
			}
			else
			{
				$field_recherche = $TFields[$j];
			}
			$SearchCriterias[] = $field_recherche." like('%".$Search."%')";
		}
		$SearchCriteria = join($SearchCriterias," or ");

//		 Correcs LAC : parenthese fermante a la fin de la requete
//		if (eregi("where", $StrSQL)) {
//			$StrSQL .= " and (".$SearchCriteria.")";
//		}
//		else {
//			$StrSQL .= " where (".$SearchCriteria.")";
//		}

		if (eregi("where", $StrSQL)) 
		{
			$StrSQL .= " and (".$SearchCriteria;
		}
		else 
		{
			$StrSQL .= " where (".$SearchCriteria;
		}
		
	}
	//Avec des * dans la clause  select
	elseif ($Search && ereg("\*",$SelectListe) && empty($mode)) 
	{
		$arr_table_form = split(",",eregi_replace("from","",$SQLBody));

		for ($i=0;$i<count($arr_table_form) ;$i++) 
		{

			$str_search = "show fields from ".$arr_table_form[$i];
			$rst_seach = mysql_query($str_search);

			for ($s=0;$s < mysql_num_rows($rst_seach) ; $s++) {
				if(isMultiLingue(@mysql_result($rst_seach,$s,"Field"),$TableDef))
				{
					$SearchCriterias[] = "id_".trim($arr_table_form[$i])." in (SELECT distinct id__".trim($arr_table_form[$i])." FROM "._CONST_BO_PREFIX_TABLE_TRAD.trim($arr_table_form[$i])." WHERE "._CONST_BO_PREFIX_TABLE_TRAD.trim($arr_table_form[$i]).".".@mysql_result($rst_seach,$s,"Field")." like('%".$Search."%') AND id__langue=".$_SESSION['ses_langue'].")";
				}
				else
				$SearchCriterias[] = trim($arr_table_form[$i]).".".@mysql_result($rst_seach,$s,"Field")." like('%".$Search."%')";
			}
		}

		$SearchCriteria = join($SearchCriterias," or ");
		
//		 Correcs LAC : parenthese fermante a la fin de la requete
//		if (eregi("where", $StrSQL)) {
//			$StrSQL .= " and (".$SearchCriteria.")";
//		}
//		else {
//			$StrSQL .= " where (".$SearchCriteria.")";
//		}
		
		if (eregi("where", $StrSQL)) 
		{
			$StrSQL .= " and (".$SearchCriteria;
		}
		else 
		{
			$StrSQL .= " where (".$SearchCriteria;
		}
	}

	//GESTION DES FILTRES
	//07/02/2003	
	if (count($_SESSION['ses_filter'])>0 && $EnabledFilter==1  && empty($mode))
	{
		
		$tab_ses_filter_temp = array();
		
		for ($i=$indice_de_depard ; $i < (@count($_SESSION['ses_filter'])+$indice_de_depard); $i++) 
		{
			if (!ereg("^filter_([0-9]*)_null$",$_SESSION['ses_filter'][$i]))
			{
				$tab_ses_filter_temp[] = $_SESSION['ses_filter'][$i];
			}
		}
		
		$str_sql_filter = stripslashes(str_replace("##","\"",join(" and ", $tab_ses_filter_temp)));
		
	//	print_r($tab_ses_filter_temp);
		
		if (count($tab_ses_filter_temp)>0) 
		{	
			if (eregi("where", $StrSQL)) 
			{
				$str_sql_filter = " and (".$str_sql_filter.")";
			}
			else 
			{
				$str_sql_filter = " where (".$str_sql_filter.")";
			}
		}
		
		unset($tab_ses_filter_temp);
		
		$StrSQL .= $str_sql_filter;
		
		$full=0;
	}

	
	
	//On recupere non seulement le gabarit selectionn, mais galement les gabarits de langue diffrente et de meme group id
	if ($object_type==3 || $CurrentTableName=='_object') 
  {
    		
		if ($object_type == 3) 
		{
			$field_id = "item_table_ref_req";
			$gab_field_id = "id_".$CurrentTableName;
		}
		if ($TableDef == 3) 
		{
			$field_id = "id__object";
			$gab_field_id = "item_table_ref_req";
		}
    		
    		
    		

		//GESTION DU FILTRE SUR L'ID SELECTIONNE EN MODE MODIF OU SUPPR
		if ($ID) 
		{
	
			$StrSQLGroup = "select o1.* from _object o1 inner join _object o2 on o1._group_gab_id = o2._group_gab_id and o1.id__table_def = ".$TableDef."  and o2.".$field_id." = ".$ID;	
			
		}
		
		$resultGroup = mysql_query($StrSQLGroup);
		
		$index = 0;
		while ($myrow = mysql_fetch_array($resultGroup))
		{
			if ($index != 0)
			{
				$group.= ",";
			}
			
			$group.=$myrow["item_table_ref_req"];
			$index += 1;
		}
		
		
		if ($group) 
		{
			if (eregi("where", $StrSQL)) 
			{
				$StrSQL .= " and ".$CurrentTableName.".".$gab_field_id." in (".$group.")";	
			}
			else 
			{
				$StrSQL .= " where ".$CurrentTableName.".".$gab_field_id." in (".$group.")";
			}
		}
		
		
	
		
	
	}
	else
	{
		//GESTION DU FILTRE SUR L'ID SELECTIONNE EN MODE MODIF OU SUPPR
		if ($ID) 
		{
			if (eregi("where", $StrSQL)) 
			{
				$StrSQL .= " and ".$CurrentTableName.".id_".$CurrentTableName."=".$ID;
			}
			else 
			{
				$StrSQL .= " where ".$CurrentTableName.".id_".$CurrentTableName."=".$ID;
			}
		}
	}



  //OBJECT
	if ($TableDef==3) 
  {
		//Filtre sur les objets de l'item selectionn
		if ($idItem) 
		{
			if (eregi("where", $StrSQL)) 
			{
		    $StrSQL .= " and "._CONST_BO_CODE_NAME."object.id_"._CONST_BO_CODE_NAME."nav=".$idItem;
			}
			else 
			{
		    $StrSQL .= " where "._CONST_BO_CODE_NAME."object.id_"._CONST_BO_CODE_NAME."nav=".$idItem;
			}
	

			if ($mode!="supr")
			{
	
	    	//GESTION DE LA LANGUE
	      if (isset($_SESSION['ses_langue']) && $_SESSION['ses_langue']) 
	      {
	
	        if (eregi("where", $StrSQL)) {
	            $StrSQL .= " and ";
	        }
	        else {
	            $StrSQL .= " where ";
	        }
	
	        $StrSQL .= _CONST_BO_CODE_NAME."object.id_"._CONST_BO_CODE_NAME."langue = ".$_SESSION['ses_langue'];
	   		}
	        
			}
    }
    elseif($viewTask==1) 
    {
     	//L'utilisateur veux voir les taches en cours !
      if (eregi("where", $StrSQL)) 
      {
      	$StrSQL .= " and ";
      }
      else 
      {
      	$StrSQL .= " where ";
      }
      $StrSQL .= _CONST_BO_CODE_NAME."object.id_"._CONST_BO_CODE_NAME."workflow_state in (".$profil_list_wf_state_allow_in_task.")";
      
      // Modif LAC 23/02/05 : etat publi supprim de la liste des taches en cours.
      // car aucune tache  raliser.. on est en tat principal du WF.
      $StrSQL .= "and "._CONST_BO_CODE_NAME."object.id_"._CONST_BO_CODE_NAME."workflow_state  != "._WF_DISPLAYED_STATE_VALUE;
          
    }

    // on ne veut pas que les users autre que root et admin voient les objets supprims dans la nav courante		
    if ($_SESSION['ses_profil_user']>2)
    {
     	if (eregi("where", $StrSQL)) 
      {
      	$StrSQL .= " and ";
      }
      else 
      {
      	$StrSQL .= " where ";
  		}

     	$StrSQL .= _CONST_BO_CODE_NAME."object.id_"._CONST_BO_CODE_NAME."workflow_state != 9 ";
    }
  }        	    

    //DROIT D'AJOUT D'ELEMENTS DE NAVIGATION
    //30/09/2003

   // modif LAC 18/02. Filtre sur la nav autorise pour ce user qqsoit le type d'objet ! (mais pas en root, et admin)
    // et pas si un mode est positionn : si un mode est positionn, on vient d'une liste dja filtre.
    // donc, on peut tout faire sur l'objet selectionn
    // de plus, fait planter le typeobj=3 si pas de tabledef sur le nav id
    
    //if ($TableDef == 2 && $_SESSION['ses_profil_user']>2) {
    	
	if (($_SESSION['ses_profil_user']>2)&& (((!isset($_REQUEST['mode']))&&($object_type==3))||($_REQUEST['viewTask']==1))) 
	{
        $StrSQL .= "
                    AND
                        "._CONST_BO_CODE_NAME."nav.id_"._CONST_BO_CODE_NAME."nav IN (".$arr_user_right_rub.")
                    ";
  }



		// filtre sur tous les tabledef uniquement sur les langues autoriss par le profil connect
		
		//On regarde si il y a id__langue dans les champs de la table
	$sql_is_id_langue = "SHOW COLUMNS FROM ".$CurrentTableName;
	$rst_is_id_langue = mysql_query($sql_is_id_langue);
	$is_id_langue = false;
	for ($f = 0; $f< mysql_numrows($rst_is_id_langue) && !$is_id_langue; $f++)
	{
		$is_id_langue = eregi("id__langue", mysql_result($rst_is_id_langue, $f, 0));
	}
		
	if ( ($_SESSION['ses_profil_user']!=1) && (!isset($_REQUEST['mode'])) && (eregi("id__langue", $StrSQL) || $is_id_langue) ) // pas pour root
	{
		if (eregi("where", $StrSQL)) 
    {
    	$StrSQL .= " and ";
    }
    else 
    {
    	$StrSQL .= " where ";
  	}
		//$StrSQL.= " id__langue in (".$_SESSION['ses_id_langue_user'].")"; // SBA 07/08/07/
		$StrSQL.= " ( ".$CurrentTableName.".id__langue like '".$_SESSION['ses_langue']."'" ;
		$StrSQL.= " OR ".$CurrentTableName.".id__langue like '%,".$_SESSION['ses_langue'] ."'";
		$StrSQL.= " OR ".$CurrentTableName.".id__langue like '".$_SESSION['ses_langue'] .",%'";
		$StrSQL.= " OR ".$CurrentTableName.".id__langue like '%,".$_SESSION['ses_langue'] .",%' )";
	}


	// LAC : 03/06		
	if (($Search)&&empty($mode)) $StrSQL.=" )";

	// *** SELECTION
	// API : 05/01/2004
	// API : 01/03/2005
	// LAC : 17/12/06 : economise le traitement quand choix "tous" choisi

	if ( ($_REQUEST['formMain_selection'] != -1) && ($_REQUEST['formMain_selection'] != "") )
	{
	$chaine = "select champ_selection from "._CONST_BO_CODE_NAME."select_champ where flag_actif=1 and id_"._CONST_BO_CODE_NAME."table_def=".$TableDef;
	$RSselection = mysql_query($chaine);

		if (mysql_num_rows($RSselection)>0) 
		{
			if ( (!isset($_REQUEST['formMain_selection'])) || ($_REQUEST['formMain_selection']=="") )  // choix "faites votre slection" : on fait planter la requete esqueprs pour ne plus rien avoir dans la liste
			{
				if (eregi("where", $StrSQL)) 
		      {
		      	$StrSQL .= " and ";
		      }
		      else 
		      {
		      	$StrSQL .= " where ";
		     	}
				
				$StrSQL .= " 1=0 ";
			} 
			else 
			{
				if ($_REQUEST['formMain_selection']=="") // choix "faites votre slection"
				{ 
					$_REQUEST['formMain_selection'] = 0;
				}
			
				if ((mysql_result($RSselection,0,"champ_selection")!="")&& empty($mode)) 
				{			
					if (eregi("where", $StrSQL)) 
          {
             $StrSQL .= " and ";
          }
          else 
          {
          	$StrSQL .= " where ";
        	}
			
					$StrSQL .= $CurrentTableName.".".mysql_result($RSselection,0,"champ_selection")."=".$_REQUEST['formMain_selection'];
				}		
			}
		}		
	}

	if (!isset($_REQUEST['mode'])) 
	{
		//GESTION DE L'ORDRE
		if ( isset($_REQUEST['ordre']) && !empty($_REQUEST['ordre']) ) //Gestion de la clause order by des requetes
		{  
		
		  if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE && 
      
            (in_array($_REQUEST["TableDef"],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) ||
            $_REQUEST["TableDef"] == _CONST_TABLEDEF_ACTUALITE ||
            $_REQUEST["TableDef"] == _CONST_TABLEDEF_BON_PLAN)){
            
            
            
        if(stristr($StrSQL, 'where') === FALSE) {
         $StrSQL .= " WHERE ";
        }else{
         $StrSQL .= " AND ";
        }
        $StrSQL .= " id_centre=".$_SESSION["ses_id_centre"]." ";
      }
		
		
		
			$StrSQL .= " order by ".$_REQUEST['ordre']." ".$_REQUEST['AscDesc'];						
		}
    elseif ($_REQUEST['TableDef'] == 3) 
    {
    	$StrSQL .= " order by id_"._CONST_BO_CODE_NAME."workflow_state, ordre Asc ";
		}
    elseif ($TableDef == 3) 
    {
    	$StrSQL .= " order by ordre Asc";
    }
		else //Si pas d'ordre alors on affect l'ordre du premier champs de la clause select par defaut en Asc
		{
		  $ordre="";
		  // FFR on affiche seulement les sjours des centres ----
		  if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE && 
      
            (in_array($_REQUEST["TableDef"],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) ||
            $_REQUEST["TableDef"] == _CONST_TABLEDEF_ACTUALITE ||
            $_REQUEST["TableDef"] == _CONST_TABLEDEF_BON_PLAN)){
            
            
            
        if(stristr($StrSQL, 'where') === FALSE) {
         $StrSQL .= " WHERE ";
        }else{
         $StrSQL .= " AND ";
        }
        $StrSQL .= " id_centre=".$_SESSION["ses_id_centre"]." ";
      }
		  // ------------------------------------------------------
		
			$TabFieldsSelect	= split(",",$SelectListe);
			$ordre			.= trim(eregi_replace("select","",$TabFieldsSelect[0]));

     


			if (eregi("\.\*",$TabFieldsSelect[0])) 
			{
				$ordre = eregi_replace("\.\*","",trim(eregi_replace("select","",$TabFieldsSelect[0]))).".id_".eregi_replace("\.\*","",trim(eregi_replace("select","",$TabFieldsSelect[0])));
				$StrSQL .= " order by ".$ordre." Asc";
			}
			else 
			{
				$StrSQL .= " order by ".$ordre." Asc";
			}

		}

		//Affectation du deuxieme tri pour tuer le ambiguitees entre la requete de la liste et la requete de la modification
		//On aplique tj un deuxieme tri dans la clause order by
		
		//mardi 9 avril 2002 -->$TFromTable	= split(",",$SQLBody);
		//samedi 24 juillet 2004 : correc LAC : where devient , pour le split..
		$SQLBodyTest = eregi_replace("where ",",",$SQLBody);
		$TFromTable	= split(",",$SQLBodyTest);
		$first_table_name	= trim(eregi_replace("from ","",$TFromTable[0]));

		if (count($TFromTable)>1) 
		{
			$StrSQL .= ", ".$first_table_name.".id_".$first_table_name." Asc";
		}
	}
	else
	{
		//Pour les types 3 (contenu), on ordonne par langue
		if ($object_type==3 || $CurrentTableName=='_object') 
		{
			$StrSQL .= " order by _langue._langue_by_default desc, _langue.id__langue Asc";
		}
		else
		{
			$StrSQL .= " order by id_".$CurrentTableName." Asc";
		}
	}
	

	//Methode pouvant afficher LE DESCRIPTIF de la table en cours
	//Cette methode annule tout les traitemnet precedent (ordres, filtres...)
	if ($ShowFields==1) 
	{
		$StrSQL = "Show Fields From ".$first_table_name;
	}

	//Methode pouvant afficher TOUT les enregistements d'une table
	//Cette methode annule tout les traitemnet precedent (ordres, filtres...)
	if ($ShowAllRec==1) 
	{
		$StrSQL = "Select * From ".$first_table_name;
	}	

	
	//==========================================================================================================
	// Correctif TLY => 15/02/2010 => Vrification qu'il existe bien un objet par langue => sinon cration
	//==========================================================================================================
	if($_REQUEST["TableDef"]==3)
	{
		$sql = " SELECT * FROM _object WHERE id__nav='$idItem' ORDER BY _group_gab_id ";
		$rs = mysql_query($sql);
		$_group_gab_id = "";
		$_group_gab_id_tmp = "";
		while ($row = mysql_fetch_array($rs))
		{   	
			$_group_gab_id = $row["_group_gab_id"] ;
	   		if($_group_gab_id_tmp  != $_group_gab_id || $_group_gab_id_tmp == "")
	   		{
	   			//on recupere les elements communs  l'objet qq soit la langue  pour crer le nouvel objet
				$sqlObj = " SELECT * FROM _object WHERE id__nav='$idItem' AND _group_gab_id = '".$_group_gab_id."' ";				
				$rsObj = mysql_query($sqlObj);				
	   			$table_ref_req  = mysql_result($rsObj,0,"table_ref_req");	   			
	   			$id__table_def = mysql_result($rsObj,0,"id__table_def");
	   			$name_req = mysql_result($rsObj,0,"name_req");
	   			$obj_desc = mysql_result($rsObj,0,"description");
	   			$id__workflow_state = mysql_result($rsObj,0,"id__workflow_state");
	   			$obj_ordre = mysql_result($rsObj,0,"ordre");
	   			$id__object_source = mysql_result($rsObj,0,"id__object_source") ;
	   			
	   			$sqlLangues = " SELECT * FROM _langue ORDER BY ordre ";
	   			$rsLangues = mysql_query($sqlLangues);
	   			for($iLangue=0;$iLangue<mysql_num_rows($rsLangues);$iLangue++)
	   			{	
	   				$sqlObj = " SELECT * FROM _object WHERE id__nav='$idItem' AND id__langue = '".mysql_result($rsLangues,$iLangue,"id__langue")."' AND _group_gab_id = '".$_group_gab_id."' ";
	   				$rsObj = mysql_query($sqlObj);
	   				if(mysql_num_rows($rsObj)==0)
	   				{
	   					//Creation de l objet manquant dans la nouvelle langue
//	   					echo $sqlObj."<br />";
	   					
	   					//bloc d'insertion qui se trouve dans le inc_form_action.inc.php
	   					//Requete d insertion
				         $sqlInsertObj = " INSERT INTO $table_ref_req (id_$table_ref_req) VALUES (NULL) ";
//				         echo $sqlInsertObj."<br />";
		            	 mysql_query($sqlInsertObj);//execution de la requete
				         $item_ref_id = mysql_insert_id();
				         if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQL <br>".mysql_errno() . ": " . mysql_error());
				         			 
			               
			              //----------------------------  	
			                $StrSQLObj = "
	                                INSERT INTO
	                                        "._CONST_BO_CODE_NAME."object
	                                    (
	                                        id_"._CONST_BO_CODE_NAME."table_def,
	                                        name_req,
	                                        description,
	                                        date_create_auto,
	                                        date_update_auto,
	                                        table_ref_req,
	                                        item_table_ref_req,
	                                        id_"._CONST_BO_CODE_NAME."workflow_state,
	                                        id_"._CONST_BO_CODE_NAME."nav,
	                                        id_"._CONST_BO_CODE_NAME."user,
	                                        ordre,
		                                        		id_"._CONST_BO_CODE_NAME."langue,
		                                        		id_"._CONST_BO_CODE_NAME."user_autor,
			                                        		id_"._CONST_BO_CODE_NAME."object_source,
			                                        		_group_gab_id
	                                    )
	                                VALUES
	                                    (
	                                        ".$id__table_def.",
	                                        \"".$name_req."\",
	                                        \"".$obj_desc."\",
	                                        NOW(),
	                                        NOW(),
	                                        \"".($table_ref_req)."\",
	                                        $item_ref_id,
	                                        ".$id__workflow_state.",
	                                        ".$idItem.",
	                                        ".$_SESSION['ses_id_bo_user'].",
	                                        \"".$obj_ordre."\",
	                                        			".mysql_result($rsLangues,$iLangue,"id__langue").",
	                                        			".$_SESSION['ses_id_bo_user'].",
		                                        			\"".($id__object_source)."\",
		                                        			\"".$_group_gab_id."\"
	                                    )
	                             ";
//			            echo $StrSQLObj."<br />";
		                mysql_query($StrSQLObj);
		                if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQLObj<br>".mysql_errno() . ": " . mysql_error());
	   				}
	   			}
	   		}
	   		$_group_gab_id_tmp = $_group_gab_id ;
		}
	}
	//================ FIN CORRECTIF ==============================================
		
  //execution de la requete
  
  //GESTION DE LA RECHERCHE PAR CENTRE  
  
  //Dfinition de l'oprateur utilis pour la reqte
  $operateur = "OR";
  if (isset($_REQUEST['nomCentre']))
  {
  	$searchByCentre = true;
  	
  	$where = "";
  	
  	if ($_REQUEST['nomCentre'] != "")
  		$where .= ($where == "" ? "" : $operateur)." centre.libelle like '%".addslashes($_REQUEST['nomCentre'])."%' ";
    
  	if ($_REQUEST['code_postal'] != "")
  		$where .= ($where == "" ? "" : $operateur)." centre.code_postal = '".addslashes($_REQUEST['code_postal'])."' ";
  		
  	if ($_REQUEST['region'] != "")
  		$where .= ($where == "" ? "" : $operateur)." centre.id_centre_region = '".$_REQUEST['region']."' ";  		

  	//Conditions sur la table centre	
  	$champsCentre = array( "nb_chambre", "nb_lit", "nb_couvert", "nb_salle_reunion", "capacite_salle",
  					"nb_chambre_handicap", "nb_lit_handicap");	
  	foreach ($champsCentre as $champ)
  	{	
	  	if ($_REQUEST[$champ] != "")
	  		$where .= ($where == "" ? "" : $operateur)." centre.".$champ." >= '".$_REQUEST[$champ]."' ";
  	}	

  	//Conditions sur la table centre (checkbox)
  	$champsCheckbox = array( "couvert_assiette", "couvert_self");	
  	foreach ($champsCheckbox as $champ)
  	{	
	  	if ($_REQUEST[$champ] != "")
	  		$where .= ($where == "" ? "" : $operateur)." centre.".$champ." = 1 ";
  	}	  	
  	
  	//Conditions sur les tables lies  centre
  	$champsCentreLiee = array("ambiance", "environnement", "environnement_montagne", "classement",
					 "detention_label", "activite", "service", "espace_detente"); 	
  	foreach ($champsCentreLiee as $champ)
  	{	
	  	if ($_REQUEST[$champ] != "")
			$where .= ($where == "" ? "" : $operateur)." centre.id_centre_".$champ." = ".$_REQUEST[$champ]." ";
  	}					 	
					 	
  	//Ajouter Order BY!!!!!!
  	
  	if ($where != "")
	{
	  	$StrSQL= $SelectListe.$SQLBody;
	  	$StrSQL .= " INNER JOIN centre on ".$CurrentTableName.".id_centre = centre.id_centre ";  	
	  	$StrSQL .= " WHERE ".$where;  	
	}
  	//echo $StrSQL;  
  }
 
  // ------------------
  if($_REQUEST["TableDef"] == _CONST_TABLEDEF_CENTRE  && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE && !isset($_GET["mode"])){
    	$StrSQL = "Select centre.id_centre,centre.libelle,centre.id_centre_ambiance,centre.id_centre_environnement,centre.id_centre_environnement_montagne,centre.ville,centre.fax,centre.id_centre_region,centre.etat From centre where id_centre='".$_SESSION['ses_id_centre']."'";
    	
       if($_REQUEST["ordre"] != ""){
        $StrSQL .=" ORDER BY ".$_REQUEST["ordre"];
      }
    }
  
  
  // ------------------
  
  // ------------------
  if($_REQUEST["TableDef"] == _CONST_TABLEDEF_ORGANISATEUR_CVL  && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE && !isset($_GET["mode"])){
    	$StrSQL = "Select organisateur_cvl.* from organisateur_cvl where id_centre in('".$_SESSION['ses_id_centre']."')";
       if($_REQUEST["ordre"] != ""){
        $StrSQL .=" ORDER BY ".$_REQUEST["ordre"];
      }
  }
  
  
  // ------------------
  
      // ------------------
  if($_REQUEST["TableDef"] == _CONST_TABLEDEF_OFFRE_EMPLOI  && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE && !isset($_GET["mode"])){
    	$StrSQL = "Select offre_emploi.* from offre_emploi where id_centre='".$_SESSION['ses_id_centre']."'";
    	
       if($_REQUEST["ordre"] != ""){
        $StrSQL .=" ORDER BY ".$_REQUEST["ordre"];
      }
    }
  
  
  // ------------------
  
// echo ($StrSQL);
  $result		= mysql_query($StrSQL);
  $result_fieldname	= mysql_query($StrSQLBis);
  if ($result )
  	$nb_cols		= mysql_num_fields($result);
  else
  	$nb_cols = 0;

?>
