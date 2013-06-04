<?
/**********************************************************************************/
/*	C2IS : 		xxprojetxx
/*	Auteur : 	SBA	  
/*	Date : 		Novembre 2006						  
/*	Version :	1.0							  
/*	Fichier :	inc_chang_langue.inc.php						  
/*										  
/*	Description :	Construction et assignation de l'url de changement de langue
/*										  
/**********************************************************************************/


	
//On definit l'url pour le changement de langue
$url_lang = $_SERVER['PHP_SELF']."?";
//echo($url_lang);
//On recupere l'id de l'autre langue
$id_autre_langue = 1;
if ($_SESSION['ses_langue']==1)
	$id_autre_langue = 2;
	
//Si le paramètre langue est deja présent on le remplace
$query_str = $_SERVER['QUERY_STRING'];
if (ereg("L=[^&]",$query_str))
	$query_str= ereg_replace ("L=[^&]*","L=".$id_autre_langue,$query_str);
else
	$query_str.= "&L=".$id_autre_langue;
	
$url_lang .=	$query_str;

$template -> assign("url_chang_langue", ($url_lang));
?>
