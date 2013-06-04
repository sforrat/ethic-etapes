<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY 							  
/*	Date : 		JUIN 2009
/*	Version :	1.0							  
/*	Fichier :	editorial.php						  
/*										  
/*	Description :	Page éditoriale
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$template->assign("titre",mb_strtoupper(get_nav(_NAV_LAISSEZ_AVIS),"utf-8"));

$sql = "select libelle,id__laissez_avis_note  from trad_laissez_avis_note where id__langue='".$_SESSION["ses_langue"]."'";
$result = mysql_query($sql);
while ($myrow = mysql_fetch_array($result)) {
	$tab["id"] = $myrow["id__laissez_avis_note"];
	$tab["libelle"] = $myrow["libelle"];
	$TabNote[] = $tab;
	unset($tab);
}

$template->assign('lib_valider',strtoupper(get_libLocal('lib_valider')));
$template->assign('TabNote',$TabNote);
$template->assign('id_centre',$_GET["id_centre"]);

$template->display('laissez_avis.tpl');
?>