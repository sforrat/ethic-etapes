<?
/**********************************************************************************/
/*	C2IS :
/*	Auteur : 	GPE
/*	Date : 		MAI 2010
/*	Version :	1.0
/*	Fichier :	fiche_centre_tarifs.php
/*
/*	Description :	Page sejour
/**********************************************************************************/



// Initialisation de la page
$path="./";
require_once($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include_once($path."include/inc_output_filters.inc.php");


$template->display('fiche_centre_tarifs.tpl');

?>