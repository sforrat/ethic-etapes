<?
// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");

$nom_fichier = "export_stages_thematiques_individuels.xls";

if($_POST["action"]==1){


  $cmptOuvertureFichier = 0;
  
  $id_langue = $_POST["langueExport"];
  
  $sql = "SELECT 
    		    stages_thematiques_individuels.*, 
    		    trad_stages_thematiques_individuels.nom AS trad_nom,
    		    trad_stages_thematiques_individuels.duree_sejour AS trad_duree_sejour,
    		    trad_stages_thematiques_individuels.prix_comprend AS trad_prix_comprend,
    		    trad_stages_thematiques_individuels.prix_ne_comprend_pas AS trad_prix_ne_comprend_pas,
    		    trad_stages_thematiques_individuels.conditions_professionnels AS trad_conditions_professionnels,
    		    trad_stages_thematiques_individuels.descriptif AS trad_descriptif,
    		    centre.libelle,
    		    centre.ville 
    		  FROM 
    		    stages_thematiques_individuels
    		  INNER JOIN
    		    centre ON (centre.id_centre=stages_thematiques_individuels.id_centre)  
    		  INNER JOIN 
    		    trad_stages_thematiques_individuels ON 
    		    (trad_stages_thematiques_individuels.id__langue=$id_langue AND stages_thematiques_individuels.id_stages_thematiques_individuels=trad_stages_thematiques_individuels.id__stages_thematiques_individuels) ORDER BY id_centre";
      
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
              <td>Thème du séjour</td>
              <td>Durée du séjour (XX jours / XX nuits)</td>
              <td>Nombre de jours</td>
              <td>Nombre de nuits</td>
              <td>Période de disponibilité du séjour</td>
              <td>Prix à partir de (par participant)</td>
              <td>Le prix comprend</td>
              <td>Le prix ne comprend pas</td>
              <td>Conditions pour les professionnels</td>
              <td>Descriptif</td>
              <td>Détail du séjour</td>
              <td>Les plus séjour</td>
            </tr>";
            
  while($myrow = mysql_fetch_array($result)){
  
    $csv .="<tr>";
  	$id_centre = $myrow["id_centre"];
  	$id_sejour = $myrow["id_stages_thematiques_individuels"];
  	
  	
  	if($cmptOuvertureFichier == 0){
  		$fp = fopen($nom_fichier, 'w');
  		$cmptOuvertureFichier = 1;
  	}else{
  		$fp = fopen($nom_fichier, 'a');
  	}
  	
  	$csv.= "<td>".$myrow["libelle"]."</td>";
  	$csv.= "<td>".$myrow["ville"]."</td>";
    $csv.= "<td>".$myrow["trad_nom"]."</td>";
    
    //---- Theme
  	$id = test_virgule_fin($myrow["id_sejour_stage_theme"]);
  	$sql_S = "SELECT libelle FROM trad_sejour_stage_theme WHERE id__sejour_stage_theme IN($id) AND id__langue=1";
  	$result_S = mysql_query($sql_S);
  	$texte="";
  	while($myrow_S = mysql_fetch_array($result_S)){
  	   $texte.=$myrow_S["libelle"]."<br>";
    }
  	$csv.= "<td>".$texte."</td>";
    
    $csv.= "<td>".$myrow["trad_duree_sejour"]."</td>";
    $csv.= "<td>".$myrow["nb_jours"]."</td>";
    $csv.= "<td>".$myrow["nb_nuits"]."</td>";
    
       
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
  	$csv.= "<td>".$myrow["trad_descriptif"]."</td>";
  	
  	//--- Détails séjour 
    $sql_S = "SELECT
				trad_sejour_detail.* 
			FROM 
				trad_sejour_detail
			INNER JOIN 
				sejour_detail ON (trad_sejour_detail.id__sejour_detail = sejour_detail.id_sejour_detail AND trad_sejour_detail.id__langue=$id_langue AND sejour_detail.idSejour=".$id_sejour." and sejour_detail.id__table_def="._CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL.")"; 
    	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
      $texte = "";
    	while($myrow_S = mysql_fetch_array($result_S)){
    		$texte.= $myrow_S["jour"]." - ".$myrow_S["activite"]."<br>";
    	
    	}
      $csv.= "<td>".$texte."</td>"; 
      	
  	//--- Les plus
  	$sql_S = "SELECT
				trad_sejour_les_plus.libelle 
			FROM 
				trad_sejour_les_plus
			INNER JOIN 
				sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus AND trad_sejour_les_plus.id__langue=$id_langue AND sejour_les_plus.idSejour=".$id_sejour." and sejour_les_plus.id__table_def="._CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL.")"; 
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
