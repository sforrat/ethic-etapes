<?
/**********************************************************************************/
/*	C2IS :
/*	Auteur : 	GPE
/*	Date : 		MAI 2010
/*	Version :	1.0
/*	Fichier :	fiche_c.php
/*
/*	Description :	Page sejour
/**********************************************************************************/

$iIdCentre = $_GET['id_centre'];
// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

$sql = "SELECT ville FROM centre where id_centre = ".$_GET["id_centre"];
$rst = mysql_query($sql);

if (!$rst)
	echo mysql_error().' - '.$sql;
else 
	$template -> assign ("ville", mb_strtoupper(mysql_result($rst, 0, 'ville'), 'utf-8'));



$template -> assign ("titre", mb_strtoupper(get_trad_nav($GLOBALS['Rub']), "utf-8"));

$template -> assign ("id_centre", $_GET["id_centre"]);

//Gestion de la popup d'impression
$paramsUrlPrint[] = array ('id_name' => 'action', 'id' => 'print');
$template -> assign ("urlPrint", get_url_nav_centre($_REQUEST['Rub'], $_GET["id_centre"], $paramsUrlPrint));

if ($_REQUEST['action'] == 'print')
	$template->display('fiche_centre_print.tpl');
else
	$template->display('fiche_centre.tpl');

?>