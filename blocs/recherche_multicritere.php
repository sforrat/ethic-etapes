<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	recherche_geographique.php						  
/*										  
/*	Description :	Recherche géographique               
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";

if (isset($_REQUEST['individuel']))
	$this -> assign ('is_individuel_filter', true);

if (isset($_REQUEST['groupe']))
	$this -> assign ('is_groupe_filter', true);	

getListeCentreEnvironnement($listeCEnv);
$this -> assign ('listeCEnv', $listeCEnv);

getListeCentreAmbiance($liste);
$this -> assign ('listeAmbiance', $liste);

$this -> assign ('action_recherche_multicriteres', get_url_nav(_NAV_DESTINATIONS));

$this -> display('blocs/recherche_multicritere.tpl');
?>
