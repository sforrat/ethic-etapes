<?
	if (empty($mode)) { //Requete pour l'affichage de la liste
		//requete
		$StrSQL = $SelectListe.$SQLBody;
	}
	else { //Requet pour la modification
		if ($_REQUEST['action'] == 1) {
			$StrSQL = $SelectUpdateInsert.$SQLBody;
		}
		else {
			$StrSQL = $SelectModifAjout.$SQLBody;
			$StrSQLBis = $SelectUpdateInsert.$SQLBody;            
		}
	}

	//GESTION DE LA RECHERCHE PAR MOTS CLEFS
	//Si pas de * dans la clause select
	if ($Search && !ereg("\*",$SelectListe) && empty($mode)) {
		$TFields = split(",",eregi_replace("^Select", "", trim($SelectListe)));
		for ($j=0; $j<count($TFields); $j++) {
				$SearchCriterias[] = $TFields[$j]." like('%".$Search."%')";
		}
		$SearchCriteria = join($SearchCriterias," or ");

		if (eregi("where", $StrSQL)) {
			$StrSQL .= " and (".$SearchCriteria.")";
		}
		else {
			$StrSQL .= " where (".$SearchCriteria.")";
		}
	}
	//Avec des * dans la clause  select
	elseif ($Search && ereg("\*",$SelectListe) && empty($mode)) {
		$arr_table_form = split(",",eregi_replace("from","",$SQLBody));

		for ($i=0;$i<count($arr_table_form) ;$i++) {
			//echo "--".$arr_table_form[$i]."--<br>";

			$str_search = "show fields from ".$arr_table_form[$i];
			$rst_seach = mysql_query($str_search);

			for ($s=0;$s < mysql_num_rows($rst_seach) ; $s++) {
				$SearchCriterias[] = trim($arr_table_form[$i]).".".@mysql_result($rst_seach,$s,"Field")." like('%".$Search."%')";
			}
		}

		$SearchCriteria = join($SearchCriterias," or ");

		if (eregi("where", $StrSQL)) {
			$StrSQL .= " and (".$SearchCriteria.")";
		}
		else {
			$StrSQL .= " where (".$SearchCriteria.")";
		}

	}


