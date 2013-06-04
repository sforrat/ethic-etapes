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


<?php
$xmlUrl = "export/export_anglais.xml"; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);




	$i = 0;
foreach($arrXml["RESULTSET"]["ROW"] as $val){



	foreach($val as $values){

		if($values[0]["DATA"] != ""){
			$tel  = addslashes($values[21]["DATA"]);
			$tel_resa = addslashes($values[22]["DATA"]);
			$fax = addslashes($values[23]["DATA"]);
			$fax_resa = addslashes($values[24]["DATA"]);
			$ville = addslashes($values[25]["DATA"]);
			$centre = addslashes($values[26]["DATA"]);
			$acces_route_texte_1= addslashes($values[0]["DATA"]);
			$acces_train= addslashes($values[1]["DATA"]);
			$acces_avion= addslashes($values[2]["DATA"]);
			$acces_autobus= addslashes($values[3]["DATA"]);
			$presentation = addslashes($values[4]["DATA"]);
			$presentation_region = addslashes($values[10]["DATA"]);
			
			if($ville != "Array" && $ville!="Lanslebourg-Val Cenis"){
				$sql_S = "select id_centre from centre where ville='$ville' and libelle='$centre'";
			}elseif($ville=="Lanslebourg-Val Cenis"){
				$sql_S = "select id_centre from centre where ville='Val Cenis Lanslebourg' and libelle='$centre'";
			}else{	
				$sql_S = "select id_centre from centre where libelle='$centre'";
			}
			$result_S = mysql_query($sql_S) or die(mysql_error());
			

			$id_centre = mysql_result($result_S,0,"id_centre");
			//echo  mysql_result($result_S,0,"id_centre")." ".$sql_S."<br>";
		
			if($id_centre!=""){
			$sql_U = "update trad_centre set 	telephone='$tel',
												tel_resa='$tel_resa',
												fax='$fax',
												fax_resa='$fax_resa',
												acces_route_texte='$acces_route_texte_1',
												acces_train_texte='$acces_train',
												acces_avion_texte='$acces_avion',
												acces_bus_metro_texte='$acces_autobus',
												presentation='$presentation',
												presentation_region='$presentation_region'
												
												where id__centre=$id_centre and id__langue = 2";
			
			$sql_U = str_replace("Array","",$sql_U);
			//echo $sql_U.";<br>";
			$result_U = mysql_query($sql_U) or die(mysql_error());
			}else{
				echo $sql_S."<br>";
			}
			$i++;
		}
	}
}

echo "NB result : ".$i;
?>
