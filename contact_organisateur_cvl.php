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
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");



if($_GET["envoi"] == "ok"){
	$template->assign("messageOK",1);
	$template->assign("message",get_libLocal("lib_message_contact_envoye"));
	unset($_SESSION["envoiContact"]);
}
//------- Civilité
$sql = "select libelle,id__civilite from trad_civilite where id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__civilite"];
	$TabCivilite[] = $tab;
	unset($tab);
}
$template->assign("TabCivilite",$TabCivilite);

//------- Pays
$sql = "SELECT libelle,id__pays FROM trad_pays WHERE id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__pays"];
	$TabPays[] = $tab;
	unset($tab);
}
$template->assign("TabPays",$TabPays);

$template->assign("ID_FR",_ID_FR);
$template->assign("ID_EN",_ID_EN);
$template->assign("ID_ES",_ID_ES);
$template->assign("ID_DE",_ID_DE);

$template->assign("titre",mb_strtoupper(get_libLocal('lib_formulaire_contact').' '.get_trad_nav($_REQUEST['Rub']), "utf-8"));
$template -> display('contact_organisateur_cvl.tpl');
?>
