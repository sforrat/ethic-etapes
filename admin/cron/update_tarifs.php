<?
/**********************************************************************************/
/*	C2IS :
/*	Auteur : 	RPL
/*	Date : 		Janvier 2011
/*	Version :	1.4
/*	Fichier :	update_tarifs.php
/*
/*	Description :	script execute par Cron au 1er janvier de chaque annee:
/*						- Passage des tarifs saisonniers N+1 a N
/*						- Effacement des tarifs N+1 obsoletes
/*
/**********************************************************************************/

// securite : est-on le premier janvier ?
$date = explode('-',date('d-m'));
if( $date[0] != '01' || $date[1] != '01' ){
	die("Execution interdite !!!");
}

// Initialisation de la page
$path = "/data/services/web/www.ethic-etapes.fr/";

require($path."include/inc_header.inc.php");

$link = mysql_connect( $Host, $UserName, $UserPass );
mysql_select_db($BaseName, $link);

// Initialisations
$countUpdates = 0;

echo "Mise a jour des tarifs...<br /><br />";
	
// passage des tarifs N aux tarifs N+1
// purge des tarifs N+1 (a resaisir par le client)

// Recuperation des tarifs N+1
$sql = "SELECT * FROM sejour_tarif_groupe_plus";		
$rst = mysql_query($sql);
while( $row = mysql_fetch_array($rst, MYSQL_ASSOC)){
	$aTarifsSejour[] = array(
		'id'		=> $row['id_sejour_tarif_enfant_scolaire'],
		'HS_bb'		=> $row['HS_bb'],
		'HS_dp'		=> $row['HS_dp'],
		'HS_pc'		=> $row['HS_pc'],
		'HS_rs'		=> $row['HS_rs'],
		'MS_bb'		=> $row['MS_bb'],
		'MS_dp'		=> $row['MS_dp'],
		'MS_pc'		=> $row['MS_pc'],
		'MS_rs'		=> $row['MS_rs'],
		'BS_bb'		=> $row['BS_bb'],
		'BS_dp'		=> $row['BS_dp'],
		'BS_pc'		=> $row['BS_pc'],
		'BS_rs'		=> $row['BS_rs']
	);
}
//trace($aTarifsSejour);

//=================================================
// Mise a jour des tarifs N
//=================================================
foreach( $aTarifsSejour as $tarifSejour ){
	$sql = "UPDATE sejour_tarif_groupe
			SET HS_bb = '".$tarifSejour['HS_bb']."',
				HS_dp = '".$tarifSejour['HS_dp']."',
				HS_pc = '".$tarifSejour['HS_pc']."',
				HS_rs = '".$tarifSejour['HS_rs']."',
				MS_bb = '".$tarifSejour['MS_bb']."',
				MS_dp = '".$tarifSejour['MS_dp']."',
				MS_pc = '".$tarifSejour['MS_pc']."',
				MS_rs = '".$tarifSejour['MS_rs']."',
				BS_bb = '".$tarifSejour['BS_bb']."',
				BS_dp = '".$tarifSejour['BS_dp']."',
				BS_pc = '".$tarifSejour['BS_pc']."',
				BS_rs = '".$tarifSejour['BS_rs']."'
			WHERE id_sejour_tarif_enfant_scolaire = ".$tarifSejour['id'];
	$rst = mysql_query($sql);
	
	// securite
	$countUpdates += mysql_affected_rows($link);
	
	//=================================================	
	// Mise a jour des details tarifs saison
	//=================================================
	$sql = "UPDATE trad_accueil_groupes_jeunes_adultes
			SET haute_saison = haute_saison_n1,
				moyenne_saison = moyenne_saison_n1,
				basse_saison = basse_saison_n1,
				haute_saison_n1 = NULL,
				moyenne_saison_n1 = NULL,
				basse_saison_n1 = NULL";
	$rst = mysql_query($sql);
	
	$sql = "UPDATE trad_accueil_groupes_scolaires
			SET haute_saison = haute_saison_n1,
				moyenne_saison = moyenne_saison_n1,
				basse_saison = basse_saison_n1,
				haute_saison_n1 = NULL,
				moyenne_saison_n1 = NULL,
				basse_saison_n1 = NULL";
	$rst = mysql_query($sql);
	
	$sql = "UPDATE trad_accueil_individuels_familles
			SET haute_saison = haute_saison_n1,
				moyenne_saison = moyenne_saison_n1,
				basse_saison = basse_saison_n1,
				haute_saison_n1 = NULL,
				moyenne_saison_n1 = NULL,
				basse_saison_n1 = NULL";
	$rst = mysql_query($sql);
}
	
	
echo "Nombre d'offres a mettre a jour : ".count($aTarifsSejour)."<br />";
echo "Nombre d'offres mises a jour : ".$countUpdates."<br />";

