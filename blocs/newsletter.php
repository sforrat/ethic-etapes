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
	$this->assign("message",get_libLocal("lib_message_newsletter_envoye"));
	
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

if($_POST["email"] != ""){
	$this->assign('email',$_POST["email"]);
}

$this -> display('blocs/newsletter.tpl');
?>
