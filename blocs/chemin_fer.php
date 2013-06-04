<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY 							  
/*	Date : 		 
/*	Version :	1.0							  
/*	Fichier :	chemin_fer.php						  
/*										  
/*	Description :	Bloc de gestion du chemin de fer                        
/*										  
/**********************************************************************************/

// on r�cup�re le chemin de nav courant
$navID = get_navID($GLOBALS['Rub']);

// r�cup�re le chemin de fer courant
$chemin_fer = get_chemin_fer_interne($GLOBALS['Rub'], $navID, false);

$this -> assign("CHEMIN_FER", $chemin_fer);

$this -> display('blocs/chemin_fer.tpl');
?>
