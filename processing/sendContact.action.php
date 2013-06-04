<?
// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");

$filename_langue = $path."include/language/lib_language_".$_SESSION['ses_langue_ext'].".inc.php";

if (is_file($filename_langue))
{
	include($filename_langue);	
}




switch($_POST["contact_youAre"]){
	case 1:
		$youAre = get_libLocal('lib_enseignant');
		break;	
	case 2:
		$youAre = get_libLocal('lib_organisateur_vacances');
		break;	
	case 3:
		$youAre = get_libLocal('lib_organisateur_reunion');
		break;	
	case 4:
		$youAre = get_libLocal('lib_to');
		break;	
	case 5:
		$youAre = get_libLocal('lib_ce');
		break;	
	case 6:
		$youAre = get_libLocal('lib_assoc');
		break;	
	case 7:
		$youAre = get_libLocal('lib_particulier');
		break;	
	case 8:
		$youAre = get_libLocal('lib_presse');
		break;	
	case 9:
		$youAre = get_libLocal('lib_collectivite');
		break;	
	case 10:
		$youAre = get_libLocal('lib_partenaires');
		break;
	case 11:
		$youAre = get_libLocal('lib_futur_ee');
		break;	
	case 12:
		$youAre = get_libLocal('lib_autre');
		break;	
	default:
		break;
}
				
$message = "Type : ".$youAre."<br /><br />";
if( $_POST["test-Civilite"] !=""){
	$message .= $_POST["test-Civilite"];
}
if( $_POST["test-contact_name"] !=""){
	$message .= " ".$_POST["test-contact_name"]."<br />";
}
if( $_POST["test-Pecole"] !=""){
	$message .= "<br /><strong>Nom de l'&eacute;cole : </strong>".$_POST["test-Pecole"]."<br />";
}
if( $_POST["test-email-contact_mail"] !=""){
	$message .= "<br /><strong>Adresse e-mail :</strong> ".$_POST["test-email-contact_mail"]."<br />";
}
if( $_POST["test-Pcollectivite"] !=""){
	$message .= "<br /><strong>Nom de la collectivit&eacute; :</strong> ".$_POST["test-Pcollectivite"]."<br />";
}
if( $_POST["test-Pequipement"] !=""){
	$message .= "<br /><strong>Nom de l'&eacute;quipement :</strong> ".$_POST["test-Pequipement"]."<br />";
}
if( $_POST["test-PFonction"] !=""){
	$message .= "<br /><strong>Fonction de la personne :</strong> ".$_POST["test-PFonction"]."<br />";
}
if( $_POST["test-Pstructure"] !=""){
	$message .= "<br /><strong>Nom de la structure :</strong> ".$_POST["test-Pstructure"]."<br />";
}
if( $_POST["test-Pmedia"] !=""){
	$message .= "<br /><strong>Nom du media :</strong> ".$_POST["test-Pmedia"]."<br />";
}
if( $_POST["test-Passociation"] !=""){
if($_POST["contact_youAre"]==2){
    $message .= "<br /><strong>Nom de la structure :</strong> ".$_POST["test-Passociation"]."<br />";
  }else{
	$message .= "<br /><strong>Nom de l'association ou de l'organisme :</strong> ".$_POST["test-Passociation"]."<br />";
}

}
//[RPL] 30/11/2010 - uniquement discipline sur association sportive
/*if( $_POST["test-Pdiscipline"] !="" && $_POST["contact_youAre"]!=1 
                                    && $_POST["contact_youAre"]!=2
                                    && $_POST["contact_youAre"]!=3
                                    && $_POST["contact_youAre"]!=7){*/
if( $_POST["test-Pdiscipline"] !="" && $_POST["contact_youAre"]==6 ){
	
	$Pdiscipline="";	
	$message .= "<strong>Discipline :</strong><br />";
	foreach($_POST["test-Pdiscipline"] as $val){
                $Pdiscipline .=$val.",";
		$sql = "select libelle from trad_discipline_sportive where id__langue=1 and id_trad_discipline_sportive=".$val;
		$result = mysql_query($sql);
		$message .= mysql_result($result,0,"libelle")."<br />";
	}
	
}
if( $_POST["test-Padresse"] !=""){
	$message .= "<br /><strong>Adresse :</strong> ".$_POST["test-Padresse"]."<br />";
}
if( $_POST["test-Pcp"] !=""){
	$message .= "<strong>Code postal :</strong> ".$_POST["test-Pcp"]."<br />";
}
if( $_POST["test-Pville"] !=""){
	$message .= "<br /><strong>Ville :</strong> ".$_POST["test-Pville"]."<br />";
}
if( $_POST["test-Ppays"] !=""){
	$message .= "<br /><strong>Pays :</strong> ";
	$sql = "select libelle from trad_pays where id__langue=1 and id__pays=".$_POST["test-Ppays"];
	$result = mysql_query($sql);
	$message .= mysql_result($result,0,"libelle")."<br />";
}
if( $_POST["test-contact_tel"] !=""){
	$message .= "<strong>T&eacute;l&eacute;phone :</strong> ".$_POST["test-contact_tel"]."<br />";
}
if( $_POST["PFax"] !=""){
	$message .= "<br /><strong>Fax :</strong> ".$_POST["PFax"]."<br />";
}
/*if( $_POST["test-Pniveau"] !="" && $_POST["contact_youAre"]!=2
                                && $_POST["contact_youAre"]!=3
                                && $_POST["contact_youAre"]!=6
                                && $_POST["contact_youAre"]!=7){*/
