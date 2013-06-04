<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	bloc_gauche.php						  
/*										  
/*	Description :	Colonne de gauche                 
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
		





if ($_REQUEST["Rub"] == _NAV_ACCUEIL || !$_REQUEST["Rub"])
{
	if (isset($_REQUEST['individuel']))
		$this -> assign ('is_individuel_filter', true);
	
	if (isset($_REQUEST['groupe']))
		$this -> assign ('is_groupe_filter', true);		
		
	$this -> assign ('is_moteurResa', true);		
	$this -> assign ('is_rechMulti', true);
	$this -> assign ('is_rechGeo', true);
	$this -> assign ('is_ancv', true);
}
else if ($_REQUEST["Rub"] == _NAV_SEJOUR || $_REQUEST["Rub"] == _NAV_DESTINATIONS)
{
	if (isset($_REQUEST['individuel']))
		$this -> assign ('is_individuel_filter', true);
	
	if (isset($_REQUEST['groupe']))
		$this -> assign ('is_groupe_filter', true);			
	
	$this -> assign ('is_moteurResa', true);
	$this -> assign ('is_rechMulti', true);
	$this -> assign ('is_rechGeo', true);
}
else if ($_REQUEST["Rub"] == _NAV_FICHE_CENTRE)
{
  $this -> assign ('is_bnt_back', true);
	
  $this -> assign ('is_moteurResa', true);
  $this -> assign ('is_rechGeo', true);
  $this -> assign ('view_filter', false);
}else if (in_array($_REQUEST["Rub"], $GLOBALS["_NAV_SEJOUR"]) || in_array($_REQUEST["Rub"], $GLOBALS['_NAV_DESTINATIONS']))
{
	
	if (isset($_REQUEST['id']))
		$this -> assign ('is_bnt_back', true);
		
	$this -> assign ('is_actu', true);
	$this -> assign ('is_promo', true);
	
	
//-----------------------------------------
//				Actualités
//-----------------------------------------

$params = array();
$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_GENERALE;
if (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR_MOINS_18_ANS"]))
{
		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_MOINS_18_ANS;	
}
elseif (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR_REUNION"]))
{
		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_SEMINAIRE_REUNION;	
}
elseif (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR_DECOUVERTE"]))
{
		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_SEJOUR_INDIVIDUEL;	
		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_SEJOUR_GROUPE;	
}

$nbActu = getActualites($listeActu, $params);

if ($nbActu == 0)
	$this -> assign ('is_actu', false);

$this -> assign ("nbActu", count($nbActu));
$this -> assign ("listeActu", $listeActu);

//-----------------------------------------
//				Bons Plans
//-----------------------------------------

$nbBP = getBonPlan($listeBP, $params);

if ($nbBP == 0)
	$this -> assign ('is_promo', false);
	
$this -> assign ("nbBP", $nbBP);
$this -> assign ("listeBP", $listeBP);	
	
}


if (in_array($_REQUEST["Rub"], $GLOBALS['_NAV_DESTINATIONS']))
{
	$this -> assign ('is_moteurResa', true);
	$this -> assign ('is_rechGeo', true);
}



$this -> assign ('action_recherche_multicriteres', get_url_nav(_NAV_DESTINATIONS));

$this -> display('blocs/bloc_gauche.tpl');
?>
