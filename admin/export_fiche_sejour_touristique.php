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

$nom_fichier = "export_sejour_touristique.xls";

if($_POST["action"]==1){


  $cmptOuvertureFichier = 0;
  
  $id_langue = $_POST["langueExport"];
  
  $sql = "	SELECT 
      		    sejours_touristiques.*, 
      		    trad_sejours_touristiques.nom_sejour AS trad_nom_sejour,
      		    trad_sejours_touristiques.duree_sejour AS trad_duree_sejour,
      		    trad_sejours_touristiques.descriptif AS trad_descriptif,
      		    trad_sejours_touristiques.prix_comprend AS trad_prix_comprend,
      		    trad_sejours_touristiques.prix_ne_comprend_pas AS trad_prix_ne_comprend_pas,
      		    trad_sejours_touristiques.conditions_professionnels AS trad_conditions_professionnels,
      		    trad_sejours_touristiques.details AS trad_details,
      		    centre.libelle,
      		    centre.ville 
      		  FROM 
      		    sejours_touristiques
      		  INNER JOIN
      		    centre ON (centre.id_centre=sejours_touristiques.id_centre)  
      		  INNER JOIN 
      		    trad_sejours_touristiques ON 
      		    (trad_sejours_touristiques.id__langue=$id_langue AND sejours_touristiques.id_sejours_touristiques=trad_sejours_touristiques.id__sejours_touristiques) ORDER BY id_centre";
        
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
              <td>Séjour</td>
              <td>Durée du séjour (XX jours / XX nuits) </td>
              <td>Nombre de jours</td>
              <td>Nombre de nuits</td>
              <td>Durée du séjour</td>
              <td>Descriptif sommaire du séjour </td>
              <td>Période de disponibilité du séjour</td>
              <td>Prix à partir de (par participant)</td>
              <td>Le prix comprend</td>
              <td>Le prix ne comprend pas</td>
              <td>Conditions pour les professionnels</td>
              <td>Détails du programme</td>
              <td>Le séjour est adapté pour les IME/IMP</td>
              <td>Les plus séjour</td>
            </tr>";
            
  while($myrow = mysql_fetch_array($result)){
  
    $csv .="<tr>";
  	$id_centre = $myrow["id_centre"];
  	$id_sejour = $myrow["id_sejours_touristiques"];
  	
  	
  	if($cmptOuvertureFichier == 0){
  		$fp = fopen($nom_fichier, 'w');
  		$cmptOuvertureFichier = 1;
  	}else{
  		$fp = fopen($nom_fichier, 'a');
  	}
  	
  	$csv.= "<td>".$myrow["libelle"]."</td>";
  	$csv.= "<td>".$myrow["ville"]."</td>";
    $csv.= "<td>".$myrow["trad_nom_sejour"]."</td>";
    $csv.= "<td>".$myrow["trad_duree_sejour"]."</td>";
    $csv.= "<td>".$myrow["nb_jours"]."</td>";
    $csv.= "<td>".$myrow["nb_nuits"]."</td>";
    
    $sql_S = "SELECT libelle FROM trad_sejour_duree WHERE id__sejour_duree=".$myrow["id_sejour_duree"]." AND id__langue=$id_langue";
  	$result_S = mysql_query($sql_S);
    $csv.= "<td>".mysql_result($result_S,0,"libelle")."</td>";
    
    $csv.= "<td>".$myrow["trad_descriptif"]."</td>";
    
  	//---- periode_disponibilite
  	$id = test_virgule_fin($myrow["id_sejour_periode_disponibilite"]);
  	$sql_S = "SELECT libelle FROM trad_sejour_periode_disponibilite WHERE id__sejour_periode_disponibilite IN($id) AND id__langue=$id_langue";
  	$result_S = mysql_query($sql_S);
  	$texte="";
  	while($myrow_S = mysql_fetch_array($result_S)){
  	   $texte.=$myrow_S["libelle"]."<br>";
    }
  	$csv.= "<td>".$texte."</td>";
  	
  	$csv.= "<td>".$myrow["a_partir_de_prix"]."</td>";
  	$csv.= "<td>".$myrow["trad_prix_comprend"]."</td>";
  	$csv.= "<td>".$myrow["trad_prix_ne_comprend_pas"]."</td>";
  	$csv.= "<td>".$myrow["trad_conditions_professionnels"]."</td>";
  	$csv.= "<td>".$myrow["trad_details"]."</td>";
  	$csv.= "<td>".$myrow["adapte_IME_IMP_4"]."</td>";
  	  	
  	
  	$sql_S = "SELECT
				trad_sejour_les_plus.libelle 
			FROM 
				trad_sejour_les_plus
			INNER JOIN 
				sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus AND trad_sejour_les_plus.id__langue=$id_langue AND sejour_les_plus.idSejour=".$id_sejour." and sejour_les_plus.id__table_def="._CONST_TABLEDEF_SEJOUR_TOURISTIQUE.")"; 
    	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
      $texte = "";
    	while($myrow_S = mysql_fetch_array($result_S)){
    		$texte.= $myrow_S["libelle"]."<br>";
    	
    	}
      $csv.= "<td>".$texte."</td>";
  	
    $csv.= "</tr>";  
      
  	
  	
  
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
