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


define("_MOTEUR_ITEMS_BY_PAGE",5);
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

$objSearch -> tabTablesDug["trad__nav"] = "trad__nav._nav";
$objSearch -> tabTablesDug["gab_titre"] = "gab_titre.titre"; 
$objSearch -> tabTablesDug["gab_annee"] = "gab_annee.description";
$objSearch -> tabTablesDug["gab_sous_titre"] = "gab_sous_titre.sous_titre";

$objSearch -> tabTablesDug["editorial_img_droite"] = "editorial_img_droite.titre"; 
$objSearch -> tabTablesDug["editorial_img_gauche"] = "editorial_img_gauche.titre"; 
$objSearch -> tabTablesDug["trad_gammes"] = "trad_gammes.titre";
 
$objSearch -> tabTablesDug["trad_fiche_produit"] = "trad_fiche_produit.description_courte";

$objSearch -> smartyAssign("template"); // on indique le nom de l'instance smarty en cours


//echo trace($objSearch->getnumRows);

/*
*
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
function triggerUrlBuilder($_rstRow){

  //echo "<hr>";
  //trace($_rstRow);
  
	if($_rstRow[2] == "trad_gammes"){ // gammes	  
		return get_url_gamme($_rstRow[0],true);
	}
  elseif($_rstRow[2] == "trad_fiche_produit"){ // produit    
		return get_url_produit($_rstRow[0],true);
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

//trace($items);
//display
$this->display('blocs/bloc_recherche.tpl');
?>