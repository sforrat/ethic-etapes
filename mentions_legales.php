<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	RPL 							  
/*	Date : 		SEPTEMBRE 2010
/*	Version :	1.0							  
/*	Fichier :	mentions_legales.php						  
/*										  
/*	Description :	Page de mentions légales
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$tabNav = get_navID($_GET["Rub"]);


$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));
$template->display('mentions_legales.tpl');
?>