<?
// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");


$filename_langue = $path."include/language/lib_language_".$_SESSION['ses_langue_ext'].".inc.php";

if (is_file($filename_langue))
{
	include($filename_langue);	
}

				
$message = "";
if( $_POST["test-Civilite"] !=""){
	$message .= $_POST["test-Civilite"];
}
if( $_POST["test-contact_name"] !=""){
	$message .= " ".$_POST["test-contact_name"]."<br />";
}
if( $_POST["test-email-contact_mail"] !=""){
	$message .= "<br /><strong>Adresse e-mail :</strong> ".$_POST["test-email-contact_mail"]."<br />";
}


//if( $_POST["test-Newsletter"] !=""){
	$message .= "<br /><strong>Newsletter :</strong> ";
	foreach($_POST["test-Newsletter"] as $val){
		
		$Newsletter .=$val.",";
		
		$sql = "select libelle from trad_types_newsletter where id__langue=1 and id__types_newsletter=".$val;
		$result = mysql_query($sql);
		$message .= mysql_result($result,0,"libelle")."<br />";
	}
//}


$sql = "insert into inscription_newsletter (
			date,
			nom,
			civilite,
			email,
			id_types_newsletter)
		 VALUES ( 	NOW(),
		 			'".addslashes(trim($_POST["test-contact_name"]))."',
		 			'".$_POST["test-Civilite"]."',
		 			'".addslashes(trim($_POST["test-email-contact_mail"]))."',
		 			'".$Newsletter."')";

$result = mysql_query($sql);

$message .= "<br /><strong>Langue :</strong> ";
$sql = "select _langue from _langue where id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
$message .= mysql_result($result,0,"_langue")."<br />";

$titre = get_libLocal('lib_titre_mail_newsletter');
$template->assign('urlSite',_CONST_APPLI_URL);
$template->assign('titre',$titre);
$template->assign('message',$message);
$message_mail= $template->fetch('gab/mail/mail.tpl');
			
envoie_mail(_MAIL_CONTACT_EMPLOI,$message_mail,$_POST["test-email-contact_mail"],get_libLocal('lib_titre_mail_newsletter'));
//envoie_mail("f.frezzato@c2is.fr",$message_mail,$_POST["test-email-contact_mail"],get_libLocal('lib_titre_mail_newsletter'));
envoie_mail(_MAIL_WEBMASTER,$message_mail,$_POST["test-email-contact_mail"],get_libLocal('lib_titre_mail_newsletter'));  

$param[0]["id"] = "ok";
$param[0]["id_name"] = "envoi";

redirect($path.get_url_nav(_NAV_NEWSLETTER,$param));
?>