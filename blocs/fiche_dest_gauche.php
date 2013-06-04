<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	GPE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	fiche_dest_gauche.php						  
/*										  
/*	Description :	Bas de page                        
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";

$iIdCentre = $_GET['id_centre'];
$iNbCentre = getListeCentreGP($listeCentre,array('id_centre'=>array($iIdCentre)));//$_GET['id_centre']
$listeCentre=$listeCentre[0];

	$params['id'] = split(",",$listeCentre['id_centre_detention_label']);
	$visuel_label = getCentreLabels($params);
	
	if ($visuel_label['ecolabel'])
		$this -> assign ('ecoLabel', true);
		
	$visuel_label = $visuel_label['label'];
	
	$this -> assign ('title_label', get_libLocal('lib_'.$visuel_label));
	$this -> assign ('label', $visuel_label);


if(sizeof($listeCentre['image'])<=4) $this->assign("bPlus4Image",false);
else $this->assign("bPlus4Image",true);

$this->assign("nbImage",sizeof($listeCentre['image']));

$_SESSION['nom_centre'] = $listeCentre['libelle'];
$this->assign("lstCentre",$listeCentre);
$this->display('blocs/fiche_dest_gauche.tpl');
?>
