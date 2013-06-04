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



if($_GET["envoi"] == "ok"){
	$this->assign("messageOK",1);
	$this->assign("message",get_libLocal("lib_message_contact_envoye"));
	unset($_SESSION["envoiContact"]);
}
//------- Civilit
$sql = "select libelle,id__civilite from trad_civilite where id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__civilite"];
	$TabCivilite[] = $tab;
	unset($tab);
}
$this->assign("TabCivilite",$TabCivilite);
//------- Type tablissement
$sql = "SELECT libelle,id__etablissement_type FROM trad_etablissement_type WHERE id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__etablissement_type"];
	$TabType[] = $tab;
	unset($tab);
}
$this->assign("TabType",$TabType);
//------- Type newsletter
$sql = "SELECT libelle,id__types_newsletter FROM trad_types_newsletter WHERE id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__types_newsletter"];
	$TabTypeNL[] = $tab;
	unset($tab);
}
$this->assign("TabTypeNews",$TabTypeNL);
//------- Pays
$sql = "SELECT trad_pays.libelle,trad_pays.id__pays,pays.defaut FROM trad_pays inner join pays on(pays.id_pays = trad_pays.id__pays) WHERE id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__pays"];
	$tab["selected"] = $myrow["defaut"];
	$TabPays[] = $tab;
	unset($tab);
}
$this->assign("TabPays",$TabPays);

$this->assign("ID_FR",_ID_FR);
$this->assign("ID_EN",_ID_EN);
$this->assign("ID_ES",_ID_ES);
$this->assign("ID_DE",_ID_DE);
//------- Discipline
$sql = "SELECT libelle,id_trad_discipline_sportive FROM trad_discipline_sportive WHERE id__langue=".$_SESSION["ses_langue"]." order by libelle";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id_trad_discipline_sportive"];
	$TabDiscipline[] = $tab;
	unset($tab);
}
$this->assign("TabDiscipline",$TabDiscipline);
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
$this->assign("TabNiveau",$TabNiveau);

$this -> display('blocs/contact.tpl');
?>
