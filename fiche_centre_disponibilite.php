<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	sejour.php						  
/*										  
/*	Description :	Page sejour
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");



//------- Civilite
$sql = "select libelle,id__civilite from trad_civilite where id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__civilite"];
	$TabCivilite[] = $tab;
	unset($tab);
}
$template->assign("TabCivilite",$TabCivilite);
//------- Type etablissement
$sql = "SELECT libelle,id__etablissement_type FROM trad_etablissement_type WHERE id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__etablissement_type"];
	$TabType[] = $tab;
	unset($tab);
}
$template->assign("TabType",$TabType);
//------- Pays
$sql = "SELECT 	trad_pays.libelle,
				trad_pays.id__pays,
				pays.defaut 
		FROM 
				trad_pays 
		inner join 
				pays on(pays.id_pays = trad_pays.id__pays) WHERE id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__pays"];
	$tab["defaut"] = $myrow["defaut"];
	$TabPays[] = $tab;
	unset($tab);
}
$template->assign("TabPays",$TabPays);

$template->assign("ID_FR",_ID_FR);
$template->assign("ID_EN",_ID_EN);
$template->assign("ID_ES",_ID_ES);
$template->assign("ID_DE",_ID_DE);
//------- Discipline
$sql = "SELECT libelle,id_trad_discipline_sportive FROM trad_discipline_sportive WHERE id__langue=".$_SESSION["ses_langue"]." order by libelle";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id_trad_discipline_sportive"];
	$TabDiscipline[] = $tab;
	unset($tab);
}
$template->assign("TabDiscipline",$TabDiscipline);
//------- Type newsletter
$sql = "SELECT libelle,id__types_newsletter FROM trad_types_newsletter WHERE id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__types_newsletter"];
	$TabTypeNL[] = $tab;
	unset($tab);
}
$template->assign("TabTypeNews",$TabTypeNL);
//------- niveau scolaire
$sql = "SELECT 
			trad_sejour_niveau_scolaire.libelle, 
			trad_sejour_niveau_scolaire.id__sejour_niveau_scolaire
		FROM
			trad_sejour_niveau_scolaire
		INNER JOIN 
			sejour_niveau_scolaire ON (trad_sejour_niveau_scolaire.id__sejour_niveau_scolaire = sejour_niveau_scolaire.id_sejour_niveau_scolaire AND trad_sejour_niveau_scolaire.id__langue=".$_SESSION["ses_langue"].")";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__sejour_niveau_scolaire"];
	$TabNiveau[] = $tab;
	unset($tab);
}
$template->assign("TabNiveau",$TabNiveau);


$template->assign('id_centre',$_REQUEST["id_centre"]);
$template->assign('titre',get_libLocal('lib_disponibilite_maj'));

$template->display('centre_disponibilite.tpl');
?>