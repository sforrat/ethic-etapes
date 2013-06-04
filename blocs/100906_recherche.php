<?
/**********************************************************************************/
/*	C2IS : 		ADN INFORMATIQUE				          */
/*	Auteur : 	ACI 							  */
/*	Date : 		JANVIER 2010						  */
/*	Version :	1.0							  */
/*	Fichier :	bloc_recherche.php						  */
/*										  */
/*	Description :	applique la recherche					  */
/*			sur les mots du champ de recherche > 2 caractères 	  */
/*
/* NOTA BENE : NE PAS UTILISER DE REGEXP CAR C'EST ICOMPTABILE AVEC
/* DES TABLES EN CHARSET LATIN QUI CONTIENNENT DE L'UTF8
/**********************************************************************************/


/*
*		INSTANCIATION ET EXECUTION DU MOTEUR DE RECHERCHE
*  		IL FOUILLE TOUS LES CHAMPS POUVANT CONTENIR DU TEXTE
*
*		SI ELLE EST DECLAREE, LA FONCTION triggerUrlBuilder PERMET DE MODIFIER LA FORME DES URLS
*		SI ELLE EST DECLAREE, LA FONCTION triggerNameBuilder PERMET DE MODIFIER LE LIBELLE DES LIENS
*
*/


define("_MOTEUR_ITEMS_BY_PAGE",5555);
define("_MOTEUR_NB_PAGES_AFFICHES_DANS_PAGINATION",3);

$objSearch = new Search();
$objSearch-> debug = false;
$objSearch -> numRowsSplit = _MOTEUR_ITEMS_BY_PAGE;
$objSearch -> workflowStatePublished = "3";
$objSearch -> typeOfWordsMatching = "or"; // or où and :  si plusieurs mots saisis, on les cherche  en ET oubien en OU

/*
*  nom des tables à fouiller :
*  nom = la valeur du champ qu'on doit récupérer comme titre de l'item (sera affiché dans le libellé du res)
*/

$objSearch -> tabTablesDug["centre"] = "centre.libelle";
$objSearch -> tabTablesDug["trad_centre"] = "trad_centre.id__centre";
$objSearch -> tabTablesDug["classe_decouverte"] = "classe_decouverte.nom";
$objSearch -> tabTablesDug["trad_classe_decouverte"] = "trad_classe_decouverte.id__classe_decouverte";
$objSearch -> tabTablesDug["cvl"] = "cvl.nom";
$objSearch -> tabTablesDug["trad_cvl"] = "trad_cvl.id__cvl";
$objSearch -> tabTablesDug["accueil_groupes_scolaires"] = "accueil_groupes_scolaires.id_centre";
$objSearch -> tabTablesDug["trad_accueil_groupes_scolaires"] = "trad_accueil_groupes_scolaires.id__accueil_groupes_scolaires";
$objSearch -> tabTablesDug["accueil_reunions"] = "accueil_reunions.id_centre";
$objSearch -> tabTablesDug["trad_accueil_reunions"] = "trad_accueil_reunions.id__accueil_reunions";
$objSearch -> tabTablesDug["seminaires"] = "seminaires.nom";
$objSearch -> tabTablesDug["trad_seminaires"] = "trad_seminaires.id__seminaires";
$objSearch -> tabTablesDug["accueil_groupes_jeunes_adultes"] = "accueil_groupes_jeunes_adultes.id_centre";
$objSearch -> tabTablesDug["trad_accueil_groupes_jeunes_adultes"] = "trad_accueil_groupes_jeunes_adultes.id__accueil_groupes_jeunes_adultes";
$objSearch -> tabTablesDug["sejours_touristiques"] = "sejours_touristiques.nom_sejour";
$objSearch -> tabTablesDug["trad_sejours_touristiques"] = "trad_sejours_touristiques.id__sejours_touristiques";
$objSearch -> tabTablesDug["stages_thematiques_groupes"] = "stages_thematiques_groupes.nom_stage";
$objSearch -> tabTablesDug["trad_stages_thematiques_groupes"] = "trad_stages_thematiques_groupes.id__stages_thematiques_groupes";
$objSearch -> tabTablesDug["accueil_individuels_familles"] = "accueil_individuels_familles.id_centre";
$objSearch -> tabTablesDug["trad_accueil_individuels_familles"] = "trad_accueil_individuels_familles.id__accueil_individuels_familles";
$objSearch -> tabTablesDug["short_breaks"] = "short_breaks.nom";
$objSearch -> tabTablesDug["trad_short_breaks"] = "trad_short_breaks.id__short_breaks";
$objSearch -> tabTablesDug["stages_thematiques_individuels"] = "stages_thematiques_individuels.nom";
$objSearch -> tabTablesDug["trad_stages_thematiques_individuels"] = "trad_stages_thematiques_individuels.id__stages_thematiques_individuels";
$objSearch -> tabTablesDug["gab_texte_riche"] = "gab_texte_riche.gab_texte_riche";
$objSearch -> tabTablesDug["gabarit_bouton"] = "gabarit_bouton.titre";
$objSearch -> tabTablesDug["trad__nav"] = "trad__nav._nav";
$objSearch -> tabTablesDug["trad_brochure"] = "trad_brochure.libelle";
$objSearch -> tabTablesDug["trad_bon_plan"] = "trad_bon_plan.libelle";
$objSearch -> tabTablesDug["trad_actualite"] = "trad_actualite.libelle";



