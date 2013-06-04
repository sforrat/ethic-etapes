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




function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
    
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}
?>

Usage:

<?php
$xmlUrl = "export/export_classes_decouv.xml"; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);
/*
echo "<pre>";
print_r($arrXml["RESULTSET"]["ROW"]);
echo "</pre>";
*/
$j = 0;
foreach($arrXml["RESULTSET"]["ROW"] as $val){

    
    $i = 1;
    foreach($val as $values){
    
            if($values[0]["DATA"] != ""){
              $nom_centre = utf8_encode($values[0]["DATA"]);
              $ville_centre = utf8_encode($values[1]["DATA"]);
              $sql_S = "select id_centre from centre where libelle='".addslashes($values[0]["DATA"])."' and ville='".addslashes($values[1]["DATA"])."'"; 
              $result_S = mysql_query($sql_S);
              $id_centre = mysql_result($result_S,0,"id_centre");
              
              //----------------------------------------------------
              $nom_sejour = addslashes($values[2]["DATA"]);
              //----------------------------------------------------
              $tabNiveauScolaire = explode("\n",$values[3]["DATA"]);
              $id_niveau="";
              foreach($tabNiveauScolaire as $value){
              	$sql_S = "SELECT id__sejour_niveau_scolaire FROM trad_sejour_niveau_scolaire WHERE libelle='$value'"; 
              	$result_S = mysql_query($sql_S);
              	if($id_niveau != ""){
              		$id_niveau.=",";
              	}
              	$id_niveau .= mysql_result($result_S,0,"id__sejour_niveau_scolaire");
              }
              //----------------------------------------------------
              $duree_sejour = addslashes($values[4]["DATA"]);
              //----------------------------------------------------
              $id_periode_dispo="";
              $tabPeriode = explode("\n",$values[5]["DATA"]);
              foreach($tabPeriode as $value){
              	$sql_S = "SELECT id__sejour_periode_disponibilite FROM trad_sejour_periode_disponibilite WHERE libelle='$value'"; 
              	
              	$result_S = mysql_query($sql_S);
              	if($id_periode_dispo != ""){
              		$id_periode_dispo.=",";
              	}
              	$id_periode_dispo .= mysql_result($result_S,0,"id__sejour_periode_disponibilite");
              }
              //----------------------------------------------------
              $id_nb_lit="";
              $tabLit = explode("\n",$values[6]["DATA"]);
              foreach($tabLit as $value){
              	$sql_S = "SELECT id__sejour_nb_lit__par_chambre FROM trad_sejour_nb_lit__par_chambre WHERE libelle='$value'"; 
              
              	$result_S = mysql_query($sql_S);
              	if($id_nb_lit != ""){
              		$id_nb_lit.=",";
              	}
              	$id_nb_lit .= mysql_result($result_S,0,"id__sejour_nb_lit__par_chambre");
              }
              //----------------------------------------------------
              $prix_a_partir_de = floatval($values[7]["DATA"]);
              //----------------------------------------------------
              $prix_comprend = addslashes($values[8]["DATA"]);
              //----------------------------------------------------
              $prix_ne_comprend = addslashes($values[9]["DATA"]);
              //----------------------------------------------------
              $interet_pedagogique = addslashes($values[10]["DATA"]);
              //----------------------------------------------------
              $presentation = addslashes($values[11]["DATA"]);
              //----------------------------------------------------
              $id_theme="";
              $tabTheme= explode("\n",$values[12]["DATA"]);
              foreach($tabTheme as $value){
              	$sql_S = "SELECT id__sejour_theme FROM trad_sejour_theme WHERE libelle='$value'"; 
              	$result_S = mysql_query($sql_S);
              	if($id_theme != ""){
              		$id_theme.=",";
              	}
              	$id_theme .= mysql_result($result_S,0,"id__sejour_theme");
              }
              //----------------------------------------------------
              
              
              $sql_I = "insert into classe_decouverte (	nom,
              								id_centre,
              								id_sejour_theme,
              								id_sejour_niveau_scolaire,
              								id_sejour_periode_disponibilite,
              								id_sejour_nb_lit__par_chambre,
              								a_partir_de_prix,
              								prix_par_29)
              						VALUES(	'$nom_sejour',
              								'$id_centre',
              								'$id_theme',
              								'$id_niveau',
              								'$id_periode_dispo',
              								'$id_nb_lit',
              								'$prix_a_partir_de',
              								'')";
              $result_I = mysql_query($sql_I) or die(mysql_error());
              $id_sejour = mysql_insert_id();
              
              $sql_I = "insert into trad_classe_decouverte (id__classe_decouverte,
              												id__langue,
              												duree_sejour,
              												prix_comprend,
              												prix_ne_comprend_pas,
              												interet_pedagogique,
              												details)
              								VALUES		(	$id_sejour,
              												1,
              												'$duree_sejour',
              												'$prix_comprend',
              												'$prix_ne_comprend',
              												'$interet_pedagogique',
              												'$presentation')";								
				$result_I = mysql_query($sql_I)  or die(mysql_error());
				$sql_I = "insert into trad_classe_decouverte(id__classe_decouverte,id__langue) values($id_sejour,2)";
				$result_I = mysql_query($sql_I) or die(mysql_error());
				$sql_I = "insert into trad_classe_decouverte(id__classe_decouverte,id__langue) values($id_sejour,3)";
				$result_I = mysql_query($sql_I) or die(mysql_error());
				$sql_I = "insert into trad_classe_decouverte(id__classe_decouverte,id__langue) values($id_sejour,5)";
				$result_I = mysql_query($sql_I) or die(mysql_error());
              	$i++;
            }
      }
}

echo "NB result : ".$i;
?>
