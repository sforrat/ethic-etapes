<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	bloc contact.php						  
/*										  
/*	Description :	Colonne de gauche                 
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
		

$this->assign("adresse",get_libLocal('lib_adresse_ee'));
$this->assign("horaire",get_libLocal('lib_horaire_ee'));
$this->assign("tel",get_libLocal('lib_tel_ee'));

$this -> display('blocs/blocContact.tpl');
?>
