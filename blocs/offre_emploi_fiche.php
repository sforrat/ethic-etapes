<?
/**********************************************************************************/
/*	C2IS :
/*	Auteur : 	FFR
/*	Date :
/*	Version :	1.0
/*	Fichier :	offre_emploi_fiche.php
/*
/*	Description :	Emploi Fiche
/*
/**********************************************************************************/

// Initialisation de la page
$path="./";

if($_GET["idOffre"] == ""){
	redirect(_NAV_OFFRE_EMPLOI_LISTE);
	die();
}

$sql = "SELECT
			offre_emploi.id_offre_emploi,
			offre_emploi.libelle,
			offre_emploi.descriptif,
			offre_emploi.id_offre_type,
			offre_emploi.contact_nom,
			offre_emploi.contact_prenom,
			offre_emploi.contact_email,
			offre_emploi.contact_telephone,
			offre_emploi.contact_fax,
			DATE_FORMAT(offre_emploi.periode_debut,'%d-%m-%Y') as periode_debut,
			DATE_FORMAT(offre_emploi.periode_fin,'%d-%m-%Y') as periode_fin,
			offre_type.libelle as contrat,
			centre.ville,
			centre.code_postal,
			offre_secteur_activite.libelle as secteur
		FROM 
			offre_emploi
		INNER JOIN	offre_type on (offre_type.id_offre_type =offre_emploi.id_offre_type)
		INNER JOIN	centre on (centre.id_centre =offre_emploi.id_centre)
		INNER JOIN	offre_secteur_activite on (offre_secteur_activite.id_offre_secteur_activite =offre_emploi.id_offre_secteur_activite)
		
		WHERE
			id_offre_emploi=".$_GET["idOffre"];
		

$result = mysql_query($sql);
$nb = mysql_num_rows($result);
if(!$nb){
	redirect(_NAV_OFFRE_EMPLOI_LISTE);
	die();
}
$myrow = mysql_fetch_array($result);

$this->assign('secteur',$myrow["secteur"]);
$this->assign('contrat',mb_strtoupper($myrow["contrat"],"utf-8"));
$this->assign('libelle',mb_strtoupper($myrow["libelle"],"utf-8"));
$this->assign('ville',$myrow["ville"]);
$this->assign('dept',substr($myrow["code_postal"],0,2));
$this->assign('description',$myrow["descriptif"]);

if($myrow["periode_fin"] != "" && $myrow["id_offre_type"]!= _ID_CDI){
	$this->assign('periode_texte',get_libLocal('lib_periode'));
	$periode = str_replace("##DATE_DEBUT##",$myrow["periode_debut"],get_libLocal('lib_du_au'));
	$periode = str_replace("##DATE_FIN##",$myrow["periode_fin"],$periode);
	$this->assign('periode',$periode);
	
}else{
	$this->assign('date_debut_texte',get_libLocal('lib_date_debut_contrat'));
	$this->assign('periode_debut',$myrow["periode_debut"]);
}

$this->assign('contact_nom',$myrow["contact_nom"]);
$this->assign('contact_prenom',$myrow["contact_prenom"]);
$this->assign('contact_email',$myrow["contact_email"]);
$this->assign('contact_telephone',$myrow["contact_telephone"]);
$this->assign('contact_fax',$myrow["contact_fax"]);

$this->assign('url_retour_liste',get_url_nav(_NAV_OFFRE_EMPLOI_LISTE));
$params[0]["id_name"] = "idOffre";
$params[0]["id"] = $_GET["idOffre"];

$this->assign('url_postuler',get_url_nav(_NAV_OFFRE_EMPLOI_CANDIDATURE,$params));

$this -> display('blocs/offre_emploi_fiche.tpl');
?>
