<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	bloc_newsletter.php						  
/*										  
/*	Description :	Colonne de gauche                 
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
		

$this->assign("url",get_url_nav(_NAV_NEWSLETTER));


$this -> display('blocs/blocNewsletter_simple.tpl');
?>
