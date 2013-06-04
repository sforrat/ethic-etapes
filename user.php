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

$sql = "select * from centre";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
  $sql_I = "update _user set id_centre ='".$myrow["id_centre"]."' where login='".$myrow["login"]."' and password='".$myrow["passe"]."'";
  echo $sql_I."<br>";
  $result_I= mysql_query($sql_I);
}

?>
