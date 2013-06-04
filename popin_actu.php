<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	partenaire.php						  
/*										  
/*	Description :	Page PARTENAIRE
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$tabNav = get_navID($_GET["Rub"]);

$sql = "select
			t.libelle,
			t.description_courte,
			t.description_longue,
			a.visuel_1
		from
			trad_actualite t
		inner join 
			actualite a on (t.id__actualite = a.id_actualite and t.id__langue=".$_SESSION["ses_langue"]." and a.id_actualite=".$_REQUEST["id"].")";
$result = mysql_query($sql);

$template->assign("titre",mb_strtoupper(mysql_result($result,0,"libelle"),"utf-8"));
$template->assign("visuel",getFileFromBDD(mysql_result($result,0,"visuel_1"),"actualite"));

list($width, $height, $type, $attr) = getimagesize(getFileFromBDD(mysql_result($result,0,"visuel_1"),"actualite"));
if($width>620){
	$temp_width  = $width;
	$temp_height = $height;
	
	$rapport = ((620*100) / $temp_width);
	$width=620;

	
	$height = ($rapport * $temp_height)/100;
	
}
$template->assign("height",$height);
$template->assign("width",$width);

if(mysql_result($result,0,"description_longue") != ""){
	$template->assign("description",mysql_result($result,0,"description_longue"));
}else{
	$template->assign("description",mysql_result($result,0,"description_courte"));
}


$template->display('popin_actu.tpl');

?>