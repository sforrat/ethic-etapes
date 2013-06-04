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

$sql = "select id__user,login from _user where id__profil=4";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
  $sql_S = "insert into portfolio_rub (portfolio_rub,id__user) VALUES ('mes_images-".$myrow["login"]."',".$myrow["id__user"].")";
  //echo $sql_S."<br>";
  $result_S = mysql_query($sql_S);
}

?>
