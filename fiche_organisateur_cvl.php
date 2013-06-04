<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	fiche_organisateur_cvl.php						  
/*										  
/*	Description :	
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

	$sql = "SELECT id_organisateur_cvl, visuel, adresse, code_postal, ville, telephone, fax, email, site_internet ,
					agrement_jeunesse, id_sejour_thematique, id_sejour_tranche_age
			FROM organisateur_cvl 
			WHERE id_organisateur_cvl = ".$_REQUEST['id'];
	$rst = mysql_query($sql);
	
	if (!$rst)
		echo mysql_error().' - '.$sql;
	
	$organisateurCVL = array ("nom" => mb_strtoupper(getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'libelle', mysql_result($rst, 0, 'id_organisateur_cvl'), 'utf-8')),
							"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel"), "organisateur_cvl")),
							"description" => getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'presentation_organisme', mysql_result($rst, 0, 'id_organisateur_cvl')),
							"projet_educatif" => getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'projet_educatif', mysql_result($rst, 0, 'id_organisateur_cvl')),
							"adresse" => mysql_result($rst, 0, 'adresse'),
							"code_postal" => mysql_result($rst, 0, 'code_postal'),
							"ville" => mysql_result($rst, 0, 'ville'),
							"telephone" => mysql_result($rst, 0, 'telephone'),
							"fax" => mysql_result($rst, 0, 'fax'),
							"email" => mysql_result($rst, 0, 'email'),
							"site_internet" => mysql_result($rst, 0, 'site_internet'),
							"agrement_jeunesse" => ((mysql_result($rst,0, 'agrement_jeunesse') == 1) ? getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'agrement_jeunesse_texte', mysql_result($rst, 0, 'id_organisateur_cvl')) : '')); 
	
$template -> assign ('ville', mb_strtoupper(mysql_result($rst, 0, 'ville'),'utf-8'));
$template -> assign ('organisateurCVL', $organisateurCVL);

//**Thématiques séjour
$paramsThem['id'] = explode(',',mysql_result($rst,0,'id_sejour_thematique'));
$nbThematique = getListeSejourInfos('thematique',$listeThematique,$paramsThem);
$template -> assign ('listeThematique', $listeThematique);
$template -> assign ('nbThematique', $nbThematique);

//**Tranches age
$paramsAge['id'] = explode(',',mysql_result($rst,0,'id_sejour_tranche_age'));
$nbAge = getListeSejourInfos('tranche_age',$listeAge,$paramsAge);
$template -> assign ('listeAge', $listeAge);
$template -> assign ('nbAge', $nbAge);


$template -> assign ('urlContact', 'contact_organisateur_cvl.php');

$template->display('fiche_organisateur_cvl.tpl');
?>