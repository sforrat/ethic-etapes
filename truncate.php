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

// Affichage la page elle même
// les blocs sont inclus directement dans le template de la page
// les variables de positionnement de contexte sont passées depuis cette page vers les différents blocs
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`acceuil_reunions`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`accueil_groupes_jeunes_adultes`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`accueil_groupes_scolaires`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`centre`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`trad_centre_site_touristique`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`trad_centre_les_plus`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`trad_centre`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`trad_accueil_groupes_scolaires`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`trad_accueil_groupes_jeunes_adultes`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`centre_site_touristique`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`trad_centre_site_touristique`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`sejour_tarif_groupe`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`trad_sejour_tarif_groupe`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`sejour_tarif_groupe_plus`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`trad_sejour_tarif_groupe_plus`";
mysql_query($sql);
?>
