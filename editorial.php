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
$tabNav = get_navID($_GET["Rub"]);

// RPL - 30/05/2011 : redirection sur l'espace membre si rub pere est l'espace membre
if( count($tabNav) > 2 ){
	$rub_pere = $tabNav[count($tabNav)-2];
	if( $rub_pere == _NAV_ESPACE_MEMBRE && $_SESSION['user_connect_membre'] == '' ){
		redirect( _CONST_APPLI_URL.get_url_nav(_NAV_ESPACE_MEMBRE) );
		die();
	}
}
// RPL

$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));
$template->display('editorial.tpl');

?>