$objSearch -> smartyAssign("template"); // on indique le nom de l'instance smarty en cours


//echo trace($objSearch->getnumRows);

/*
* TRIGGER QUI PERMET D'INTERVENIR SUR LA CONSTRUCTION DE L'URL
* $_rstRow : chaque ligne de résultat, la classe boucle dans
* ce trigger quand elle traite les résultats
*
* $_rstRow renvoie 4 champs
* 0 : id de l'item dans la table
* 1 : valeur du champ indiqué comme libellé dans la config tabTablesDug
* 2 : id__object, sa valeur est 'void' si on est pas dans une table système
* 3 : id__nav, sa valeur est 'void' si on est pas dans une table système
*/

function GetCOntentSejour($table,$id){

	switch($table){
		case "accueil_groupes_scolaires":
			$sql = "SELECT 
						trad_centre.presentation 
					FROM 
						trad_centre
					INNER JOIN 
						centre on (trad_centre.id__centre = centre.id_centre)
					inner join 
						accueil_groupes_scolaires on (accueil_groupes_scolaires.id_centre=centre.id_centre and accueil_groupes_scolaires.id_accueil_groupes_scolaires=".$id.")
					where
						trad_centre.id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"presentation"))),150);
			break;
		case "accueil_reunions":
			$table = "accueil_reunions";
			$sql = "SELECT 
						trad_centre.presentation 
					FROM 
						trad_centre
					INNER JOIN 
						centre on (trad_centre.id__centre = centre.id_centre)
					inner join 
						$table on ($table.id_centre=centre.id_centre and $table.id_$table=".$id.")
					where
						trad_centre.id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"presentation"))),150);
			break;
		case "accueil_groupes_jeunes_adultes":
			$table = "accueil_groupes_jeunes_adultes";
			$sql = "SELECT 
						trad_centre.presentation 
					FROM 
						trad_centre
					INNER JOIN 
						centre on (trad_centre.id__centre = centre.id_centre)
					inner join 
						$table on ($table.id_centre=centre.id_centre and $table.id_$table=".$id.")
					where
						trad_centre.id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"presentation"))),150);
			break;
			
		case "accueil_individuels_familles":
			$table = "accueil_individuels_familles";
			$sql = "SELECT 
						trad_centre.presentation 
					FROM 
						trad_centre
					INNER JOIN 
						centre on (trad_centre.id__centre = centre.id_centre)
					inner join 
						$table on ($table.id_centre=centre.id_centre and $table.id_$table=".$id.")
					where
						trad_centre.id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"presentation"))),150);
			break;	
		case "classe_decouverte":
			$sql = "select trad_classe_decouverte.details from trad_classe_decouverte where id__classe_decouverte=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"details"))),150);
			break;
		case "trad_classe_decouverte":
			$sql = "select details from trad_classe_decouverte where id_trad_classe_decouverte=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"details"))),150);
			break;
		case "cvl":
			$sql = "select presentation from trad_cvl where id__cvl=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"presentation"))),150);
			break;
		case "trad_cvl":
			$sql = "select presentation from trad_cvl where id_trad_cvl=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"presentation"))),150);
			break;
		case "seminaires":
			$sql = "select presentation from trad_seminaire where id__seminaire=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"presentation"))),150);
			break;
		case "trad_seminaires":
			$sql = "select presentation from trad_seminaires where id_trad_seminaired=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"presentation"))),150);
			break;
		case "trad_sejours_touristiques":
			$sql = "select descriptif from trad_sejours_touristiques where id_trad_sejours_touristiques=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"descriptif"))),150);
			break;
		case "sejours_touristiques":
			$sql = "select descriptif from trad_sejours_touristiques where id__sejours_touristiques=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"descriptif"))),150);
			break;
		case "trad_stages_thematiques_groupes":
			$sql = "select descriptif from trad_stages_thematiques_groupes where id_trad_stages_thematiques_groupes=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"descriptif"))),150);
			break;
		case "stages_thematiques_groupes":
			$sql = "select descriptif from trad_stages_thematiques_groupes where id__stages_thematiques_groupes=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"descriptif"))),150);
			break;
		case "stages_thematiques_individuels":
			$sql = "select descriptif from trad_stages_thematiques_individuels where id__stages_thematiques_individuels=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"descriptif"))),150);
			break;	
		case "trad_stages_thematiques_individuels":
			$sql = "select descriptif from trad_stages_thematiques_individuels where id_trad_stages_thematiques_individuels=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"descriptif"))),150);
			break;	
			
		case "trad_short_breaks":
			$sql = "select descriptif from trad_short_breaks where id_trad_short_breaks=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"descriptif"))),150);
			break;
		case "short_breaks":
			$sql = "select descriptif from trad_short_breaks where id__short_breaks=".$id." and id__langue=".$_SESSION["ses_langue"];
			$result = mysql_query($sql);
			return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"descriptif"))),150);
			break;
		default:
			return "";
			break;
	}
}




