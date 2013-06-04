<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	footer.php						  
/*										  
/*	Description :	Bas de page                        
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
//$this->assign("titre_recherche",get_liblocal("lib_titre_recherche"));

$iNbInfos = getListeCentreInfos("detention_label",$liste_detention_label);
$iNbEnviron = getListeCentreEnvironnement($liste_environnement);

if($iNbInfos) $this->assign("is_infos",true);
if($iNbEnviron) $this->assign("is_environ",true);

$this->assign("label",$liste_detention_label);
$this->assign("environmt",$liste_environnement);
$this->display('blocs/moteur_resa.tpl');
?>
