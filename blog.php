<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY 							  
/*	Date : 		JUIN 2009
/*	Version :	1.0							  
/*	Fichier :	editorial.php						  
/*										  
/*	Description :	Page �ditoriale
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");


if($_GET["idRub"] == "actualite"){
	$template->assign('url_blog','blog/blog5.php/');
}elseif($_GET["idRub"] == "bonplan"){
	$template->assign('url_blog','blog/blog5.php/bons-plans/');
}elseif($_GET["id_article"] >0){
	$date = date("Y/m/d");

	
	if($_GET["Rub"] == _NAV_ACTUALITE){
		$sql = "select libelle from trad_actualite where id__langue=".$_SESSION["ses_langue"]." and id__actualite=".$_GET["id_article"];
		$result = mysql_query($sql);
		$titreArticle = utf8_decode(mysql_result($result,0,"libelle"));
		$titreArticle = get_formatte_membre_url_rewrited($titreArticle);
	}else{
		$sql = "select libelle from trad_bon_plan where id__langue=".$_SESSION["ses_langue"]." and id__bon_plan=".$_GET["id_article"];
		$result = mysql_query($sql);
		$titreArticle = utf8_decode(mysql_result($result,0,"libelle"));
		$titreArticle = get_formatte_membre_url_rewrited($titreArticle);
	}

	//echo 'blog/blog5.php/'.$date.'/'.$titreArticle;
	//die();
	if($_SESSION["ses_langue"]==1){
	 $template->assign('url_blog','blog/blog5.php/'.$date.'/'.$titreArticle);
	}elseif($_SESSION["ses_langue"]==2){
	 $template->assign('url_blog','blog/blog6.php/'.$date.'/'.$titreArticle);
	}elseif($_SESSION["ses_langue"]==3){
	 $template->assign('url_blog','blog/blog7.php/'.$date.'/'.$titreArticle);
	}elseif($_SESSION["ses_langue"]==5){
	 $template->assign('url_blog','blog/blog8.php/'.$date.'/'.$titreArticle);
	}
	//$template->assign('url_blog','blog/blog5.php/'.$date.'/'.$titreArticle);
}else{
	$template->assign('url_blog','blog/index.php');
}

$template->display('blog.tpl');
?>
