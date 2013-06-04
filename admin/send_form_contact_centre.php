<?php
$path="./";
require($path."include/inc_header.inc.php");

$sEmailExped = filter_input(INPUT_POST, 'txtContactEmail', FILTER_VALIDATE_EMAIL);

$sNom = $_POST['txtContactNom'];
$sPrenom = $_POST['txtContactPrenom'];
$sTypeContact = $_POST['slctContactType']?$_POST['slctContactType']:0;
$sCivilite = $_POST['slctContactCiv']?$_POST['slctContactCiv']:0;
$sPays = $_POST['slctContactPays']?$_POST['slctContactPays']:0;


$sql = "select email from centre where id_centre='".$_POST["id_centre"]."'";
$result = mysql_query($sql);
$emailCentre = mysql_result($result,0,"email");

function envoi_mail_simple($Destinataire,$from,$Message,$Sujet){

	$From  = "From:".$from."\n";
	$From .= "MIME-version: 1.0\n";
	$From .= "Content-type: text/html; charset= utf-8\n";



	$retour = mail($Destinataire,$Sujet,$Message,$From);
	return $retour;
}


$sql = '
				INSERT INTO centre_contact
					(
						id_centre_contact_type,
						id_civilite,
						id_pays,
						nom,
						prenom,
						nom_ecole,
						email,
						adresse,
						code_postal,
						ville,
						telephone,
						fax,
						id_sejour_niveau_scolaire,
						id_etablissement_type,
						commentaire,
						id_discipline_sportive,
						structure,
						media,
						collectivite,
						fonction,
						equipement,
						id_centre_2,
						date,
						id_types_newsletter )
			  VALUES
			  	(
						'.$sTypeContact.',
						'.$sCivilite.',
						'.$sPays.',
						"'.$sNom.'",
						"'.$sPrenom.'",
						"'.$_POST['txtContactEcole'].'",
						"'.$_POST['txtContactEmail'].'",
						"'.$_POST['txtContactAdresse'].'",
						"'.$_POST['txtContactCp'].'",
						"'.$_POST['txtContactVille'].'",
						"'.$_POST['txtContactTel'].'",
						"'.$_POST['txtContactFax'].'",
						"'.$_POST['slctContactNivScol'].'",
						"'.$_POST['slctContactEtablissType'].'",
						"'.$_POST['txtaContactCommQuest'].'",
						"'.$_POST['slctContactDiscipline'].'",
						"'.$_POST['txtContactStructure'].'",
						"'.$_POST['txtContactMedia'].'",
						"'.$_POST['txtContactNomCollec'].'",
						"'.$_POST['txtContactFonction'].'",
						"'.$_POST['txtContactNomEquipmt'].'",
						"'.$_POST['id_centre'].'",
						NOW(),
						"'.$_POST['newsletter'].'" )';

			  
			  	
$rst = mysql_query($sql);

