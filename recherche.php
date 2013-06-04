<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY 							  
/*	Date : 		JUIN 2009					  
/*	Version :	1.0							  
/*	Fichier :	recherche.php						  
/*										  
/*	Description :	Page qui affiche le resultat d'une recherche fulltext     
/*										  
/*	=> le champ recherche doit s'appeller : "query_string" <= 		  
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// positionnement de la langue en cours ($_SESSION et prise en compte des changts de langue)
set_langue();

// Chemin de fer
$template -> assign("CHEMIN_FER",get_chemin_fer_interne($GLOBALS['Rub'], $navID));

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");


$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));



// Affichage la page elle même
// les blocs sont inclus directement dans le template de la page
// les variables de positionnement de contexte sont passées depuis cette page vers les différents blocs
$template->display('recherche.tpl');
?>
