<?
// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");
session_start();

$filename_langue = $path."include/language/lib_language_".$_SESSION['ses_langue_ext'].".inc.php";

if (is_file($filename_langue))
{
	include($filename_langue);	
}


if (!empty($_REQUEST['userCode']))
{
	/* Conversion en majuscules */
	$userCode = strtoupper($_REQUEST['userCode']);

	/* Cryptage et comparaison avec la valeur stockée dans $_SESSION['captcha'] */
	if( md5($userCode) == $_SESSION['captcha'] ){
		$sql = "insert into laissez_avis (	nom,
											prenom,
											pseudo,
											avis,
											email,
											date_auto,
											id_centre,
											id_laissez_avis_note,
											id__langue)
									VALUES(	'".add_slashes($_POST["nom"])."',
											'".add_slashes($_POST["prenom"])."',
											'".add_slashes($_POST["pseudo"])."',
											'".add_slashes($_POST["commentaire"])."',
											'".add_slashes($_POST["email"])."',
											NOW(),
											'".add_slashes($_POST["id_centre"])."',
											'".add_slashes($_POST["note"])."',
											'".$_SESSION["ses_langue"]."')";
		$result = mysql_query($sql);
		
		
		$message = "Un avis vient d'être posté.<br /><br />";
    
    $sql_S = "select libelle,ville from centre where id_centre=".$_POST["id_centre"];
    $result_S = mysql_query($sql_S); 
		
		
		$message .= "Centre : ".mysql_result($result_S,0,"libelle")."<br /><br />";
    $message .= "Nom : ".$_POST["nom"]."<br />";
		$message .= "Prénom : ".$_POST["prenom"]."<br />";
		$message .= "email : ".$_POST["email"]."<br />";
		
		$sql_SS = "SELECT libelle FROM trad_laissez_avis_note WHERE id__laissez_avis_note=".$_POST["note"];
    $result_SS = mysql_query($sql_SS); 
		$message .= "Note : ".mysql_result($result_SS,0,"libelle")."<br /><br />";
		
		$message .= "Avis :<br /> ".$_POST["commentaire"]."<br />";
		
		
		$template->assign('urlSite',_CONST_APPLI_URL);
		$template->assign('titre',get_libLocal("lib_presentation_projet"));
		$template->assign('message',$message);
		$message= $template->fetch('gab/mail/mail.tpl');				
		$sujet = 	str_replace("##CENTRE##",mysql_result($result_S,0,"libelle"),get_libLocal('lib_sujet_mail_avis'));
    $sujet = 	str_replace("##VILLE##",mysql_result($result_S,0,"ville"),$sujet);
    envoie_mail(_MAIL_CONTACT_PRESSE,$message,$_POST["email"],$sujet);
		//envoie_mail("f.frezzato@c2is.fr",$message,$_POST["email"],$sujet);
		
		echo "|".get_libLocal('lib_avis_envoi_ok');
	}else{
		echo '|BAD_CAPTCHA';
	}
	
}
/* Si aucun code n'a été entré */
else echo '|BAD_CAPTCHA';

?>