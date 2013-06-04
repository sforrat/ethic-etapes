<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	offre_emploi.php						  
/*										  
/*	Description :	Page offre emploi
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$tabNav = get_navID($_GET["Rub"]);

// calcul du nombre d'offres pour savoir si on doit afficher le moteur de recherche
$sql = "SELECT
			count(*) as nb
		FROM 
			offre_emploi
		WHERE
			(date_depublication > NOW() OR date_depublication = '0000-00-00')
			AND 
			(date_publication <= NOW())";
$result = mysql_query($sql);
$nb = mysql_result($result,0,"nb");
if($nb>=10){
  $template->assign("afficheMoteur",1);

}else{
  $template->assign("afficheMoteur",0);
}
// --------------------------------------------------------------------------------


$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));
$template->display('offre_emploi.tpl');

?>