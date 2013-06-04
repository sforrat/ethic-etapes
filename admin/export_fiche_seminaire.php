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

$nom_fichier = "export_seminaire.xls";

if($_POST["action"]==1){


  $cmptOuvertureFichier = 0;
  
  $id_langue = $_POST["langueExport"];
  
  $sql = "SELECT 
            seminaires.*, 
            trad_seminaires.presentation as trad_presentation,
            trad_seminaires.prix_comprend as trad_prix_comprend,
            trad_seminaires.prix_ne_comprend_pas as trad_prix_ne_comprend_pas,
            trad_seminaires.descriptif as trad_descriptif,
            centre.libelle,
            centre.ville 
          FROM 
            seminaires
          INNER JOIN
            centre ON (centre.id_centre=seminaires.id_centre)  
          INNER JOIN 
            trad_seminaires ON 
            (trad_seminaires.id__langue=$id_langue AND seminaires.id_seminaires=trad_seminaires.id__seminaires) ORDER BY id_centre";
  
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
              <td>Thème</td>
              <td>Présentation</td>
              <td>Prix à partir de (par participant) </td>
              <td>Le prix comprend </td>
              <td>Le prix ne comprend pas</td>
              <td>Descriptif du séminaire</td>
              <td>Séjour adapté</td>
              <td>Les plus séjour</td>
            </tr>";
            
  while($myrow = mysql_fetch_array($result)){
  
    $csv .="<tr>";
  	$id_centre = $myrow["id_centre"];
  	$id_sejour = $myrow["id_seminaires"];
  	
  	
  	if($cmptOuvertureFichier == 0){
  		$fp = fopen($nom_fichier, 'w');
  		$cmptOuvertureFichier = 1;
  	}else{
  		$fp = fopen($nom_fichier, 'a');
  	}
  	
  	$csv.= "<td>".$myrow["libelle"]."</td>";
  	$csv.= "<td>".$myrow["ville"]."</td>";
    $csv.= "<td>".$myrow["nom"]."</td>";
    
  	//---- Thème
  	$id_sejour_theme = test_virgule_fin($myrow["id_sejour_theme_seminaire"]);
  	$sql_S = "SELECT libelle FROM trad_sejour_theme_seminaire WHERE id__sejour_theme_seminaire IN($id_sejour_theme) AND id__langue=$id_langue";
  	$result_S = mysql_query($sql_S);
  	$texte="";
  	while($myrow_S = mysql_fetch_array($result_S)){
  	   $texte.=$myrow_S["libelle"]."<br>";
    }
  	$csv.= "<td>".$texte."</td>";
  	
  	$csv.= "<td>".$myrow["trad_presentation"]."</td>";
  	$csv.= "<td>".$myrow["a_partir_de_prix"]."</td>";
  	$csv.= "<td>".$myrow["trad_prix_comprend"]."</td>";
  	$csv.= "<td>".$myrow["trad_prix_ne_comprend_pas"]."</td>";
  	$csv.= "<td>".$myrow["trad_descriptif"]."</td>";
  	
  	//---- Sejour Acces handicap
  	$id = test_virgule_fin($myrow["id_sejour_accueil_handicap"]);
  	$sql_S = "SELECT libelle FROM trad_sejour_accueil_handicap WHERE id__sejour_accueil_handicap IN($id) AND id__langue=$id_langue";
  	$result_S = mysql_query($sql_S);
  	$texte="";
  	while($myrow_S = mysql_fetch_array($result_S)){
  	   $texte.=$myrow_S["libelle"]."<br>";
    }
  	$csv.= "<td>".$texte."</td>";
  	
  		
  	$sql_S = "SELECT
				trad_sejour_les_plus.libelle 
			FROM 
				trad_sejour_les_plus
			INNER JOIN 
				sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus AND trad_sejour_les_plus.id__langue=$id_langue AND sejour_les_plus.idSejour=".$id_sejour." and sejour_les_plus.id__table_def="._CONST_TABLEDEF_SEMINAIRE.")"; 
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
