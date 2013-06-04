<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	GPE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	fiche_centre_localisation.php						  
/*										  
/*	Description :	Page localisation d'un centre
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
//
//$iNbCentre = getListeCentreGP($lstCentre,array('id_centre'=>array($iIdCentre)));
//$lstCentre = $lstCentre[0];
//
//if($iNbCentre)
//{
//	$template->assign("lstCentre",$lstCentre);
//	if($lstCentre['acces_route_4'] == 'Oui') $template->assign("acces_route",true);
//	if($lstCentre['acces_train_4'] == 'Oui') $template->assign("acces_train",true);
//	if($lstCentre['acces_avion_4'] == 'Oui') $template->assign("acces_avion",true);
//	if($lstCentre['acces_bus_metro_4'] == 'Oui') $template->assign("acces_bus_metro",true);
//	
//	/*if($iNbCentreTarifsScolaire) $template->assign("listeTarifsScolaire",$listeTarifsScolaire);	
//	if($iNbCentreTarifsAdulte) $template->assign("listeTarifsAdulte",$listeTarifsAdulte);	
//	if($iNbCentreTarifsFamille) $template->assign("listeTarifsFamille",$listeTarifsFamille);	*/
//}

$template->display('fiche_centre_localisation.tpl');

?>