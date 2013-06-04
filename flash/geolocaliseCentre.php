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
$path="../";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

$sql = "select id_centre,ville,paris_arrondissement,flash_x,flash_y,flash_paris,id_centre from centre";


if( $_REQUEST["idLabel"] >0 || $_REQUEST["idEnvironnement"] >0){
  $sql.= " WHERE ";
  
  
 
  if($_REQUEST["idLabel"] >0 && $_REQUEST["idEnvironnement"] >0){
    $sql.= " ".get_multi_fullkit_choice('centre.id_centre_ambiance',$_REQUEST["idEnvironnement"])." and ".get_multi_fullkit_choice('centre.id_centre_detention_label',$_REQUEST["idLabel"]);
    
 
  }
  elseif($_REQUEST["idLabel"] >0){
    $sql.= "  ".get_multi_fullkit_choice('centre.id_centre_detention_label',$_REQUEST["idLabel"])." ";
    //$sql.= " centre.id_centre_detention_label in (".$_REQUEST["idLabel"].") ";
  }
  elseif($_REQUEST["idEnvironnement"] >0){
    $sql.= "  ".get_multi_fullkit_choice('centre.id_centre_ambiance',$_REQUEST["idEnvironnement"])." ";
    //$sql.= " centre.id_centre_environnement in (".$_REQUEST["idEnvironnement"].") ";
  }
}

if( ($_REQUEST["idCentre"] != "" || $_SESSION["idCentre"]!="") && $_REQUEST["Rub"] != _NAV_ACCUEIL){

  
  if($_REQUEST["idCentre"] != ""){
      $listeId = $_REQUEST["idCentre"];
  }else{
      $listeId = $_SESSION["idCentre"];
  }

  if (eregi("where", $sql)) {
    $sql.=" and id_centre in(".$listeId.")";
  }else{
    $sql.=" where id_centre in(".$listeId.")";
  }
}

if (eregi("where", $sql)) {
    $sql.=" and etat=1";
  }else{
    $sql.=" where etat=1";
  }




$result = mysql_query($sql);
$i = 0;
while($myrow = mysql_fetch_array($result)){
  if($myrow["paris_arrondissement"] != "" && $myrow["flash_paris"] == 1){
  	
  	
    $ville = $myrow["paris_arrondissement"];
  }else{
    $ville = $myrow["ville"];
  }
  
  
    
  $sql_S = "select paris_arrondissement from trad_centre where id__centre=".$myrow["id_centre"]." and id__langue=".$_SESSION["ses_langue"];
  $result_S = mysql_query($sql_S);
  
  if(mysql_result($result_S,0,"paris_arrondissement") != ""){
  	$ville.= " ".mysql_result($result_S,0,"paris_arrondissement");
  }
  
  
  $url = get_url_nav_centre(_NAV_FICHE_CENTRE,$myrow["id_centre"]);
  echo "&Url_".$i."=".urlencode($url);
  echo "&Id_".$i."=".$myrow["id_centre"];
  echo "&Paris_".$i."=".$myrow["flash_paris"];
  echo "&X_".$i."=".$myrow["flash_x"];
  echo "&Y_".$i."=".$myrow["flash_y"];
  echo "&Ville_".$i."=".urlencode($ville);
  $i++;
}

if($_REQUEST["centreID"]>0){
  echo "&ViewBlanc=1&Centre=".$_REQUEST["centreID"];
}

echo "&Total=$i&";
?>
