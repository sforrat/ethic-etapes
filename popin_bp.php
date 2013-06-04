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
			t.description,
			bp.visuel,
			DATE_FORMAT( bp.date_debut, '%d/%m/%Y') as date_debut,
			DATE_FORMAT( bp.date_fin, '%d/%m/%Y') as date_fin
		from
			trad_bon_plan t
		inner join 
			bon_plan bp on (t.id__bon_plan = bp.id_bon_plan and t.id__langue=".$_SESSION["ses_langue"]." and bp.id_bon_plan=".$_REQUEST["id"].")";
$result = mysql_query($sql);

$template->assign("titre",mb_strtoupper(mysql_result($result,0,"libelle"),"utf-8"));
$template->assign("visuel",getFileFromBDD(mysql_result($result,0,"visuel"),"bon_plan"));

list($width, $height, $type, $attr) = getimagesize(getFileFromBDD(mysql_result($result,0,"visuel"),"bon_plan"));
if($width>620){
	$temp_width = $width;
	$temp_height = $height;
	
	$rapport = ((620*100) / $temp_width);
	$width=620;

	
	$height = ($rapport * $temp_height)/100;
	
}
$template->assign("width",$width);
$template->assign("height",$height);
$template->assign("description",mysql_result($result,0,"description"));

$lib_date = get_libLocal('lib_du')." ".mysql_result($result,0,"date_debut")." ".get_libLocal('lib_au')." ".mysql_result($result,0,"date_fin");
$template->assign("lib_date",$lib_date);
$template->display('popin_bp.tpl');

?>