<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	GPE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	fiche_dest_principale.php						  
/*										  
/*	Description :	                        
/*										  
/**********************************************************************************/

$iIdCentre = $_GET['id_centre'];
// Initialisation de la page
$path="./";
$this->assign("id_centre",$_GET["id_centre"]);
$iNbCentreLesPlus = getListeCentreLesPlus($listeCentreLesPlus,array('id_centre'=>array($iIdCentre)));//$_GET['id_centre']
$iNbCentreService = getListeCentreService($listeCentreService,array('id_centre'=>array($iIdCentre)));//$_GET['id_centre']
$iNbCentreSiteTour = getListeCentreSiteTouristique($listeCentreSiteTour,array('id_centre'=>$iIdCentre));
$iNbCentreAvisIntern = getListeCentreAvisInternaute($listeCentreAvisIntern,array('id_centre'=>array($iIdCentre)));
$iNbCentreActivite = getListeCentreActivite($listeCentreActivite,array('id_centre'=>array($iIdCentre)));
$iNbCentreEquipement = getListeCentreEquipement($tmpListeCentreEquipement,array('id_centre'=>array($iIdCentre)));

$iNbCentre = getListeCentreGP($listeCentre,array('id_centre'=>array($iIdCentre)));//$_GET['id_centre']
$listeCentre = $listeCentre[0];

if($iNbCentreLesPlus) 
{
	$this->assign("is_centrelesplus",true);
	$this->assign("listeCentreLesPlus",$listeCentreLesPlus);
}

if($iNbCentreService) 
{
	$this->assign("is_centreservice",true);
	$this->assign("listeCentreService",$listeCentreService);
}

if($listeCentre['nb_chambre']) 
	$this->assign("is_chambre",true);
	
if($listeCentre['nb_lit']) 
	$this->assign("is_lit",true);

if($listeCentre['nb_couvert']) 
	$this->assign("is_couvert",true);
	
if($iNbCentreActivite) 
{
	$this->assign("is_activite",true);
	$this->assign("listeCentreActivite",$listeCentreActivite);
}

if($iNbCentreEquipement) 
{
	$this->assign("is_equipement",true);
	
	foreach($tmpListeCentreEquipement as $sEquipement => $sType)
	{
		if($sType['surplace'] == 1) 
			$listeCentreEquipement[] = get_libLocal('lib_'.$sEquipement). " : ".get_libLocal('lib_sur_place');
		
		if ($sType['proche'] == 1)
			$listeCentreEquipement[] = get_libLocal('lib_'.$sEquipement). " : ".str_replace('xxDISTANCExx',$sType['distance'], get_libLocal('lib_a_km') );
	}
	
	$this->assign("listeCentreEquipement",$listeCentreEquipement);
}

if($iNbCentreSiteTour) 
{
	$this->assign("is_site_touristique",true);
	$this->assign("listeCentreSiteTour",$listeCentreSiteTour);
	
}

if($iNbCentreAvisIntern) 
{
	$this->assign("is_avis_internaute",true);
	$this->assign("listeCentreAvisIntern",$listeCentreAvisIntern);		
}


//Classements
if ($listeCentre['id_centre_classement'] != '')
{
	if ($listeCentre['id_centre_classement'] == 0 || $listeCentre['id_centre_classement'] == 10)
	{
		$listeClassement[] = array('img' => "images/dyn/rating_grey.png",
									'title' => getTradTable('centre_classement', $_SESSION['ses_langue'], 'libelle', 10));		
	}
	else 
	{
		for ($i = 0 ; $i < $listeCentre['id_centre_classement']; $i++)
		{
			$listeClassement[] = array('img' => "images/dyn/rating_green.png",
										'title' => getTradTable('centre_classement', $_SESSION['ses_langue'], 'libelle', $listeCentre['id_centre_classement']));
		}
	}
	
	$this->assign('listeClassement', $listeClassement);
}


if ($listeCentre['id_centre_classement_1'] != '')
{
	if ($listeCentre['id_centre_classement_1'] == 0 || $listeCentre['id_centre_classement_1'] == 10)
	{
		$listeClassement_1[] = array('img' => "images/dyn/rating_grey.png",
									'title' => getTradTable('centre_classement', $_SESSION['ses_langue'], 'libelle', 10));		
	}	
	else 
	{
		for ($i = 0 ; $i < $listeCentre['id_centre_classement_1']; $i++)
		{	
			$listeClassement_1[] = array('img' => "images/dyn/rating_green.png",
										'title' => getTradTable('centre_classement', $_SESSION['ses_langue'], 'libelle', $listeCentre['id_centre_classement_1']));
		}
	}
	$this->assign('listeClassement_1', $listeClassement_1);
}



$this->assign("id_centre",$iIdCentre);
$this->assign("lstCentre",$listeCentre);

$this->display('blocs/fiche_dest_principale.tpl');
?>
