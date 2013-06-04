<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	form_sejour_contact.php						  
/*										  
/*	Description :	Formulaire de contact des séjours
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");


	$sql = "SELECT url_hostelworld 
			FROM centre 
			WHERE id_centre = ".$_REQUEST['id_centre'];

	$rst = mysql_query($sql);
	
	if (!$rst)
		echo mysql_error(). ' - '.$sql;
	else 
	{
		$urlReservation = mysql_result($rst,0,'url_hostelworld');
		if ($urlReservation == '')
			$urlReservation = _URL_HOSTELWORLD;
	}

	$template -> assign ('urlReservation', $urlReservation);	
	$template->assign("Rub",$_REQUEST['Rub']);	
		
	$template->assign("idSejour",$_REQUEST['id_sejour']);
	$template->assign("idCentre",$_REQUEST['id_centre']);
		
	if (isset ($_REQUEST['id_sejour']))
		$template->assign("urlAjax","form_sejour_contact.php");	
	else
		$template->assign("urlAjax","fiche_centre_disponibilite.php");	
		
		
	$template->assign("prefixe",$_SESSION['ses_langue_ext']);	
	
	
	
	$template->display('form_reservation_accueil_individuel.tpl');
?>