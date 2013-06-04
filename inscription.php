<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	DCA 							  
/*	Date : 		JUIN 2010
/*	Version :	1.0							  
/*	Fichier :	inscription.php						  
/*										  
/*	Description :	Page inscription
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");
$tabNav = get_navID($_GET["Rub"]);


//------- Civilité
$TabCivilite = array();
$sql = "select libelle,id__civilite from trad_civilite where id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$TabCivilite[$myrow["id__civilite"]] = $myrow["libelle"];
}

//------- types de média
$TabTypesMedia = array();
$sql = "select libelle,id__types_media from trad_types_media where id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$TabTypesMedia[$myrow["id__types_media"]] = $myrow["libelle"];
}

//------- types de public
$TabTypesPublic = array();
$sql = "select libelle,id__types_public from trad_types_public where id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$TabTypesPublic[$myrow["id__types_public"]] = $myrow["libelle"];
}


// traitement du formulaire
if(!empty($_POST['nom_media']))
{
	if(isValidFormInscription($_POST))
	{
		// génération du mot de passe aléatoire
		$mot_passe = genere_mot_passe();
		
		// récupération des données
		$aformContact["nom_media"] = add_slashes(trim($_POST["nom_media"]));
		$aformContact["nom_contact"] = add_slashes(trim($_POST["nom_contact"]));
		$aformContact["telephone"] = add_slashes(trim($_POST["telephone"]));
		$aformContact["email"] = add_slashes(trim($_POST["email"]));
		$aformContact["fonction"] = add_slashes(trim($_POST["fonction"]));
		$aformContact["mot_passe"] = $mot_passe;
		
		// traitement des ids
		$types_public = "";
		$noms_types_public = "";
		$i = 1;
		foreach($_POST['types_public'] as $id_type_public)
		{
			if($i > 1)
			{
				$types_public.= ",";
				$noms_types_public.= ", ";
			}
			
			$types_public.= $id_type_public;
			$noms_types_public.= $TabTypesPublic[$id_type_public];
			$i ++;
		}
		
		$nom_civilite = $TabCivilite[$_POST["civilite"]];
		$nom_type_media = $TabTypesMedia[$_POST["type_media"]];
		
		// insertion en base
		$sql_insert = "INSERT INTO membres (
			nom_media, 
			nom_contact, 
			email, 
			mot_passe, 
			telephone, 
			fonction,
			id_types_media,
			id_civilite,
			id_types_public,
			actif,
			flag_mail_envoye
		) VALUES (
			'".$aformContact["nom_media"]."',
			'".$aformContact["nom_contact"]."',
			'".$aformContact["email"]."',
			'".$aformContact["mot_passe"]."',
			'".$aformContact["telephone"]."',
			'".$aformContact["fonction"]."',
			".$_POST["type_media"].", 
			".$_POST["civilite"].",
			'".$types_public."',
			1,
			0
		) ";
		$result_insert = set_query($sql_insert);
		
		// fin récupération des données
		$aformContact["type_media"] = $nom_type_media;
		$aformContact["civilite"] = $nom_civilite;
		$aformContact["types_public"] = $noms_types_public;
		
		
		// envoi du mail de confirmation au client
		$template -> assign("formContact", $aformContact);
		$message  = $template -> fetch("mail/mail_confirmation_inscription.tpl");
		$titre = get_liblocal("lib_demande_compte_presse");
		$template->assign('urlSite', _CONST_APPLI_URL);
		$template->assign('titre', $titre);
		$template->assign('message', $message);
		$message_mail = $template->fetch('gab/mail/mail.tpl');
		
		$aEnvoi = envoie_mail($aformContact["email"], $message_mail, _MAIL_WEBMASTER, $titre);
		
		
		// envoi du mail de notification à l'admin
		$template -> assign("formContact", $aformContact);
		$message  = $template -> fetch("mail/mail_notification_inscription.tpl");
		$titre = get_liblocal("lib_demande_compte_presse");
		$template->assign('urlSite', _CONST_APPLI_URL);
		$template->assign('titre', $titre);
		$template->assign('message', $message);
		$message_mail = $template->fetch('gab/mail/mail.tpl');
		$bEnvoi = envoie_mail(_MAIL_WEBMASTER, $message_mail, _MAIL_WEBMASTER, $titre);
		$bEnvoi = envoie_mail(_MAIL_CONTACT_PRESSE, $message_mail, _MAIL_WEBMASTER, $titre);
		
		
		// redirection
		if($aEnvoi && $bEnvoi)
		{
			unset($_POST);
			redirect(get_url_nav(_NAV_DEMANDE_PRESSE_OK));		
		}
		else
		{
			redirect(get_url_nav(_NAV_DEMANDE_PRESSE_PAS_OK));
		}
	}
	
	else
	{
		redirect(get_url_nav(_NAV_DEMANDE_PRESSE_PAS_OK));
	}
}

// affichage du formulaire
else
{
	$type = 'Presse';	
	$template->assign('type', $type);
	
	$template->assign("TabCivilite",$TabCivilite);
	$template->assign("TabTypesMedia",$TabTypesMedia);
	$template->assign("TabTypesPublic",$TabTypesPublic);
	
	$template->assign("titre",mb_strtoupper(get_nav($_GET["Rub"]),"utf-8"));
	$template->display('inscription.tpl');
}
?>