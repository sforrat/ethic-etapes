<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	offre_emploi.php						  
/*										  
/*	Description :	Page offre emploi
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$tabNav = get_navID($_GET["Rub"]);
$template->assign("afficheCalandar",1);

$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));
$template->display('offre_candidature.tpl');

?>