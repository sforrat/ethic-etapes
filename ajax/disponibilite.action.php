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
	//trace($_POST);
	/* Conversion en majuscules */
	$userCode = strtoupper($_REQUEST['userCode']);
	//trace($_POST);
	/* Cryptage et comparaison avec la valeur stockee dans $_SESSION['captcha'] */
	if( md5($userCode) == $_SESSION['captcha'] ){
		$message="";
		foreach($_POST as $key=>$val){

			if($key != "userCode" && $val!=""){
				$key = str_replace("_"," ",$key);

				if($key == "centre"){
					$sql_S = "select libelle, ville from centre where id_centre=".$val;
					$result_S = mysql_query($sql_S);

					$message .= "Centre : ".mysql_result($result_S,0,"libelle")." - ".mysql_result($result_S,0,"ville")."<br />";
					$objet_mail = str_replace("##CENTRE##",mysql_result($result_S,0,"libelle"),get_libLocal('lib_demande_info_centre_sejour') );
					$objet_mail = str_replace("##VILLE##",mysql_result($result_S,0,"ville"),$objet_mail);
					
				}elseif($key=="Type de personne"){
					if($val == 1){
						$message .= $key." : ".get_libLocal('lib_enseignant')."<br />";
					}elseif($val == 2){
						$message .= $key." : ".get_libLocal('lib_agence_to_special_scolaire')."<br />";
					}elseif($val == 3){
						$message .= $key." : ".get_libLocal('lib_organisateur_vacances')."<br />";
					}elseif($val == 4){
						$message .= $key." : ".get_libLocal('lib_organisateur_reunion')."<br />";
					}elseif($val == 5){
						$message .= $key." : ".get_libLocal('lib_to_special_groupe')."<br />";
					}elseif($val == 6){
						$message .= $key." : ".get_libLocal('lib_ce')."<br />";
					}elseif($val == 7){
						$message .= $key." : ".get_libLocal('lib_assoc')."<br />";
					}elseif($val == 8){
						$message .= $key." : ".get_libLocal('lib_particulier')."<br />";
					}elseif($val == 9){
						$message .= $key." : ".get_libLocal('lib_autre')."<br />";
					}
				}elseif($key=="Newsletter"){
					$sql_S = "SELECT libelle FROM trad_types_newsletter WHERE id__langue=".$_SESSION["ses_langue"]." and id__types_newsletter in(".$val."0)";
					$result_S = mysql_query($sql_S);
					$message .= $key." : ";
					while($myrow_S = mysql_fetch_array($result_S)){
						$message .= $myrow_S["libelle"]."<br />";
					}
				}else{
					$message .= $key." : ".$val."<br />";
				}
			}
		}

		$template->assign('urlSite',_CONST_APPLI_URL);
		$template->assign('titre',get_libLocal("lib_disponibilite_maj"));
		$template->assign('message',$message);
		$message= $template->fetch('gab/mail/mail.tpl');

		//envoie_mail(_MAIL_WEBMASTER_C2IS,$message,$_POST["Mail"],$objet_mail);
		envoie_mail(_MAIL_WEBMASTER,$message,$_POST["Mail"],$objet_mail);

		//stockage des donnees en base :
		$sql = "insert into centre_demande_dispo (	date_demande,
													id_centre_1,
													types_public,
													nom,
													nom_ecole,
													mail,
													nom_structure,
													nom_association,
													niveau_scolaire,
													discipline_sportive,
													pays,
													etablissement_type,
													telephone,
													adresse,
													cp,
													ville,
													date_arrivee,
													date_depart,
													nb_personne,
													id_types_newsletter,
													commentaire)
													
										VALUES (	now(),
													'".add_slashes($_REQUEST["centre"])."',
													'".add_slashes($_REQUEST["Type_de_personne"])."',
													'".add_slashes($_REQUEST["Nom"])."',
													'".add_slashes($_REQUEST["Nom_de_l_ecole"])."',
													'".add_slashes($_REQUEST["Mail"])."',
													'".add_slashes($_REQUEST["Nom_de_la_structure"])."',
													'".add_slashes($_REQUEST["Nom_de_l_association"])."',
													'".add_slashes($_REQUEST["Niveau_scolaire"])."',
													'".add_slashes($_REQUEST["Discipline"])."',
													'".add_slashes($_REQUEST["Pays"])."',
													'".add_slashes($_REQUEST["Type_d_etablissement"])."',
													'".add_slashes($_REQUEST["Telephone"])."',
													'".add_slashes($_REQUEST["Adresse"])."',
													'".add_slashes($_REQUEST["Code_postal"])."',
													'".add_slashes($_REQUEST["Ville"])."',
													'".add_slashes($_REQUEST["Date_d_arrivee"])."',
													'".add_slashes($_REQUEST["Date_de_depart"])."',
													'".add_slashes($_REQUEST["Nombre_de_personne"])."',
													'".add_slashes($_REQUEST["Newsletter"])."',
													'".add_slashes($_REQUEST["Commentaire"])."')";
		$sql = str_replace("<br />","",$sql);
		$result = mysql_query($sql);


		echo "|".get_libLocal('lib_disponibilite_envoi_ok');
	}else{
		echo '|BAD_CAPTCHA';
	}

}
/* Si aucun code n'a ete entre */
else echo '|BAD_CAPTCHA';

?>