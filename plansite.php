<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY 							  
/*	Date : 		JUIN 2009		  
/*	Version :	1.0							  
/*	Fichier :	plansite.php				  
/*										  
/*	Description :	Génère le plan du site  
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
require_once($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));

$template ->display('plansite.tpl');


?>
