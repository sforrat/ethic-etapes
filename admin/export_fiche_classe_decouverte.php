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

$nom_fichier = "export_classe_decouverte.xls";

if($_POST["action"]==1){


  $cmptOuvertureFichier = 0;
  
  $id_langue = $_POST["langueExport"];
  
  $sql = "SELECT 
            classe_decouverte.*, 
            trad_classe_decouverte.duree_sejour AS trad_duree_sejour,
            trad_classe_decouverte.prix_comprend AS trad_prix_comprend,
            trad_classe_decouverte.prix_ne_comprend_pas AS trad_prix_ne_comprend_pas,
            trad_classe_decouverte.interet_pedagogique AS trad_interet_pedagogique,
            trad_classe_decouverte.details AS trad_details,
            centre.libelle,
            centre.ville 
          FROM 
            classe_decouverte
          INNER JOIN
            centre on (centre.id_centre=classe_decouverte.id_centre)  
          INNER JOIN 
            trad_classe_decouverte ON 
            (trad_classe_decouverte.id__langue=$id_langue AND classe_decouverte.id_classe_decouverte=trad_classe_decouverte.id__classe_decouverte) ORDER BY id_centre";
  
  
  
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
              <td>Niveau(x) scolaire(s) concerné(s)</td>
              <td>Durée du séjour (XX jours / XX nuits)</td>
              <td>Nombre de jours</td>
              <td>Nombre de nuits</td>
              <td>Période de disponibilité du séjour</td>
              <td>Nombre de lits par chambre (pour élèves)</td>
              <td>Prix à partir de</td>
              <td>Prix à partir de (suite)</td>
              <td>Le prix comprend</td>
              <td>Le prix ne comprend pas</td>
              <td>Intérêt pédagogique du séjour </td>
              <td>Détails de l’offre</td>
              <td>Les plus séjour</td>
            </tr>";
  while($myrow = mysql_fetch_array($result)){
  
    $csv .="<tr>";
  	$id_centre = $myrow["id_centre"];
  	$id_sejour = $myrow["id_classe_decouverte"];
  	
  	
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
  	$id_sejour_theme = test_virgule_fin($myrow["id_sejour_theme"]);
  	$sql_S = "SELECT libelle FROM trad_sejour_theme WHERE id__sejour_theme IN($id_sejour_theme) AND id__langue=$id_langue";
  	$result_S = mysql_query($sql_S);
  	$texte="";
  	while($myrow_S = mysql_fetch_array($result_S)){
  	   $texte.=$myrow_S["libelle"]."<br>";
    }
  	$csv.= "<td>".$texte."</td>";
  	
  	
  	//---- sejour niveau scolaire
  	$id_sejour_niveau_scolaire = test_virgule_fin($myrow["id_sejour_niveau_scolaire"]);
  	$sql_S = "SELECT libelle FROM trad_sejour_niveau_scolaire WHERE id__sejour_niveau_scolaire IN($id_sejour_niveau_scolaire) AND id__langue=$id_langue";
  	$result_S = mysql_query($sql_S);
  	$texte="";
  	while($myrow_S = mysql_fetch_array($result_S)){
  	   $texte.=$myrow_S["libelle"]."<br>";
    }
  	$csv.= "<td>".$texte."</td>";
  	
  	$csv.= "<td>".$myrow["trad_duree_sejour"]."</td>";
  	$csv.= "<td>".$myrow["nb_jours"]."</td>";
  	$csv.= "<td>".$myrow["nb_nuits"]."</td>";
  	
  	
  	//---- sejour periode disponibilité
  	$id_sejour_periode_disponibilite = test_virgule_fin($myrow["id_sejour_periode_disponibilite"]);
  	$sql_S = "SELECT libelle FROM trad_sejour_periode_disponibilite WHERE id__sejour_periode_disponibilite IN($id_sejour_periode_disponibilite) AND id__langue=$id_langue";
  	$result_S = mysql_query($sql_S);
  	$texte="";
  	while($myrow_S = mysql_fetch_array($result_S)){
  	   $texte.=$myrow_S["libelle"]."<br>";
    }
  	$csv.= "<td>".$texte."</td>";
  	
  	//---- Sejour nb lit par chambre
  	$id = test_virgule_fin($myrow["id_sejour_nb_lit__par_chambre"]);
  	$sql_S = "SELECT libelle FROM trad_sejour_nb_lit__par_chambre WHERE id__sejour_nb_lit__par_chambre IN($id) AND id__langue=$id_langue";
  	$result_S = mysql_query($sql_S);
  	$texte="";
  	while($myrow_S = mysql_fetch_array($result_S)){
  	   $texte.=$myrow_S["libelle"]."<br>";
    }
  	$csv.= "<td>".$texte."</td>";
  	
  	$csv.= "<td>".$myrow["a_partir_de_prix"]."</td>";
  	$csv.= "<td>".$myrow["prix_par_29"]."</td>";
  	$csv.= "<td>".$myrow["trad_prix_comprend"]."</td>";
  	$csv.= "<td>".$myrow["trad_prix_ne_comprend_pas"]."</td>";
  	$csv.= "<td>".$myrow["trad_interet_pedagogique"]."</td>";
  	$csv.= "<td>".$myrow["trad_details"]."</td>";
  	
  	$sql_S = "SELECT
				trad_sejour_les_plus.libelle 
			FROM 
				trad_sejour_les_plus
			INNER JOIN 
				sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus AND trad_sejour_les_plus.id__langue=$id_langue AND sejour_les_plus.idSejour=".$id_sejour." and sejour_les_plus.id__table_def="._CONST_TABLEDEF_CLASSE_DECOUVERTE.")"; 
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
