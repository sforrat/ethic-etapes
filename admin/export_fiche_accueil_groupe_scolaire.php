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

$nom_fichier = "export_accueil_groupe_scolaire.xls";

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
              <td>Type d'hébergement</td>
              <td>Conditions scolaire</td>
              <td>Gratuité chauffeur</td>
              <td>Gratuité accompagnateur</td>
              <td>Activités spécifiques aux enfants et scolaires</td>
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
              accueil_groupes_scolaires.*, 
              trad_accueil_groupes_scolaires.* 
            FROM 
              accueil_groupes_scolaires 
            INNER JOIN 
              trad_accueil_groupes_scolaires ON (trad_accueil_groupes_scolaires.id__accueil_groupes_scolaires = accueil_groupes_scolaires.id_accueil_groupes_scolaires AND trad_accueil_groupes_scolaires.id__langue=$id_langue AND accueil_groupes_scolaires.id_centre=$id_centre)";
    $result_S = mysql_query($sql_S);
    $nb = mysql_num_rows($result_S);
    if(!$nb){
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "</tr>";
    }else{
      while($myrow_S = mysql_fetch_array($result_S)){
        $id_sejour = $myrow_S["id_accueil_groupes_scolaires"];
      
        $texte = test_virgule_fin($myrow_S["id_sejour_nb_lit__par_chambre"]);
        $sql_SS = "select libelle from trad_sejour_nb_lit__par_chambre where id__sejour_nb_lit__par_chambre in ($texte) and id__langue=1";
        $result_SS = mysql_query($sql_SS);
        $nb_lit = "";
        
        while($myrow_SS = mysql_fetch_array($result_SS)){
          $nb_lit .= $myrow_SS["libelle"]."<br>";
        }
        $csv.= "<td>$nb_lit</td>";
        $csv.= "<td>".$myrow_S["conditions_scolaires"]."</td>";
        $csv.= "<td>".$myrow_S["gratuite_chauffeur_4"]."</td>";
        $csv.= "<td>".$myrow_S["gratuite_accompagnateur_4"]."</td>";
        
        
        //-------- Sejour dispo :
        $sql_SS = "SELECT 
                    trad_sejour_loisirs_dispo.* 
                  FROM 
                    trad_sejour_loisirs_dispo 
                  INNER JOIN 
                    sejour_loisirs_dispo ON (sejour_loisirs_dispo.id_sejour_loisirs_dispo = trad_sejour_loisirs_dispo.id__sejour_loisirs_dispo AND sejour_loisirs_dispo.idSejour=$id_sejour)
                  WHERE 
                    trad_sejour_loisirs_dispo.id__langue=$id_langue";
        $result_SS = mysql_query($sql_SS);
        $texte="";
        while($myrow_SS = mysql_fetch_array($result_SS)){
          $texte .= $myrow_SS["commentaire"]."<br>";
        }
        $csv.= "<td>$texte</td>";
        
        
        //-------- Sejour dispo :
        $sql_SS = "SELECT 
                    trad_sejour_les_plus.* 
                  FROM 
                    trad_sejour_les_plus 
                  INNER JOIN 
                    sejour_les_plus ON (sejour_les_plus.id_sejour_les_plus = trad_sejour_les_plus.id__sejour_les_plus AND sejour_les_plus.idSejour=$id_sejour)
                  WHERE 
                    trad_sejour_les_plus.id__langue=$id_langue";
        $result_SS = mysql_query($sql_SS);
        $texte="";
        while($myrow_SS = mysql_fetch_array($result_SS)){
          $texte .= $myrow_SS["libelle"]."<br>";
        }
        $csv.= "<td>$texte</td>";
        
      } 
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
