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

$sql = "SELECT id_centre FROM accueil_individuels_familles";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$sql_S = "select * from centre where id_centre=".$myrow["id_centre"];
	$result_S = mysql_query($sql_S);
	$nb = mysql_num_rows($result_S);
	if(!$nb){
		  $sql_SS = "delete from accueil_individuels_familles where id_centre=".$myrow["id_centre"];
		  //echo $sql_S.";<br>";
		  $result_S = mysql_query($sql_SS);
	}

}

?>
