<?
// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");


$filename_langue = $path."include/language/lib_language_".$_SESSION['ses_langue_ext'].".inc.php";

if (is_file($filename_langue))
{
	include($filename_langue);	
}
//trace($_POST);
/*
	[contact_youAre] => 13
    [test-Civilite] => Monsieur
    [test-contact_name] => sxsqx
    [test-Pecole] => qsxsqx
    [test-email-contact_mail] => dvfd@vfd.com
    [test-Pcollectivite] => xqsx
    [test-Pequipement] => qsx
    [test-PFonction] => sqxsqx
    [test-Pstructure] => qsxqs
    [test-Pmedia] => qsx
    [test-Passociation] => xqs
    [test-Pdiscipline] => Array
        (
            [0] => 1
            [1] => 9
            [2] => 37
        )

    [test-Padresse] => xqs
    [test-Pcp] => xsqxqsxqsx
    [test-Pville] => qsxqs
    [test-Ppays] => 1
    [test-contact_tel] => xsqxqs
    [PFax] => xqsxqsx
    [test-Pniveau] => Array
        (
            [0] => 2
            [1] => 6
        )

    [test-Petablissement] => Array
        (
            [0] => 1
            [1] => 3
        )

    [contact_commentaire] => xsqxqs
    [test-Newsletter] => 


*/



if( md5($_POST["userCode"]) != $_SESSION['captcha'] )
{
	echo '|BAD_CAPTCHA';
	die();
}

				
$message = "";
if( $_POST["test-Civilite"] !=""){
	$message .= $_POST["test-Civilite"];
}
if( $_POST["test-contact_name"] !=""){
	$message .= " ".$_POST["test-contact_name"]."<br />";
}
if( $_POST["test-Pecole"] !=""){
	$message .= "<br /><strong>Nom de l'&eacute;cole : </strong>".$_POST["test-contact_name"]."<br />";
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
if( $_POST["test-contact_commentaire"] !=""){
	$message .= "<br /><strong>Commentaire :</strong> ".$_POST["test-contact_commentaire"]."<br />";
}

if( $_POST["test-Newsletter"] !=""){
	$message .= "<br /><strong>Newsletter :</strong> ";
	$message .= $_POST["test-Newsletter"]."<br />";
}

//$titre = get_libLocal('lib_titre_mail_contact');
$titre = 'Demande de contact à partir du site Internet';
$template->assign('urlSite',_CONST_APPLI_URL);
$template->assign('titre',$titre);
$template->assign('message',$message);
$message_mail= $template->fetch('gab/mail/mail.tpl');
			
envoie_mail(_MAIL_CONTACT_EMPLOI,$message_mail,$_POST["test-email-contact_mail"],$titre));

$param[0]["id"] = "ok";
$param[0]["id_name"] = "envoi";

echo 1;
//redirect($path.get_url_nav(_NAV_CONTACT,$param));
?>