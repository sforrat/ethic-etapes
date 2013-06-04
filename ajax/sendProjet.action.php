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
		
		$message="";
		
		foreach($_POST as $key=>$val){
			if($key != "userCode" && $key != "youAre_id" && $val!="" && $val!="undefined"){
				$key = str_replace("_"," ",$key);
				
				switch( $key ){
					
					case "centre":
						$sql = "select libelle, ville from centre where id_centre=".$val;
						$result = mysql_query($sql);
						$message .= "Centre : ".mysql_result($result,0,"libelle")." - ".mysql_result($result,0,"ville")."<br />";
						break;
						
					case "Discipline":
						if( $_POST["youAre_id"]==6 ){
							$message .= $key." : ".$val."<br />";
						}						
						break;
						
					case "Niveau scolaire":
						if( $_POST["youAre_id"]==1 ){
							$message .= $key." : ".$val."<br />";		
						}						
						break;
						
					case "Type d etablissement":
						if( $_POST["youAre_id"]==1 ){
							$message .= $key." : ".$val."<br />";		
						}						
						break;
						
					case "Nom de l ecole":
						if( $_POST["youAre_id"]==1 ){
							$message .= $key." : ".$val."<br />";		
						}						
						break;
						
					case "Nom de l association":
						if( $_POST["youAre_id"]==6 ){
							$message .= $key." : ".$val."<br />";		
						}						
						break;
							
					default:
						$message .= $key." : ".$val."<br />";
						break;
					
				}
			}
		}
		
		$template->assign('urlSite',_CONST_APPLI_URL);
		$template->assign('titre',get_libLocal("lib_presentation_projet"));
		$template->assign('message',$message);
		$message= $template->fetch('gab/mail/mail.tpl');				
		//envoie_mail(_MAIL_WEBMASTER_C2IS,$message,$_POST["Mail"],get_libLocal('lib_sujet_mail_send_projet'));
		envoie_mail(_MAIL_WEBMASTER,$message,$_POST["Mail"],get_libLocal('lib_sujet_mail_send_projet'));
		
		echo "|".get_libLocal('lib_projet_envoi_ok');
	}else{
		echo '|BAD_CAPTCHA';
	}
	
}
/* Si aucun code n'a été entré */
else echo '|BAD_CAPTCHA';

?>