//if( count($aTarifsSejour) == $countUpdates ){

//=================================================	
// Purge des tarifs N+1
//=================================================
$sql = "UPDATE sejour_tarif_groupe_plus
		SET HS_bb = NULL,
			HS_dp = NULL,
			HS_pc = NULL,
			HS_rs = NULL,
			MS_bb = NULL,
			MS_dp = NULL,
			MS_pc = NULL,
			MS_rs = NULL,
			BS_bb = NULL,
			BS_dp = NULL,
			BS_pc = NULL,
			BS_rs = NULL";
$rst = mysql_query($sql);
		
//}
//else
//	echo "Probleme de mise a jour N... Conservation des tarifs N+1.<br /><br />";

//=================================================
// Depublication des accueils sans tarifs N
//=================================================
$sql_fin = "(HS_bb = NULL OR HS_bb = '') AND
			(HS_dp = NULL OR HS_dp = '') AND
			(HS_pc = NULL OR HS_pc = '') AND
			(HS_rs = NULL OR HS_rs = '') AND
			(MS_bb = NULL OR MS_bb = '') AND
			(MS_dp = NULL OR MS_dp = '') AND
			(MS_pc = NULL OR MS_pc = '') AND
			(MS_rs = NULL OR MS_rs = '') AND
			(BS_bb = NULL OR BS_bb = '') AND
			(BS_dp = NULL OR BS_dp = '') AND
			(BS_pc = NULL OR BS_pc = '') AND
			(BS_rs = NULL OR BS_rs = '') )";
		
echo "<br /><br />Depublication sejours accueils : <br /><br />";
	
// Accueils groupes jeunes et adultes
$sql = "UPDATE accueil_groupes_jeunes_adultes SET etat='0' WHERE id_accueil_groupes_jeunes_adultes IN (
		SELECT IdSejour FROM sejour_tarif_groupe WHERE
				id__table_def = '"._CONST_TABLEDEF_GROUPE_ADULTE."' AND ";
$sql.= $sql_fin;	
//echo "---------> SQL : ".$sql."<br />";
$rst = mysql_query($sql);
echo mysql_affected_rows($link)." sejours 'accueil groupes adultes' depublies<br />";

// Accueils groupes scolaires
$sql = "UPDATE accueil_groupes_scolaires SET etat='0' WHERE id_accueil_groupes_scolaires IN (
		SELECT IdSejour FROM sejour_tarif_groupe WHERE
			id__table_def = '"._CONST_TABLEDEF_ACCUEIL_GROUPE."' AND ";
$sql.= $sql_fin;		
//echo "---------> SQL : ".$sql."<br />";
$rst = mysql_query($sql);
echo mysql_affected_rows($link)." sejours 'accueil groupes scolaires et sportifs' depublies<br />";

// Accueils individuels et familles
$sql = "UPDATE accueil_individuels_familles SET etat='0' WHERE id_accueil_individuels_familles IN (
		SELECT IdSejour FROM sejour_tarif_groupe WHERE
			id__table_def = '"._CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE."' AND ";
$sql.= $sql_fin;		
//echo "---------> SQL : ".$sql."<br />";
$rst = mysql_query($sql);
echo mysql_affected_rows($link)." sejours 'accueil individuels et familles' depublies<br /><br />";
		
echo "Traitement termine !";

mysql_close($link);

?>