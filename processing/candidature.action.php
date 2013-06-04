<?
// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");

// inclusion de la classe mail
require_once($path."admin/library_local/html_mime_mail.php");



$filename_langue = $path."include/language/lib_language_".$_SESSION['ses_langue_ext'].".inc.php";

if (is_file($filename_langue))
{
	include($filename_langue);	
}

$_SESSION["nom"]=$_POST["postulerNom"];
$_SESSION["prenom"]=$_POST["postulerPrenom"];
$_SESSION["date"]=$_POST["datepicker"];
$_SESSION["email"]=$_POST["postulerEmail"];
$_SESSION["tel"]=$_POST["postulerTelephone"];
$_SESSION["message"]=$_POST["postulerMessage"];
$_SESSION["region"]=$_POST["postulerIdRegion"];
$_SESSION["secteur"]=$_POST["postulerSecteur"];




if(	$_POST["datepicker"] != "" &&
$_POST["postulerSecteur"] != "" &&
$_POST["postulerIdRegion"] != "" &&
$_POST["postulerNom"]  != "" &&
$_POST["postulerPrenom"]  != "" &&
$_POST["postulerMessage"]  != "" &&
$_POST["postulerEmail"]   != ""  &&
$_POST["postulerTelephone"]   != ""  &&
$_FILES["postulerCV"]["name"]!= ""  &&
$_FILES["postulerMotivation"]["name"] != "")
{
	$rEFileTypes = "/^\.(doc|docx|txt|rtf|pdf){1}$/i";
	$dir_base = $path."images/upload/postulant/";

	$isFile = is_uploaded_file($_FILES['postulerCV']['tmp_name']);
	if ($isFile)    //  do we have a file?
	{	//  sanatize file name
		//     - remove extra spaces/convert to _,
		//     - remove non 0-9a-Z._- characters,
		//     - remove leading/trailing spaces
		//  check if under 5MB,
		//  check file extension for legal file types

		$safe_filenameCV = preg_replace(	array("/\s+/", "/[^-\.\w]+/"),
		array("_", ""),
		trim($_FILES['postulerCV']['name']));
		$prefixe = substr(microtime(),2,5);
		$safe_filenameCV = $prefixe.$safe_filenameCV;
		//$safe_filenameCV.="_".microtime();
		if (preg_match($rEFileTypes, strrchr($safe_filenameCV, '.')))
		{
			$isMove = move_uploaded_file ($_FILES['postulerCV']['tmp_name'],$dir_base.$safe_filenameCV);
		        $url_cv = _CONST_APPLI_URL."images/upload/postulant/".$safe_filenameCV;
                }else{
			$erreur=1;
		}
	}



	$isFile = is_uploaded_file($_FILES['postulerMotivation']['tmp_name']);
	if ($isFile)    //  do we have a file?
	{	//  sanatize file name
		//     - remove extra spaces/convert to _,
		//     - remove non 0-9a-Z._- characters,
		//     - remove leading/trailing spaces
		//  check if under 5MB,
		//  check file extension for legal file types

		$safe_filenameLM = preg_replace(	array("/\s+/", "/[^-\.\w]+/"),
		array("_", ""),
		trim($_FILES['postulerMotivation']['name']));
		$prefixe = substr(microtime(),2,5);
		$safe_filenameLM = $prefixe.$safe_filenameLM;
		if (preg_match($rEFileTypes, strrchr($safe_filenameLM, '.')))
		{
			$isMove = move_uploaded_file ($_FILES['postulerMotivation']['tmp_name'],$dir_base.$safe_filenameLM);
      $url_lm = _CONST_APPLI_URL."images/upload/postulant/".$safe_filenameLM;
		}else{
			$erreur=1;
		}
	}


	if($erreur !=1){
		$tab = explode("/",$_POST["datepicker"]);
		$date = $tab[2]."-".$tab[0]."-".$tab[1];
		$sql = "insert into postulant (	id_offre_emploi,
										date_demande,
										nom,
										prenom,
										email,
										telephone,
										id_centre_region,
										message,
										cv,
										lettre_motivation,
										id_offre_secteur_activite,
										date_embauche)
										
							VALUES 	(	'".addslashes($_POST["postulerOffre"])."',
										NOW(),
										'".addslashes($_POST["postulerNom"])."',
										'".addslashes($_POST["postulerPrenom"])."',
										'".addslashes($_POST["postulerEmail"])."',
										'".addslashes($_POST["postulerTelephone"])."',
										'".addslashes($_POST["postulerIdRegion"])."',
										'".addslashes($_POST["postulerMessage"])."',
										'$safe_filenameCV',
										'$safe_filenameLM',
										'".addslashes($_POST["postulerSecteur"])."',
										'".$date."')";
		
		$result = mysql_query($sql) or die(mysql_error());
		$params = Array();
		
		
		
		if($_POST["postulerOffre"] != ""){
			$params[0]["id_name"] = "idOffre";
			$params[0]["id"] = $_POST["postulerOffre"];
		}

		$_SESSION["erreur"] = "no_erreur";

		
		// --- Cration du message
		$message_mail  = "Le ".date("d-m-Y")."<br /><br />";
		if($_POST["postulerOffre"] != ""){
			$titre = get_libLocal('lib_mail_message_candidature');
			$message_mail .= "Offre : ".$_POST["postulerReference"]."<br /><br />";
		}else{
			$titre = get_libLocal('lib_mail_message_candidature_spontanee');
		}
		
		$message_mail .=  	$_POST["postulerNom"]." ".$_POST["postulerPrenom"]."<br />";
		
		$sql_S 		= "select libelle from centre_region where id_centre_region=".$_POST["postulerIdRegion"];
		$result_S 	= mysql_query($sql_S);
		$message_mail .= get_libLocal('lib_region')." : ".mysql_result($result_S,0,"libelle");
		
		$sql_S 		= "select libelle from offre_secteur_activite where id_offre_secteur_activite=".$_POST["postulerSecteur"];
		$result_S 	= mysql_query($sql_S);
		$message_mail .= "<br />".get_libLocal('lib_secteur')." : ".mysql_result($result_S,0,"libelle");
		
		
		$message_mail .=  	"<br />Tel : ".$_POST["postulerTelephone"]."<br />";
		$message_mail .=  	"Email : ".$_POST["postulerEmail"]."<br />";
		$message_mail .=  	"Message : ".$_POST["postulerMessage"]."<br />";
		$message_mail .=  	get_libLocal('lib_date_debut_embauche')." : ".$_POST["datepicker"]."<br /><br />";
		$message_mail .=    "Téléchargement du CV : <a href='$url_cv'>Cliquez ici.</a><br><br>";
                $message_mail .=    "Téléchargement de la lettre de motivation : <a href='$url_lm'>Cliquez ici.</a><br><br>";
    
		// --- Cration du message
		

		$template->assign('urlSite',_CONST_APPLI_URL);
		$template->assign('titre',$titre);
		$template->assign('message',$message_mail);
		
		
		
		$message= $template->fetch('gab/mail/mail.tpl');
		
		
		
		if($_POST["postulerOffre"]!=""){
			$sql= "	select 
						centre.email,
						centre.libelle,
						centre.ville
					FROM
						centre
					inner join 
						offre_emploi on (offre_emploi.id_offre_emploi=".$_POST["postulerOffre"]." and offre_emploi.id_centre=centre.id_centre)";
			$result = mysql_query($sql);
			//envoie_mail(mysql_result($result,0,"email"),$message,$_POST["postulerEmail"],get_libLocal('lib_sujet_mail_candidature'));
			
			$nom_centre = mysql_result($result,0,"libelle");
			$ville_centre = mysql_result($result,0,"ville");
			
			$mail_to_send = new html_mime_mail(1024000, "utf-8");
    	$mail_to_send->add_body($message);
    	$mail_to_send->build_mail("base64", 1);
    	
    	
    	
    	/*
      send($to_name, $to_addr, $from_name, $from_addr, $subject = '', $headers = '')
      */
    	//$bEnvoi = $mail_to_send->send("", $_POST["postulerEmail"], "", _MAIL_CONTACT_EMPLOI, get_libLocal('lib_sujet_mail_candidature')." - ".$nom_centre."/".$ville_centre);
    	$bEnvoi = $mail_to_send->send("", mysql_result($result,0,"email"), "", _MAIL_CONTACT_EMPLOI, get_libLocal('lib_sujet_mail_candidature')." - ".$nom_centre."/".$ville_centre);     
      //$bEnvoi = $mail_to_send->send("", "f.frezzato@c2is.fr", "", _MAIL_CONTACT_EMPLOI, get_liblocal("lib_sujet_mail_candidature_centre")." - ".$nom_centre."/".$ville_centre);
      $bEnvoi = $mail_to_send->send("", _MAIL_CONTACT_EMPLOI, "", _MAIL_CONTACT_EMPLOI, get_liblocal("lib_sujet_mail_candidature_centre")." - ".$nom_centre."/".$ville_centre);
    
      
      
      envoie_mail(mysql_result($result,0,"email"),$message,_MAIL_CONTACT_EMPLOI,get_libLocal('lib_sujet_mail_candidature')." - ".$nom_centre."/".$ville_centre);
			envoie_mail(_MAIL_CONTACT_EMPLOI,$message,_MAIL_CONTACT_EMPLOI,get_libLocal('lib_sujet_mail_candidature')." - ".$nom_centre."/".$ville_centre);
       //envoie_mail("f.frezzato@c2is.fr",$message.mysql_result($result,0,"email"),_MAIL_CONTACT_EMPLOI,get_libLocal('lib_sujet_mail_candidature')." - ".$nom_centre."/".$ville_centre);
			
			//if($_POST["postulerEmail"] == "fredfrezzato@yahoo.fr"){
        //die($bEnvoi);
      //}
			
			
			
		
		}else{
		
		  
		  $mail_to_send = new html_mime_mail(1024000, "utf-8");
    	$mail_to_send->add_body($message);
    	$mail_to_send->build_mail("base64", 1);
    	
    	$bEnvoi = $mail_to_send->send("", $_POST["postulerEmail"], "", _MAIL_CONTACT_EMPLOI, get_liblocal("lib_sujet_mail_candidature_centre"));
      //$bEnvoi = $mail_to_send->send("", _MAIL_WEBMASTER, "", "f.frezzato@c2is.fr", get_liblocal("lib_sujet_mail_candidature_centre"));

      /*
      envoie_mail("f.frezzato@c2is.fr",$message._MAIL_CONTACT_EMPLOI,$_POST["postulerEmail"],get_libLocal('lib_sujet_mail_candidature_centre'));
		  envoie_mail("sophie.landmann@gmail.com",$message,$_POST["postulerEmail"],get_libLocal('lib_sujet_mail_candidature_centre'));
		  */
		  
			
			$sql= "	select 
						centre.email,
						centre.libelle,
						centre.ville
					FROM
						centre
					WHERE
						centre.id_centre_region=".$_POST["postulerIdRegion"];
			$result = mysql_query($sql);
		
  	 $mail_to_send = new html_mime_mail(1024000, "utf-8");
     $mail_to_send->add_body($message);
     $mail_to_send->build_mail("base64", 1);
  	   
			while($myrow = mysql_fetch_array($result)){
			  //envoi_mail_simple("f.frezzato@c2is.fr",$_POST["postulerEmail"],$message,get_libLocal('lib_sujet_mail_candidature_centre'));
			 	//envoi_mail_simple($myrow["email"],$_POST["postulerEmail"],$message,get_libLocal('lib_sujet_mail_candidature_centre'));
			
  	     $bEnvoi = $mail_to_send->send("", $_POST["postulerEmail"], "", $myrow["email"], get_liblocal("lib_sujet_mail_candidature_centre"));
  	     //$bEnvoi = $mail_to_send->send("", $_POST["postulerEmail"], "", "f.frezzato@c2is.fr", get_liblocal("lib_sujet_mail_candidature_centre"));
  	  
        //envoie_mail($myrow["email"],$message,$_POST["postulerEmail"],get_libLocal('lib_sujet_mail_candidature_centre'));
			 	//envoie_mail("f.frezzato@c2is.fr",$message,$_POST["postulerEmail"],get_libLocal('lib_sujet_mail_candidature_centre'));
			}
		}
		
		redirect($path.get_url_nav(_NAV_OFFRE_EMPLOI_CANDIDATURE,$params));
	}else{
		$_SESSION["erreur"] = 1;
		
		if($_POST["postulerOffre"] != ""){
			$params[0]["id_name"] = "idOffre";
			$params[0]["id"] = $_POST["postulerOffre"];
			//die("ko2");
			redirect($path.get_url_nav(_NAV_OFFRE_EMPLOI_CANDIDATURE,$params));
		}else{
			//die("ko3");
			redirect($path.get_url_nav(_NAV_OFFRE_EMPLOI_CANDIDATURE));
		}


	}
}
else
{
	//die("ko");
	$_SESSION["erreur"] = 1;
	$params = Array();
	if($_POST["postulerOffre"] != ""){
		$params[0]["id_name"] = "idOffre";
		$params[0]["id"] = $_POST["postulerOffre"];
	}
	redirect($path.get_url_nav(_NAV_OFFRE_EMPLOI_CANDIDATURE,$params));
}

?>