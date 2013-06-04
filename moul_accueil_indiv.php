<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY 							  
/*	Date : 		JUIN 2009
/*	Version :	1.0							  
/*	Fichier :	index.php						  
/*										  
/*	Description :	Home page Front office du site                        

/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

$sql = "SELECT id__accueil_individuels_familles FROM trad_accueil_individuels_familles WHERE haute_saison='' AND moyenne_saison='' AND basse_saison=''  AND id__langue=1 AND conditions IS NULL ";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
  $sql_S = "delete from accueil_individuels_familles where id_accueil_individuels_familles=".$myrow["id__accueil_individuels_familles"];
  //echo $sql_S."<br>";
  $result_S = mysql_query($sql_S);
}

?>
