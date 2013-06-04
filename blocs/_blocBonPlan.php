<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	blocBonPlan.php						  
/*										  
/*	Description :	Colonne de gauche                 
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
		
//-----------------------------------------
//				Bons Plans
//-----------------------------------------
//
//$params = array();
//$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_GENERALE;
//if ($_REQUEST['Rub'] == _NAV_FICHE_CENTRE)
//	$params['id_centre'] = $_REQUEST['id_centre'];
//else if (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR_MOINS_18_ANS"]))
//{
//		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_MOINS_18_ANS;	
//}
//elseif (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR_REUNION"]))
//{
//		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_SEMINAIRE_REUNION;	
//}
//elseif (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR_DECOUVERTE"]))
//{
//		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_SEJOUR_INDIVIDUEL;	
//		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_SEJOUR_GROUPE;	
//}
//
//if (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR"])&& isset($_REQUEST['id']))
//{
//	$Rub = $_REQUEST['Rub'];
//	$sql = "SELECT id_centre FROM ".$GLOBALS["_NAV_SEJOUR_TABLE"][$Rub]." WHERE id_".$GLOBALS["_NAV_SEJOUR_TABLE"][$Rub]." = ".$_REQUEST['id'];
//	$rst = mysql_query($sql);
//	
//	if (!$rst)
//		echo mysql_error(). ' - '.$sql;
//	else
//		$params['id_centre'] = mysql_result($rst, 0, 'id_centre');
//}


$nbBP = getBonPlan($listeBP, getActuAndBonPlanParams());

if ($nbBP == 0)
	$this -> assign ('is_promo', false);
else
	$this -> assign ('is_promo', true);
	
$this -> assign ("nbBP", $nbBP);
$this -> assign ("listeBP", $listeBP);	
	
$titre = get_libLocal('lib_bon_plan_promotion');

if ($_REQUEST['Rub'] == _NAV_FICHE_CENTRE || (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR"]) && isset($_REQUEST['id'])))
	$titre = '<h3>'.ucfirst(strtolower($titre)).'</h3>';
else 
	$titre = '<h2>'.strtoupper($titre).'</h2>';
	
$this -> assign ("titreBP", $titre);

$this -> display('blocs/blocBonPlan.tpl');
?>
