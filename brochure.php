<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	partenaire.php						  
/*										  
/*	Description :	Page PARTENAIRE
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$tabNav = get_navID($_GET["Rub"]);


$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));
$template->display('brochure.tpl');

?>