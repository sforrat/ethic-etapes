<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	espace_membre.php						  
/*										  
/*	Description :	Gestion de toutes les pages de l'espace membre
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$tabNav = get_navID($_GET["Rub"]);


if ($_SESSION['user_connect_membre'] == '')
{
	redirect(_CONST_APPLI_URL.get_url_nav($tabNav[1]));
die();
}

$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));


$paramUrl[] = array('id_name' => 'action', 'id' => 'deconnexion');
$template->assign("urlDeconnexion",_CONST_APPLI_URL.get_url_nav(_NAV_ESPACE_MEMBRE, $paramUrl));
$template->display('espace_membre.tpl');

?>