function triggerUrlBuilder($_rstRow){

	//echo "<hr>";
	//trace($_rstRow);

	if($_rstRow[2] == "centre" || $_rstRow[2] == "trad_centre"){ // gammes
		
		return get_url_nav_centre(_NAV_FICHE_CENTRE,$_rstRow[0]);
	}
	elseif($_rstRow[2] == "trad_actualite"){ // sejour
		$sql = "select id__actualite as id from trad_actualite where id_trad_actualite=".$_rstRow[0];
		$result = mysql_query($sql);
		
		return "le-blog/en-direct-des-centres."._NAV_ACTUALITE.",".mysql_result($result,0,'id').".html";
	}
	elseif($_rstRow[2] == "trad_bon_plan"){ // sejour
		$sql = "select id__bon_plan as id from trad_bon_plan where id_trad_bon_plan=".$_rstRow[0];
		$result = mysql_query($sql);
		
		return "le-blog/en-direct-des-centres."._NAV_ACTUALITE.",".mysql_result($result,0,'id').".html";
	}
	elseif($_rstRow[2] == "trad_brochure"){ // sejour
		return get_url_nav($_rstRow[0],true);
	}
	elseif($_rstRow[2] == "classe_decouverte" || $_rstRow[2] == "trad_classe_decouverte"){ // sejour
		if($_rstRow[2] == "trad_classe_decouverte"){
			$tableTrad = $_rstRow[2];
			$sql = "select id__classe_decouverte from trad_classe_decouverte where id_trad_classe_decouverte=".$_rstRow[0];
			$result = mysql_query($sql);
			return get_url_nav_sejour(_NAV_CLASSE_DECOUVERTE,mysql_result($result,0,'id__classe_decouverte'));
		}else{
			return get_url_nav_sejour(_NAV_CLASSE_DECOUVERTE,$_rstRow[0]);
		}
		
	}
	elseif($_rstRow[2] == "cvl" || $_rstRow[2] == "trad_cvl"){ // sejour
		if($_rstRow[2] == "trad_cvl"){
			$tableTrad = $_rstRow[2];
			$table = "cvl";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			
			return get_url_nav_sejour(_NAV_CVL,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_CVL,$_rstRow[0]);
		}

	}
	elseif($_rstRow[2] == "accueil_groupes_scolaires" || $_rstRow[2] == "trad_accueil_groupes_scolaires"){ // sejour
		if($_rstRow[2] == "trad_accueil_groupes_scolaires"){
			$tableTrad = $_rstRow[2];
			$table = "accueil_groupes_scolaires";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			//echo "<br>--------------------------------------<br>$sql<br>--------------------------------------<br>";
			return get_url_nav_sejour(_NAV_ACCUEIL_GROUPES_SCOLAIRES,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_ACCUEIL_GROUPES_SCOLAIRES,$_rstRow[0]);
		}
		
		
	}
	elseif($_rstRow[2] == "accueil_reunions" || $_rstRow[2] == "trad_accueil_reunions"){ // sejour
		if($_rstRow[2] == "trad_accueil_reunions"){
			$tableTrad = $_rstRow[2];
			$table = "accueil_reunions";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			return get_url_nav_sejour(_NAV_ACCEUIL_REUNIONS,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_ACCEUIL_REUNIONS,$_rstRow[0]);
		}
		

	}
	elseif($_rstRow[2] == "seminaires" || $_rstRow[2] == "trad_seminaires"){ // sejour
		
		if($_rstRow[2] == "trad_seminaires"){
			$tableTrad = $_rstRow[2];
			$table = "seminaires";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			return get_url_nav_sejour(_NAV_SEMINAIRES,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_SEMINAIRES,$_rstRow[0]);
		}
		
		
	}elseif($_rstRow[2] == "accueil_groupes_jeunes_adultes" || $_rstRow[2] == "trad_accueil_groupes_jeunes_adultes"){ // sejour
		
		if($_rstRow[2] == "trad_accueil_groupes_jeunes_adultes"){
			$tableTrad = $_rstRow[2];
			$table = "accueil_groupes_jeunes_adultes";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			return get_url_nav_sejour(_NAV_ACCUEIL_GROUPE,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_ACCUEIL_GROUPE,$_rstRow[0]);
		}
		
		

	}
	elseif($_rstRow[2] == "sejours_touristiques" || $_rstRow[2] == "trad_sejours_touristiques"){ // sejour
		
		if($_rstRow[2] == "trad_sejours_touristiques"){
			$tableTrad = $_rstRow[2];
			$table = "sejours_touristiques";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			return get_url_nav_sejour(_NAV_SEJOURS_TOURISTIQUES_GROUPE,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_SEJOURS_TOURISTIQUES_GROUPE,$_rstRow[0]);
		}
		
		
	}
	elseif($_rstRow[2] == "stages_thematiques_groupes" || $_rstRow[2] == "trad_stages_thematiques_groupes"){ // sejour
		
			
		if($_rstRow[2] == "trad_stages_thematiques_groupes"){
			$tableTrad = $_rstRow[2];
			$table = "stages_thematiques_groupes";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			return get_url_nav_sejour(_NAV_STAGES_THEMATIQUES_GROUPE,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_STAGES_THEMATIQUES_GROUPE,$_rstRow[0]);
		}

		
	}
	elseif($_rstRow[2] == "accueil_individuels_familles" || $_rstRow[2] == "trad_accueil_individuels_familles"){ // sejour
		
			
		if($_rstRow[2] == "trad_accueil_individuels_familles"){
			$tableTrad = $_rstRow[2];
			$table = "accueil_individuels_familles";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			return get_url_nav_sejour(_NAV_ACCUEIL_INDIVIDUEL,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_ACCUEIL_INDIVIDUEL,$_rstRow[0]);
		}


	}
	elseif($_rstRow[2] == "short_breaks" || $_rstRow[2] == "trad_short_breaks"){ // sejour
		
			
		if($_rstRow[2] == "trad_short_breaks"){
			$tableTrad = $_rstRow[2];
			$table = "short_breaks";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			return get_url_nav_sejour(_NAV_SHORT_BREAK,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_SHORT_BREAK,$_rstRow[0]);
		}


	}
	elseif($_rstRow[2] == "stages_thematiques_individuels" || $_rstRow[2] == "trad_stages_thematiques_individuels"){ // sejour
		
			
		if($_rstRow[2] == "trad_stages_thematiques_individuels"){
			$tableTrad = $_rstRow[2];
			$table = "stages_thematiques_individuels";
			$sql = "select id__$table as id from trad_$table where id_$tableTrad=".$_rstRow[0];
			$result = mysql_query($sql);
			return get_url_nav_sejour(_NAV_STAGES_THEMATIQUES_INDIVIDUEL,mysql_result($result,0,'id'));
		}else{
			return get_url_nav_sejour(_NAV_STAGES_THEMATIQUES_INDIVIDUEL,$_rstRow[0]);
		}


	}
	elseif($_rstRow[3] != "void"){ // si il y a un id__nav : on est dans une table gabarit ou nav
		return get_url_nav($_rstRow[3]);
	}
	elseif($_rstRow["id_trad__nav"]!="" && $_rstRow["id_trad__nav"]!="void" && $_rstRow["id_trad__nav"]!=0 ) // si on est dans une table spécifiques
	{
		$sql = " SELECT id___nav FROM trad__nav WHERE id_trad__nav = ".$_rstRow["id_trad__nav"];
		$rs = mysql_query($sql);
		return get_url_nav(mysql_result($rs,0,"id___nav"));
	}
	else
	{
		return "";
	}

}


