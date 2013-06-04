<?
/*
* auteur : ACI
* date : 12/05/2009
*
*/

class search
{
	// CONFIGS
	var $debug; // si true : pn print la requête de count et la requête de recherche
	var $SearchType; // bool ou like, bool effectuera une vértable recherche sémantique via le mode FullText
	var $numRowsSplit; // le nombre de résultats à stocker dans une portion (ie. une page)
	var $tabTablesDug; // les tables qui doivent êtres parcourues. Nom de la table à fouiller = le champ qu'on doit récupérer comme titre de l'item (sera affiché dans le libellé du res)
	var $workflowStatePublished;
	var $typeOfWordsMatching; // or où and :  si plusieurs mots saisis, on les cherche soit en ET doit en OU
	// VARIABLES INTERNES
	var $terms; // la chaine qui a été saisié dans l'input text de recherche
	var $numRows; // le nombre de résultats trouvés
	var $tabResCurrent; // tableau de la portion de résultats
	var $tabFieldsTypeText; // les types de champs à considérer comme contenant du texte
	var $tabTablesFields; // les champs associés aux tables
	var $resultSets; // tous les resultSets renvoyés par les requêtes
	var $tplInstance;
	var $rst; // le resultset de la requête
	function search($_terms){
		$this -> debug = false;
		$this -> numRowsSplit = 2;
		$this -> SearchType = "like";
		$this -> typeOfWordsMatching = "or";
	}
	//-----------------------------------------
	// RENVOIE LES NOMS DE CHAMPS SUCEPTIBLES, DE PAR LEUR TYPE, DE CONTENIR DU TEXTE
	//-----------------------------------------
	function textFields($_tableName){
		$strQuery = "desc ".$_tableName;
		$resSet = mysql_query($strQuery);
		while($row = mysql_fetch_array($resSet)){
			foreach($this -> tabFieldsTypeText as $typeName){
				if(preg_match("/^".$typeName."/",$row['Type'])>0)
				$res[] = $row["Field"];
			}
		}
		return array_unique($res);
	}
	//-----------------------------------------
	// LANCE LA RECHERCHE
	//-----------------------------------------
	function searchProcess($_terms){
		$this -> terms = utf8_decode($_terms);
		$this -> terms = secure($this -> terms);
		$this -> terms = utf8_encode($this -> terms);
		if($this -> terms != ""){
			$this -> searchInit();
			$query = $this -> searchQuery();
			$query .= $this -> limitStr();
			//echo "<hr> " . $query . "<hr> ";
			$this -> rst = mysql_query($query);
			$countToExec = explode("union",$this -> countQuery());
			foreach($countToExec as $quer){
				$rstCount = mysql_query($quer);
				if(eregi("group by",$quer))
				$this -> numRows = $this -> numRows + mysql_num_rows($rstCount);
				else{
					while($r = mysql_fetch_array($rstCount)){
						$this -> numRows += $r[0];
					}
				}
			}
		}
		else{
			$this -> numRows = 0;
		}

		if($this -> debug){
			print "<br>Requete de count : <br>".$this -> countQuery();
			print "<br><br>Requete de recherche : <br>".$query."";
			print "<br><br>Erreurs MySql : <br>".mysql_error()."<br><br>";

		}
		$this -> smartyAssign($this->tplInstance);

	}
	//-----------------------------------------
	// TRAITEMENT DE CONFIGURATIONS
	//-----------------------------------------
	function searchInit(){
		$this -> setFieldsTypeText();
		$this -> checkTablesDug();

		foreach($this -> tabTablesDug as $tableName=>$fieldAsTitle)
		$this -> tabTablesFields[$tableName] = implode(",",$this -> textFields($tableName));

	}
	//--------------------------------------------------------
	//  TESTE l'EXISTENCE DES TABLES MENTIONNEES
	//	ET CORRIGE LE TABLEAU tabTablesDug LE CAS ECHEANT
	//--------------------------------------------------------
	function checkTablesDug(){
		global $BaseName;
		$query = "show tables from ".$BaseName;
		$rst = mysql_query($query);
		while($row = mysql_fetch_array($rst))
		$a_tablesInDB[] = $row[0];
		foreach($this -> tabTablesDug as $tableName=>$fieldAsTitle)
		if(in_array($tableName,$a_tablesInDB))
		$a_tablesToDig[$tableName] = $fieldAsTitle;
		$this -> tabTablesDug = $a_tablesToDig;
	}
	//-----------------------------------------
	// DEFINITIION DES TYPES DE DONNEES QUI DOIVENT ETRE FOUILLES
	//-----------------------------------------
	function setFieldsTypeText(){
		$this -> tabFieldsTypeText[]="varchar";
		$this -> tabFieldsTypeText[]="tinytext";
		$this -> tabFieldsTypeText[]="text";
		$this -> tabFieldsTypeText[]="mediumtext";
		$this -> tabFieldsTypeText[]="longtext";
	}
	//-----------------------------------------
	// CONSTRUCTION DE LA REQUETE
	//-----------------------------------------
	function searchQuery(){
		foreach($this -> tabTablesFields as $tableName=>$fields){
			/*
			* TABLES DE NAV
			*/
			if($tableName == "trad__nav" && strpos($fields,",")!== false){
				$tmp = "
 				select id_".$tableName.",".$tableName.".".$this -> tabTablesDug[$tableName].",'void',id___nav 
 				from ".$tableName.", _nav   INNER JOIN _nav ON (trad__nav.id___nav = _nav.id__nav AND _nav.id__nav_pere != 1 and _nav.selected=1) WHERE ".$tableName.".id__langue = ".$_SESSION['ses_langue']. " and ".$tableName.".id___nav = _nav.id__nav and _nav.selected=1 and ";
				$tmp .= "(";
				$arrTmp = "";
				foreach(explode(",",$fields) as $fieldName){
					$fieldName = $tableName.".".$fieldName;
					$arrTmp[] = "(".$this -> compareStructure($fieldName,$this -> terms).")";
				}
				$tmp .= implode("or",$arrTmp).")";
				$tmp .= " group by id___nav";

				$queries[] = $tmp;
			}
			/*
			* TABLES DE CONTENU
			*/
			elseif (preg_match("/^gab_/",$tableName)>0 || preg_match("/^gabarit_/",$tableName)>0 || preg_match("/^editorial_/",$tableName)>0 ) { // && strpos($fields,",")!==false
				// ses_langue
				$tmp = "
 				select id_".$tableName.",".$this -> tabTablesDug[$tableName].",o.id__object,o.id__nav 
 				from ".$tableName."
 				LEFT join _object o on $tableName.id_$tableName = o.item_table_ref_req 
 				INNER JOIN _nav ON (o.id__nav = _nav.id__nav AND _nav.id__nav_pere!=1 and _nav.selected=1) 
 				WHERE o.table_ref_req = '".$tableName."' and o.id__workflow_state = '".$this -> workflowStatePublished."' and o.id__langue = ".$_SESSION['ses_langue']." and ";
				$tmp .= "(";
				$arrTmp = "";
				foreach(explode(",",$fields) as $fieldName){
					$fieldName = $tableName.".".$fieldName;
					$arrTmp[] = "(".$this -> compareStructure($fieldName,$this -> terms).")";
				}
				$tmp .= implode("or",$arrTmp).")";
				$tmp .= " group by id__nav";
				
				
				$tmp = str_replace("gab_texte_riche.gab_texte_riche","gab_texte_riche.texte",$tmp);
				$queries[] = $tmp;
			}
			/*
			* TABLES SPECIFIQUES
			* elseif(strpos($fields,",")!=false){
			*/
			else{
				$tmp = "
 				select id_".$tableName.",".$this -> tabTablesDug[$tableName].", '$tableName' , 'void'
 				from ".$tableName;

				if ($tableName == "trad__nav"){
					$tmp .=" INNER JOIN _nav ON (trad__nav.id___nav = _nav.id__nav AND _nav.id__nav_pere != 1 and _nav.id__nav!=1 and _nav.selected=1) ";
				}

				if(in_array($tableName,$GLOBALS["_NAME_TABLE_SEJOUR"])){
					$tmp .= " inner join centre on (centre.id_centre = $tableName.id_centre and centre.etat=1)";
				}
				
				
				if(in_array($tableName,$GLOBALS["_NAV_TRAD_SEJOUR_TABLE"])){
					$table=str_replace("trad_","",$tableName);
					$tmp .= " inner join  $table on ($table.id_$table = $tableName.id__$table and $table.etat=1 and $tableName.id__langue=".$_SESSION["ses_langue"].")";
					$tmp .= " inner join centre on ($table.id_centre=centre.id_centre and centre.etat=1) ";
				}
				
				
				
				
				$tmp .=" where ";

				
				if(in_array($tableName,$GLOBALS["_NAME_TABLE_SEJOUR"])){
					$tmp .= " $tableName.etat=1 and ";
				}
				
				if($tableName == "centre"){
					$tmp .= " $tableName.etat=1 and ";
				}
				
				
				
				
				if (preg_match("/^trad_/",$tableName)>0){
					$tmp .=" id__langue=".$_SESSION["ses_langue"]." and ";
				}

				$tmp .= "(";
				$arrTmp = "";
				foreach(explode(",",$fields) as $fieldName){
					$fieldName = $tableName.".".$fieldName;
					$arrTmp[] = "(".$this -> compareStructure($fieldName,$this -> terms).")";
				}
				$tmp .= implode("or",$arrTmp).")";

        if(in_array($tableName,$GLOBALS["_NAV_TRAD_SEJOUR_TABLE"]) || in_array($tableName,$GLOBALS["_NAME_TABLE_SEJOUR"])){
					$tmp .= " or (centre.ville like '%".$this -> terms."%')";
				}
				/*
				echo "<br> *******table_name = ". $tableName;
				echo "<br> *******tabTablesDug[tableName] = " . $this -> tabTablesDug[$tableName];
				echo "<br> *******req = " . $tmp;
				*/

				
				$queries[] = $tmp;

			}

		}
		
		//echo implode(" union ",$queries);
		//echo "<br><br>------------------------------------------------<br><br>";
		return implode(" union ",$queries);

	}