if( $_POST["test-Pniveau"] !="" && $_POST["contact_youAre"]==1 ){
	
	$message .= "<br /><strong>Niveau scolaire :</strong><br />";
	foreach($_POST["test-Pniveau"] as $val){
                $Pniveau .=$val.",";
		$sql = "select libelle from trad_sejour_niveau_scolaire where id__langue=1 and id__sejour_niveau_scolaire=".$val;
		$result = mysql_query($sql);
		$message .= mysql_result($result,0,"libelle")."<br />";
	}
	
}
/*if( $_POST["test-Petablissement"] !="" && $_POST["contact_youAre"]!=2
                                       && $_POST["contact_youAre"]!=3
                                       && $_POST["contact_youAre"]!=6
                                       && $_POST["contact_youAre"]!=7 ){*/
if( $_POST["test-Petablissement"] !="" && $_POST["contact_youAre"]==1 ){
	
	$message .= "<br /><strong>Type d'&eacute;tablissement :</strong><br />";
	foreach($_POST["test-Petablissement"] as $val){
                $Petablissement.=$val.",";
		$sql = "select libelle from trad_etablissement_type where id__langue=1 and id__etablissement_type=".$val;
		$result = mysql_query($sql);
		$message .= mysql_result($result,0,"libelle")."<br />";
	}
	
}
if( $_POST["test-contact_commentaire"] !=""){
	$message .= "<br /><strong>Commentaire :</strong> ".$_POST["test-contact_commentaire"]."<br />";
}

if( $_POST["test-Newsletter"] !=""){
	$message .= "<br /><strong>Newsletter :</strong> ";
	foreach($_POST["test-Newsletter"] as $val){
		
		$Newsletter .=$val.",";
		
		$sql = "select libelle from trad_types_newsletter where id__langue=1 and id__types_newsletter=".$val;
		$result = mysql_query($sql);
		$message .= mysql_result($result,0,"libelle")."<br />";
	}
}

$titre = get_libLocal('lib_titre_mail_contact');
$template->assign('urlSite',_CONST_APPLI_URL);
$template->assign('titre',$titre);
$template->assign('message',$message);
$message_mail= $template->fetch('gab/mail/mail.tpl');
			
envoie_mail(_MAIL_WEBMASTER,$message_mail,$_POST["test-email-contact_mail"],get_libLocal('lib_sujet_mail_contact'));
//envoie_mail(_MAIL_WEBMASTER_C2IS,$message_mail._MAIL_WEBMASTER,$_POST["test-email-contact_mail"],get_libLocal('lib_sujet_mail_contact'));

$sql = "insert into contact (	type_contact,
								civilite,
								nom,
								ecole,
								collectivite,
								equipement,
								fonction,
								media,
								association,
								id_discipline_sportive,
								email,
								adresse,
								cp,
								ville,
								id_pays,
								telephone,
								fax,
								id_sejour_niveau_scolaire,
								id_etablissement_type,
								commentaire,
								id_types_newsletter)
								
					VALUES (	'".addslashes($youAre)."',
								'".addslashes($_POST["test-Civilite"])."',
								'".addslashes($_POST["test-contact_name"])."',
								'".addslashes($_POST["test-Pecole"])."',
								'".addslashes($_POST["test-Pcollectivite"])."',
								'".addslashes($_POST["test-Pequipement"])."',
								'".addslashes($_POST["test-PFonction"])."',
								'".addslashes($_POST["test-Pmedia"])."',
								'".addslashes($_POST["test-Passociation"])."',
								'".addslashes($Pdiscipline)."',
								'".addslashes($_POST["test-email-contact_mail"])."',
								'".addslashes($_POST["test-Padresse"])."',
								'".addslashes($_POST["test-Pcp"])."',
								'".addslashes($_POST["test-Pville"])."',
								'".addslashes($_POST["test-Ppays"])."',
								'".addslashes($_POST["test-contact_tel"])."',
								'".addslashes($_POST["PFax"])."',
								'".addslashes($Pniveau)."',
								'".addslashes($Petablissement)."',
								'".addslashes($_POST["test-contact_commentaire"])."',
								'".addslashes($Newsletter)."')";
$result  = mysql_query($sql);
$param[0]["id"] = "ok";
$param[0]["id_name"] = "envoi";

redirect($path.get_url_nav(_NAV_CONTACT,$param));
?>