function GetCOntentCentre($id){
	$sql= "select presentation from trad_centre where id__centre=$id and id__langue=".$_SESSION["ses_langue"];
	$result = mysql_query($sql);
	return coupe_espace(strip_tags(html_entity_decode(mysql_result($result,0,"presentation"))),150);
}

function GetCentreName($id){
	$sql = "select libelle from centre where id_centre=$id";
	$result = mysql_query($sql);
	return mysql_result($result,0,"libelle");
}


function triggerTableBuilder($_rstRow){

	if($_rstRow[2] == "centre"){ // gammes
		return get_nav(_NAV_FICHE_CENTRE);
	}
	else
	{
		return "";//get_url_nav($_rstRow[1]);
	}

}


/*
*
* TRIGGER QUI PERMET D'INTERVENIR SUR LA CONSTRUCTION DU LIBELLE DE L'URL
* $_rstRow : chaque ligne de résultat, la classe boucle dans
* ce trigger quand elle traite les résultats
*
*/
/*
function triggerNameBuilder($_rstRow){
if($_rstRow[3] != "void"){ // si il y a un id__nav : on est dans une table gabarit ou nav
if($_rstRow[1] != "")
return $_rstRow[1];
else
return get_trad_nav($_rstRow[3]);
}
else  // si on est dans une table spécifiques
if($_rstRow[1] != ""){
return get_trad_nav($_rstRow[1]);
}
else
return "Voir ce r&eacute;sultat";
}
*/
/*
*
* TRIGGER QUI PERMET DE CONSTRUIRE L'APERCU TEXTE
* $_rstRow : chaque ligne de résultat, la classe boucle dans
* ce trigger quand elle traite les résultats
*
*/




