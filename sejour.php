<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	sejour.php						  
/*										  
/*	Description :	Page sejour
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

if ($_REQUEST['Rub'] == _NAV_CVL && $_SESSION['ses_langue'] != _ID_FR)
//if ($_REQUEST['Rub'] == _NAV_CVL && $_SESSION['ses_langue'] != _ID_EN)
{
	$template->display('liste_organisateur_cvl.tpl');
}elseif($_REQUEST['Rub'] == _NAV_MOINS_18_ANS || $_REQUEST['Rub'] == _NAV_POUR_VOS_REUNION || $_REQUEST['Rub'] == _NAV_DECOUVERTE_TOURISTIQUE){
	$template->display('sejour_gamme.tpl');
}
else{
	$template->display('sejour.tpl');
    echo "<!-- SEJOUR.PHP: SESSION['last_rub']=".$_SESSION['last_rub']."-->";
}
?>