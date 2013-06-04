<?php
// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

$Rub = $_REQUEST['Rub'];
$idSejour = $_REQUEST['id'];
$nom_centre = $_POST['nom_centre'];

unset($_REQUEST['Rub']);
unset($_REQUEST['id']);
unset($_POST['nom_centre']);

$titre = get_nav($Rub);
//getListeSejour($Rub, $sejour, array('id_sejour' => $idSejour));

trace($sejour);
        
if ($Rub == _NAV_CLASSE_DECOUVERTE || $Rub == _NAV_CVL || $Rub == _NAV_INCENTIVE || $Rub == _NAV_SEMINAIRES || 
	$Rub == _NAV_SEJOURS_TOURISTIQUES_GROUPE || $Rub == _NAV_SHORT_BREAK || $Rub == _NAV_STAGES_THEMATIQUES_GROUPE || $Rub == _NAV_STAGES_THEMATIQUES_INDIVIDUEL)
	{
		//$titre .= " - ".$sejour[0]['libelle'];
        $titre .= ($_REQUEST['nom_sejour'])?" - ".$_REQUEST['nom_sejour'] : "";
	}
$nom_colonne = "";
$nom_valeur = "";
	
foreach ($_REQUEST as $key => $value)
{
	// [RPL] 27/09/2010 - Pour eviter de choper la variable postee par le tracker d'url
	// effet de bord : on ignore toutes les variables dont le libelle n'existe pas
	// if ($value != '' && $key != 'PHPSESSID' && $key != 'P')
	if ($value != '' && $key != 'PHPSESSID' && get_libLocal( 'lib_'.$key )!='Lib_'.$key)
	{
		if ($key == 'centre_contact_type'){
			if($value>0){
				$value = getContactTypeLib($value);
				$message_mail .= 'Vous &ecirc;tes : '.$value."<br/>";
			}
		}
        if ($key != 'userCode'){
			$nom_colonne .= 	$key.",";
			$nom_valeur  .= "'".addslashes($value)."',";
		}	
		if ($key == 'centre_contact_type' && $value==0){
			continue;
		}
		if ($key == 'email'){
			$email_from = $value;
		}
		if ($key == 'userCode')
		{
			$value = strtoupper($value);
			if( md5($value) == $_SESSION['captcha'] )
				continue;
			else 
			{
				echo '|BAD_CAPTCHA';
				die();
			}
		}
			
			
		$message_mail .= get_libLocal('lib_'.$key).' : '.$value."<br/>";
	}
}
$nom_colonne .= "date_contact";
$nom_valeur  .= "now()";

$sql = "insert into contact_sejour ($nom_colonne) values ($nom_valeur)";
$result = mysql_query($sql);
//===============================================
//RPL - 20/06/2011 : patch recup email du centre
//$destinataire = $sejour[0]['email'];
$sql_email = "SELECT email FROM centre WHERE id_centre = ".$_REQUEST["id_centre"];
$rst_email = mysql_query($sql_email);
$destinataire = mysql_result($rst_email, 0, "email");
//===============================================

$template->assign('urlSite',_CONST_APPLI_URL);
$template->assign('titre',$titre);
$template->assign('message',$message_mail);
$message = $template->fetch('gab/mail/mail.tpl');

$object = get_libLocal('lib_sujet_email_contact') . " - " . $nom_centre;

$is_send =  envoie_mail($destinataire,$message,$email_from, $object);
$is_send =  envoie_mail(_MAIL_CONTACT_SEJOUR,$message,$email_from,$object);
//$is_send =  envoie_mail(_MAIL_WEBMASTER_C2IS,$message.$destinataire,$email_from,$object);
echo "|".$is_send;

function getContactTypeLib($id)
{

	switch ($id)
	{
		case 1 :
			$value = get_libLocal('lib_enseignant');
			break;
			
		case 2 : 
			$value = get_libLocal('lib_agence_to_special_scolaire');
			break;		
			
		case 3 : 
			$value = get_libLocal('lib_organisateur_vacances');
			break;	
			
		case 4 : 
			$value = get_libLocal('lib_organisateur_reunion');
			break;		
			
		case 5 : 
			$value = get_libLocal('lib_to_special_groupe');
			break;

		case 6 : 
			$value = get_libLocal('lib_ce');
			break;		

		case 7 : 
			$value = get_libLocal('lib_assoc_orga_sportif');
			break;

		case 8 : 
			$value = get_libLocal('lib_autre_type_groupe');
			break;		

		case 9 : 
			$value = get_libLocal('lib_autre');
			break;						
					
		default:
			$value = $id;
			break;
	}
	
	return $value;
}

?>