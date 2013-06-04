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

function getListeSejourContactType(&$listeContactType, $_params = "")
{

	if ($_REQUEST['Rub'] == _NAV_CLASSE_DECOUVERTE || $_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPES_SCOLAIRES || $_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPE)
	{
		$listeContactType[] = array (	"id" =>  		1,
										"libelle" => 	get_libLocal('lib_enseignant'));
										
		$listeContactType[] = array (	"id" =>  		2,
										"libelle" => 	get_libLocal('lib_agence_to_special_scolaire'));	
															
	}		

	if ($_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPE)	
	{
		$listeContactType[] = array (	"id" =>  		3,
										"libelle" => 	get_libLocal('lib_organisateur_vacances'));		
	
		$listeContactType[] = array (	"id" =>  		4,
										"libelle" => 	get_libLocal('lib_organisateur_reunion'));	
										
		$listeContactType[] = array (	"id" =>  		5,
										"libelle" => 	get_libLocal('lib_to_special_groupe'));				
										
		$listeContactType[] = array (	"id" =>  		6,
										"libelle" => 	get_libLocal('lib_ce'));				
	
		$listeContactType[] = array (	"id" =>  		7,
										"libelle" => 	get_libLocal('lib_assoc_orga_sportif'));	
	
		$listeContactType[] = array (	"id" =>  		9,
										"libelle" => 	get_libLocal('lib_autre_type_groupe'));		
	}																		
	
	if ($_REQUEST['Rub'] == _NAV_CLASSE_DECOUVERTE || $_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPES_SCOLAIRES)
		$listeContactType[] = array (	"id" =>  		9,
										"libelle" => 	get_libLocal('lib_autre'));			
	
	return count($listeContactType);
} // getListeCentreContactType(&$listeContactType, $_params = "")

//nom du centre/s�jour
$template->assign("nom_centre", $_SESSION['nom_centre']);

//newsletters
getListeNewsletter($listeNewsletter);
$template->assign("listeNewsletter",$listeNewsletter);

//**Civilité
getListeCivilite($listeCivilite);
$template->assign("listeCivilite",$listeCivilite);

//**Pays
getListePays($listePays);
$template->assign("listePays",$listePays);

//**Type Etablissement
getListeEtablissementType($listeEtablissementType);
$template->assign("listeEtablissementType",$listeEtablissementType);

//**Discipline
getListeDiscipline($listeDiscipline);
$template->assign("listeDiscipline",$listeDiscipline);

//**Niveau scolaire
$nbNiveauScolaire = getListeSejourInfos('niveau_scolaire', $listeNiveauScolaire);
$template->assign("listeNiveauScolaire",$listeNiveauScolaire);


$iNbContactType = getListeSejourContactType($listeContactType);

if($iNbContactType > 0) 
{
	$template->assign("is_contact_type",true);
	$template->assign("listeContactType",$listeContactType);
}

	$template->assign("titre",mb_strtoupper(get_libLocal('lib_formulaire_contact').' '.get_trad_nav($_REQUEST['Rub']), "utf-8"));

		
	$libNewsletter = get_libLocal('lib_inscription_newsletter');
	switch ($_REQUEST['Rub'])	
	{
		case _NAV_CLASSE_DECOUVERTE :
			$template->assign("isEPeriodeSouhaite",true);
			$template->assign("isDureeSouhaite",true);	
			$template->assign("isENbPersonnes",true);	
			
			$template->assign("isNomTo",true);
			$template->assign("isNbPersonnes",true);	

			$libNewsletter = get_libLocal('lib_inscription_newsletter_scolaire');
			
			getListeSejour($_REQUEST['Rub'], $sejour, array('id_sejour' => $_REQUEST['id']));
			$template->assign("rappelSejour",$sejour[0]['libelle']);						
			break;
		
		case _NAV_ACCUEIL_GROUPES_SCOLAIRES :
			$template->assign("isEPeriodeSouhaite",true);
			$template->assign("isDureeSouhaite",true);	
			$template->assign("isENbPersonnes",true);	
			//$template->assign("isEPresentationProjet",true);			
			
			$template->assign("isNomTo",true);
			$template->assign("isNbPersonnes",true);
			$libNewsletter = get_libLocal('lib_inscription_newsletter_scolaire');		
			break;
			
		case _NAV_CVL :
			$template->assign("isAgeEnfant",true);
			$template->assign("isPeriodeSouhaite",true);
			
			getListeSejour($_REQUEST['Rub'], $sejour, array('id_sejour' => $_REQUEST['id']));
			$template->assign("rappelSejour",$sejour[0]['libelle']);				
			break;
			
		case _NAV_ACCEUIL_REUNIONS :
			$template->assign("isPeriodeSouhaite",true);
			$template->assign("isNbPersonnes",true);
			$template->assign("isPresentationProjet",true);				
			break;	
			
		case _NAV_INCENTIVE :
		case _NAV_SEMINAIRES :
			$template->assign("isPeriodeSouhaite",true);
			$template->assign("isNbPersonnes",true);	
			$template->assign("isPresentationProjet",true);	
			getListeSejour($_REQUEST['Rub'], $sejour, array('id_sejour' => $_REQUEST['id']));
			$template->assign("rappelSejour",$sejour[0]['libelle']);					
			break;						
			
		case _NAV_ACCUEIL_GROUPE :	
			$template->assign("isNomAssoc",true);
			$template->assign("isDiscipline",true);		
			$template->assign("isPresentationProjet",true);	
			$template->assign("isNomStructure",true);		
			break;	
		case _NAV_ACCUEIL_INDIVIDUEL :	
    $template->assign("isPresentationProjet",true);	
    break;	
		case _NAV_ACCUEIL_SPORTIF :	
			$template->assign("isNomAssoc",true);
			$template->assign("isDiscipline",true);		
      $template->assign("isPresentationProjet",true);		
			break;		
					
		case _NAV_SEJOURS_TOURISTIQUES_GROUPE :	
			$template->assign("isNomStructureOption",true);
		case _NAV_SHORT_BREAK :	
			$template->assign("isNomStructureOption",true);
		case _NAV_STAGES_THEMATIQUES_GROUPE :
			$template->assign("isNomStructureOption",true);
   		case _NAV_STAGES_THEMATIQUES_INDIVIDUEL :	
   			$template->assign("isNomStructureOption",true);
		    $template->assign("isPresentationProjet",true);	
			$template->assign("isNomStructure",true);	
			getListeSejour($_REQUEST['Rub'], $sejour, array('id_sejour' => $_REQUEST['id']));
			$template->assign("rappelSejour",$sejour[0]['libelle']);					
			break;						
			
		default:
			break;
	}	
	
	$template->assign("libNewsletter",$libNewsletter);		
	
	$template->assign("Rub",$_REQUEST['Rub']);		
	//$template->assign("idSejour",$_REQUEST['id']);		
	$template->assign("nom_sejour",$_GET['nom_sejour']);		
	$template->assign("id_centre",$_GET['id_centre']);
	
	
	$template->display('form_sejour_contact.tpl');

?>