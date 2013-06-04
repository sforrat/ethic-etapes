<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	bloc_brochure.php						  
/*										  
/*	Description :	Colonne de gauche                 
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
		

$this->assign("url_brochure",get_url_nav(_NAV_BROCHURE));


$this -> display('blocs/blocBrochure.tpl');
?>
