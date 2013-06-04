<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	LAC 							  
/*	Date : 		Mai 2010
/*	Version :	1.0							  
/*	Fichier :	header_blog.php
/*										  
/*	Description :	genere le bloc entete du blog
/**********************************************************************************/

// Initialisation de la page
/*
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
*/

//Url accueil
$template -> assign("url_home", _CONST_APPLI_URL);

//Menus
$aMenu = get_menu_gauche(_NAV_ACCUEIL,$navID,$db,_NAV_SITE);


//trace($aMenu);

$template -> assign("item_menu_n1",$aMenu);

$template->assign("Rub",$_GLOBALS["Rub"]);
$template -> display("header_blog.tpl");
?>