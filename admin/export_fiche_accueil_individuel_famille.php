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

$nom_fichier = "export_accueil_individuel_famille.xls";

if($_POST["action"]==1){


  $cmptOuvertureFichier = 0;
  
  $id_langue = $_POST["langueExport"];
  
  $sql = "SELECT DISTINCT centre.* FROM centre";
  
  
  
  $result = mysql_query($sql) or die(mysql_error()."<br>Requete : ".$sql);
  $nb = mysql_num_rows($result);
  
  	$csv = "<style>
				<!--
				br
					{mso-data-placement:same-cell;}
				-->
				</style>";
  
  
  $csv = "<table border='1'>
            <tr>
              <td>Centre</td>
              <td>Ville</td>
              <td>Le coin des familles</td>
              <td>Bébés</td>
              <td>Enfants </td>
              <td>Les plus séjour</td>
            </tr>";
  while($myrow = mysql_fetch_array($result)){
  
  
    $csv .="<tr>";
  	$id_centre = $myrow["id_centre"];
  	
  	
  	
  	if($cmptOuvertureFichier == 0){
  		$fp = fopen($nom_fichier, 'w');
  		$cmptOuvertureFichier = 1;
  	}else{
  		$fp = fopen($nom_fichier, 'a');
  	}
  	
  	$csv.= "<td>".$myrow["libelle"]."</td>";
  	$csv.= "<td>".$myrow["ville"]."</td>";
  	
    //---- Le sejour :
    $sql_S = "SELECT 
              accueil_individuels_familles.*, 
              trad_accueil_individuels_familles.*
            FROM 
              accueil_individuels_familles 
            INNER JOIN 
              trad_accueil_individuels_familles ON (trad_accueil_individuels_familles.id__accueil_individuels_familles = accueil_individuels_familles.id_accueil_individuels_familles AND trad_accueil_individuels_familles.id__langue=$id_langue AND accueil_individuels_familles.id_centre=$id_centre)";
    

    $result_S = mysql_query($sql_S);
    $nb = mysql_num_rows($result_S);
    if(!$nb){
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "</tr>";
    }else{
      $myrow_S = mysql_fetch_array($result_S);
      $id_sejour = $myrow_S["id_accueil_individuels_familles"];
      $csv.= "<td>".$myrow_S["conditions"]."</td>";
      
      
      $texte = test_virgule_fin($myrow_S["id_sejour_services_familles_bebes"]);
      $sql_SS = "SELECT libelle FROM trad_sejour_services_familles_bebes WHERE id__sejour_services_familles_bebes IN ($texte) AND id__langue=1";
      $result_SS = mysql_query($sql_SS);
      $texte="";
      while($myrow_SS=mysql_fetch_array($result_SS)){
        $texte .= $myrow_SS["libelle"]."<br>";
      }
      $csv.= "<td>".$texte."</td>";
      
      $texte = test_virgule_fin($myrow_S["id_sejour_services_familles_enfants"]);
      $sql_SS = "SELECT libelle FROM trad_sejour_services_familles_enfants WHERE id__sejour_services_familles_enfants IN ($texte) AND id__langue=1";
      $result_SS = mysql_query($sql_SS);
      $texte="";
      while($myrow_SS=mysql_fetch_array($result_SS)){
        $texte .= $myrow_SS["libelle"]."<br>";
      }
      $csv.= "<td>".$texte."</td>";
      
      $sql_S = "SELECT
				trad_sejour_les_plus.libelle 
			FROM 
				trad_sejour_les_plus
			INNER JOIN 
				sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus AND trad_sejour_les_plus.id__langue=$id_langue AND sejour_les_plus.idSejour=".$id_sejour." and sejour_les_plus.id__table_def="._CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE.")"; 
    	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
      $texte = "";
    	while($myrow_S = mysql_fetch_array($result_S)){
    		$texte.= $myrow_S["libelle"]."<br>";
    	
    	}
      $csv.= "<td>".$texte."</td>";
      $csv.= "</tr>";  
      
  	}
  	
  
  	fwrite($fp, $csv);
  	$csv="";
  	fclose($fp);
  }
	
	
$csv.= "</table>";




$fp = fopen($nom_fichier, 'a');
fwrite($fp, $csv);
fclose($fp);


echo "<a href='telecharge.php?src=$nom_fichier'><font face='arial'>Cliquez ici pour télécharger le fichier XLS</font></a>";

}
else{
  
  echo"<form action=\"\" method=\"POST\">";
  echo"<input type='hidden' value='1' name='action'/>";
  echo "<table>";
  echo "<tr>";
  echo "  <td>Choisissez une langue pour l'export :</td>";
  echo "  <td>";
  echo "    <select name='langueExport'>";
  
  $sql = "SELECT _langue, id__langue FROM _langue";  
  $result = mysql_query($sql);
  while($myrow = mysql_fetch_array($result)){
    echo"<option value='".$myrow["id__langue"]."'>".$myrow["_langue"]."</option>";
  }
        
  echo "    </select>";
  echo "  </td>";
  echo "</tr>";
  echo "<tr>";
  echo "  <td colspan='2'><input type='submit' value='Valider' /></td>";
  echo "</tr>";
   echo "</table>";
  
  echo"<form>";
  
  
}

function zero_or_one($i){
  if($i == 0){
    return "non";
  }else{
    return "oui";
  }
}


function test_virgule_fin($texte){
	$rest = substr($texte, -1);
	if($rest == ","){
		$return = substr($texte, 0, -1);
	}else{
		$return = $texte;
	}
	return $return;
}
?>