function contentBuilder($_rstRow){
	global $db;
	if($_rstRow[3] != "void"){
		$r = getContent($db,"",$_rstRow[3], false);
		// if($_rstRow[3] == 135)
		$ret = resumeFromRes($r);
		return $ret;
	}
	// si on est dans une table spécifiques
	else
	return "";
}
/*
* on retourne le mots-clé et son cotexte dans le champ où il est le plus représentatif
*
*/
function resumeFromRes($_aTabRes){
	for($i=0;$i<count($_aTabRes);$i++){
		foreach($_aTabRes[$i] as $fieldName=>$fieldValue){
			// on stocke le max de caractère trouvé
			$bestOccur = 0;
			$cnt = getMatchingArea($fieldValue);
			$cntLen = strlen($cnt);
			if($cntLen>$bestOccur){
				$bestOccur = $cntLen;
				$ret = $cnt;
			}
		}
	}
	return $ret;
}

function GetTableName($id,$nav,$id_nav){
	if($nav == "nav"){
		if(is_numeric($id_nav)){
			$tab = get_navID($id_nav);
		}else{
			$sql = "SELECT id___nav FROM trad__nav WHERE id_trad__nav=$id";
			$result = mysql_query($sql);
			$tab = get_navID(mysql_result($result,0,"id___nav"));
		}
		//
		return get_nav($tab[1]);
	}elseif($nav == "trad_nav" || $nav=="centre"){
		$sql = "SELECT ville,libelle FROM centre WHERE id_centre=$id_nav";
		$result = mysql_query($sql);
		if(mysql_result($result,0,"ville")!="" && mysql_result($result,0,"libelle")!=""){
			$tab = mysql_result($result,0,"ville")." - ".mysql_result($result,0,"libelle");
			return $tab;
		}
	}else{
		return get_nav($id);
	}
}