//SPECIFIQUE LOISIRS VTT
//06/05/2003
	if ($Search && empty($mode)) {
		$search_marque = "
							SELECT
								*
							FROM
								marque
							WHERE
								marque like(\"%".$Search."%\")
							";
		//echo $search_marque;

		$rst_search_marque = mysql_query($search_marque);
		
		for ($i=0;$i<@mysql_num_rows($rst_search_marque);$i++) {
			$arr_id_marque[] = @mysql_result($rst_search_marque,$i,"id_marque");
		}

		$clause_marque = " or id_marque in (".@join(",",$arr_id_marque).")";

		//echo "<br>".$clause_marque;

		if (count($arr_id_marque)>0) {
			$StrSQL .= $clause_marque;
			$StrSQLBis .= $clause_marque;
		}

		$str_search = "
							SELECT
								*
							FROM
								"._CONST_BO_CODE_NAME."nav
							WHERE
								"._CONST_BO_CODE_NAME."nav like(\"%".$Search."%\")
							";
		//echo $search_marque;

		$rst_search = mysql_query($str_search);
		
		for ($i=0;$i<@mysql_num_rows($rst_search);$i++) {
			$arr_search[] = @mysql_result($rst_search,$i,"id_"._CONST_BO_CODE_NAME."nav");
		}

		$clause_search = " or id_"._CONST_BO_CODE_NAME."nav in (".@join(",",$arr_search).")";

		//echo "<br>".$clause_search;

		if (count($arr_search)>0) {
			$StrSQL .= $clause_search;
			$StrSQLBis .= $clause_search;
		}
	}
//SPECIFIQUE LOISIRS VTT


	//GESTION DES FILTRES
	//07/02/2003
	if (count($_SESSION['ses_filter'])>0 && $EnabledFilter==1  && empty($mode)){
		
		$tab_ses_filter_temp = array();
		
		for ($i=$indice_de_depard ; $i < (@count($_SESSION['ses_filter'])+$indice_de_depard); $i++) {
			if (!ereg("^filter_([0-9]*)_null$",$_SESSION['ses_filter'][$i])){
				$tab_ses_filter_temp[] = $_SESSION['ses_filter'][$i];
			}
		}
		
		$str_sql_filter = str_replace("##","\"",join(" and ", $tab_ses_filter_temp));
		
		if (count($tab_ses_filter_temp)>0) {	
			if (eregi("where", $StrSQL)) {
				$str_sql_filter = " and (".$str_sql_filter.")";
			}
			else {
				$str_sql_filter = " where (".$str_sql_filter.")";
			}
		}
		
		unset($tab_ses_filter_temp);
		
		$StrSQL .= $str_sql_filter;
	}

	
	//echo get_sql_format($StrSQL);


	
	
	
	//GESTION DU FILTRE SUR L'ID SELECTIONNE EN MODE MODIF OU SUPPR
	if ($ID) {
		if (eregi("where", $StrSQL)) {
			$StrSQL .= " and ".$CurrentTableName.".id_".$CurrentTableName."=".$ID;
		}
		else {
			$StrSQL .= " where ".$CurrentTableName.".id_".$CurrentTableName."=".$ID;
		}
	}



	//OBJECT 	
	if ($idItem && $_REQUEST['TableDef']==3) {
		if (eregi("where", $StrSQL)) {
			$StrSQL .= " and "._CONST_BO_CODE_NAME."object.id_"._CONST_BO_CODE_NAME."nav=".$idItem;
		}
		else {
			$StrSQL .= " where "._CONST_BO_CODE_NAME."object.id_"._CONST_BO_CODE_NAME."nav=".$idItem;
		}		
	}	


	if (empty($mode)) {
		//GESTION DE L'ORDRE
		if ($ordre) { //Gestion de la clause order by des requetes
			$StrSQL .= " order by $ordre $AscDesc";
		}
		else {//Si pas d'ordre alors on affect l'ordre du premier champs de la clause select par defaut en Asc
			$TabFieldsSelect	= split(",",$SelectListe);
			$ordre				= trim(eregi_replace("select","",$TabFieldsSelect[0]));

			if (eregi("\.\*",$TabFieldsSelect[0])) {
				$ordre = eregi_replace("\.\*","",trim(eregi_replace("select","",$TabFieldsSelect[0]))).".id_".eregi_replace("\.\*","",trim(eregi_replace("select","",$TabFieldsSelect[0])));
				$StrSQL .= " order by ".$ordre." Asc";
			}
			else {
				$StrSQL .= " order by ".$ordre." Asc";
			}

		}

		//Affectation du deuxieme tri pour tuer le ambiguitees entre la requete de la liste et la requete de la modification
		//On aplique tj un deuxieme tri dans la caluse order by
		
		//mardi 9 avril 2002 -->$TFromTable	= split(",",$SQLBody);
		$SQLBodyTest = eregi_replace("where ","",$SQLBody);
		$TFromTable	= split(",",$SQLBodyTest);
		$first_table_name	= trim(eregi_replace("from ","",$TFromTable[0]));

		if (count($TFromTable)>1) {
			$StrSQL .= ", ".$first_table_name.".id_".$first_table_name." Asc";
		}
	}

	//Methode pouvant afficher LE DESCRIPTIF de la table en cours
	//Cette methode annule tout les traitemnet precedent (ordres, filtres...)
	if ($ShowFields==1) {
		$StrSQL = "Show Fields From ".$first_table_name;
	}

	//Methode pouvant afficher TOUT les enregistements d'une table
	//Cette methode annule tout les traitemnet precedent (ordres, filtres...)
	if ($ShowAllRec==1) {
		$StrSQL = "Select * From ".$first_table_name;
	}

	//execution de la reqete
	$result				= mysql_query($StrSQL);
    $result_fieldname	= mysql_query($StrSQLBis);
    $nb_cols			= @mysql_num_fields($result);

?>
