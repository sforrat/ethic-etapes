<?
if ($valide_envoie == 1) {

	set_time_limit(86400); //1 jour

	$StrNewsLetter = "
			SELECT 
				"._CONST_BO_CODE_NAME."newsletter.*
			FROM 
				"._CONST_BO_CODE_NAME."newsletter
			WHERE 
				"._CONST_BO_CODE_NAME."newsletter.id_"._CONST_BO_CODE_NAME."newsletter=".$ID."
			";

	//echo get_sql_format($StrNewsLetter);

	$RstNewsLetter = mysql_query($StrNewsLetter);

	$contenu_html	= @mysql_result($RstNewsLetter,0,"descriptif");
	$news_titre		= @mysql_result($RstNewsLetter,0,_CONST_BO_CODE_NAME."newsletter");
	$numero			= @mysql_result($RstNewsLetter,0,"numero");


	$path_file = "http://".$HTTP_HOST._CONST_APPLI_PATH;


		$haut_news_html = <<<EOF
<html>
<head>
<title>Loisirs-VTT : NewsLetter</title>
<style type="text/css">
<!--
.tit {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 18px; font-style: normal; line-height: normal; font-weight: bold; font-variant: normal; text-transform: none; color: #2e3092; text-decoration: none}
.sstit {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-style: normal; line-height: normal; font-weight: bold; font-variant: normal; text-transform: none; color: #2e3092; text-decoration: none}
.txt {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-style: normal; line-height: normal; font-weight: normal; font-variant: normal; text-transform: none; color: #000000; text-decoration: none}
.txrge {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-style: normal; line-height: normal; font-weight: bold; font-variant: normal; text-transform: none; color: #ed1b2f; text-decoration: none}
-->
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div align="center">
  <table width="700" border="0" cellspacing="5" cellpadding="0">
	<tr> 
	  <td width="200" valign="top"><span class="tit">Newsletter n&deg;#NUMBER#</span><br>
		<span class="sstit">#DATE#<br>
		</span><span class="txrge"><br>
		&gt; </span><a href="http://www.loisirs-vtt.fr" target="_blank"><span class="txrge">http://www.loisirs-vtt.fr</span></a><br>
		</td>
	  <td width="500" valign="top" class="txt">
EOF;

	$bas_news_html = <<<EOF
		<br><br>
	  </td>
	</tr>
	<tr valign="top"> 
		<td>&nbsp;</td>
	  <td class="txt" >
		<hr>
		Cliquez <a href="#PATH_FILE#/pg/index.php?Rub=151" class="txrge">ici</a> pour vous d&eacute;sinscrire<br>
		</td>
	</tr>
	<tr> 
	  <td colspan="2" valign="top">&nbsp;</td>
	</tr>
  </table>
</div>
</body>
</html>
EOF;



	$haut_news_html		= eregi_replace("#PATH_FILE#", $path_file, $haut_news_html);
	$haut_news_html		= eregi_replace("#DATE#", CDate(date("Y-m-d"),2), $haut_news_html);
	$haut_news_html		= eregi_replace("#NUMBER#", $numero, $haut_news_html);

	$bas_news_html		= eregi_replace("#PATH_FILE#", $path_file, $bas_news_html);

	$contenu_html		= eregi_replace("<br>", "\n<br>", $contenu_html);

	$text = $contenu_texte;
	$html = $haut_news_html.$contenu_html.$bas_news_html;




	$TABLE = "client";

	$StrSQL = "
			SELECT * 
			FROM 
				".$TABLE." 
			WHERE 
				email!=\"\" 
			AND
				newsletter=1
			";

	$Rst = mysql_query($StrSQL);

	echo "<br><b>Envoi de la NewsLetter : ".$news_titre."</b><br>> Nombre d'abonn&eacute;s : ".@mysql_num_rows($Rst)."<br><br>";

	for ($i=0;$i<@mysql_num_rows($Rst);$i++) {

		$id				= @mysql_result($Rst,$i,"id_".$TABLE);
		$nom			= strtoupper(@mysql_result($Rst,$i,"nom"));
		$prenom			= ucfirst(@mysql_result($Rst,$i,"prenom"));
		$email			= @mysql_result($Rst,$i,"email");



		//if ($version_html==1) {

/*
			$envoi=SendMail(
						$email,	$prenom." ".$nom,
						"info@loisirs-vtt.fr","Loisirs-VTT",
						"",	"",
						"",	"",
						"info@loisirs-vtt.fr", "Loisirs-VTT",
						"info@loisirs-vtt.fr", $prenom." ".$nom,
						"normal", 2000,
						$news_titre,
						$html,$text,
						"",	"",
						"", "", "",
						"", "", "", ""
					);
*/

		//}
		//else {
		//	envoie_mail($email,nl2br($text),"Helinetwork International<info@helinetwork.com>",$news_titre,"info@helinetwork.com");
		//}



			echo "<br>Id : ".$id." | ".$nom." ".$prenom." -> <a href='mailto:".$email."'>".$email."</a>";

			usleep(800);
			//mysql_query("Update ".$TABLE." set flag_mail=1 where id_cigales=".$id_cigales);

			flush();
		}

	echo "<br><br><br><b>Envoi termin&eacute;.</b>";


}
else {

	?> <br><br>
	Etês-vous sûr de vouloir envoyer la newsletter ?
	<?

	//AFFICHAGE DU BOUTON ACTION
	echo "<p><blockquote><blockquote>";
	$action_button = new bo_button();
	$action_button->c1 = $MenuBgColor;
	$action_button->c2 = $MainFontColor;
	$action_button->name = "Envoyer la NewsLetter";
	$action_button->action = "javascript:document.location.href='".NomFichier($_SERVER['PHP_SELF'],0)."?valide_envoie=1&".$QUERY_STRING."'";
	$action_button->display();
	echo "</blockquote></blockquote>\n";

	?> <br>
	<a href="javascript:history.go(-1)">Annuler</a>
	<?

}







//echo "<br><br><br><hr><br><br><br><br>";
//show_source("m.php");
?>
</body>
</html>

<? 
	function SendMail(	$to,$to_name,
				$from,$from_name,
				$cc,$cc_name,
				$bcc,$bcc_name,
				$reply,$reply_name,
				$errors,$errors_name,
				$priority,$maxsize,
				$subject,
				$body,$text,
				$signature,$signature_maxsize,
				$attachment_name,$attachment_type,$attachment,
				$file_name,$file_type,$file_maxsize,$file
			)
	{

/****************************** VERIFICATION ******************************/

		if(!Verify($to,0))
			return(false);


/****************************** SEPARATEURS ******************************/

		$boundary_mixed="Part_Mix_".md5(uniqid(time()));
		$boundary_related="Part_Rel_".md5(uniqid(time()));
		$boundary_alternative="Part_Alt_".md5(uniqid(time()));
		$boundary_signature="Part_Sig_".md5(uniqid(time()));


/****************************** ENTETE ******************************/

		$mail_header="";

		if(!empty($from))
		{
			if(empty($from_name))
				$mail_header.="From: ".$from."\n";
			else
				$mail_header.="From: \"".$from_name."\" <".$from.">\n";
		}
		if(!empty($to_name))
			$to=$to_name." <".$to.">";
/*
		if(!empty($to))
		{
			if(empty($to_name))
				$mail_header.="To: ".$to."\n";
			else
				$mail_header.="To: \"".$to_name."\" <".$to.">\n";
		}
*/
		if(!empty($cc))
		{
			if(empty($cc_name))
				$mail_header.="Cc: ".$cc."\n";
			else
				$mail_header.="Cc: \"".$cc_name."\" <".$cc.">\n";
		}
		if(!empty($bcc))
		{
			if(empty($bcc_name))
				$mail_header.="Bcc: ".$bcc."\n";
			else
				$mail_header.="Bcc: \"".$bcc_name."\" <".$bcc.">\n";
		}
		if(!empty($reply))
		{
			if(empty($reply_name))
				$mail_header.="Reply-To: ".$reply."\n";
			else
				$mail_header.="Reply-To: \"".$reply_name."\" <".$reply.">\n";
		}
		if(!empty($errors))
		{
			$parameter="";
			if(empty($errors_name))
			{
				$parameter="-f ".$errors;
				$mail_header.="Errors-To: ".$errors."\n";
				$mail_header.="Return-Path: ".$errors."\n";
//				$mail_header.="Return-Receipt-To: ".$errors."\n";
			}
			else
			{
				$parameter="-f \"".$errors_name."\" <".$errors.">";
				$mail_header.="Errors-To: \"".$errors_name."\" <".$errors.">\n";
				$mail_header.="Return-Path: \"".$errors_name."\" <".$errors.">\n";
//				$mail_header.="Return-Receipt-To: \"".$errors_name."\" <".$errors.">\n";
			}
		}

		$mail_header.="Date: ".date("r",time())."\n";

		switch($priority)
		{
			case "high":
				$priority="1 (High)";
				break;
			case "normal":
				$priority="3 (Normal)";
				break;
			case "low":
				$priority="5 (Low)";
				break;
			default:
				$priority="3 (Normal)";
				break;
		}
		$mail_header.="X-Priority: ".$priority."\n";

		if(!empty($from))
			$mail_header.="X-Sender: ".$from."\n";

		$mail_header.="X-Mailer: PHP/".phpversion()."\n";
		$mail_header.="Organization: FULLSUD\n";

		$mail_header.="MIME-Version: 1.0\n";
		//$mail_header.="Content-Type: multipart/mixed; ";
		$mail_header.="Content-Type: multipart/alternative; ";
		$mail_header.="Boundary=\"".$boundary_alternative."\"";
//		$mail_header.="This is a multi-part message in MIME format.\n\n";


/****************************** TESTS ******************************/

		$signature_mark=false;
		if((file_exists($signature))and(filesize($signature)<($signature_maxsize*1000)))
			$signature_mark=true;

		$attachment_mark=false;
		if(strcmp($attachment,"")!=0)
			$attachment_mark=true;

		$file_mark=false;
		if((file_exists($file))and(filesize($file)<($file_maxsize*1000)))
			$file_mark=true;


/****************************** COMPLEMENTS ******************************/

		$subject=stripslashes($subject);
		$body_html=stripslashes($body);
		$body_plain=stripslashes($text);

		if($signature_mark)
			$body_html=eregi_replace("cid:BOUNDARY","cid:".$boundary_signature,$body_html);


/****************************** DEBUT du CORPS ******************************/

/****************************** MESSAGE ******************************/

		/*$mail_body.="--".$boundary_mixed."\n";*/

		if($signature_mark)
		{
			$mail_body.="Content-Type: multipart/related; ";
			$mail_body.="Boundary=\"".$boundary_related."\"\n\n";
			$mail_body.="--".$boundary_related."\n";
		}

		$mail_body.="Content-Type: multipart/alternative; ";
		$mail_body.="Boundary=\"".$boundary_alternative."\"\n\n";

		$mail_body.="--".$boundary_alternative."\n";
		$mail_body.="Content-Type: text/plain; charset=\"iso-8859-1\"\n";
		$mail_body.="Content-Transfer-Encoding: 8bit\n\n";
		$mail_body.=$body_plain."\n\n";

		$mail_body.="--".$boundary_alternative."\n";
		$mail_body.="Content-Type: text/html; charset=\"iso-8859-1\"\n";
		$mail_body.="Content-Transfer-Encoding: 8bit\n\n";
		$mail_body.=$body_html."\n\n";

		$mail_body.="--".$boundary_alternative."--\n\n";


/****************************** SIGNATURE ******************************/

		if($signature_mark)
		{
			$signature_pointer=fopen($signature,"r");
			$signature_contents=fread($signature_pointer,filesize($signature));

			$signature_name=substr($signature,strrpos($signature,"/")+1);
			$signature_type=substr($signature,strrpos($signature,".")+1);

			$mail_body.="--".$boundary_related."\n";
			$mail_body.="Content-Type: image/".$signature_type."; name=\"".$signature_name."\"\n";
			$mail_body.="Content-ID: <".$boundary_signature.">\n";
			$mail_body.="Content-Transfer-Encoding: base64\n";
			$mail_body.="Content-Disposition: attachment; filename=\"".$signature_name."\"\n\n";
			$mail_body.=chunk_split(base64_encode($signature_contents))."\n\n";

			fclose($signature_pointer);

			$mail_body.="--".$boundary_related."--\n\n";
		}


/****************************** ATTACHEMENT ******************************/

		if($attachment_mark)
		{
			$mail_body.="--".$boundary_mixed."\n";
			$mail_body.="Content-Type: ".$attachment_type."; name=\"".$attachment_name."\"\n";
			$mail_body.="Content-Description:\n\n";
			$mail_body.=stripslashes($attachment)."\n\n";
		}


/****************************** FICHIER ******************************/

		if($file_mark)
		{
			$file_pointer=fopen($file,"r");
			$file_contents=fread($file_pointer,filesize($file));

			if(strcmp($file_type,"")==0)
				$file_type="application/octet-stream";

			$mail_body.="--".$boundary_mixed."\n";
			$mail_body.="Content-Type: ".$file_type."; name=\"".$file_name."\"\n";
			$mail_body.="Content-Transfer-Encoding: base64\n";
			$mail_body.="Content-Disposition: attachment; filename=\"".$file_name."\"\n\n";
			$mail_body.=chunk_split(base64_encode($file_contents))."\n\n";

			fclose($file_pointer);
//			unlink($file);
		}

		$mail_body.="--".$boundary_mixed."--\n";


/****************************** FIN du CORPS ******************************/


/****************************** ENVOI ******************************/

		if(strlen($mail_body)<($maxsize*1000))
			return(mail($to,$subject,$mail_body,$mail_header,$parameter));
		else
			return(false);
	}

	//{{{ 
        function Verify($email,$level)
	{
		if(eregi("^[0-9a-z_]([-_.]?[0-9a-z])*@[0-9a-z][-.0-9a-z]*\\.[a-z]{2,3}$",$email))
		{
			if($level==1)
			{
				$domain=substr(strstr($email,"@"),1);
				$result=checkdnsrr($domain,"MX");

				if(($result)or(strcmp($result,"")==0))
					return(true);
			}
			else
				return(true);
		}

		return(false);
	} //}}} 


	function Weight($size)
	{
		$extension=array("o","Ko","Mo","Go","To");

		$i=0;
		while($size>=pow(1000,$i))
			$i++;

		return((round($size/pow(1000,$i-1)*100)/100).$extension[$i-1]);
	}

?>
