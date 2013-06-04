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

$nom_fichier = "export_accueil_groupe_jeune_adulte.xls";

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
              <td>Condition pour groupe</td>
              <td>Gratuité chauffeur</td>
              <td>Conditions pour les professionnels</td>
              <td>Souhaitez vous accueillir des sportifs dans votre centre ?</td>
              <td>Piste dathlétisme</td>
              <td>Piste dathlétisme sur place</td>
              <td>Piscine (min. 25m)</td>
              <td>Piscine sur place</td>
              <td>Terrains extérieurs (football, rugby)</td>
              <td>Terrains extérieurs sur place</td>
              <td>Terrains couverts (Basketball, Handball) </td>
              <td>Terrains couverts (Basketball, Handball) sur place </td>
              <td>Dojos</td>
              <td>Dojos sur place</td>
              <td>Cours de tennis</td>
              <td>Cours de tennis sur place</td>
              <td>Autres installations</td>
              <td>Services spécial sportifs</td>
              <td>séjour de préparation</td>
              <td>séjour de préparation Commentaires </td>
              <td>séjour de rentrée</td>
              <td>séjour de rentrée Commentaires</td>
              <td>séjour d oxygénation</td>
              <td>séjour d oxygénation Commentaires</td>
              <td>autre </td>
              <td>autre Commentaires</td>
              <td>Centre particulièrement adapté pour </td>
              <td>Commentaires accueil sportifs </td>
              <td>Je dispose de conditions particulières pour les membres de la FFH</td>
              <td>Si oui lesquels </td>
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
              accueil_groupes_jeunes_adultes.*, 
              trad_accueil_groupes_jeunes_adultes.sejour_preparation_commentaire,
              trad_accueil_groupes_jeunes_adultes.sejour_rentree_commentaire,
              trad_accueil_groupes_jeunes_adultes.sejour_oxygenation_commentaire,
              trad_accueil_groupes_jeunes_adultes.conditions_groupes,
              trad_accueil_groupes_jeunes_adultes.conditions_professionnels
            FROM 
              accueil_groupes_jeunes_adultes 
            INNER JOIN 
              trad_accueil_groupes_jeunes_adultes ON (trad_accueil_groupes_jeunes_adultes.id__accueil_groupes_jeunes_adultes = accueil_groupes_jeunes_adultes.id_accueil_groupes_jeunes_adultes AND trad_accueil_groupes_jeunes_adultes.id__langue=$id_langue AND accueil_groupes_jeunes_adultes.id_centre=$id_centre)";
    
    
    $result_S = mysql_query($sql_S);
    $nb = mysql_num_rows($result_S);
    if(!$nb){
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "<td>&nbsp;</td>";
      $csv.= "</tr>";
    }else{
      $myrow_S = mysql_fetch_array($result_S);
      $id_sejour = $myrow_S["id_accueil_groupes_jeunes_adultes"];
      $csv.= "<td>".$myrow_S["conditions_groupes"]."</td>";
      $csv.= "<td>".$myrow_S["gratuite_chauffeur_4"]."</td>";
      $csv.= "<td>".$myrow_S["conditions_professionnels"]."</td>";
      $csv.= "<td>".$myrow_S["accueil_sportif_4"]."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["piste_athetisme"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["piste_athetisme_sur_place"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["piscine"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["piscine_sur_place"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["terrains_exterieurs"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["terrains_exterieurs_sur_place"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["terrains_couverts"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["terrains_couverts_sur_place"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["dojos"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["dojos_sur_place"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["courts_tennis"])."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["courts_tennis_sur_place"])."</td>";
      $csv.= "<td>".$myrow_S["installations_autres_multi"]."</td>";
      
      $texte = test_virgule_fin($myrow_S["id_sejour_services_sportifs"]);
      $sql_SS = "SELECT libelle FROM trad_sejour_services_sportifs WHERE id__sejour_services_sportifs IN ($texte) AND id__langue=1";
      $result_SS = mysql_query($sql_SS);
      $texte="";
      while($myrow_SS=mysql_fetch_array($result_SS)){
        $texte .= $myrow_SS["libelle"]."<br>";
      }
      $csv.= "<td>".$texte."</td>";
      
      $csv.= "<td>".zero_or_one($myrow_S["sejour_preparation"])."</td>";
      $csv.= "<td>".$myrow_S["sejour_preparation_commentaire"]."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["sejour_rentree"])."</td>";
      $csv.= "<td>".$myrow_S["sejour_rentree_commentaire"]."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["sejour_oxygenation"])."</td>";
      $csv.= "<td>".$myrow_S["sejour_oxygenation_commentaire"]."</td>";
      $csv.= "<td>".zero_or_one($myrow_S["forfait_autre"])."</td>";
      $csv.= "<td>".$myrow_S["forfait_autre_commentaire_multi"]."</td>";
      
      
      
      
      $texte = test_virgule_fin($myrow_S["id_sejour_centre_adapte"]);
      $sql_SS = "SELECT libelle FROM trad_sejour_centre_adapte WHERE id__sejour_centre_adapte IN ($texte) AND id__langue=1";
      $result_SS = mysql_query($sql_SS);
      $texte="";
      while($myrow_SS=mysql_fetch_array($result_SS)){
        $texte .= $myrow_SS["libelle"]."<br>";
      }
      $csv.= "<td>".$texte."</td>";
      
      $csv.= "<td>".$myrow_S["commentaire_accueil_sportifs_multi"]."</td>";
      $csv.= "<td>".$myrow_S["sports_adaptes_FFH_4"]."</td>";
      $csv.= "<td>".$myrow_S["sports_adaptes_FFH_libelle_multi"]."</td>";
      
      
      $sql_S = "SELECT
				trad_sejour_les_plus.libelle 
			FROM 
				trad_sejour_les_plus
			INNER JOIN 
				sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus AND trad_sejour_les_plus.id__langue=$id_langue AND sejour_les_plus.idSejour=".$id_sejour." and sejour_les_plus.id__table_def="._CONST_TABLEDEF_GROUPE_ADULTE.")"; 
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
