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

$nom_fichier = "export_accueil_reunion.xml";

if($_POST["action"]==1){


  $cmptOuvertureFichier = 0;
  
  $id_langue = $_POST["langueExport"];
  
  $sql = "SELECT DISTINCT centre.* FROM centre";
  
  
  
  $result = mysql_query($sql) or die(mysql_error()."<br>Requete : ".$sql);
  $nb = mysql_num_rows($result);
  
  $xml = "<?xml version=\"1.0\" ?>";
  $xml.= "<FICHESACCUEIL>";
  
  
  while($myrow = mysql_fetch_array($result)){
  
  
   
  	$id_centre = $myrow["id_centre"];
  	
  	
  	
  	if($cmptOuvertureFichier == 0){
  		$fp = fopen($nom_fichier, 'w');
  		$cmptOuvertureFichier = 1;
  	}else{
  		$fp = fopen($nom_fichier, 'a');
  	}
  	$xml.= "<centre>";
  	// ----------------------------------------------------------------
	  $xml.= "  <nom><![CDATA[".$myrow["libelle"]."]]></nom>\n";
	  $xml.= "  <nom><![CDATA[".$myrow["ville"]."]]></nom>\n";
  	
  	
    //----- Sejour
    $sql_S = "SELECT 
                accueil_reunions.* 
              FROM 
                accueil_reunions 
              WHERE 
                id_centre=$id_centre";
              
    $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
    $id_sejour = mysql_result($result_S,0,"id_accueil_reunions");
    $id_sejour_materiel_service = mysql_result($result_S,0,"id_sejour_materiel_service");
    if(!$id_sejour){
      $id_sejour = 9999999999;
    }
    //----- Salle de réunion :
    $sql_S = "SELECT 
                sejour_salle_acceuil_reunion.* 
              FROM 
                sejour_salle_acceuil_reunion 
              WHERE 
                sejour_salle_acceuil_reunion.idSejour=$id_sejour";
    $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
    $i = 1;
    while($myrow_S=mysql_fetch_array($result_S)){
      $xml.= "  <salle_$i><![CDATA[".$myrow_S["nom_salle"]."]]></salle_$i>\n";
      $xml.= "  <tarif_demi_journee_salle_$i>".$myrow_S["tarif_demi_journee"]."</tarif_demi_journee_salle_$i>\n";
      $xml.= "  <tarif_journee_salle_$i>".$myrow_S["tarif_journee"]."</tarif_journee_salle_$i>\n";
      $xml.= "  <tarif_soiree_salle_$i>".$myrow_S["tarif_soiree"]."</tarif_soiree_salle_$i>\n";
      $xml.= "  <taille_salle_$i>".$myrow_S["taille"]."</taille_salle_$i>\n";
      $xml.= "  <tour_de_table_salle_$i>".$myrow_S["tour_table"]."</tour_de_table_salle_$i>\n";
      $xml.= "  <conference_salle_$i>".$myrow_S["conference"]."</conference_salle_$i>\n";
      $xml.= "  <classe_salle_$i>".$myrow_S["classe"]."</classe_salle_$i>\n";
      $xml.= "  <tableau_blanc_salle_$i>".$myrow_S["tableau_blanc_28"]."</tableau_blanc_salle_$i>\n";
      $xml.= "  <sonorisation_salle_$i>".$myrow_S["sonorisation_28"]."</sonorisation_salle_$i>\n";
      $xml.= "  <paperboard_salle_$i>".$myrow_S["paperboard_28"]."</paperboard_salle_$i>\n";
      $xml.= "  <ecran_salle_$i>".$myrow_S["ecran_28"]."</ecran_salle_$i>\n";
      $xml.= "  <climatisation_salle_$i>".$myrow_S["climatisation_28"]."</climatisation_salle_$i>\n";
      $i++;
    }
                
    $sql_S    = "select commentaires_salles from trad_accueil_reunions where id__langue=$id_langue and id__accueil_reunions=$id_sejour";
    $result_S = mysql_query($sql_S);
    $xml.= "  <commentaire_salle><![CDATA[".mysql_result($result_S,0,"commentaires_salles")."]]></commentaire_salle>\n";
    $i = 1;
    //----- Réstauration repas :
    $sql_S = "SELECT 
                sejour_restauration_repas.* 
              FROM 
                sejour_restauration_repas 
              WHERE 
                sejour_restauration_repas.idSejour=$id_sejour";
               
    $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
    $i=1;
    while($myrow_S=mysql_fetch_array($result_S)){
      $sql_S = "SELECT 
                trad_sejour_restauration_repas.* 
              FROM 
                trad_sejour_restauration_repas 
              WHERE 
                trad_sejour_restauration_repas.id__sejour_restauration_repas=".$myrow_S["id_sejour_restauration_repas"]." and id__langue=$id_langue";
         
      $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
       
       
      $xml.= "  <repas_nom_formule_$i><![CDATA[".mysql_result($result_S,0,"nom_formule")."]]></repas_nom_formule_$i>\n";  
      $xml.= "  <repas_tarif_$i><![CDATA[".$myrow_S["tarif"]."]]></repas_tarif_$i>\n"; 
      $xml.= "  <repas_detail_prestation_$i><![CDATA[".mysql_result($result_S,0,"detail_prestation")."]]></repas_detail_prestation_$i>\n";    
  	}
  	
  	//----- Réstauration Pause :
    $sql_S = "SELECT 
                sejour_restauration_pause.* 
              FROM 
                sejour_restauration_pause 
              WHERE 
                sejour_restauration_pause.idSejour=$id_sejour";
               
    $result_S = mysql_query($sql_S);
    $i=1;
    while($myrow_S=mysql_fetch_array($result_S)){
      $sql_S = "SELECT 
                trad_sejour_restauration_pause.* 
              FROM 
                trad_sejour_restauration_pause 
              WHERE 
                trad_sejour_restauration_pause.id__sejour_restauration_pause=".$myrow_S["id_sejour_restauration_pause"]." and id__langue=$id_langue";
         
      $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
       
       
      $xml.= "  <pause_nom_formule_$i><![CDATA[".mysql_result($result_S,0,"nom_formule")."]]></pause_nom_formule_$i>\n";  
      $xml.= "  <pause_tarif_$i><![CDATA[".$myrow_S["tarif"]."]]></pause_tarif_$i>\n"; 
      $xml.= "  <pause_detail_prestation_$i><![CDATA[".mysql_result($result_S,0,"detail_prestation")."]]></pause_detail_prestation_$i>\n"; 
      $i++;   
  	}
  	
  	
  	//----- Réstauration Cocktail :
    $sql_S = "SELECT 
                sejour_restauration_cocktail.* 
              FROM 
                sejour_restauration_cocktail 
              WHERE 
                sejour_restauration_cocktail.idSejour=$id_sejour";
               
    $result_S = mysql_query($sql_S);
    $i=1;
    while($myrow_S=mysql_fetch_array($result_S)){
      $sql_S = "SELECT 
                trad_sejour_restauration_cocktail.* 
              FROM 
                trad_sejour_restauration_cocktail 
              WHERE 
                trad_sejour_restauration_cocktail.id__sejour_restauration_cocktail=".$myrow_S["id_sejour_restauration_cocktail"]." and id__langue=$id_langue";
         
      $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
       
       
      $xml.= "  <cocktail_nom_formule_$i><![CDATA[".mysql_result($result_S,0,"nom_formule")."]]></cocktail_nom_formule_$i>\n";  
      $xml.= "  <cocktail_tarif_$i><![CDATA[".$myrow_S["tarif"]."]]></cocktail_tarif_$i>\n"; 
      $xml.= "  <cocktail_detail_prestation_$i><![CDATA[".mysql_result($result_S,0,"detail_prestation")."]]></cocktail_detail_prestation_$i>\n";
      $i++;    
  	}
  	
  	//----- sejour_formule_reunion :
    $sql_S = "SELECT 
                sejour_formule_reunion.* 
              FROM 
                sejour_formule_reunion 
              WHERE 
                sejour_formule_reunion.idSejour=$id_sejour";
               
    $result_S = mysql_query($sql_S);
    $i=1;
    while($myrow_S=mysql_fetch_array($result_S)){
      $sql_S = "SELECT 
                trad_sejour_formule_reunion.* 
              FROM 
                trad_sejour_formule_reunion 
              WHERE 
                trad_sejour_formule_reunion.id__sejour_formule_reunion=".$myrow_S["id_sejour_formule_reunion"]." and id__langue=$id_langue";
         
      $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
       
       
      $xml.= "  <formule_reunion_nom_formule_$i><![CDATA[".mysql_result($result_S,0,"nom_formule")."]]></formule_reunion_nom_formule_$i>\n";  
      $xml.= "  <formule_reunion_tarif_$i><![CDATA[".$myrow_S["tarif"]."]]></formule_reunion_tarif_$i>\n"; 
      $xml.= "  <formule_reunion_detail_prestation_$i><![CDATA[".mysql_result($result_S,0,"detail_prestation")."]]></formule_reunion_detail_prestation_$i>\n";
      $i++;    
  	}
  	
  	$texte = test_virgule_fin($id_sejour_materiel_service);
  	$sql_S = "SELECT libelle FROM trad_sejour_materiel_service WHERE id__sejour_materiel_service IN ($texte) AND id__langue=1";
  	$result_S = mysql_query($sql_S);
  	$materiel="";
  	while($myrow_S=mysql_fetch_array($result_S)){
  	   $materiel .= $myrow_S["libelle"]."\n";
  	}
  	$xml.= "  <materiel_equippement>".$materiel."</materiel_equippement>\n"; 
  	
  	
  	$sql_S = "SELECT
				trad_sejour_les_plus.libelle 
			FROM 
				trad_sejour_les_plus
			INNER JOIN 
				sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus AND trad_sejour_les_plus.id__langue=$id_langue AND sejour_les_plus.idSejour=".$id_sejour." and sejour_les_plus.id__table_def="._CONST_TABLEDEF_ACCUEIL_REUNION.")"; 
  	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
  	$cmpt = 1;
  	while($myrow_S = mysql_fetch_array($result_S)){
  		$xml.= "<les_plus_sejour_$cmpt><![CDATA[".$myrow_S["libelle"]."]]></les_plus_sejour_$cmpt>\n";
  		$cmpt++;
  	}
  	
  	
    $xml.= "</centre>";
  	fwrite($fp, $xml);
  	$xml="";
  	fclose($fp);
  } 
	
	




$xml= "</FICHESACCUEIL>";
$fp = fopen($nom_fichier, 'a');
fwrite($fp, $xml);
fclose($fp);


echo "<a href='telecharge.php?src=$nom_fichier'><font face='arial'>Cliquez ici pour télécharger le fichier XML</font></a>";

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
