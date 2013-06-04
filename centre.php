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

//trace($_SESSION['params']);

//-----------------------------------------------
// recherche depuis Recherche Multicritères
//-----------------------------------------------
if (isset($_REQUEST['amb_filter']) && $_REQUEST['amb_filter'] != '')
{
	$params['id_centre_ambiance'][] = $_REQUEST['amb_filter'];
}

if ($_REQUEST['individuel'] == 'on')
{
	$params['individuel'] = true;
}
	
if ($_REQUEST['groupe'] == 'on')
{
	$params['groupe'] = true;
}

// Passage de la Rub correspondant à l'ambiance (ici Rub=_NAV_DESTINATION soit 4)
// pour afficher le bandeau de recherche correspondant dans le tpl

switch ($_REQUEST['amb_filter'])
{
	case _CONST_CENTRE_AMB_SPORTIF:
		$GLOBALS['nav_amb'] = _NAV_CENTRES_ACCUEIL_SPORTIFS;
		break;
	case _CONST_CENTRE_AMB_100_NATURE:
		$GLOBALS['nav_amb'] = _NAV_CENTRES_100_NATURE;
		break;
	case _CONST_CENTRE_AMB_FARNIENTE:
		$GLOBALS['nav_amb'] = _NAV_CENTRES_AMBIANCE_FARNIENTE;
		break;
	case _CONST_CENTRE_AMB_CULTUREL:
		$GLOBALS['nav_amb'] = _NAV_CENTRES_CULTUREL;
		break;
	case _CONST_CENTRE_AMB_URBAN_TRIP:
		$GLOBALS['nav_amb'] = _NAV_CENTRES_URBAN_TRIP;
		break;
}


//----------------------------------
// recherche depuis Menu
//----------------------------------
if (in_array($GLOBALS['Rub'], $GLOBALS["_NAV_DESTINATIONS"]))
{
	switch ($GLOBALS['Rub'])
	{
		case _NAV_CENTRES_MER :
			$params['id_centre_environnement'][] = _CONST_CENTRE_ENV_MER;
			break;
		case _NAV_CENTRES_MONTAGNE:
			$params['id_centre_environnement'][] = _CONST_CENTRE_ENV_MONTAGNE;
			break;
		case _NAV_CENTRES_CAMPAGNE:
			$params['id_centre_environnement'][] = _CONST_CENTRE_ENV_CAMPAGNE;
			break;			
		case _NAV_CENTRES_VILLE:
			$params['id_centre_environnement'][] = _CONST_CENTRE_ENV_VILLE;
			break;
		case _NAV_CENTRES_NEW:
			$params['moins_6_mois'][] = true;
			break;
	}
	
}

// --- On recupere tous les centres pour les afficher sur la carte
$params["disableLimit"] = true;
getListeCentre($listeTotalRes, $params);
// ---
$idCentre="";
foreach($listeTotalRes as $val){
  if($idCentre == ""){
    $idCentre.= $val["id"];
  }else{
    $idCentre.= ",".$val["id"];
  }
}

// --- On sauvegarde la liste des centres pour pouvoir les afficher ensuite sur la carte de la fiche centre
$_SESSION["idCentre"] = $idCentre;
// ----

$template->assign("idCentre",$idCentre);	
$template->display('centre.tpl');
?>