function getMatchingArea($_str){
	$str = unhtmlentities(strip_tags($_str));
	$bRes = preg_match("/(.*".$_REQUEST['search'].".*)/i",$str,$res);
	if($bRes){
		$numCharsBefore = 50; $numCharsAfter = 150;
		$pos = strpos($res[0],$_REQUEST['search']);
		$posBefore = $pos - $numCharsBefore;
		if($posBefore < 0) $posBefore = 0;
		$len = strlen($_REQUEST['search']) + $numCharsAfter;
		if($posAfter < 0) $posAfter = 0;
		$str = substr($res[0],$posBefore,$len);
		$str = eregi_replace($_REQUEST['search'],"<b>".$_REQUEST['search']."</b>",$str);
		//
		$pos1 = strpos($str," ");
		if($pos1 < 0) $pos1 = 0;
		$pos2 = strrpos($str," ");
		$len = strlen($str) - $pos1;
		$str = substr($str,$pos1,$pos2);
		return $str;
	}
}

//echo "<br> search=" . $_REQUEST['search'];

$objSearch -> searchProcess($_REQUEST['search']);

//pagination
$arrPagination = $objSearch -> pagination();

$i=0;
foreach($arrPagination as $num=>$numStart)
{
	$i++;
	$pagination[$i] = $numStart;
}

//page en cours
$currentPage = $_REQUEST["currentPage"]!="" ? $_REQUEST["currentPage"] : 1;
$nextPage = $_REQUEST["currentPage"] + 1;
$prevPage = $_REQUEST["currentPage"] - 1;


$this->assign("currentPage",$currentPage);
$this->assign("prevPage",$prevPage);
$this->assign("nextPage",$nextPage);
$this->assign("nbPages",count($pagination));
$this->assign('pagination',$pagination);
$this->assign('urlFormPagination',get_url_nav(_NAV_RECHERCHE));


//tt($pagination);

//assignations
$this->assign("navName",get_trad_nav(_NAV_RECHERCHE));
$this->assign("lib_suivant",get_libLocal("lib_suivant"));
$this->assign("lib_precedent",get_libLocal("lib_precedent"));
$this->assign("lib_pas_de_resultat",get_libLocal("lib_pas_de_resultat"));
$this->assign("lib_resultats",get_libLocal("lib_resultats"));
$this->assign("critere",$_REQUEST["search"]);
//trace($items);
//display
$this->display('blocs/recherche.tpl');
?>