	//-----------------------------------------
	// CONSTRUCTION DE LA REQUETE POUR CALCUL DU TOTAL GLOBAL DE RESULTATS
	//-----------------------------------------
	function countQuery(){
		$arr = explode("union",$this -> searchQuery());
		foreach($arr as $quer){
			$quer = str_replace("\t"," ",$quer);
			$quer = str_replace("\r"," ",$quer);
			$quer = str_replace("\n"," ",$quer);
			$quer = substr($quer,strpos($quer," from "),strlen($quer));
			$quer = "select count(*) ".$quer;
			$querCount[] = $quer;
		}

		return implode(" union ",$querCount);
	}
	//-----------------------------------------
	// CONSTRUCTION REQUETE : RENVOIE LES EXPRESSIONS EN LIKE
	//-----------------------------------------
	function compareStructure($_field,$_terms){
		//$a_words = explode(" ",$_terms);
		//foreach($a_words as $word)
		$word=$_terms;
		$ret[] = $this -> likeStucture($_field,$word);
		$ret = implode(" ".$this -> typeOfWordsMatching." ",$ret);
		return $ret;
	}
	//-----------------------------------------
	// CONSTRUCTION REQUETE : RENVOIE LES EXPRESSIONS EN LIKE
	//-----------------------------------------
	function likeStucture($_field,$_word){
		// $words = str_replace(" ","%",$_word);
		$str[] = $_field." like \"".$_word."\"";
		$str[] = $_field." like \"".$_word."%\"";
		$str[] = $_field." like \"%".$_word."\"";
		$str[] = $_field." like \"%".$_word."%\"";
		return implode(" or ",$str);
	}
	//-----------------------------------------
	// PAGINATION : CONSTRUCTION DE LA PARTIE "LIMIT"
	//-----------------------------------------
	function limitStr(){
		$start = secure(($_REQUEST["currentPage"]-1)*_MOTEUR_ITEMS_BY_PAGE); //$_REQUEST["start"]
		if($start < 1)
		$start = 0;
		return " LIMIT ".$start.",".$this -> numRowsSplit;
	}
	//-----------------------------------------
	// PAGINATION : RENVOIE LES NUMEROS DE PAGE ET LEUR PARAMETRE
	//-----------------------------------------
	function pagination(){
		$numPage = $this -> numRows / $this -> numRowsSplit;
		$newStart = 0;
		for($i=0;$i<$numPage;$i++){
			$arr[$i] = $newStart;
			$newStart = $newStart + $this -> numRowsSplit;
		}
		return $arr;
	}
	//-----------------------------------------
	// SMARTY : ASSIGNATION DES VARIABLES
	//-----------------------------------------
	function smartyAssign($_tplInstance){
		global $$_tplInstance;
		$this -> tplInstance = $_tplInstance;
		$$_tplInstance -> assign("numRows",$this -> numRows);

		while($row=mysql_fetch_array($this -> rst)){
			$content="";
			$table="";
			$url="";
			$libelle="";
$erreur = 0;
			//trace($row);
			//echo $this -> nameBuilder($row)."<br>";
			if( is_numeric($this -> nameBuilder($row)) ){
				$libelle = GetCentreName($this -> nameBuilder($row));
			}else{
				$libelle = $this -> nameBuilder($row);
			}
			
			
			/*if($row[2] == "classe_decouverte"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
						
			}*/
                        if($row[2] == "trad_classe_decouverte" || $row[2] == "classe_decouverte"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				$sqlTable = "classe_decouverte";
				$sql_S = "	SELECT 
								$sqlTable.id_centre,
								$sqlTable.nom as libelle,
								$sqlTable.etat 
							FROM 
								$sqlTable 
							INNER JOIN 
								trad_$sqlTable ON (	trad_$sqlTable.id__langue=".$_SESSION["ses_langue"]." AND 
													trad_$sqlTable.id__$sqlTable=".$row[1]." AND 
													trad_$sqlTable.id__$sqlTable=$sqlTable.id_$sqlTable)";
				$result_S = mysql_query($sql_S);
				$libelle = mysql_result($result_S,0,'libelle');
				//$libelle = GetCentreName(mysql_result($result_S,0,'id_centre'));
                                
                                if(mysql_result($result_S,0,'etat') != 1 ){
					$erreur = 1;
				}
			
			}
			/*elseif($row[2] == "cvl"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}*/
			elseif($row[2] == "trad_cvl" || $row[2] == "cvl"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);	
				
			}
			elseif($row[2] == "accueil_groupes_scolaires"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}
			elseif($row[2] == "accueil_reunions"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}
			/*elseif($row[2] == "seminaires"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}*/
			elseif($row[2] == "trad_seminaires" || $row[2] == "seminaires"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}
			elseif($row[2] == "accueil_groupes_jeunes_adultes"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}
			/*elseif($row[2] == "sejours_touristiques"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}*/
			elseif($row[2] == "trad_sejours_touristiques" || $row[2] == "sejours_touristiques"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				$sql_S = "	SELECT 
								sejours_touristiques.id_centre ,
								 trad_sejours_touristiques.nom_sejour as libelle
						
							FROM 
								sejours_touristiques 
							INNER JOIN 
								trad_sejours_touristiques ON (	trad_sejours_touristiques.id__langue=".$_SESSION["ses_langue"]." AND 
																trad_sejours_touristiques.id__sejours_touristiques=".$row[1]." AND 
																trad_sejours_touristiques.id__sejours_touristiques=sejours_touristiques.id_sejours_touristiques)";
				$result_S = mysql_query($sql_S);
				
				
				$libelle = mysql_result($result_S,0,'libelle');
				//$libelle = GetCentreName(mysql_result($result_S,0,'id_centre'));
			
			}
			/*elseif($row[2] == "stages_thematiques_groupes"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}*/
			elseif($row[2] == "trad_stages_thematiques_groupes" || $row[2] == "stages_thematiques_groupes"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				$sqlTable = "stages_thematiques_groupes";
				$sql_S = "	SELECT 
								$sqlTable.id_centre ,
								trad_$sqlTable.nom_stage
							FROM 
								$sqlTable 
							INNER JOIN 
								trad_$sqlTable ON (	trad_$sqlTable.id__langue=".$_SESSION["ses_langue"]." AND 
													trad_$sqlTable.id__$sqlTable=".$row[1]." AND 
													trad_$sqlTable.id__$sqlTable=$sqlTable.id_$sqlTable)";
				$result_S = mysql_query($sql_S);
				//$libelle = GetCentreName(mysql_result($result_S,0,'id_centre'));
				$libelle = mysql_result($result_S,0,'libelle');
				
				
			}
			elseif($row[2] == "accueil_individuels_familles"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}
			/*elseif($row[2] == "short_breaks"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				
			}*/
			elseif($row[2] == "trad_short_breaks" || $row[2] == "short_breaks"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				$sqlS = "select etat from $table where id_$table = ".$row[0];
				$resultS = mysql_query($sqlS);
				$etat = mysql_result($resultS,0,"etat");
				if($etat != 1){
					$erreur = 1;
				}
			}
			/*elseif($row[2] == "stages_thematiques_individuels"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
			
			}*/
			elseif($row[2] == "trad_stages_thematiques_individuels" || $row[2] == "stages_thematiques_individuels"){
				$table = GetTableName(_NAV_SEJOUR);
				$content = GetCOntentSejour($row[2],$row[0]);
				$sqlTable = "stages_thematiques_individuels";
				$sql_S = "	SELECT 
								$sqlTable.id_centre ,
								trad_$sqlTable.nom as libelle
							FROM 
								$sqlTable 
							INNER JOIN 
								trad_$sqlTable ON (	trad_$sqlTable.id__langue=".$_SESSION["ses_langue"]." AND 
													trad_$sqlTable.id__$sqlTable=".$row[1]." AND 
													trad_$sqlTable.id__$sqlTable=$sqlTable.id_$sqlTable)";
				$result_S = mysql_query($sql_S);
				//$libelle = GetCentreName(mysql_result($result_S,0,'id_centre'));
				$libelle = mysql_result($result_S,0,'libelle');
			}
			elseif($row[2] == "trad__nav" || is_numeric($row[2])){
				$table = GetTableName($row[0],"nav",$row[3]);

                                // GPE - 2011-02-28
                                // Ne pas afficher les pages issues de l'Espace membre dans le résultats de recherche
                                if( $table == 'Espace membres')
                                    continue;

				$content = GetCOntentSejour($row[2]);
				
			}
			elseif($row[2] == "centre"){
                                $libelle = GetCentreName($row["id_centre"]);
				$content = GetCOntentCentre($row[0]);
				$table = get_nav(_NAV_DESTINATIONS);
				
			}
			elseif($row[2] == "trad_centre"){
				$libelle = GetCentreName($row[1]);
				$content = GetCOntentCentre($row[1]);
				$table = get_nav(_NAV_DESTINATIONS);
				$url   = get_url_nav_centre(_NAV_FICHE_CENTRE,$row[1]);
			}
elseif($row[2] == "trad_actualite"){
	
				$table = get_nav(_NAV_ACTUALITE);
				
			}
			elseif($row[2] == "trad_bon_plan"){
	
				$table = get_nav(_NAV_BON_PLAN);
			}
			else{
				$table 		= $this -> TableBuilder($row);
				$content 	= $this -> contentBuilder($row);
			}
			
						
			if($url==""){
				
				$url 		= $this -> urlBuilder($row);
			}
			$libelle = coupe_espace(html_entity_decode(strip_tags($libelle)),150);
		if($erreur != 1){
			$items[] = array("table"=>$table,"libelle"=>$libelle,"url"=>$url,"content"=>$content);
		}
}