if(!$rst) $bBddError = true;
else 
{
	//$sEmailDestin=_MAIL_CONTACT_PRESSE;
	
	$sql = "SELECT libelle FROM trad_centre_contact_type WHERE id__centre_contact_type=$sTypeContact AND id__langue=".$_SESSION["ses_langue"];
	$result = mysql_query($sql);
	$type = mysql_result($result,0,"libelle");
	
	$sql = "SELECT libelle FROM trad_civilite WHERE id__civilite=$sCivilite AND id__langue=".$_SESSION["ses_langue"];
	$result = mysql_query($sql);
	$civilite = mysql_result($result,0,"libelle");
	
	
	$message = "Type : ".$type."<br />";
	$message .= "$civilite $sNom $sPrenom"."<br />";
	$message .= "Email : ".$_POST['txtContactEmail']."<br />";
	if($_POST['txtContactAdresse'] != ""){
		$message .= "Adresse : ".$_POST['txtContactAdresse']."<br />";
	}
	if($_POST['txtContactCp'] != ""){
		$message .= "Code Postal : ".$_POST['txtContactCp']." ".$_POST['txtContactVille']."<br />";
	}
	if($_POST['txtContactTel'] != ""){
		$message .= get_libLocal('lib_telephone')." : ".$_POST['txtContactTel']."<br />";
	}
	if($_POST['txtContactFax'] != ""){
		$message .= get_libLocal('lib_fax')." : ".$_POST['txtContactFax']."<br />";
	}
	if($_POST['slctContactNivScol'] != ""){
		$sql = "SELECT libelle FROM trad_sejour_niveau_scolaire WHERE id__sejour_niveau_scolaire=".$_POST['slctContactNivScol']." AND id__langue=".$_SESSION["ses_langue"];
		$result = mysql_query($sql);
		$NivScol = mysql_result($result,0,"libelle");
		$message .= get_libLocal('lib_niveau_scolaire')." : ".$NivScol."<br />";
	}
	if($_POST['txtContactEcole'] != ""){
		$message .= get_libLocal('lib_nom_ecole')." : ".$_POST['txtContactEcole']."<br />";
	}
	if($_POST['slctContactEtablissType'] != ""){
		$sql = "SELECT libelle FROM trad_etablissement_type WHERE id__etablissement_type=".$_POST['slctContactEtablissType']." AND id__langue=".$_SESSION["ses_langue"];
		$result = mysql_query($sql);
		$txt = mysql_result($result,0,"libelle");
		$message .= get_libLocal('lib_type_etablissement')." : ".$txt."<br />";
	}
	if($_POST['txtaContactCommQuest'] != ""){
		$message .= get_libLocal('lib_commentaires_questions')." : ".$_POST['txtaContactCommQuest']."<br />";
	}
	if($_POST['slctContactDiscipline'] != ""){
		$sql = "SELECT libelle FROM trad_discipline_sportive WHERE id__discipline_sportive=".$_POST['slctContactDiscipline']." AND id__langue=".$_SESSION["ses_langue"];
		$result = mysql_query($sql);
		$txt = mysql_result($result,0,"libelle");
		$message .= get_libLocal('lib_discipline_sportive')." : ".$txt."<br />";
	}
	if($_POST['txtContactStructure'] != ""){
		$message .= get_libLocal('lib_nom_structure')." : ".$_POST['txtContactStructure']."<br />";
	}
	if($_POST['txtContactMedia'] != ""){
		$message .= get_libLocal('lib_media')." : ".$_POST['txtContactMedia']."<br />";
	}
	if($_POST['txtContactNomCollec'] != ""){
		$message .= get_libLocal('lib_collectivite')." : ".$_POST['txtContactNomCollec']."<br />";
	}
	if($_POST['txtContactFonction'] != ""){
		$message .= get_libLocal('lib_fonction')." : ".$_POST['txtContactFonction']."<br />";
	}
	if($_POST['txtContactNomEquipmt'] != ""){
		$message .= get_libLocal('lib_fonction')." : ".$_POST['txtContactNomEquipmt']."<br />";
	}	
	if($_POST['txtaContactCommQuest'] != ""){
		$message .= get_libLocal('lib_presentation_projet')." : ".$_POST['txtaContactCommQuest']."<br />";
	}
		if( $_POST["newsletter"] !=""){
		$message .= "<br /><strong>Newsletter :</strong> ";
                $newsletter = explode(",",$_POST["newsletter"]);

		foreach($newsletter as $val){



			$sql = "select libelle from trad_types_newsletter where id__langue=1 and id__types_newsletter=".$val;
			$result = mysql_query($sql);
			$message .= mysql_result($result,0,"libelle")."<br />";
		}
	}
	$titre = 'Contact Centre - Demande à partir du site Internet';
	$template->assign('urlSite',_CONST_APPLI_URL);
	$template->assign('titre',$titre);
	$template->assign('message',$message);
	$message_mail= $template->fetch('gab/mail/mail.tpl');
	
	
	$sEmailDestin=$emailCentre;
	if($sEmailDestin){
	//envoi_mail_simple("f.frezzato@c2is.fr",$_REQUEST["cptEmail"],$message_mail,'Contact Centre - Demande de contact : '.$sPrenom.' '.$sNom,$sEmailExped);
	
		envoie_mail($sEmailDestin,$message_mail,$sEmailExped,'Contact Centre - Demande de contact : '.$sPrenom.' '.$sNom,$sEmailExped);
		envoie_mail(_MAIL_CONTACT_PRESSE,$message_mail,$sEmailExped,'Contact Centre - Demande de contact : '.$sPrenom.' '.$sNom,$sEmailExped);
		envoie_mail(_MAIL_WEBMASTER_C2IS,$message_mail,$sEmailExped,'Contact Centre - Demande de contact : '.$sPrenom.' '.$sNom,$sEmailExped);
	}else {
		$bMailError=true;
	}
}

if((!$bBddError) && (!$bMailError)) echo 1;
?>