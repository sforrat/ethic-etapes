<?
/**********************************************************************************/
/*	C2IS : 		xxprojetxx
/*	Auteur : 	SBA	  
/*	Date : 		Novembre 2006						  
/*	Version :	1.0							  
/*	Fichier :	inc_lib_language.inc.php						  
/*										  
/*	Description :	sous include permettant d'aller chercher la bon bundle de langue                     
/*										  
/**********************************************************************************/

// determine quel fichier de définition de langue on doit importer ?
$filename_langue = $path."include/language/lib_language_".$_SESSION['ses_langue_ext'].".inc.php";

if (is_file($filename_langue))
{
	include($filename_langue);	
}
?>