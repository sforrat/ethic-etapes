<?
/**********************************************************************************/
/*	C2IS :
/*	Auteur : 	AHE
/*	Date :
/*	Version :	1.0
/*	Fichier :	bloc_gauche.php
/*
/*	Description :	Colonne de gauche
/*
/**********************************************************************************/

// Initialisation de la page
$path="./";


if($_POST["secteur_filter"] != ""){
	$_SESSION["secteur_filter"] = $_POST["secteur_filter"];
}
if($_POST["region_filter"] != ""){
	$_SESSION["region_filter"] = $_POST["region_filter"];
}
if($_POST["contractType_filter"] != ""){
	$_SESSION["contractType_filter"] = $_POST["contractType_filter"];
}


// ----------------------------------------------------------------------------- Secteur d'activité
$sql = "SELECT * FROM offre_secteur_activite";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["id"] = $myrow["id_offre_secteur_activite"];
	$tab["libelle"] = $myrow["libelle"];

	if($_POST["secteur_filter"] == $myrow["id_offre_secteur_activite"]){
		$tab["selected"] = "selected";
	}elseif($_SESSION["secteur_filter"] == $myrow["id_offre_secteur_activite"]){
		$tab["selected"] = "selected";
	}

	$TabSecteur[] = $tab;
	unset($tab);
}
$this->assign("TabSecteur",$TabSecteur);
// ----------------------------------------------------------------------------- Région
$sql = "SELECT id_centre_region,libelle FROM centre_region ORDER BY libelle";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["id"] = $myrow["id_centre_region"];
	$tab["libelle"] = $myrow["libelle"];

	if($_POST["region_filter"] == $myrow["id_centre_region"]){
		$tab["selected"] = "selected";
	}elseif($_SESSION["region_filter"] == $myrow["id_centre_region"]){
		$tab["selected"] = "selected";
	}

	$TabRegion[] = $tab;
	unset($tab);
}
$this->assign("TabRegion",$TabRegion);
// ----------------------------------------------------------------------------- Type contrat
$sql = "SELECT id_offre_type,libelle FROM offre_type ORDER BY libelle";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["id"] = $myrow["id_offre_type"];
	$tab["libelle"] = $myrow["libelle"];

	if($_POST["contractType_filter"] == $myrow["id_offre_type"]){
		$tab["selected"] = "selected";
	}elseif($_SESSION["contractType_filter"] == $myrow["id_offre_type"]){
		$tab["selected"] = "selected";
	}

	$TabContrat[] = $tab;
	unset($tab);
}
$this->assign("TabContrat",$TabContrat);

$this->assign("urlForm",get_url_nav(_NAV_OFFRE_EMPLOI_LISTE));
$this -> display('blocs/emploiFiltre.tpl');
?>