	   // trace($items);
		$NewItems = sort_by_key($items, "table");
		//trace($items);
		$NewItems_S = DelDoublonNomTable($NewItems);
		
		$nbItem = count($NewItems_S);
		
		
		$$_tplInstance -> assign("nbitems",$nbItem);
		$$_tplInstance -> assign("items",$NewItems_S);
	}
	//-----------------------------------------
	// CONSTRUCTION DES NOMS
	//-----------------------------------------
	function nameBuilder($_rstRow){
		if(function_exists(triggerNameBuilder))
		return triggerNameBuilder($_rstRow);
		else{
			// si il y a un id__nav : on est dans une table gabarit ou nav
			if($_rstRow[3] != "void"){
				if($_rstRow[1] != "")
				return $_rstRow[1];
				else
				return get_trad_nav($_rstRow[3]);
			}
			// si on est dans une table spécifiques
			else
			{
				if($_rstRow[1] != "")
				{//
					return $_rstRow[1];
				}
				else
				{
					$nom = nameSejour($_rstRow);
				  if($nom == ""){
            return "Voir ce rÃ©sultat";
          }else{
            return $nom;
          }
				}
			}
		}
	}
	//-----------------------------------------
	// CONSTRUCTION DES URLS
	//-----------------------------------------
	function TableBuilder($_rstRow){
		if(function_exists(triggerTableBuilder))
		return triggerTableBuilder($_rstRow);
		else{
			// si il y a un id__nav : on est dans une table gabarit ou nav
			if($_rstRow[3] != "void"){
				return $_rstRow[3];
			}
			// si on est dans une table spécifiques
			else
			return ""; //"./"
		}

	}
	//-----------------------------------------
	// CONSTRUCTION DES Libelle Table
	//-----------------------------------------
	function urlBuilder($_rstRow){
		if(function_exists(triggerUrlBuilder))
		return triggerUrlBuilder($_rstRow);
		else{
			// si il y a un id__nav : on est dans une table gabarit ou nav
			if($_rstRow[3] != "void"){
				return get_url_nav($_rstRow[3]);
			}
			// si on est dans une table spécifiques
			else
			return ""; //"./"
		}
	}
	//-----------------------------------------
	// CONSTRUCTION DES APERCUS DU TEXTE
	//-----------------------------------------
	function contentBuilder($_rstRow){
		
		if(function_exists(contentBuilder)){
			return contentBuilder($_rstRow);
		}else{
			// si il y a un id__nav : on est dans une table gabarit ou nav
			if($_rstRow[3] != "void"){
				return "";
			}
			// si on est dans une table spécifiques
			else
			return "";
		}


	}

	function getnumRows()
	{
		return $this->numRows;
	}
};
?>
