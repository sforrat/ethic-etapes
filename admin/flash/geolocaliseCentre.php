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
$path="../../";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

$sql = "select ville,paris_arrondissement,flash_x,flash_y,flash_paris,id_centre from centre where flash_x!='' and id_centre!=".$_POST["id_centre"];



$result = mysql_query($sql);
$i = 0;
while($myrow = mysql_fetch_array($result)){
  if($myrow["paris_arrondissement"] != "" && $myrow["flash_paris"] == 1){
    $ville = $myrow["paris_arrondissement"];
  }else{
    $ville = $myrow["ville"];
  }
  
  $url = get_url_nav_centre(_NAV_FICHE_CENTRE,$myrow["id_centre"]);
  echo "&Url_".$i."=".urlencode(utf8_encode($url));
  echo "&Id_".$i."=".$myrow["id_centre"];
  echo "&Paris_".$i."=".$myrow["flash_paris"];
  echo "&X_".$i."=".$myrow["flash_x"];
  echo "&Y_".$i."=".$myrow["flash_y"];
  echo "&Ville_".$i."=".urlencode(utf8_encode($ville));
  $i++;
}

if($_REQUEST["centreID"]>0){
  echo "&ViewBlanc=1&Centre=".$_REQUEST["centreID"];
}

echo "&Total=$i&";
?>
