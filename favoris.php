<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	DCA 							  
/*	Date : 		JUILLET 2010
/*	Version :	1.0							  
/*	Fichier :	favoris.php						  
/*										  
/*	Description :	Page LIENS FAVORIS
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$tabNav = get_navID($_GET["Rub"]);


$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));
$template->display('favoris.tpl');

?>