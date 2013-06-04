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
$xmlUrl = "export/export_fournisseurs.xml"; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);
/*
echo "<pre>";
print_r($arrXml["RESULTSET"]["ROW"]);
echo "</pre>";
*/
$j = 0;


$sql = "TRUNCATE TABLE `ethic_etapes_www`.`em_ref_fournisseur`";
mysql_query($sql);
$sql = "TRUNCATE TABLE `ethic_etapes_www`.`em_ref_fournisseur_categorie`";
mysql_query($sql);
foreach($arrXml["RESULTSET"]["ROW"] as $val){


	$i = 1;
	foreach($val as $values){

		if($values[0]["DATA"] != ""){
			$societe  = addslashes($values[0]["DATA"]);
			$adresse1 = addslashes($values[1]["DATA"]);
			$adresse2 = addslashes($values[2]["DATA"]);
			$cp = addslashes($values[3]["DATA"]);
			$ville = addslashes($values[4]["DATA"]);
			$tel = addslashes($values[5]["DATA"]);
			$mail = addslashes($values[6]["DATA"]);
			$web = addslashes($values[7]["DATA"]);
			if($values[8]["DATA"] == "M."){
				$civilite = 1;
			}elseif($values[8]["DATA"] == "Mme"){
				$civilite = 2;
			}elseif($values[8]["DATA"] != ""){
				$civilite = 3;
			}else{
				$civilite="";
			}
			$prenom = addslashes($values[9]["DATA"]);
			$nom = addslashes($values[10]["DATA"]);
			$fonction = addslashes($values[11]["DATA"]);
			
			
			
			$activite = addslashes($values[12]["DATA"]);
			
			$sql_S = "select id_em_ref_fournisseur_categorie from em_ref_fournisseur_categorie where libelle='$activite'";
			$result_S = mysql_query($sql_S);
			$nb = mysql_num_rows($result_S);
			if($nb>0){
				$id_activite = mysql_result($result_S,0,"id_em_ref_fournisseur_categorie");
			}else{
				$sql_I = "insert into em_ref_fournisseur_categorie (libelle) value('$activite')";
				$result_I = mysql_query($sql_I) or die(mysql_error());
				$id_activite = mysql_insert_id();
			}
			
			
			$presentation = addslashes($values[13]["DATA"]);
			$condition = addslashes($values[14]["DATA"]);



			
			
			

			$sql_I = "insert into em_ref_fournisseur (	societe,
												adresse1,
												adresse2,
												cp,
												ville,
												telephone,
												email,
												site_internet,
												id_civilite,
												prenom,
												nom,
												fonction,
												id_em_ref_fournisseur_categorie,
												presentation,
												condition_catalogue)
												
              						VALUES(	'$societe',
              								'$adresse1',
              								'$adresse2',
              								'$cp',
              								'$ville',
              								'$tel',
              								'$mail',
              								'$web',
              								'$civilite',
              								'$prenom',
              								'$nom',
              								'$fonction',
              								'$id_activite',
              								'$presentation',
              								'$condition')";
			
			$sql_I = str_replace("Array","",$sql_I);
			
			$result_I = mysql_query($sql_I) or die(mysql_error());
			
		}
	}
}

echo "NB result : ".$i;
?>
