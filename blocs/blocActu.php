<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	blocActu.php						  
/*										  
/*	Description :	Colonne de gauche                 
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
		
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


$id_centre = getCentreId($_REQUEST['Rub'],$_REQUEST['id']);
if($id_centre>0){
	$params["id_centre"]=$id_centre;
}

$nbActu = getActualites($listeActu, $params);

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
	

$this -> display('blocs/blocActu.tpl');
?>
