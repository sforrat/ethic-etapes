<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	login_espace_membre.php						  
/*										  
/*	Description :	Login espace membre
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

	if ($_REQUEST['login'] != '')
	{
		$sql = "SELECT mot_passe 
		FROM membres 
		where actif = 1 
		and email = '".add_slashes($_REQUEST['login'])."' ";
		
		$rst = mysql_query($sql);
		if (!$rst)
			echo mysql_error().' - '.$sql;
		else 
		{
			$nb = mysql_num_rows($rst);			
			if ($nb == 1)
			{
				$message_mail = get_libLocal('lib_mot_de_passe').' : '.mysql_result($rst, 0, 'mot_passe');
				
				$template->assign('urlSite',_CONST_APPLI_URL);
				$template->assign('titre', get_libLocal('lib_vos_identifiants'));
				$template->assign('message',$message_mail);
				$message = $template->fetch('gab/mail/mail.tpl');

				$destinataire = $_REQUEST['login'];
							
				$is_send =  envoie_mail($destinataire, $message, _MAIL_CONTACT_PRESSE, get_libLocal('lib_vos_identifiants'));			
				$template -> assign ('successMsg', get_libLocal('lib_identifiants_envoyes'));
			}
			else 
			{
				$template -> assign ('errorMsg', get_libLocal('lib_email_inexistant'));
			}
			
		}
		
		$template -> assign ('login', $_REQUEST['login']);
	}


	$template->assign('titre', mb_strtoupper(get_nav($_REQUEST['Rub']),'utf-8'));
	$template->assign('action', get_url_nav($_REQUEST['Rub']));
	$template->display('mdp_oublie_presse.tpl');


?>