<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	fiche_dest_offres.php						  
/*										  
/*	Description :	Bas de page                        
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";

$idCentre = $_REQUEST['id_centre'];
$idTypeSejour = $_REQUEST['id_type_sejour'];

//*********************************************************//
//				Affichage des blocs d'offres			   //
//*********************************************************//

$FilsKids = get_item_fils(_NAV_SEJOUR_MOINS_18_ANS);
$listeFilsKids = array();
foreach ($FilsKids as $fils)
{
	$param['id_centre'] = $_REQUEST['id_centre'];
	$nbSejour = getListeSejour($fils,$listeSejour, $param);
	if ($nbSejour > 0)
	{
		$params = array();
		$params[] = array ('id_name' => 'id_type_sejour', 'id' => $fils);
		$listeFilsKids[] = array (	'libelle' => mb_strtoupper(get_nav($fils),'utf-8'),
									'lien' => get_url_nav_centre($_REQUEST['Rub'], $idCentre, $params).'#ficheDest_results');
	
		if ($idTypeSejour == $fils)
			$type = 'kids';
	}
}
$this -> assign ('nbFilsKids', count($listeFilsKids));
$this -> assign ('listeFilsKids', $listeFilsKids);


$FilsCompany = get_item_fils(_NAV_SEJOUR_REUNION);
$listeFilsCompany = array();
foreach ($FilsCompany as $fils)
{
	$param['id_centre'] = $_REQUEST['id_centre'];
	$nbSejour = getListeSejour($fils,$listeSejour, $param);
	if ($nbSejour > 0)
	{	
		$params = array();
		$params[] = array ('id_name' => 'id_type_sejour', 'id' => $fils);		
		$listeFilsCompany[] = array (	'libelle' => mb_strtoupper(get_nav($fils),'utf-8'),
										'lien' => get_url_nav_centre($_REQUEST['Rub'], $idCentre, $params).'#ficheDest_results');
	
		if ($idTypeSejour == $fils)
			$type = 'company';	
	}
	
}
$this -> assign ('nbFilsCompany', count($listeFilsCompany));
$this -> assign ('listeFilsCompany', $listeFilsCompany);


$FilsTourism = get_item_fils(_NAV_SEJOUR_DECOUVERTE);
$listeFilsTourism = array();
foreach ($FilsTourism as $fils)
{
	$param['id_centre'] = $_REQUEST['id_centre'];
	$nbSejour = getListeSejour($fils,$listeSejour, $param);
	if ($nbSejour > 0)
	{	
		$params = array();
		$params[] = array ('id_name' => 'id_type_sejour', 'id' => $fils);		
		$listeFilsTourism[] = array (	'libelle' => mb_strtoupper(get_nav($fils),'utf-8'),
									'lien' => get_url_nav_centre($_REQUEST['Rub'], $idCentre, $params).'#ficheDest_results');
	
		if ($idTypeSejour == $fils)
			$type = 'tourism';	
	}
}
$this -> assign ('nbFilsTourism', count($listeFilsTourism));
$this -> assign ('listeFilsTourism', $listeFilsTourism);

$this -> assign ('titreSejour', mb_strtoupper(get_nav($idTypeSejour), 'utf-8'));
$this -> assign ('type', $type);

$this->display('blocs/fiche_dest_offres.tpl');
?>
