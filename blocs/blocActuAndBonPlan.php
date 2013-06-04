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
//				Actualités
//-----------------------------------------

$nbActu = getActualites($listeActu, getActuAndBonPlanParams());

if ($nbActu == 0)
	$this -> assign ('is_actu', false);
else
	$this -> assign ('is_actu', true);

$this -> assign ("nbActu", $nbActu);
$this -> assign ("listeActu", $listeActu);


$titre = get_libLocal('lib_titre_actualite');
if ($_REQUEST['Rub'] == _NAV_FICHE_CENTRE || (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR"]) && isset($_REQUEST['id'])))
	$titre = '<h3>'.ucfirst(mb_strtolower($titre,"utf-8")).'</h3>';
else 
	$titre = '<h2>'.mb_strtoupper($titre,"utf-8").'</h2>';
	
$this -> assign ("titreBP", $titre);
	
$this -> assign ("titreActu", $titre);
	

//-----------------------------------------
//				Bons Plans
//-----------------------------------------

$nbBP = getBonPlan($listeBP, getActuAndBonPlanParams());

if ($nbBP == 0)
	$this -> assign ('is_promo', false);
else
	$this -> assign ('is_promo', true);
	
$this -> assign ("nbBP", $nbBP);
$this -> assign ("listeBP", $listeBP);	
	
$titre = get_libLocal('lib_bon_plan_promotion');

if ($_REQUEST['Rub'] == _NAV_FICHE_CENTRE || (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR"]) && isset($_REQUEST['id'])))
		$titre = '<h3>'.ucfirst(mb_strtolower($titre,"utf-8")).'</h3>';
else 
	$titre = '<h2>'.mb_strtoupper($titre,"utf-8").'</h2>';

$this -> assign ("titreBP", $titre);


if ($nbActu > 0 || $nbBP > 0)
$this -> display('blocs/blocActuAndBonPlan.tpl');
?>
