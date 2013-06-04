<?
/**********************************************************************************/
/*	C2IS :
/*	Auteur : 	FFR
/*	Date :
/*	Version :	1.0
/*	Fichier :	offre_candidature.php
/*
/*	Description :	Emploi Fiche
/*
/**********************************************************************************/

// Initialisation de la page
$path="./";


// -- Erreur sur l'ajout d'une candidature
if($_SESSION["erreur"] == 1){
	$this->assign("erreur",1);
	$this->assign("nom",$_SESSION["nom"]);
	$this->assign("prenom",$_SESSION["prenom"]);
	$this->assign("date",$_SESSION["date"]);
	$this->assign("email",$_SESSION["email"]);
	$this->assign("tel",$_SESSION["tel"]);
	$this->assign("message",$_SESSION["message"]);
	$this->assign("region",$_SESSION["region"]);
	$this->assign("secteur",$_SESSION["secteur"]);

}elseif($_SESSION["erreur"] == "no_erreur"){
	$this->assign("ok",1);

}	
unset($_SESSION["nom"]);
unset($_SESSION["prenom"]);
unset($_SESSION["date"]);
unset($_SESSION["email"]);
unset($_SESSION["tel"]);
unset($_SESSION["message"]);
unset($_SESSION["erreur"]);
// ---------------------------------------


if($_GET["idOffre"] != ""){
	$sql = "select
					offre_emploi.libelle,
					offre_emploi.id_offre_emploi,
					offre_emploi.id_offre_secteur_activite,
					offre_emploi.id_offre_type,
					centre_region.id_centre_region,
					centre_region.libelle as region,
					offre_secteur_activite.libelle as secteur
				FROM
					offre_emploi
				INNER JOIN
					offre_secteur_activite on (offre_secteur_activite.id_offre_secteur_activite = offre_emploi.id_offre_secteur_activite)
				INNER JOIN
					centre on (offre_emploi.id_centre = centre.id_centre)
				INNER JOIN
					centre_region on (centre.id_centre_region = centre_region.id_centre_region)
								
				WHERE 	
					offre_emploi.id_offre_emploi =".$_GET["idOffre"];
	/*$sql .=" and
	offre_emploi.periode_debut<=NOW() and
	offre_emploi.periode_fin>NOW()";
*/

	$result = mysql_query($sql) or die(mysql_error());
	$myrow = mysql_fetch_array($result);
	$this->assign("offre",$myrow["libelle"]);
	$this->assign("idoffre",$myrow["id_offre_emploi"]);
	$this->assign("secteur",$myrow["secteur"]);
	$this->assign("idsecteur",$myrow["id_offre_secteur_activite"]);
	$this->assign("region",$myrow["region"]);
	$this->assign("idregion",$myrow["id_centre_region"]);

}else{
	$this->assign("offre","");
	// -- Secteur
	$sql = "select id_offre_secteur_activite, libelle from offre_secteur_activite";
	$result = mysql_query($sql);
	$tab = array();
	while($myrow = mysql_fetch_array($result)){
		$tab["id"] = $myrow["id_offre_secteur_activite"];
		$tab["libelle"] = $myrow["libelle"];
		$TabSecteur[] = $tab;
		unset($tab);
	}
	$this->assign("TabSecteur",$TabSecteur);

	// -- Région
	$sql = "select id_centre_region, libelle from centre_region order by libelle";
	$result = mysql_query($sql);
	$tab = array();
	while($myrow = mysql_fetch_array($result)){
		$tab["id"] = $myrow["id_centre_region"];
		$tab["libelle"] = $myrow["libelle"];
		$TabRegion[] = $tab;
		unset($tab);
	}
	$this->assign("TabRegion",$TabRegion);
}

$this->assign("lib_postuler",mb_strtoupper(get_libLocal('lib_postuler'),"utf-8"));

$this -> display('blocs/offre_candidature.tpl');

?>
