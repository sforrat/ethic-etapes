<?
/******************************************************************************************/
/*	C2IS : 		xxprojetxx
/*	Auteur : 	API 								  
/*	Date : 		Mai 2005							  
/*	Version :	1.0								  
/*	Fichier :	inc_mailer.inc.php					          
/*										  	  
/*	Description :	Formulaire d'envoi de mail formaté pour l'administrateur du site  
/******************************************************************************************/

if ($TableDef == 1 || $TableDef == 11) {
	$StyleChamps =  "InputTextBo";
}else {
	$StyleChamps =  "InputText";
}

if ($_REQUEST['EM']==1) {
	require("../include/Smarty_local.class.php");
	$template = new Smarty_local; // instanciation nouvel objet template enrichit par les parametres locaux
	     
	$template->compile_check = true; // vérifie si un template a été modifié a chaque appel
					 // peut être passé à False en production pour améliorer
					 // les performances. Attention lors des mises à jour
	$template->debugging = DEBUG_SMARTY;    // Constante positionnée dans lib_global.inc.php
	
	$template->caching = false; // cache de compilation des templates ? => ATTENTION avec les pages dynamiques..
	
	// on s'affranchit de l'interpretation par smarty des { sur les js par ex.
	// en changeant les délimiteurs gauche et droite par défaut par des #{
	$template->left_delimiter = '#{';
	$template->right_delimiter = '}#';
	
	include("../include/inc_output_filters.inc.php");
	
	$template -> assign("URL_SITE",_CONST_APPLI_URL);
	$template -> assign("MESSAGE",nl2br($_REQUEST['message']));
	
	$message_html = $template->fetch('mail_webmaster.tpl');
	
	envoie_mail($_REQUEST['cible'],$message_html,$_REQUEST['from'],$_REQUEST['objet'],$_REQUEST['from'],0);

	// *** insertion dans BDD
	$chaine = "insert into format_mail (objet,cible,part,message,date_ins) values ('".$_REQUEST['objet']."','".$_REQUEST['cible']."','".$_REQUEST['from']."','".$message_html."',now())";
	mysql_query($chaine);

	echo("<p class=\"titre\">Formulaire d'envoi d'email formaté :</p><br>");
	echo("Votre email a bien été envoyé à <b>".$_REQUEST['cible']."</b><br><br><br>");
	echo("<a href=\"bo_include_launcher.php?file=include/inc_mailer.inc.php&TableDef=".$_REQUEST['TableDef']."\">Retour</a>");

}else{ ?>
	<script language="javascript">
	function envoyer() {
		if ((document.form_mail.objet.value=="") || (document.form_mail.objet.value==" ")) {
			alert("Le champ \"Objet\" est obligatoire.");
		}else if ((document.form_mail.cible.value=="") || (document.form_mail.cible.value==" ")) {
			alert("Le champ \"Email Cible\" est obligatoire.");
		}else if ((document.form_mail.from.value=="") || (document.form_mail.from.value==" ")) {
			alert("Le champ \"De la part de\" est obligatoire.");
		}else{
			if (confirm("Vous êtes sur le point d'envoyer un mail.\nConfirmez vous votre choix ?")) {
				document.form_mail.submit();
			}
		}
	}
	</script>
	<p class="titre">Formulaire d'envoi d'email formaté :</p>
	<form name="form_mail" action="bo_include_launcher.php?file=include/inc_mailer.inc.php" method="post">
	<input type="hidden" name="TableDef" value="<?=$_REQUEST['TableDef']?>">
	<input type="hidden" name="EM" value="1">
	<table cellspacing="0" cellpadding="2" border="0">
	<tr>
	<td>Objet</td>
	<td><input class="<?=$StyleChamps?>" type="text" name="objet" size="60"></td>
	</tr>
	<tr>
	<td>Email Cible</td>
	<td><input class="<?=$StyleChamps?>" type="text" name="cible" size="60"></td>
	</tr>
	<tr>
	<td>De la part de</td>
	<td><input class="<?=$StyleChamps?>" type="text" name="from" size="60" value="<?=_MAIL_WEBMASTER?>"></td>
	</tr>

	<tr>
	<td valign="top">Message</td>
	<td><textarea name="message" class="<?=$StyleChamps?>" cols="60" rows="20"></textarea></td>
	</tr>

	<tr><td colspan="2" align="center"><br>
<?	$TitreBouton = $inc_form_valider." >>";

	//AFFICHAGE DU BOUTON ACTION
	$action_button = new bo_button();
	$action_button->c1 = $MenuBgColor;
	$action_button->c2 = $MainFontColor;
	$action_button->name = $TitreBouton;
	$action_button->action = "envoyer();";
	$action_button->display( );
	
	echo("</td></tr></table>");
	echo("</form>");
} ?>
