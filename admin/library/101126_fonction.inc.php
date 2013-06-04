<?
function desactive_centre($id){
  $sql_U = "update centre set etat=0 where id_centre='$id'";
  $result_U = mysql_query($sql_U);
}
function active_centre($id){
  $sql_U = "update centre set etat=1 where id_centre='$id'";
  $result_U = mysql_query($sql_U);
}
function desactive_sejour($id,$table){
  $sql_U = "update $table set etat=0 where id_$table='$id'";
  $result_U = mysql_query($sql_U);
}

function envoi_mail_simple($Destinataire,$from,$Message,$Sujet){

	$From  = "From:".$from."\n";
	$From .= "MIME-version: 1.0\n";
	$From .= "Content-type: text/html; charset= utf-8\n";



	$retour = mail($Destinataire,$Sujet,$Message,$From);
	return $retour;
}
function delete_centre($id){
  // sauvegarde du centre
  $sql_I = "INSERT INTO old_centre (SELECT * FROM centre WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  //On efface toutes les offres d'emploi
  $sql_D = "DELETE FROM offre_emploi WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  //On efface toutes les actus
  $sql_D = "DELETE FROM actualite WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  //On efface tous les bons plans
  $sql_D = "DELETE FROM bon_plan WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  // Sauvegarde des sÃ©jours + suppression
  $sql_I = "INSERT INTO old_acceuil_reunions (SELECT * FROM acceuil_reunions WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM acceuil_reunions WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_accueil_groupes_jeunes_adultes (SELECT * FROM accueil_groupes_jeunes_adultes WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM accueil_groupes_jeunes_adultes WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_accueil_groupes_scolaires (SELECT * FROM accueil_groupes_scolaires WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM accueil_groupes_scolaires WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_accueil_individuels_familles (SELECT * FROM accueil_individuels_familles WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM accueil_individuels_familles WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_classe_decouverte (SELECT * FROM classe_decouverte WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM classe_decouverte WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_cvl (SELECT * FROM cvl WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM cvl WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_sejours_touristiques (SELECT * FROM sejours_touristiques WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM sejours_touristiques WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_seminaires (SELECT * FROM seminaires WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM seminaires WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_short_breaks (SELECT * FROM short_breaks WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM short_breaks WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_stages_thematiques_groupes (SELECT * FROM stages_thematiques_groupes WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM stages_thematiques_groupes WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_I = "INSERT INTO old_stages_thematiques_individuels (SELECT * FROM stages_thematiques_individuels WHERE id_centre='$id')";
  $result_I = mysql_query($sql_I);
  $sql_D = "DELETE FROM stages_thematiques_individuels WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
  
  $sql_D = "DELETE FROM _user WHERE id_centre = $id";
  $result_D = mysql_query($sql_D);
}

function connection() {
//Fonction de connection a une base MySQL

	/* dÃ©claration de quelques variables */
	global $Host, $BaseName, $UserName, $UserPass;

	/* connection avec MySQL */
	@mysql_connect($Host,$UserName,$UserPass) or die("&nbsp;&nbsp;&nbsp;&nbsp;Impossible de se connecter &agrave; la base de donn&eacute;es $BaseName");
	// Le @ ordonne a php de ne pas afficher de message d'erreur
	@mysql_select_db("$BaseName") or die("&nbsp;&nbsp;&nbsp;&nbsp;Impossible de se connecter &agrave; la base de donn&eacute;es $BaseName");
}

function ferme_connection()
{
	// Fonction de fermeture des connexions Ã  MySQL
	mysql_close();
}

function get_img($nom_image, $path_image, $alt="", $width="", $height="") {

    if( is_numeric( $nom_image ) )
    {
       $path_image   = _CONST_APPLI_PATH."images/upload/portfolio_img/";
       $nom_image    = get_portfolio_img( $nom_image );
    }
		
    $size   = get_image_size($nom_image, $path_image, $width, $height);
    return  TestPicture($nom_image, $path_image, $alt, $size[0], $size[1]);
}


//Test de la validitÃ© d'une image dans la base et l'affiche
function TestPicture($image, $chemin, $alt="",$width="none", $height="none") {
//13/07/2001

   		if( is_numeric( $image ) )
    		{
        		$chemin       = _CONST_APPLI_PATH."images/upload/portfolio_img/";
       $image       = get_portfolio_img( $image );
    		}

		//Valeur par defaut
		if ($width=="none") {
			$width = "";
		}
		if ($height=="none") {
			$height = "";
		}

		//on test si le chemin fini par un /, si c'est le cas ok sinon on ajoute le /
		if (substr($chemin,strlen($chemin)-1,1) != "/") {
			$chemin .= "/";
		}
		
		if ($image) {
			if ($height) {
				$height = "height=\"".$height."\"";
			}
			if ($width) {
				$width = "width=\"".$width."\"";
			}
			return("<img src=\"".$chemin."".$image."\" ".$width." ".$height." name=\"image_formatee\" alt=\"".$alt."\" border=\"0\">");
		}
		else {
			return("&nbsp;");
		}
}

// 30/10/02
// retourne un tableau contenant les tailles de l image en fonction des tailles max passees en parametre
// le truc c est de tjs forcer qu une dimension pour garder l integrite
function get_image_size($image,$chemin,$width,$height) {
	//on test si le chemin fini par un /, si c'est le cas ok sinon on ajoute le /
	if (substr($chemin,strlen($chemin)-1,1) != "/") {
		$chemin .= "/";
	}
	
	$size = @getimagesize($chemin.$image);
 
	if ($size==NULL)
	{ $tab[] = $width;
	  $tab[] = "";
	  return $tab; 
	}

  $r_wl = ($size[0]/$size[1]); // rapport H/L initial
  
    //echo "--".$width.",".$height."--<br>";
    //echo "--".$size[0].",".$size[1]."--<br>";

	if ($size[0] > $width && $size[1]>$height) // trop large et trop haut ?
	{
	 	$pr = ($width / $size[0]); // rapport de largeur
	 	$cal_height = ceil($size[1]*$pr); // nelle hauteur calculÃ©e

	 	// on est tjs trop haut ?
	 	if ($cal_height > $height) 
	 	{ 	
	 			//$tab[] = ceil($width / $r_wl); 
	 			$tab[] = $width;
	 			$tab[] = $height ; // hauteur figÃ©e a hauteur max.
	 	}
    else
	 	{ 
        $tab[] = $width;
	 	$tab[] = $cal_height;
	 	}
	}
	elseif ($size[0]>$width)
	{
	 	$tab[] = $width;
	 	$tab[] = ceil($width/$r_wl);
	}
	elseif ($size[1]>$height)
	{
	 	$tab[] = ceil($height*$r_wl);
	 	$tab[] = $height;
	}
	else
	{
	 	$tab[] = $size[0];
	 	$tab[] = $size[1];
	}
	
	return $tab;	
}

//test si le user est bien loggÃ©
function LoginBack() 
{
	//Log de l'utilisateur
	if  (   ( (!isset($_SESSION['ses_user'])) || ($_SESSION['ses_user']== "")) ||
		( (!isset($_SESSION['ses_user_id'])) || ($_SESSION['ses_user_id']== "")) ||
		( (!isset($_SESSION['ses_profil_user'])) || ($_SESSION['ses_profil_user']== "")) ||
		( (!isset($_SESSION['ses_id_bo_user'])) || ($_SESSION['ses_id_bo_user']== ""))
	    )		
	    {
	       // une des variables de session de login est en defaut => on renvoie sur la home
	       if (isset($_COOKIE[session_name()])) {
   	          setcookie(session_name(), '', time()-42000, '/');
	       }
	       session_unset();	       
	       $_SESSION = array();
	       session_destroy();
	       
	       redirect("index.php");
		die();
	}
}



//Si la variable de session $ses_user n'est pas = Ã  1 alors on redirige vers Log.php
function LoginFront($LoginExtranet) {

	//Log de l'utilisateur
	if (!$_SESSION['Ses_LoginExtranet']|| empty($LoginExtranet)) {
		echo "<script>document.location.href='../index.html';</script>";
	}
}



//----------------------------------------------<NewsLetter>-----------------------------------------------//
function EnvoiNewsLetter($RstUser, $IdNewsLetter, $From) {

	//Selection de la newsletter
	$StrNewsLetter = "
						Select BoNewsLetter, descriptif
						from BoNewsLetter
						where id_BoNewsLetter = ".$IdNewsLetter
					;
	
	$RstNewsLetter = mysql_query($StrNewsLetter);

	$sujet			= GetTxtFromHtml(@mysql_result($RstNewsLetter,0,"BoNewsLetter"));
	$message		= @mysql_result($RstNewsLetter,0,"descriptif");

	for ($i=0;$i<@mysql_num_rows($RstUser);$i++) {
		$email			= @mysql_result($RstUser,$i,"email");
		$id_newsroom	= @mysql_result($RstUser,$i,"id_newsroom");
		
		$message .= "\n\n<br><br>-----\n<br>";
		$message .= "To cancel your subscription to this newsletter, click here : <a href=\"http://www.nmg.fr/S/index.php?N=17&SN=38&email=".$email."&Num=".$id_newsroom."\">Unsubscribe</a>";

		envoie_mail($email,$message,$From,$sujet);
	}

}



//------------------------------------------------<FORUM>-------------------------------------------------//
function GetNbMsg($id_pere, $Nb=0) {
	$StrSQL = "Select id_message from message where id_pere = ".$id_pere;
	$Rst = mysql_query($StrSQL);

	if (@mysql_num_rows($Rst)) {

		for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
			$id_message	= @mysql_result($Rst,$i,"id_message");

			$Nb++;

			$Nb = GetNbMsg($id_message,$Nb);
		}
	}

	return($Nb);
}

function GetLastDate($id_pere, $Date) {
	$StrSQL = "Select id_message, date from message where id_pere = ".$id_pere;
	$Rst = mysql_query($StrSQL);

	if (@mysql_num_rows($Rst)) {

		for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
			$id_message	= @mysql_result($Rst,$i,"id_message");
			$date		= @mysql_result($Rst,$i,"date");

			$dateTimeStamp = GetTimestampFromDate($date);

			if ($dateTimeStamp > $Date) {
				$Date = $dateTimeStamp;
			}
			$Date = GetLastDate($id_message,$Date);
		}
	}

	return($Date);
}

function Fils($id_pere, $Ind, $File, $ListMode=0, $MsgSelect, $Level, $Lien=1, $bgcolor="") {
	$TBgColor = array("#85D1F5","#B7E7FF","#469CFB","#7CB9FC","#AAD1FD","#CDE4FE","#E9F3FE","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF");

	$StrSQLFils = "
					Select *
					from message
					where id_pere = ".$id_pere." 
					order by id_message
					";
	$RstMessageFils = mysql_query($StrSQLFils);


	if (@mysql_num_rows($RstMessageFils)) {
		$Level++; //On compte les niveau

		for ($i=0;$i<@mysql_num_rows($RstMessageFils);$i++) {
			$id_message		= @mysql_result($RstMessageFils,$i,"id_message");

			//Mode Arbre
			$titre			= @mysql_result($RstMessageFils,$i,"titre");

			//Mode Liste
			$message		= @mysql_result($RstMessageFils,$i,"message");
			$date			= Cdate(@mysql_result($RstMessageFils,$i,"date"),2);
			$auteur			= @mysql_result($RstMessageFils,$i,"auteur");
			$email			= @mysql_result($RstMessageFils,$i,"email");




	$StrSQLFils2 = "
					Select *
					from message
					where id_pere = ".$id_message." 
					order by id_message
					";
	$RstMessageFils2 = mysql_query($StrSQLFils2);


			//gestion des images de fin de liste
			if ($i == @mysql_num_rows($RstMessageFils)-1) {
				$img = "jointbas.gif";
			}
			else {
				$img = "joint.gif";
			}

			if ($ListMode == 0) {
				echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" >";
				echo "<tr><td>".$Ind."<img src=\"../adm/images/$img\"></td><td>";
				echo "<table cellpadding=\"0\" cellspacing=\"1\" border=\"0\" bgcolor=\"#000000\">";
				echo "<tr><td style='background-color:$TBgColor[$Level];'>";
				echo "<img src=\"../images/pixtrans.gif\" width=\"6\" height=\"6\" border=0 alt=\"\"></td></tr></table>";
				echo "</td><td>&nbsp;";

				if ($Lien == 1) {//Lien
					echo "<a class=\"bleufonce\" href=\"".$File."?Msg=".$id_message."\">".$titre."</a>".", ".$auteur.", le ".$date."";
				}
				else {//Ancre
//	Raph				echo  "<a class=\"bleufonce\" href=\"#".substr($titre,0,1).$id_message."\">".$titre."</a>".", ".$auteur.", le ".$date."";
					echo  "<a class=\"bleufonce\" href=\"JavaScript:obj".substr($titre,0,1).$id_message."=new ConstructObject('".substr($titre,0,1).$id_message."','divContainer','divContent');objScroller.MoveArea(0,-obj".substr($titre,0,1).$id_message.".scrollTop);\">".$titre."</a>".", ".$auteur.", le ".$date."";
				}
				echo "</td></tr>";
				echo "</table>";
			}
			elseif ($ListMode == 1) {

				if ($bgcolor == "#85D1F5") {
					$bgcolor = "#B7E7FF";
				}
				else {
					$bgcolor = "#85D1F5";
				}

				$bgcolor = $TBgColor[$Level];

				if ($auteur && $email) {
					$auteur = "<a class=\"bleufonce\" href=\"mailto:".$email."\">".$auteur."</a>";
				}
				elseif ($email) {
					$auteur = "<a class=\"bleufonce\" href=\"mailto:".$email."\">".$email."</a>";
				}

//	Raph				echo "<table bgcolor=\"#36AFE8\" width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" border=\"0\">";
					echo "<style type=\"text/css\">#".substr($titre,0,1).$id_message."{position:relative;}</style><div id=\"".substr($titre,0,1).$id_message."\"></div><table bgcolor=\"#36AFE8\" width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" border=\"0\">";
	//				echo "<a name=\"".substr($titre,0,1).$id_message."\"></a>";
					echo  "
<!--	Raph				<tr bgcolor=\"".$bgcolor."\"><td><a name=\"".substr($titre,0,1).$id_message."\"></a>&nbsp;<b>$titre</b><br> -->
					<tr bgcolor=\"".$bgcolor."\"><td>&nbsp;<b>$titre</b><br>
					Envoy&eacute; par $auteur le $date<br>
					<br>$message<p>
<!--	Raph				<div align=\"right\"><a class=\"bleufonce\" href=\"#Haut\">Retour Haut</a>&nbsp;/&nbsp;<a class=\"bleufonce\" href=\"javascript:OpenPopUp('$id_message','$MsgSelect');\">RÃ©pondre</a></div> -->
					<div align=\"right\"><a class=\"bleufonce\" href=\"JavaScript:objScroller.MoveArea(0,0);\">Retour Haut</a>&nbsp;/&nbsp;<a class=\"bleufonce\" href=\"javascript:OpenPopUp('$id_message','$MsgSelect');\">RÃ©pondre</a></div>
					";
					echo "</td></tr></table><br>";
			}

			if (@mysql_num_rows($RstMessageFils2)>1 && $i == @mysql_num_rows($RstMessageFils)-1) {
				$Ind2 = "<img src=\"../adm/images/pixtrans.gif\" width=\"12\" height=\"14\">";
			}
			else {
				$Ind2 = "<img src=\"../adm/images/traitv.gif\">";
			}



			Fils($id_message, $Ind.$Ind2, $File, $ListMode, $MsgSelect, $Level, $Lien, $bgcolor);
			$NewLevel = $Level;
		}
	}
}
//------------------------------------------------</FORUM>-------------------------------------------------//



//Permet l'utilisation des balise < et >
function AllowHtmlTag($String) {
	
	$String = ereg_replace('&gt;', '>',ereg_replace('&lt;', '<', $String));
	$String = ereg_replace('&amp;', '&', $String);
	return ($String);
}


function ReturnVar($_GET,$_SERVER) {

	//Fabrication automatique de la chaine contenant les parametres pour les requetes
	reset ($_GET);
	while (list ($key, $val) = each ($_GET)) {
		$str_parametres .= "&".$key."=".$val;
	}
	$str_parametres = sup_first_carac("&",$str_parametres);

	$str = NomFichier($_SERVER['PHP_SELF'],0)."?".$str_parametres;
	return($str);

}


//Gestion du panier virtuel
function panier($mode,$select,$liste) {
//Mode:
//		+		-> Ajout et incrementation de la quantite 
//		-		-> Decrementation de la quantite, si <= 0 supression
//		q		-> Pour retourner la quantite des eleme du panier
//		RId		-> Retourne les id au format : 1,2,3,4,5 pour une requete avec la clause in (??????)
//		Liste	-> varable conteant la liste type : |1,1|2,1|3,5|8,4|
//		Select	-> element sur lequel on fait le test

	$listeElem = split("!",$liste);

	for ($j=0; $j<count($listeElem); $j++) {
		$Elem = split(",", $listeElem[$j]);
		$id = $Elem[0];
		$q = $Elem[1];

		if ($id == $select) { 
			if ($mode == "-") {//on decremente de 1 la quantite
				$q--;
			}
			if ($mode == "+") {//on increment la quantite
				$q++;
			}
			$qok = $q;//Quantite de la valeur recherche
			$ok=1;//ok la valeur a ete trouve
		}
		if ($id != "" && $q > 0) {//Ajout de tout les element trouves dans la liste dont la quantite est sup a 0
			$liste_retour[] = $id.",".$q;
			$listeId .= $id.",";
		}
	}

	if ($mode == "q") {//on retourn la quantite
		if ($ok == 1) {
			return($qok);
		}
		else {
			return(0);
		}
	}
	if ($mode == "RId") {
		$listeId = substr($listeId, 0, -1);
		return($listeId);
	}

	if ($ok!=1 && $mode == "+") {
		$q = 1;
		$liste_retour[] = $select.",".$q;
	}

	$liste = @join("!",$liste_retour);

	if ($mode != "q" && $mode != "RId") {
		return($liste);
	}
}

function NomFichier($strFile,$ext=-4) {
//Retourne le nom du fichier courrant sans l'extension
//Par defaut, l'extension supprime est de 4 caracteres, .php .htm .jpg

	if ($strFile == "") return $strFile;
	
	if ($ext!=0) {
		$str = substr($strFile,0,$ext);//Supppression de l'extension
	}
	else {
		$str = $strFile;
	}
	
	$str_temp = $str;
	
	if (eregi("/",$str_temp))
	{
			$str_temp = substr($str_temp,(strrpos($str_temp,"/")+1),strlen($str_temp));
	}

	return($str_temp);
}


function coupe_espace($texte,$nb_car=50,$nopoint=0) {
//Coupe une chaine a nb_car et ajoute ... en coupant sur les espaces
//par defaut le nombre de caracteres affichÃ© est 50

	if (strlen($texte) > $nb_car) {
		$texte = substr($texte,0,$nb_car);
		$i = strrpos($texte," ");
		$texte = substr($texte,0,$i).($nopoint==0?" ...":"");
	}

	return ($texte);
 }



function change_quote($texte) {
// fonction qui remplace une quote en 2 quotes (pour insertion dans BDD
	$texte=stripslashes($texte);
	$texte=ereg_replace("'","''",$texte);

	return $texte;
}

function change_virgule($texte) {
// fonction qui remplace une virgule par un point
	$texte=stripslashes($texte);
	$texte=ereg_replace(",",".",$texte);

	return $texte;
}

function deux_chiffres($chiffre) {
// fonction qui rajoute un 0 devant le nombre si c'est un chiffre
	if($chiffre<=9)  {
	$chiffre="0".$chiffre;
	}

  return $chiffre;
}


function HT_TTC($prix,$TVA) {
	$resultat_TVA = $prix * $TVA / 100;
	$resultat = $resultat_TVA + $prix;

	return($resultat);
}

function calcule_prix_promotion($prix,$reduction,$TVA) {
	$prix_tva = HT_TTC($prix,$TVA);
	$reduc_avec_tva=($prix_tva*$reduction)/100;
	$resultat=$prix_tva-$reduc_avec_tva;

	return($resultat);
}

function EURO_arrondi($valeur) {
	$res=$valeur*100;  
	$res1=intval($res);
	$res2=$res1/100;

	return($res2);
}

// Fonction d'envoi de mail via la fonction mail de php
function envoie_mail_php($email,$message,$from,$sujet,$reply="") {
  $limite = "b".md5 (uniqid (time())); 
  $message=stripslashes($message);
  $mail_mime = "MIME-Version: 1.0\n"; 
  $mail_mime .= "Content-Type: multipart/mixed; BOUNDARY=\"".$limite."\"\n\n";
  $mail_mime .="Message-Id: <".md5(rand(1000,200000))."@"._DOMAINE_EMAIL.">\r\n";     
  $mail_mime .= "This part of the E-mail should never be seen. If you are reading this, consider upgrading your e-mail client to a MIME-compatible client.\n\n"; 

  //le message en html original 
  $texte_html = "--".$limite."\n"; 
  $texte_html .= "Content-Type: text/html; charset=\"iso-8859-1\"\n\n"; 
  $texte_html .= $message; 
  $texte_html .= "\n\n--".$limite."--\n"; 
  
  //Le message en texte simple pour les navigateurs qui n'acceptent pas le HTML 
  $texte_simple = "--".$limite."\n"; 
  $texte_simple .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n\n"; 
  $texte_simple .= strip_tags(eregi_replace("<br>", "\n", $message)); 
  $texte_simple .= "\n\n--".$limite."--\n"; 
  
  
  $tab_mail = explode(";",$email);
  
  $success = 1;
  
  for ($i=0;$i<count($tab_mail);$i++)
  {
		$from = 	clean_header($from);
		$reply = 	clean_header($reply);
		$to = 		clean_header($tab_mail[$i]);	
		$sujet =	clean_header($sujet);

		if ($from && $reply && $to && $sujet ) { // test injection
  		if (is_email($from) && is_email($to)) {
  			$temp_res = mail($to, $sujet, $texte_html."\n".$texte_simple, "Reply-to: $reply\nFrom:$from\n".$mail_mime);
  		}
  	} else {
  		$temp_res = 0;
  	}
  	
  	if ($temp_res == 0) 
  	{
  		if ($success == 1) $success = 0;
	}  		
  }
  
  return $success;
}



// Fonction d'envoi de mail via la fonction envoi_mail_smtp (via serveur smtp)
//attachments tableau

function envoie_mail($email,$message,$from,$sujet,$reply="",$debug=false, $attachments ="" ) {
	// on envoie en utf8
	$From  = "From:".$from."\n";
	$From .= "MIME-version: 1.0\n";
	$From .= "Content-type: text/html; charset= utf-8\n";



	$retour = mail($email,$sujet,$message,$From);
	
	return $retour;
	//return envoie_mail_utf8($email,$message,$from,$sujet,$reply,$debug, $attachments);
	
	
}
	
	
function envoie_mail_utf8($email,$message,$from,$sujet,$reply="",$debug=false, $attachments ="" ) {
  // fonction reduite pour le projet : utf8 oblige
  $message=stripslashes($message);

  $mail_mime = "Content-Type: text/html; charset=\"utf-8\"\r\n";
  $mail_mime .= "Content-Transfer-Encoding: 8bit\r\n";
 
  //le message en html original 
  $texte_html = $message; 
  
  if ($reply=="") $reply = $from;
  
  $tab_mail = explode(";",$email);
  
  $success = 1;
  
  for ($i=0;$i<count($tab_mail);$i++)
  {  	
  	//Format envoi_mail_smtp( $to, $msg, $from, $sujet , $headersup, $debugmode = false )
  	//$temp_res = envoi_mail_smtp($tab_mail[$i],  $texte_html, $from, $sujet, "Reply-to: $reply\r\nFrom:$from\r\n".$mail_mime, 0);
  	
  		$from = 	clean_header($from);
		$reply = 	clean_header($reply);
		$to = 		clean_header($tab_mail[$i]);	
		$sujet =	clean_header($sujet);
		
  	$temp_res = envoi_mail_smtp($to,  $texte_html, $from, $sujet, $mail_mime, 0, $attachments);
  
  	if ($temp_res == 0) 
  	{
  		if ($success == 1) 
		{
			$success = 0;
  			//erreur_email($email,$from,$sujet,$message);
		}
	}
  		//log_email($email,$from,$sujet,$message,$success);
  }  
  
  
  return $success;
}
	

// Pour les serveurs sur lesquels la fonction mail php est dÃ©sactivÃ©.
// envoi direct en socket smtp sur serveur de mail

function sendRequest($fp, $req, $rc, $debug = false) 
{ 
	//if ($debug) echo(htmlentities($req)." ".htmlentities($rc)."<br>\n");
	if ($debug) echo("<!-- DEBUG SESSSION TELNET SMTP : \n".htmlentities($req)."-->\n");
	
	fputs($fp, "$req\r\n") ;
	
	$ret = fgets($fp);
	
	if ($debug) echo("<!--".htmlentities($ret)."--><br>\n");
	
	$ret = sscanf($ret, "%d") ; 
	$ret = $ret[0] ; 
       
	if($ret != $rc)
	{
		fputs($fp, "quit\r\n") ; 
		fclose($fp) ; 
		
		echo("<!-- RÃ©ponse invalide du serveur, $req renvoyÃ©e $ret, attendue $rc-->\n") ; 
		
		return 0;
	}
	else
	{ 
		return 1;  //success
	} 
}  

// fonction d'envoi de mail direct via protocole smtp via socket smtp sur port 25
// En entrÃ©e : $to : liste des destinataires sÃ©parÃ©s par une virgule
//	       $msg : message
// 	       $from : email emetteur
//	       $sujet : sujet message
//	       $debugmode : affiche toutes les trames de la requete
// 	       $MailServer (global) : adresse serveur de mail	

function envoi_mail_smtp( $to, $msg, $from, $sujet , $headersup, $debugmode = false, $attachments ="" )
{
	global $MailServer;
	
	$host = $MailServer;
			
 	$bound = uniqid(time()."_");

	$content = "";
	
	$heloFrom = "website";
	
	$content .= "--$bound\r\n";	
	
  $content .= $headersup."\r\n";
  $content .= $msg."\r\n";
  $content .= "\r\n";
        
        
	if( is_array( $attachments ) && count($attachments) > 0 )
	{ 
           
		foreach( $attachments as $attch )
		{
			if( $fp = fopen( $attch, "rb" ) )
			{
				$bn = basename( $attch );
               
				$content .= "--$bound\r\n" ; 
				
				//$finfo = finfo_open(FILEINFO_MIME); // Retourne le type mime Ã  la extension mimetype				
				$content .= "Content-Type: ".mime_content_type ($attch)."; name=\"$bn\"\r\n";
				$content .= "Content-Transfer-Encoding: base64\r\n";
				$content .= "Content-Disposition: inline; filename=\"$bn\"\r\n\r\n";
				$content .= chunk_split( base64_encode( fread( $fp, filesize( $attch ) ) ) )."\r\n";
				$content .= "\r\n\r\n";
				fclose( $fp );
				
			}
			else
			{
				echo "Error, could not open $attch.";
				return false;
			} 
		} 
		
		$content .= "--$bound\r\n";
	
	}
	
	elseif($attachments !="") // si c'est fichier texte
	{
		
		$file = $attachments;
		$filename = basename( $file );  
		
		// Tout d'abord lire le contenu du fichier	
		$fp = fopen($file, "rb");   // b c'est pour les windowsiens
		$attachment_file = fread($fp, filesize($file));
		fclose($fp);
		
		$attachment_file = chunk_split(base64_encode($attachment_file));
		$content .= "--$bound\r\n";		
		$content .= "Content-Type: application/pdf; name=\"$file\"\r\n";		
		$content .= "Content-Transfer-Encoding: base64\r\n";		
		$content .= "Content-Disposition: inline; filename=\"$filename\"\r\n";
		$content .= "\r\n";		
		$content .= $attachment_file . "\r\n";
		$content .= "\r\n\r\n";		
		$content .= "--$bound--\r\n";
	} 

  	  	
	$header = "From: ".$from."\r\n";
	$header .= "To: ".$to."\r\n";
	
	// patch DRO : encode le sujet du mail avec les fonction "mb_"
	mb_internal_encoding("UTF-8");
	$header .= "Subject: ".mb_encode_mimeheader($sujet, "UTF-7", "Q")."\r\n";
	//$content .= "Subject: ".$sujet."\r\n";
	
	$header .=  "X-Mailer: PHP/" . phpversion() . "\r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-Type: multipart/mixed; boundary=\"$bound\"\r\n";		  
	$header .= "\r\n";
	$header .= "this is the format MIME 1.0 multipart/mixed.\r\n\r\n";
	$content = $header.$content;
		  

	$to = explode( ";",$to); 
	
	//$petit_to = array_chunk($to,5); // on coupe en petit tableau pour ne pas assaillir le serveur SMTP	
	
	$success = 0;
	
	foreach( $to as $batch ) // et on boucle sur les petits tableaux
	{
		if (empty($to)) continue;
		
		$fp = fsockopen( $host, 25, $errno, $errstr, 60 );

		if( !$fp ) 
		{			
			echo( "Connection failed to $host:$port: ($errno) $errstr<br/>" );
			$success = 0;
	  } 

		do
		{ 
			$res = fgets( $fp );
		}while( $res[3] == "-" ); 
       
		$success = sendRequest( $fp, "helo $heloFrom", 250 , $debugmode);
		$success = sendRequest( $fp, "mail from: $from", 250 , $debugmode);

		//foreach( $batch as $rcpt ) // puis, boucle sur les envois		
		$success = sendRequest( $fp, "rcpt to: ".$batch, 250 , $debugmode);
                   
		$success = sendRequest( $fp, "data", 354 , $debugmode);
		$success = sendRequest( $fp, $content."\r\n.", 250 , $debugmode);
		$success = sendRequest( $fp, "quit", 221 , $debugmode);
           
		fclose( $fp );
	}
	
	return $success;
} 


function redirect($url,$param) {
	// Redirection vers une url
	if (headers_sent()){ 
		echo('<meta http-equiv="refresh" content="0;URL='. $url .'">'); 
	} else { 
		header("Location: ".$url.$param);
	} 
}

function sup_first_carac($car,$liste){
// Suprimme le premier element d'une chaine et retourne la chaine
	$nbcar = strlen($liste);
	$first = substr($liste,0,1);
	if ($first =="$car") {
		$liste = substr($liste,1,$nbcar-1);
	}

	return($liste);
}

function fond_tableau($fond="bgcolor=#FFFFFF") {
//Affecte une couleur de fond, une ligne sur deux dans les tableaux
$couleur1 = "#F5F5F5"; // Gris claire
$couleur2 = "#FFFFFF"; // Blanc D1E9D1

	if ($fond == "bgcolor=$couleur2") { # Affichage des grisÅ½ 1 ligne/2
		$fond = "bgcolor=$couleur1";
	}
	else {
		$fond = "bgcolor=$couleur2";
	}

	return($fond);
}


function loginOld($user,$pass) {
//Authentification de l'utilisateur

	$query = "Select * from user where nom= '$user' and pass = '$pass'";
	$result = mysql_query($query);
	$nb = mysql_num_rows($result);

		if ($nb == 1) {//L'utilisateur existe
			return(true);
		}
		else {
			redirect("index.php?user=$user");
			exit();
		}
}

function Conv_StrEspace_StrVirgule($Str) {
//Remplace les espaces d'une chaine par des virgules
//Pour une clause SQL IN par exemple
	$Str = split(" ",$Str);
	$Str = join(", ",$Str);

	return($Str);
}



//Retourne un TimeStamp a partir d'une date au format 2001-12-31
function GetTimestampFromDate($Date, $Time="00:00:00") {
	$TDate = split("-",$Date);

	if ($Time) {
		$Time = split(":",$Time);
	}
	else {
		$Time[0]=$Time[1]=$Time[2] = 0;
	}
	return(mktime($Time[0],$Time[1],$Time[2],$TDate[1],$TDate[2],$TDate[0]));
}

//Retourne une Date au format 2001-12-31 a partir d'un Timestamp
function GetDateFromTimestamp($Date) {
	return(date("Y-m-d", $Date));
}
function GetDateFromTimestampSlashs($Date) {
	return(date("d/m/Y", $Date));
}

// Retourne une date au format ISO8601 : Ã  partir d'une datetime MySQL
function GetISO8601FromDate($Date) {	
	
	$tab_date = split(" ",$Date);	
	$nTimestamp = GetTimestampFromDate($tab_date[0],$tab_date[1]);
	
	$sISO8601 = date('Y-m-d\Th:i:s',$nTimestamp). substr_replace(date('O',$nTimestamp),':',3,0);
	
	return $sISO8601;
}

function Cdate($date,$Type,$Language="fr") {
//Fonction pour convertir une date en date francaise
//1=courte
//2=moyenne
//3=longue
	$heure="";
	$heure_s="";
        $heure_s="&nbsp;<i>(".Date("H\hi's''",strtotime($date)).")</i>"; // on recupere l'heure, m, s avant de la supprimer
	$heure="&nbsp;<i>(".Date("H\hi",strtotime($date)).")</i>"; // on recupere l'heure,m  avant de la supprimer

	//Retourne la date en anglais
	if ($Language == "en" ) {
		return(CDateEn($date,$Type));
	}
	else {
		$date = split("-",$date);

		// supprime l'heure Ã  la suite de date2 si c'est un datetime
		if (strpos($date[2]," "))
		{
		   $date[2]=substr($date[2],0,strpos($date[2]," "));		   
		}
		else
		{
		    // pas d'heure dans le champ, on rÃ©initialise les valeurs
		    $heure="";
		    $heure_s="";	
		}

		if ($date[1] == 1): //Traitement du mois
			$Mois =  "Janvier";
		elseif ($date[1] == 2):
			$Mois =  "F&eacute;vrier";
		elseif ($date[1] == 3):
			$Mois =  "Mars";
		elseif ($date[1] == 4):
			$Mois =  "Avril";
		elseif ($date[1] == 5):
			$Mois =  "Mai";
		elseif ($date[1] == 6):
			$Mois =  "Juin";
		elseif ($date[1] == 7):
			$Mois =  "Juillet";
		elseif ($date[1] == 8):
			$Mois =  "Ao&ucirc;t";
		elseif ($date[1] == 9):
			$Mois =  "Septembre";
		elseif ($date[1] == 10):
			$Mois =  "Octobre";
		elseif ($date[1] == 11):
			$Mois =  "Novembre";
		elseif ($date[1] == 12):
			$Mois =  "D&eacute;cembre";
		endif;

		$Nbjour=intval($date[2]);
		
		if ($Nbjour<10):
			$Nbjour = "0".$Nbjour;
		endif;
		
		$mois=intval($date[1]);
		if ($mois<10):
			$mois = "0".$mois;
		endif;
		
		if ($Type == 1): //Date Courte 23/12/00
			return($Nbjour."/".$mois."/".$date[0]);
		elseif ($Type == 2): //Date Moyenne 23 dec. 2000
			if ($Mois=="D&eacute;cembre") {
				$date[1] = "D&eacute;c.";
			}
			elseif ($Mois=="Janvier") {
				$date[1] = "Janv.";
			}
			elseif ($Mois=="Juillet") {
				$date[1] = "Juil.";
			}
			elseif ($Mois=="F&eacute;vrier") {
				$date[1] = "F&eacute;v.";
			}
			elseif ($Mois=="Ao&ucirc;t") {
				$date[1] = "Ao&ucirc;t";
			}
			elseif (strlen($Mois)>4) {
				$date[1] = substr($Mois,0,3);
				$date[1] = $date[1].".";
			}
			elseif (strlen($Mois)==4) {
				$date[1] = substr($Mois,0,4);
				$date[1] = $date[1];
			}
			else {
				$date[1] = $Mois;
			}
			return($Nbjour." ".$date[1]." ".$date[0]);
		elseif ($Type == 3): //Date longue Lundi 23 decembre 2000
			$Jour = UcFirst(jour_de_date($date[2],$date[1],$date[0]));
			return($Jour." ".$date[2]." ".strtolower($Mois)." ".$date[0]);
		elseif ($Type == 4): // Date longue Lundi 23 decembre 2000 (Hhm) -- avec heures et minutes
			$Jour = UcFirst(jour_de_date($date[2],$date[1],$date[0]));
			return($Jour." ".$date[2]." ".strtolower($Mois)." ".$date[0].$heure);
		elseif ($Type == 5): // Date longue Lundi 23 decembre 2000 (Hhms) -- avec heure, minutes et secondes
			$Jour = UcFirst(jour_de_date($date[2],$date[1],$date[0]));
			return($Jour." ".$date[2]." ".strtolower($Mois)." ".$date[0].$heure_s);			
		elseif ($Type == 6): // Date courte 23/12/00 -- avec heure, minutes
			return($Nbjour."/".$mois."/".$date[0].$heure);						
		elseif ($Type == 7): // Date courte 23/12/00 -- avec heure, minutes et secondes
			return($Nbjour."/".$mois."/".$date[0].$heure_s);									
		elseif ($Type == 8): //Date longue Lundi 23 decembre sans l'annÃ©e
			$Jour = UcFirst(jour_de_date($date[2],$date[1],$date[0]));
			return($Jour." ".$date[2]." ".strtolower($Mois));		
		endif;
	}
}

// Renvoie la date au format US
function CDateEn($date, $Type) {

	$heure="";
	$heure_s="";
        $heure_s="&nbsp;<i>(".Date("H\hi's''",strtotime($date)).")</i>"; // on recupere l'heure, m, s avant de la supprimer
	$heure="&nbsp;<i>(".Date("H\hi",strtotime($date)).")</i>"; // on recupere l'heure,m  avant de la supprimer
	
	
		$date = split("-",$date);
		
		// supprime l'heure Ã  la suite de date2 si c'est un datetime
		if (strpos($date[2]," "))
		{
		   $date[2]=substr($date[2],0,strpos($date[2]," "));		   
		}
		else
		{
		    // pas d'heure dans le champ, on rÃ©initialise les valeurs
		    $heure="";
		    $heure_s="";	
		}
				
		if ($date[1] == 1): //Traitement du mois
			$Mois =  "January";
		elseif ($date[1] == 2):
			$Mois =  "February";
		elseif ($date[1] == 3):
			$Mois =  "March";
		elseif ($date[1] == 4):
			$Mois =  "April";
		elseif ($date[1] == 5):
			$Mois =  "May";
		elseif ($date[1] == 6):
			$Mois =  "June";
		elseif ($date[1] == 7):
			$Mois =  "July";
		elseif ($date[1] == 8):
			$Mois =  "August";
		elseif ($date[1] == 9):
			$Mois =  "September";
		elseif ($date[1] == 10):
			$Mois =  "October";
		elseif ($date[1] == 11):
			$Mois =  "November";
		elseif ($date[1] == 12):
			$Mois =  "December";
		endif;
		
		$Nbjour=intval($date[2]);		
		if ($Nbjour<10):
			$Nbjour = "0".$Nbjour;
		endif;
		
		// extension du jour en anglais
		switch(substr($Nbjour,-1))
		{
		   case "1":
		   	$ext_en="st";
		   	break;
		   case "2":
		   	$ext_en="nd";
		   	break;			   	
		   case "3":
		   	$ext_en="rd";
		   	break;			   	
		   default :
		   	$ext_en="th";
		   	break;			   	
		}
		$ext_en="<sup>".$ext_en."</sup>";
		
		$mois=intval($date[1]);
		if ($mois<10):
			$mois = "0".$mois;
		endif;
		
		if ($Type == 1) { //Date Courte 23/12/00			
			return($mois."/".$Nbjour."/".$date[0]);
		}
		elseif ($Type == 2)
		{ //Date Moyenne 23 dec. 2000
			if (strlen($Mois)>4) {
				$date[1] = substr($Mois,0,3);
				$date[1] = $date[1].".";
			}
			elseif (strlen($Mois)==4) {
				$date[1] = substr($Mois,0,4);
				$date[1] = $date[1];
	}
			else {
				$date[1] = $Mois;
			}
			return($date[1]." ".$Nbjour.$ext_en.", ".$date[0]);
}
		elseif ($Type == 3)
		{ //Date longue Lundi 23 decembre 2000
			$Jour = UcFirst(jour_de_date_en($date[2],$date[1],$date[0]));						

			return($Jour." ".$Nbjour.$ext_en." ".$Mois.", ".$date[0]);
		}
		elseif ($Type == 4)
		{
		 // Date longue Lundi 23 decembre 2000 (Hhm) -- avec heures et minutes
			$Jour = UcFirst(jour_de_date_en($date[2],$date[1],$date[0]));
			return($Jour." ".$Nbjour.$ext_en." ".$Mois.", ".$date[0].$heure);
		}
		elseif ($Type == 5)
		{ // Date longue Lundi 23 decembre 2000 (Hhms) -- avec heure, minutes et secondes
			$Jour = UcFirst(jour_de_date_en($date[2],$date[1],$date[0]));
			return($Jour." ".$Nbjour.$ext_en." ".$Mois.", ".$date[0].$heure_s);			
	}
		elseif ($Type == 6)
		{ // Date courte 23/12/00 -- avec heure, minutes
			return($mois."/".$Nbjour."/".$date[0].$heure);			
		}
		elseif ($Type == 7)
		{ // Date courte 23/12/00 -- avec heure, minutes, secondes
			return($mois."/".$Nbjour."/".$date[0].$heure_s);			
		}
		elseif ($Type == 8)
		{ //Date longue Lundi 23 decembre sans l'annÃ©e
			$Jour = UcFirst(jour_de_date_en($date[2],$date[1],$date[0]));						
		
			return($Jour." ".$Nbjour.$ext_en." ".$Mois);
		}				
}

function jour_de_date($jour,$mois,$annee) {
	 // fonction qui renvoie le nom du jour en fonction de la date
		 setlocale(LC_TIME,"fr_FR");
		 return strftime("%A",mktime(0,0,0,$mois,$jour,$annee));

	//	setlocale ("LC_TIME", "fr");
	//	return print(UcFirst(strftime("%A")));
}
 
// renvoie le jour de la date en Anglais

function jour_de_date_en($jour,$mois,$annee) {
	 // fonction qui renvoie le nom du jour en fonction de la date
		 setlocale(LC_TIME,"en_US.iso885915");
		 return strftime("%A",mktime(0,0,0,$mois,$jour,$annee));
}

//Calcule le nombre de jours entre deux dates au format AAAA-MM-JJ
function nb_jours($debut, $fin) {

  $tDeb = explode("-", $debut);
  $tFin = explode("-", $fin);

  $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) - 
          mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);
  
  return(($diff / 86400)+1);

}


function TestNav($HTTP_USER_AGENT) {
//Si internet explorer retourne true
//Si netscape6 retourne true
//Sinon false retourne true
	if (eregi("MSIE",$HTTP_USER_AGENT)) {
		return(1);
	}
	elseif (eregi("Netscape6",$HTTP_USER_AGENT)) {
		return(1);
	}
	else {
		return(0);
	}
}

Function IsInternetExplorer() {
    // Si on trouve MSIE dans la chaÃ®ne HTTP_USER_AGENT
    return eregi( "MSIE", GetEnv( "HTTP_USER_AGENT" ) );
}
 

Function IsNetscape() {
    // Si on trouve "MOZILLA" dans la chaÃ®ne HTTP_USER_AGENT
    return ( ! IsInternetExplorer() && eregi( "MOZILLA", GetEnv( "HTTP_USER_AGENT" ) ) );
}

function GetTxtFromHtml($Str) {

//	$Str	=	str_replace("'","&#8216;",$Str);
//	$Str	=	str_replace("oe","&#339;",$Str);
//	$Str	=	str_replace("'","&#8217;",$Str);
//	$Str	=	str_replace("...","&#8230;",$Str);
	$Str	=	str_replace("&amp;","&",$Str);
	$Str	=	str_replace("&lt;","<",$Str);
	$Str	=	str_replace("&gt;",">",$Str);
	$Str	=	str_replace("&quot;","\"",$Str);
	$Str	=	str_replace("&agrave;","Ã ",$Str);
	$Str	=	str_replace("&eacute;","Ã©",$Str);
	$Str	=	str_replace("&egrave;","Ã¨",$Str);
	$Str	=	str_replace("&ugrave;","Ã¹",$Str);
	$Str	=	str_replace("&acirc;","Ã¢",$Str);
	$Str	=	str_replace("&ecirc;","Ãª",$Str);
	$Str	=	str_replace("&icirc;","Ã®",$Str);
	$Str	=	str_replace("&ocirc;","Ã´",$Str);
	$Str	=	str_replace("&ucirc;","Ã»",$Str);
	$Str	=	str_replace("&auml;","Ã¤",$Str);
	$Str	=	str_replace("&euml;","Ã«",$Str);
	$Str	=	str_replace("&iuml;","Ã¯",$Str);
	$Str	=	str_replace("&ouml;","Ã¶",$Str);
	$Str	=	str_replace("&uuml;","Ã¼",$Str);
	$Str	=	str_replace("&ccedil;","Ã§",$Str);

	return $Str;
}

/*function unhtmlentities ($string)
{
	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	return strtr ($string, $trans_tbl);
}*/

function unhtmlentities ($string)  {
   $trans_tbl = get_html_translation_table (HTML_ENTITIES);
   $trans_tbl = array_flip ($trans_tbl);
   $ret = strtr ($string, $trans_tbl);
   return preg_replace('/&#(\d+);/me',"chr('\\1')",$ret);
}

function get_no_accent_from_text($Str) {
	$Str	=	str_replace("á","a",$Str);
	$Str	=	str_replace("à","a",$Str);
	$Str	=	str_replace("ã","a",$Str);
	$Str	=	str_replace("â","a",$Str);
	$Str	=	str_replace("ä","a",$Str);
			
	$Str	=	str_replace("é","e",$Str);
	$Str	=	str_replace("è","e",$Str);
	$Str	=	str_replace("ë","e",$Str);
	$Str	=	str_replace("ê","e",$Str);

	$Str	=	str_replace("î","i",$Str);
	$Str	=	str_replace("í","i",$Str);
	$Str	=	str_replace("ì","i",$Str);
	$Str	=	str_replace("ï","i",$Str);

	$Str	=	str_replace("ô","o",$Str);
	$Str	=	str_replace("ó","o",$Str);
	$Str	=	str_replace("ò","o",$Str);
	$Str	=	str_replace("ö","o",$Str);

	$Str	=	str_replace("û","u",$Str);
	$Str	=	str_replace("ü","u",$Str);
	$Str	=	str_replace("ç","c",$Str);

	return(retireAccents($Str));
}
function get_no_accent_from_text_utf8($Str) {
	$Str	=	str_replace("Ã¡","a",$Str);
	$Str	=	str_replace("Ã ","a",$Str);
	$Str	=	str_replace("Ã£","a",$Str);
	$Str	=	str_replace("Ã¢","a",$Str);
	$Str	=	str_replace("Ã¤","a",$Str);
			
	$Str	=	str_replace("Ã©","e",$Str);
	$Str	=	str_replace("Ã¨","e",$Str);
	$Str	=	str_replace("Ã«","e",$Str);
	$Str	=	str_replace("Ãª","e",$Str);

	$Str	=	str_replace("Ã®","i",$Str);
	$Str	=	str_replace("Ã­","i",$Str);
	$Str	=	str_replace("Ã¬","i",$Str);
	$Str	=	str_replace("Ã¯","i",$Str);

	$Str	=	str_replace("Ã´","o",$Str);
	$Str	=	str_replace("Ã³","o",$Str);
	$Str	=	str_replace("Ã²","o",$Str);
	$Str	=	str_replace("Ã¶","o",$Str);

	$Str	=	str_replace("Ã»","u",$Str);
	$Str	=	str_replace("Ã¼","u",$Str);
	$Str	=	str_replace("Ã§","c",$Str);

	return(retireAccents($Str));
}

function retireAccents($txt) {
  //$masque = "[?!]";
  //$txt = eregi_replace($masque, "", $txt);

  $masque = "[àâä@]";
  $txt = eregi_replace($masque, "a", $txt);

  $masque = "[éèêë€]";
  $txt = eregi_replace($masque, "e", $txt);

  $masque = "[ïì]";
  $txt = eregi_replace($masque, "i", $txt);

  $masque = "[ôö]";
  $txt = eregi_replace($masque, "o", $txt);

  $masque = "[ùûü]";
  $txt = eregi_replace($masque, "u", $txt);

  $masque = "[ç]";
  $txt = eregi_replace($masque, "c", $txt);

  $masque = "[&]";
  $txt = eregi_replace($masque, "et", $txt);

  //$masque = " +";
  //$txt = eregi_replace($masque, "-", $txt);

  return(strtolower($txt));
}
function retireAccents_utf8($txt) {
  //$masque = "[?!]";
  //$txt = eregi_replace($masque, "", $txt);

  $masque = "[Ã Ã¢Ã¤@]";
  $txt = eregi_replace($masque, "a", $txt);

  $masque = "[Ã©Ã¨ÃªÃ«â‚¬]";
  $txt = eregi_replace($masque, "e", $txt);

  $masque = "[Ã¯Ã¬]";
  $txt = eregi_replace($masque, "i", $txt);

  $masque = "[Ã´Ã¶]";
  $txt = eregi_replace($masque, "o", $txt);

  $masque = "[Ã¹Ã»Ã¼]";
  $txt = eregi_replace($masque, "u", $txt);

  $masque = "[Ã§]";
  $txt = eregi_replace($masque, "c", $txt);

  $masque = "[&]";
  $txt = eregi_replace($masque, "et", $txt);

  //$masque = " +";
  //$txt = eregi_replace($masque, "-", $txt);

  return(strtolower($txt));
}

function get_filename_from_text($Str) {
	
	$str_corrigee="";

	for ($i=0;$i<strlen($Str);$i++)
	{
		$charatpos = substr($Str,$i,1);
		$asciicharatpos= ord($charatpos);		
				
		if ( (($asciicharatpos>47) && ($asciicharatpos<58)) || // chiffres
			 (($asciicharatpos>64) && ($asciicharatpos<91))	|| // miniscules
			 (($asciicharatpos>96) && ($asciicharatpos<123)) || // majuscules
			 $asciicharatpos == 95 || $asciicharatpos == 126 || $asciicharatpos == 46 ) { // caracteres _ et ~autorisÃ©s et "."
			 $str_corrigee.= $charatpos;
		}
		else {
			 $str_corrigee.= "_";
		}
	}			
		
	return strtolower($str_corrigee);
}
	


function CheckMail($Email,$Debug=false)  
{  
    global $HTTP_HOST;  
    $Return =array();   
    // Variable for return. 
    // $Return[0] : [true|false] 
    // $Return[1] : Processing result save. 

    if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $Email)) {  
        $Return[0]=false;  
        $Return[1]="${Email} is E-Mail form that is not right.";  
        if ($Debug) echo "Error : {$Email} is E-Mail form that is not right.<br>";          
        return $Return;  
    }  
    else if ($Debug) echo "Confirmation : {$Email} is E-Mail form that is not right.<br>";  

    // E-Mail @ by 2 by standard divide. if it is $Email this "lsm@ebeecomm.com".. 
    // $Username : lsm 
    // $Domain : ebeecomm.com 
    // list function reference : http://www.php.net/manual/en/function.list.php 
    // split function reference : http://www.php.net/manual/en/function.split.php 
    list ( $Username, $Domain ) = split ("@",$Email);  

    // That MX(mail exchanger) record exists in domain check . 
    // checkdnsrr function reference : http://www.php.net/manual/en/function.checkdnsrr.php 
    if ( checkdnsrr ( $Domain, "MX" ) )  {  
        if($Debug) echo "Confirmation : MX record about {$Domain} exists.<br>";  
        // If MX record exists, save MX record address. 
        // getmxrr function reference : http://www.php.net/manual/en/function.getmxrr.php 
        if ( getmxrr ($Domain, $MXHost))  {  
      if($Debug) {  
                echo "Confirmation : Is confirming address by MX LOOKUP.<br>";  
              for ( $i = 0,$j = 1; $i < count ( $MXHost ); $i++,$j++ ) {  
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Result($j) - $MXHost[$i]<BR>";   
        }  
            }  
        }  
        // Getmxrr function does to store MX record address about $Domain in arrangement form to $MXHost. 
        // $ConnectAddress socket connection address. 
        $ConnectAddress = $MXHost[0];  
    }  
    else {  
        // If there is no MX record simply @ to next time address socket connection do . 
        $ConnectAddress = $Domain;          
        if ($Debug) echo "Confirmation : MX record about {$Domain} does not exist.<br>";  
    }  

    // fsockopen function reference : http://www.php.net/manual/en/function.fsockopen.php 
    $Connect = fsockopen ( $ConnectAddress, 25 );  

    // Success in socket connection 
    if ($Connect)    
    {  
        if ($Debug) echo "Connection succeeded to {$ConnectAddress} SMTP.<br>";  
        // Judgment is that service is preparing though begin by 220 getting string after connection . 
        // fgets function reference : http://www.php.net/manual/en/function.fgets.php 
        if ( ereg ( "^220", $Out = fgets ( $Connect, 1024 ) ) ) {  
              
            // Inform client's reaching to server who connect. 
            fputs ( $Connect, "HELO $HTTP_HOST\r\n" );  
                if ($Debug) echo "Run : HELO $HTTP_HOST<br>";  
            $Out = fgets ( $Connect, 1024 ); // Receive server's answering cord. 

            // Inform sender's address to server. 
            fputs ( $Connect, "MAIL FROM: <{$Email}>\r\n" );  
                if ($Debug) echo "Run : MAIL FROM: &lt;{$Email}&gt;<br>";  
            $From = fgets ( $Connect, 1024 ); // Receive server's answering cord. 

            // Inform listener's address to server. 
            fputs ( $Connect, "RCPT TO: <{$Email}>\r\n" );  
                if ($Debug) echo "Run : RCPT TO: &lt;{$Email}&gt;<br>";  
            $To = fgets ( $Connect, 1024 ); // Receive server's answering cord. 

            // Finish connection. 
            fputs ( $Connect, "QUIT\r\n");  
                if ($Debug) echo "Run : QUIT<br>";  

            fclose($Connect);  

                // Server's answering cord about MAIL and TO command checks. 
                // Server about listener's address reacts to 550 codes if there does not exist   
                // checking that mailbox is in own E-Mail account. 
                if ( !ereg ( "^250", $From ) || !ereg ( "^250", $To )) {  
                    $Return[0]=false;  
                    $Return[1]="${Email} is address done not admit in E-Mail server.";  
                    if ($Debug) echo "{$Email} is address done not admit in E-Mail server.<br>";  
                    return $Return;  
                }  
        }  
    }  
    // Failure in socket connection 
    else {  
        $Return[0]=false;  
        $Return[1]="Can not connect E-Mail server ({$ConnectAddress}).";  
        if ($Debug) echo "Can not connect E-Mail server ({$ConnectAddress}).<br>";  
        return $Return;  
    }  
    $Return[0]=true;  
    $Return[1]="{$Email} is E-Mail address that there is no any problem.";  
    return $Return;  
} 

//-------   FONCTION GET_EMAIL_FORMAT
//-------   Test la validitÃ© d'une adresse email
//-------   Date : jeudi 26 septembre 2002
//-------   PARAMETRES
//-------   email : recoit une chaine de caractere
//-------   RETOURNE
//-------   true : format d'email valide
//-------   false : format d'email invalide
function get_email_format($email) 
{
	//if (eregi ("^[a-z0-9]+([_.-][a-z0-9]+)*@([a-z0-9]+([.-][a-z0-9]+)*)+\\.[a-z]{2,4}$",  $email)) {  
	//if( eregi("(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$",$email))
	
	$pattern = '/.*@.*\..*/';
	if (preg_match($pattern, $email) > 0)
	{
		return true;
	}
	else 
	{
		return false;
	}
}


// retourne true si le fichier est une image
function is_image($fichier) {
	if (eregi("jpg",$fichier) || eregi("jpeg",$fichier) || eregi("gif",$fichier) || eregi("bmp",$fichier) || eregi("tif",$fichier))
		{ return true; }
	else
		{ return false; }
}



function getAgeByDate($iMonth, $iDay, $iYear) { 
    $iTimeStamp = (mktime() - 86400) - mktime(0, 0, 0, $iMonth, $iDay, $iYear); 
    $iDays = $iTimeStamp / 86400; 
    $iYears = floor($iDays / 365.25); 
    return $iYears; 

} 


function get_ligne($texte, $max_car=20) {

	$ar_ligne = array();

	$ar_mot = split(" ",$texte);

	$compteur = 0;

	for ($i=0;$i<count($ar_mot);$i++) {
		$compteur += strlen($ar_mot[$i]);
		$tmp .= " ".$ar_mot[$i];
		
		if (intval($compteur+strlen($ar_mot[$i+1]))>$max_car) {
			$compteur = 0;
			$ar_ligne[] = $tmp;
			$tmp ="";
		}
		
	}

	$ar_ligne[] = $tmp;

	return $ar_ligne;

}

// retourne un texte dans la langue en cours
//function get_libLocal($string='') 
//{
//	$libelle = getLibFromBase($string);
//	if (strlen($libelle) > 0)
//	{
//		return $libelle;	
//	}	
//		
//	return $libelle;
//}

// retourne un texte dans la langue en cours
function get_libLocal($string='',$bundle='') 
{
   global $localisations;
      
   $local_bundle = ($bundle == "" ? $localisations : $bundle);
   
   if (isset($local_bundle[$string])) {   	
       return (nl2br($local_bundle[$string]));
   }
   else {
       return (ucfirst($string));
   }
}

// retourne le prenom nom d'un user dont on passe l'id sous la forme P.NOM
function get_user_name($id_user)
{
    $StrSQL="SELECT nom, prenom, email, "._CONST_BO_CODE_NAME."profil from "._CONST_BO_CODE_NAME."user inner join "._CONST_BO_CODE_NAME."profil on "._CONST_BO_CODE_NAME."user.id_"._CONST_BO_CODE_NAME."profil = "._CONST_BO_CODE_NAME."profil.id_"._CONST_BO_CODE_NAME."profil and "._CONST_BO_CODE_NAME."user.id_"._CONST_BO_CODE_NAME."user =".$id_user;
    $RstUser=mysql_query($StrSQL);
    //echo get_sql_format($StrSQL);
    
    if (mysql_num_rows($RstUser)==1)
    {
    	$trigramme = strtoupper(substr(mysql_result($RstUser,0,"prenom"),0,1)).".".strtoupper(mysql_result($RstUser,0,"nom"));

    	if (mysql_result($RstUser,0,"email")!="")
    	{
    		return ("<a href='mailto:".mysql_result($RstUser,0,"email")."'>".$trigramme."</a>&nbsp;(".mysql_result($RstUser,0,_CONST_BO_CODE_NAME."profil").")");
	}
	else
	{
		return($trigramme."&nbsp;(".mysql_result($RstUser,0,_CONST_BO_CODE_NAME."profil").")");
	}
    }
    else
    {
    	return("Non dÃ©fini");
    }    
}

// Fonction qui embrouille les chaines (mailto en particulier)
// pour Ã©viter les aspirations des robots
// encode en entity html

function get_str_brouille($email) 
{
	$result = "";
	$i = 0;

	for ($i=0; $i < strlen($email); $i++) 
	{	
	   $c = ord(substr($email,$i,1));
	   $tmp="";
	   	
	   while ($c >= 1) 
	   {
		$tmp = substr("0123456789",($c % 10),1).$tmp;
		$c = ($c / 10);
	   }

	   if ($tmp == "") $tmp = "0";

		$tmp = "#".$tmp;
		$tmp = "&".$tmp;
		$tmp = $tmp.";";

		$result .= $tmp; 
	}
	return $result;   	
}

// fct qui gÃ©nÃ¨re automatiquement une image redimensionnÃ©e JPG Ã  partir d'une image de base en JPG
// Compatible GD1.0 !
function resize_img($largeFile,$thumbFile,$pathtoimage,$nw=251,$nh=170)
{       
     
   if (is_file($pathtoimage.$largeFile))
   {                     
      list($width_orig, $height_orig) = getimagesize($pathtoimage.$largeFile);
      
      $width = $nw;
      $height = $nh;
      
      if ($nw && ($width_orig < $height_orig)) {
         $width = ($nh / $height_orig) * $width_orig;
      } else {
         $height = ($nw / $width_orig) * $height_orig;
      }
      
      // Resize
      $image_p = imagecreate($width, $height);
      $image = imagecreatefromjpeg($pathtoimage.$largeFile);
      
      if(!imagecopyresized($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig)) 
      {
      	return false;
      }
      
      // Ecriture fichier resizÃ©
      if (!imagejpeg($image_p, $pathtoimage.$thumbFile, 100)) 
      {      
      	return false;
      }
      
      return true; 
   }
   else
   {
   		return false;
   }   
}
/*-------------------- Redimensionner une image ---------------------*/
function red_image($img_src,$img_dest,$dst_w,$dst_h,$rep_dest) {
   // Lit les dimensions de l'image
   
   
   //echo $img_src;
   $size = getimagesize($img_src);  
  // echo "<br>-->".$size[0]."<br>";
   $src_w = $size[0]; $src_h = $size[1];  
   
   
   // Teste les dimensions tenant dans la zone
   $test_h = round(($dst_w / $src_w) * $src_h);
   $test_w = round(($dst_h / $src_h) * $src_w);
   // Si Height final non prÃ©cisÃ© (0)
   if(!$dst_h) $dst_h = $test_h;
   // Sinon si Width final non prÃ©cisÃ© (0)
   elseif(!$dst_w) $dst_w = $test_w;
   // Sinon teste quel redimensionnement tient dans la zone
   elseif($test_h>$dst_h) $dst_w = $test_w;
   else $dst_h = $test_h;
   
 

   // La vignette existe ?
   $test = (file_exists($img_dest));
   // L'original a Ã©tÃ© modifiÃ© ?
   if($test)
      $test = (filemtime($img_dest)>filemtime($img_src));
   // Les dimensions de la vignette sont correctes ?
   if($test) {
      $size2 = GetImageSize($img_dest);
      $test = ($size2[0]==$dst_w);
      $test = ($size2[1]==$dst_h);
   }
  

   // CrÃ©er la vignette ?
   if(!$test) {
     	
     	
    
      // CrÃ©e une image vierge aux bonnes dimensions
      // $dst_im = ImageCreate($dst_w,$dst_h);
      $dst_im = ImageCreateTrueColor($dst_w,$dst_h); 
      // Copie dedans l'image initiale redimensionnÃ©e
      $src_im = ImageCreateFromJpeg($img_src);
      
         
      // ImageCopyResized($dst_im,$src_im,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
      ImageCopyResampled($dst_im,$src_im,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
      // Sauve la nouvelle image
      ImageJpeg($dst_im,$rep_dest.$img_dest,100);
      // DÃ©truis les tampons
      ImageDestroy($dst_im);  
      ImageDestroy($src_im);
      
   
      
   }   
   
  
   
   return $img_dest;
}

/*-------------------- -------------------------- ---------------------*/


function mail_attachement($to,$sujet,$message,$fichier,$typemime,$nom,$reply,$from){
$limite = "_parties_".md5(uniqid (rand()));
	
	$mail_mime  = "Date: ".date("l j F Y, G:i")."\n";
	$mail_mime .= "MIME-Version: 1.0\n";
	$mail_mime .= "Content-Type: multipart/mixed;\n";
	$mail_mime .= "   boundary=\"----=$limite\"\n\n";
	
	$texte = "This is a multi-part message in MIME format.\n";
	$texte .= "Ceci est un message est au format MIME.\n";
	$texte .= "------=$limite\n";
	$texte .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$texte .= "Content-Transfer-Encoding: 7bit\n\n";
	$texte .= $message;
	$texte .= "\n\n";
	
	//le fichier
	$attachement  = "------=$limite\n";
	$attachement .= "Content-Type:  $typemime; name=\"$nom\"\n";
	$attachement .= "Content-Transfer-Encoding: base64\n";
	$attachement .= "Content-Disposition: attachment; filename=\"$nom\"\n\n";

	$fd = fopen( $fichier, "r" );
	$contenu = fread( $fd, filesize( $fichier ) );
	fclose( $fd );
	$attachement .=  chunk_split(base64_encode($contenu)); 

	$attachement .= "\n\n\n------=$limite\n";
	return mail($to, $sujet, $texte.$attachement, "Reply-to: $reply\nFrom: $from\n".$mail_mime);
}


// Fonction Trace() : renvoie a l'ecran un print_r de la variable formattÃ©e
function trace($var)
{
	 echo("<pre>".print_r($var,1)."</pre>");
	 echo("<pre>".var_dump($var,1)."</pre>");	 
}

function tt($var)
{
	if($_SERVER['REMOTE_ADDR']=="10.63.1.63")	trace($var);	
}

// LAC : 18/08/06 : protection anti injection SMTP
// nettoie les champs qui doivent Ãªtre envoyÃ©s par mail pour empÃ©cher l'injection smtp
function clean_header($string) 
{    
  $string_test = urldecode($string);  
  $string_test = trim($string_test);
  $string_test = utf8_decode($string_test);

  // RFC 822: "The field-body may be composed of any ASCII
  // characters, except CR or LF".
  if (strpos($string_test, "\n") !== false) {
    //$string = substr($string, 0, strpos($string, "\n"));
    echo("<!-- INJECTION SMTP DETECTEE -->");
    $string = -1;
  }
  
  if (strpos($string_test, "\r") !== false) {
    //$string = substr($string, 0, strpos($string, "\r"));
    echo("<!-- INJECTION SMTP DETECTEE -->");
    $string = -1;
  }
  
  return $string;
}

// LAC : 18/08/06 : function qui vÃ©rifie si un email est valide
if (!function_exists("is_email")) {
	function is_email($email) {	
		// on commence par vÃ©rifier le format
		
		//if (preg_match("/^(\\w|-|_|\\.)+@((\\w|-)+\\.)+([a-z]|[A-Z]){2,6}$/i",$email))
		if(true) // A CORRIGER !!
		{
			$email_parts = explode("@", $email);	
			$host = str_replace(">","",$email_parts[1])."."; // enleve le > dans le cas de nom complet
			
			// test si le domaine renseignÃ© a un enregistement MX
			if ( getmxrr( $host, $mxhosts ) == FALSE && gethostbyname( $host ) == $host ) {
				echo("<!-- bad mx -->");
				return false;
			} 
			else {
				return true;
			}
		} else {
			echo("<!-- mauvais format -->");
			return false;
		}	
	}
}
function mysql_table_existe($table)
{
	$tables=mysql_list_tables($BaseName);
	while (list($temp)=mysql_fetch_array($tables)) 
	{ if($temp == $table) 
		{return true;}
	}
	return false;
}

// support windows platforms
if (!function_exists ('getmxrr') ) {
  function getmxrr($hostname, &$mxhosts, &$mxweight) {
  
   if (!is_array ($mxhosts) ) {
     $mxhosts = array ();
   }

   if (!empty ($hostname) ) {
     $output = "";
     @exec ("nslookup.exe -type=MX $hostname.", $output);
     $imx=-1;

     foreach ($output as $line) {
       $imx++;
       $parts = "";
       if (preg_match ("/^$hostname\tMX preference = ([0-9]+), mail exchanger = (.*)$/", $line, $parts) ) {
         $mxweight[$imx] = $parts[1];
         $mxhosts[$imx] = $parts[2];
       }
     }
     return ($imx!=-1);
   }
   return false;
  }
}


function microtime_float() {
    return array_sum(explode(' ', microtime()));
}


//**************************************//
//****** check champ multilingue *******//
//**************************************//
function isMultilingue($field,$tabledef=0)
{
	
	
	$strMultilingue="SELECT multilingue FROM _lib_champs WHERE field='".$field."' and id__table_def=".$tabledef;
	if($tabledef!=0)
	{
		$strMultilingue.=" AND id__table_def=".$tabledef;
	}
	$result=mysql_query($strMultilingue);
	return mysql_result($result,0,"multilingue");
}


//****************************************************//
//***** 14/07/2007-MVA 														****//
//***** Pour la gestion  des objets multilingues  ****//
//***** reforme le nom du control sans le suffixe ****//
//****  de langue 																****//
//****************************************************//
function recompose_formFieldName($form_fieldname)
{
					
				
					$tab=split("_",$form_fieldname);
					$form_fieldname="";
					if(count($tab)>1)
					{
						for($i=0;$i<count($tab)-1;$i++)
						{
							$form_fieldname.=$tab[$i];
						
							if($i<count($tab)-2)
								$form_fieldname.="_";
						}
					}
					return $form_fieldname;
}

//****************************************************//
//***** 17/07/2007-MVA 												********//
//***** Selectionne les bons alias de clefs   ********//
//***** d'identifiants et de libelle suivants ********//
//***** le theme retournÃ©e par le WSDL 				********//
//***** ex : id/name pour regions, code/label ********//
//***** pour les hebergements									********//
//****************************************************//
function getAliasIdAndLabel($datas,$dic)
{
		$i=0;
		$tab=array();
		
		while($i < count($dic) )//dictionnaire de clefs dÃ©fini dans lib_global
		{
			//	si la clÃ© id du dictionnaire existe dans le jeu de donnÃ©es
			//	on garde le couple id/libelle
			
			$keys=array_keys($datas);
			if(array_key_exists($dic[$i]['id'],$datas[$keys[0]]))
			{		
				$tab['id']=$dic[$i]['id'];
				$tab['name']=$dic[$i]['name'];
			}
			$i++;
		}
		
		return $tab;
}


// genÃ¨re les valeurs sql lors de l'insertion d'un enregistrmeent dans
// un formulaire
function genValueforSQL($monChamp,$mode,$langue,$id,$table_name = "")
{
		
		global $req, $datatype_text,$datatype_file,$datatype_integer	,$datatype_booleen,$datatype_key,	$datatype_multikey,$datatype_list_data,$datatype_order,$datatype_date,$datatype_datetime,$datatype_datetime_auto,$mysql_datatype_text,$mysql_datatype_text_rich,$mysql_datatype_integer,$mysql_datatype_real, $UploadPath, $CtImUpload;
	

			$fieldtype			=$monChamp['fieldtype'];
			$fieldname			=$monChamp['fieldname'];
			$form_fieldname	    =$monChamp['form_fieldname']."_".$langue;
			$fieldlen			=$monChamp['fieldlen'];
			$tablename			=$monChamp['tablename'];	
			
			
		
			if ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey)) {
					
					$value=@implode(",",$_REQUEST[$form_fieldname]);
					
					
					
				}
				//*** 12/09/2007-MVA-SPECIF Homair
				//*** donnÃ©es Resalys
			/*	elseif($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_data_resalys))
				{
					$UPDATE .=  "$fieldname=\"".@implode(",",$$form_fieldname)."\",";
					$StrINSERTleft .= $fieldname.",";
					$StrINSERTright .= "\"".@implode(",",$$form_fieldname)."\",";
				}*/
		//------------ MODIF LAC 12/2004
		// pb : le varchar(254) est trop petit pour stocker tous les id dans la table user..
		// passage du champ en longtext => detection dans inc_form ici=					
		elseif(($_REQUEST['TableDef']==8)&&($fieldname == $datatype_arbo))
		{		   
		   $value=@implode(",",$_REQUEST[$form_fieldname]);
		   continue;		   			
		}
		//------------ FIN MODIF LAC
                //************    LISTE DE DONNEES
                elseif ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_list_data)) {
                	
                    $value=@implode("|",$_REQUEST[$form_fieldname]);
                }

					//************    TEXTE
					elseif ($fieldtype==$mysql_datatype_text && $fieldlen!=ereg_replace("(.*)\((.*)\)","\\2",$datatype_file) ) {
						$valeur_formfieldname = $_REQUEST[$form_fieldname];
					$valeur_formfieldname = str_replace("<", "&lt;",$valeur_formfieldname);
					$valeur_formfieldname = str_replace(">", "&gt;",$valeur_formfieldname);
					
						
						$value=addslashes($valeur_formfieldname);
					}

				//************    CHAMPS DATE ET HEURE
				if ($fieldtype==$datatype_date || $fieldtype==$datatype_datetime) {
					$datetemp = split("/",substr($_REQUEST[$form_fieldname],0,10));
					$newdate = $datetemp[2]."-".$datetemp[1]."-".$datetemp[0];

					//Gestion del'heure
					if ($fieldtype==$datatype_datetime) {
						$newtime = " ".date("H:i:s",GetTimestampFromDate(substr($_REQUEST[$form_fieldname],0,10),substr($_REQUEST[$form_fieldname],-8)));
					}
					else {
						$newtime = "";
					}
					
					//Date du jour par defaut
					if (ereg("_auto",$fieldname) && $mode="nouveau") {
						$value = "NOW(),";
					}
					//Date saisie par l'utilisateur
					else {
						$value = ($newdate.$newtime);
					}
				}

				//On test si il s'agit d'un champs d'ordonnancement 
				//09/08/2002
				if ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_order)) {
					$ordonnancement[] = 1;
					$ordonnancement[] = $tablename;
					$ordonnancement[] = $_REQUEST[$form_fieldname];
				}

                //************    CHAMP TEXTAREA
				if ($fieldtype==$mysql_datatype_text_rich) {
					
					if (!get_magic_quotes_gpc()) { // le champ a-t'il Ã©tÃ© dÃ©ja Ã©chappÃ© ?
						$value = addslashes($_REQUEST[$form_fieldname]); // non
					}
					else {
						$value = $_REQUEST[$form_fieldname]; // oui
					}
					
					$value = str_replace ( "Ã¢â€šÂ¬", "&euro;", $value );
					$value = str_replace ( "â‚¬", "&euro;", $value );					
					
					$value = utf8_decode($value);
					$value = unhtmlentities($value);
					$value = utf8_encode($value);
					//MDI : la ligne suivante permet de rectifier l'erreur commise par la fonction utf8_encode sur l'encodage de l'â‚¬
					//$value = str_replace(chr(0xC2).chr(0x80) , chr(0xE2).chr(0x82).chr(0xAC),  $value);
				}
                //************    LISTE DEROULANTE
				if ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_key)) {
					$value=$_REQUEST[$form_fieldname];
				}
				//************    CHAMPS TEXTE CONTENANT UNE VALEUR NUMERIQUE
				if (
						(
							   $fieldtype==$mysql_datatype_integer
							|| $fieldtype==$mysql_datatype_real
						)
						&& (
								(
									   $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_integer)
									|| $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_order)
									|| $fieldlen==$datatype_real
								)
							)
						) {
					if ($_REQUEST[$form_fieldname]=="0") {
						$_REQUEST[$form_fieldname] = "0"; 
					}
					elseif (empty($_REQUEST[$form_fieldname])) {//Si rien n'a ete saisie
						$_REQUEST[$form_fieldname] = "NULL"; //On met le champs a NULL
					}

					$value=$_REQUEST[$form_fieldname];
				}

        //CASE A COCHER
				if ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_booleen) ) {
					if ($_REQUEST[$form_fieldname] == 1) {//CochÃ©e
						$value = 1;
					}
					else {//Non cochÃ©e
						$value = 0;
					}
				}

                //FICHIER
				if ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_file) ) {
						
					//On recupere le nom du champ dans la base afin de supprimer le fichier sur le server si il y a besoin
					$NomDuFichierDansLaBase = @mysql_result(@mysql_query("select trad_".$tablename.".".$fieldname." from trad_".$tablename." where trad_".$tablename.".id__".$tablename."=".$id." and trad_".$tablename.".id__langue=".$langue),0,"trad_".$tablename.".".$fieldname);
													

					//Nom donnÃ© au fichier = 95 premiers carc du nom original + id champ					
					//$TFile = split("\.",$_REQUEST[$form_fieldname."_name"]);
					
					//$TFile = split("\.",${$form_fieldname."_name"});
										
					
					//$form_fieldname  = 'field_fic_' . $langue;
					
					$TFile = split("\.",$_FILES[$form_fieldname]['name']);
					
													
					for ($n=0;$n<count($TFile);$n++) {
						$TFile[$n] = trim($TFile[$n]);
					}
					$FileExt = array_pop($TFile);					
					$TFile = substr(join($TFile,"."),0, 95);
					$FileName = $TFile."_".$id.".".$FileExt;
					


//					Avant
//					$FileName = substr($fieldname."_".$id.".".$FileExt,0, 70);

					//Si une image a ete selectionnÃ© ou si on supprime l'image
					
					
			if (	($_FILES[$form_fieldname]["name"]) 
				|| 	$_REQUEST["PictureDelete_".$fieldname."_".$langue] 
				|| $_REQUEST["choose_img_type_".$fieldname."_".$langue] == "1"
				|| $_REQUEST["choose_img_type_".$form_fieldname] == "1" ) {

						if ($_REQUEST["PictureDelete_".$fieldname."_".$langue]==1) {//On supprime l'image existante
							DeleteFile($NomDuFichierDansLaBase, $UploadPath[$CtImUpload]);
							$fichier = "";
							$supprimer = "oui";						
						}
						else {
							DeleteFile($NomDuFichierDansLaBase, $UploadPath[$CtImUpload]);
							$fichier = UploadFile_2($fieldname."_".$langue."_".$FileName, $form_fieldname, $UploadPath[$CtImUpload]);
						}


                        //Portfolio
                        if (${"choose_img_type_".$form_fieldname} == "1" || $_REQUEST["choose_img_type_".$form_fieldname] == "1") 
                        {
                              
                        	if($_REQUEST[$form_fieldname."_port"] !="")
                        	{
                              $fichier = $_REQUEST[$form_fieldname."_port"];
                        }
                        	else 
                        	{                        		
                        		$fichier = $_REQUEST[$form_fieldname."_".$_SESSION["ses_langue"]."_port"];
                        	}
                        }

						$value=$fichier;
					}
                    //************    GESTION DES UPLOAD EN MODE DUPLICATION
                    elseif ($_REQUEST[$form_fieldname."_duplicate"]) {
                       	copy($UploadPath[$CtImUpload]."/".$_REQUEST[$form_fieldname."_duplicate"], $UploadPath[$CtImUpload]."/duplicate_".$_REQUEST[$form_fieldname."_duplicate"]);
                    }
                    else { 	
	                    	$value = $NomDuFichierDansLaBase;
                    	}

					//Suppression de l'images
					if ($mode == "supr") {
						//Suppression du fichier lier						
						DeleteFile($NomDuFichierDansLaBase, $UploadPath[$CtImUpload]);
					}

				$CtImUpload++;
				}
				
				
				return $value;
}

// get Id Table def
function getIdTableDef($item)
{
	$strTableDef="SELECT id__table_def FROM _table_def WHERE cur_table_name='".$item."'";
	$id=mysql_result(mysql_query($strTableDef),0,0);
	if(mysql_error())
		echo("Erreur sur recuperation table def.\n req=".$strTableDef);
	
	return $id;
}

//BBO : Fonction qui permet de gÃ©nÃ©rer un control administrateur de liste multiple triÃ©e
function get_select_control($current_list,$tablename)
{
	global $inc_form_available_images;
	global $inc_form_diaporama_images;
	$list = "";
	$control = "";
	$control.="</tr>";
	$control.="<tr>";
	$control.="<td colspan=\"2\">";
		$control.="<table style=\"font-size: 1em;\" cellpadding=\"0\" cellspacing=\"0\" width=\"98%\">";
			$control.="<tbody>";
				$control.="<tr style=\"font-weight: bold; color: rgb(154, 1, 17); text-align: left;\">";
					$control.="<td width=\"400px\">";
						$control.="<div style=\"border: 1px solid rgb(0, 0, 0); padding: 5px; width: 98%;\">";
							$control.="<div style=\"background: rgb(254, 175, 71) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: rgb(0, 0, 0);\">".$inc_form_available_images."</div>";
							$control.="<br>";
							$control.="<select name=\"leftList\" size=\"8\" id=\"leftList\" style=\"width: 100%;\">";
							
								//Affichage de la liste des images disponibles
								$where = "";
								if (strlen($current_list) > 0)
								{
									$where .= "where id_$tablename not in (".$current_list.")";
								}
								$Request = "Select id_$tablename, description from $tablename ".$where." order by id_$tablename";
								//echo "req all : " . $Request;
								$Result =  mysql_query($Request);
								for ($i=0;$i<@mysql_num_rows($Result) ;$i++)
								{										
									$id = @mysql_result($Result,$i,"id_$tablename");
									$desc = @mysql_result($Result,$i,"description");
									if (strlen($id) > 0 && strlen($desc) > 0)
									{		
										$control.="<option value=\"".$id."\">".$desc."</option>";
									}
								}
							
								
							$control.="</select>";
						$control.="</div>";
						$control.="<br>";
						$control.="<br>";
					$control.="</td>";
					$control.="<td align=\"center\" width=\"10%\">";
						$control.="<br>";
						$control.="<input name=\"addPicture\" value=\" &gt;&gt; \" onclick=\"javascript:addPictureFromLeftToRight();\" title=\"Ajouter l'image au diaporama\" type=\"button\">";
						$control.="<br>";
						$control.="<br>";
						$control.="<input name=\"removePicture\" value=\" &lt;&lt; \" onclick=\"javascript:removePictureFromRightToLeft();\" title=\"Retirer l'image du diaporama\" type=\"button\">";
					$control.="</td>";
					$control.="<td width=\"400px\">";
						$control.="<div style=\"border: 1px solid rgb(0, 0, 0); padding: 5px; width: 98%;\">";
							$control.="<div style=\"background: rgb(254, 175, 71) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: rgb(0, 0, 0);\">".$inc_form_diaporama_images."</div>";
							$control.="<br>";
							$control.="<select name=\"rightList\" size=\"8\" id=\"rightList\" style=\"width: 100%;\">";
								
								//Affichage de la liste des images du diaporama
								if (strlen($current_list) > 0)
								{
									$tab_images = explode(",", $current_list);
									for ($i=0;$i<count($tab_images) ;$i++)
									{					
										$id = $tab_images[$i];
										$Request = "Select description from $tablename where id_$tablename = ".$id;
										//echo "<br>req right = " . $Request ;
										$Result =  mysql_query($Request);
										$desc = @mysql_result($Result,0);
										if (strlen($id) > 0 && strlen($desc) > 0)
										{		
											$control.="<option value=\"".$id."\">".$desc."</option>";
											if($i != 0)
											{
												$list.=",";
											}
											$list.=$id;
										}
									}
								}
								
							$control.="</select>";
						$control.="</div>";
						$control.="<br>";
						$control.="<br>";
					$control.="</td>";
					$control.="<td align=\"center\" width=\"10%\">";
						$control.="<br>";
						$control.="<input name=\"up\" value=\" /\ \" onclick=\"javascript:increasePictureRank();\" title=\"Augmenter le rang de l'image dans le diaporama\" type=\"button\">";
						$control.="<br>";
						$control.="<br>";
						$control.="<input name=\"down\" value=\" \/ \" onclick=\"javascript:decreasePictureRank();\" title=\"Diminuer le rang de l'image dans le diaporama\" type=\"button\">";
						$control.="<input name=\"form_id_diaporama_hebergement\" id=\"form_id_diaporama_hebergement\" value=\"".$list."\" type=\"hidden\">";
					$control.="</td>";
				$control.="</tr>";
			$control.="</tbody>";
		$control.="</table>";
	$control.="</td>";
	
	return $control;
}


function get_select_control_gen($fieldname,$current_list,$tablename)
{
	
	//echo "<br>table_name = $tablename";
	//echo "<br>fieldname = $fieldname";
	global $inc_form_available_images;
	global $inc_form_diaporama_images;
	$list = "";
	$control = "";
	$control.="</tr>";
	$control.="<tr>";
	$control.="<td colspan=\"2\">";
		$control.="<table style=\"font-size: 1em;\" cellpadding=\"0\" cellspacing=\"0\" width=\"98%\">";
			$control.="<tbody>";
				$control.="<tr style=\"font-weight: bold; color: rgb(154, 1, 17); text-align: left;\">";
					$control.="<td width=\"400px\">";
						$control.="<div style=\"border: 1px solid rgb(0, 0, 0); padding: 5px; width: 98%;\">";
							$control.="<div style=\"background: rgb(254, 175, 71) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: rgb(0, 0, 0);\">".$inc_form_available_images."</div>";
							$control.="<br>";
							$control.="<select name=\"leftList" . $fieldname . "\" size=\"8\" id=\"leftList" . $fieldname . "\" style=\"width: 380px;\" >";
							
								//Affichage de la liste des images disponibles
								$where = "";
								if (strlen($current_list) > 0)
								{																		
									if ($fieldname == "id_portfolio_img" && $_REQUEST['TableDef'] == _CONST_TABLEDEF_CAMPING_MEDIA)
									{
										$where .= "where id_$tablename not in (".$current_list.") and id_portfolio_rub = " . _CONST_TYPE_RUB_PORTFOLIO_PHOTO ; //pour les photos des camping.
									}
									elseif ($fieldname == "id_portfolio_img" && $_REQUEST['TableDef'] == _CONST_TABLEDEF_HEBERGEMENT)
									{
										$where .= "where id_$tablename not in (".$current_list.") and id_portfolio_rub = " . _CONST_TYPE_RUB_PORTFOLIO_PHOTO_HEB ; //pour les photos des hebergements.
									}

									elseif ($fieldname == "id_portfolio_img_1" && $_REQUEST['TableDef'] == _CONST_TABLEDEF_CAMPING_MEDIA)									
									{
										$where .= "where id_$tablename not in (".$current_list.") and id_portfolio_rub = " . _CONST_TYPE_RUB_PORTFOLIO_ZOOM ; //pour les zooms.
									}
									else
									{
										$where .= "where id_$tablename not in (".$current_list.") ";	
									}
								}
								else
								{
									
									if ($fieldname == "id_portfolio_img" && $_REQUEST['TableDef'] == _CONST_TABLEDEF_CAMPING_MEDIA )
									{
										$where .= "where id_portfolio_rub = " . _CONST_TYPE_RUB_PORTFOLIO_PHOTO ; //pour les photos.
									}
									elseif ($fieldname == "id_portfolio_img" && $_REQUEST['TableDef'] == _CONST_TABLEDEF_HEBERGEMENT)
									{
										$where .= "where id_portfolio_rub = " . _CONST_TYPE_RUB_PORTFOLIO_PHOTO_HEB ; //pour les photos.
									}
									elseif ($fieldname == "id_portfolio_img_1" && $_REQUEST['TableDef'] == _CONST_TABLEDEF_CAMPING_MEDIA)									
									{
										$where .= "where id_portfolio_rub = " . _CONST_TYPE_RUB_PORTFOLIO_ZOOM ; //pour les zooms.
									}									
									
								}
								
								$Request = "Select id_$tablename, portfolio_img from $tablename ".$where." order by portfolio_img";
								
								
								
								$Result =  mysql_query($Request);
								for ($i=0;$i<@mysql_num_rows($Result) ;$i++)
								{										
									$id = @mysql_result($Result,$i,"id_$tablename");
									$desc = @mysql_result($Result,$i,"portfolio_img");
									if (strlen($id) > 0 && strlen($desc) > 0)
									{		
										$control.="<option  title=\"" . $desc . "\" value=\"".$id."\">".$desc."</option>";
									}
								}
							
								
							$control.="</select>";
						$control.="</div>";
						$control.="<br>";
						$control.="<br>";
					$control.="</td>";
					$control.="<td align=\"center\" width=\"10%\">";
						$control.="<br>";
						$control.="<input name=\"addPicture\" value=\" &gt;&gt; \" onclick=\"javascript:addPictureFromLeftToRight_gen('" . $fieldname . "');\" title=\"Ajouter l'image au diaporama\" type=\"button\">";
						$control.="<br>";
						$control.="<br>";
						$control.="<input name=\"removePicture\" value=\" &lt;&lt; \" onclick=\"javascript:removePictureFromRightToLeft_gen('" . $fieldname . "');\" title=\"Retirer l'image du diaporama\" type=\"button\">";
					$control.="</td>";
					$control.="<td width=\"400px\">";
						$control.="<div style=\"border: 1px solid rgb(0, 0, 0); padding: 5px; width: 98%;\">";
							$control.="<div style=\"background: rgb(254, 175, 71) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: rgb(0, 0, 0);\">".$inc_form_diaporama_images."</div>";
							$control.="<br>";
							$control.="<select name=\"rightList" . $fieldname . "\" size=\"8\" id=\"rightList" . $fieldname . "\" style=\"width: 380px;\" >";
								
								//Affichage de la liste des images du diaporama
								if (strlen($current_list) > 0)
								{
									$tab_images = explode(",", $current_list);
									for ($i=0;$i<count($tab_images) ;$i++)
									{					
										$id = $tab_images[$i];
										$Request = "Select portfolio_img from $tablename where id_$tablename = ".$id;										
										$Result =  mysql_query($Request);
										$desc = @mysql_result($Result,0);
										if (strlen($id) > 0 && strlen($desc) > 0)
										{		
											$control.="<option title=\"" . $desc . "\" value=\"".$id."\">".$desc."</option>";
											if($i != 0)
											{
												$list.=",";
											}
											$list.=$id;
										}
									}
								}
								
							$control.="</select>";
						$control.="</div>";
						$control.="<br>";
						$control.="<br>";
					$control.="</td>";
					$control.="<td align=\"center\" width=\"10%\">";
						$control.="<br>";
						$control.="<input name=\"up\" value=\" /\ \" onclick=\"javascript:increasePictureRank_gen('" . $fieldname . "');\" title=\"Augmenter le rang de l'image dans le diaporama\" type=\"button\">";
						$control.="<br>";
						$control.="<br>";
						$control.="<input name=\"down\" value=\" \/ \" onclick=\"javascript:decreasePictureRank_gen('" . $fieldname . "');\" title=\"Diminuer le rang de l'image dans le diaporama\" type=\"button\">";
						$control.="<input name=\"form_" . $fieldname . "\" id=\"form_" . $fieldname . "\" value=\"".$list."\" type=\"hidden\">";
					$control.="</td>";
				$control.="</tr>";
			$control.="</tbody>";
		$control.="</table>";
	$control.="</td>";
	
	return $control;
}


//MVA : 11/2008 fonction de trie de tableau
//Here's a variation on the above function to sort arrays with more than one key by an arbitrary key's value.
//This function allows sorting of an array of objects too
function vsort($array, $id="id", $sort_ascending=true, $is_object_array = false) {
        $temp_array = array();
        while(count($array)>0) {
            $lowest_id = 0;
            $index=0;
            if($is_object_array){
                foreach ($array as $item) {
                    if (isset($item->$id)) {
                                        if ($array[$lowest_id]->$id) {
                        if ($item->$id<$array[$lowest_id]->$id) {
                            $lowest_id = $index;
                        }
                        }
                                    }
                    $index++;
                }
            }else{
                foreach ($array as $item) {
                    if (isset($item[$id])) {
                        if ($array[$lowest_id][$id]) {
                        if ($item[$id]<$array[$lowest_id][$id]) {
                            $lowest_id = $index;
                        }
                        }
                                    }
                    $index++;
                }                             
            }
            $temp_array[] = $array[$lowest_id];
            $array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
        }
                if ($sort_ascending) {
            return $temp_array;
                } else {
                    return array_reverse($temp_array);
                }
    }
    
    
    
 function display_on_change_data_list_script($datalistid, $tab_field_to_display)
 {
 	$script_line = "";
 	$script_line .= "<script>\n";
 	$script_line .= "function display_corresponding_data_list()\n";
 	$script_line .= "{\n";
 	$script_line .= "\tdatalist_value = document.getElementById('".$datalistid."').value;\n";
 	
 	$script_line .= "\tswitch (datalist_value)\n";
 	$script_line .= "\t{\n";
 	foreach($tab_field_to_display as $key_0 => $value_0)
 	{
 		$script_line .= "\t\tcase '".$key_0."':\n";
 		
 		foreach($tab_field_to_display as $key_1 => $value_1)
 		{
 			$tab_field = explode(",", $value_1);
 			if ($key_1 == $key_0)
 			{
 				$display = "block";
 			}
 			
 			else
 			{
 				$display = "none";
 			}
 			
 			foreach($tab_field as $key_2 => $value_2)
			{	
				$script_line .= "\t\t\tdocument.getElementById('".$value_2."').style.display='".$display."';\n";
			}	
 		}
 		$script_line .= "\t\t\tbreak;\n";
 		$script_line .= "\n";
 	}
 		
	$script_line .= "\t\tdefault :\n";
	
	foreach($tab_field_to_display as $key_3 => $value_3)
	{
		$tab_field = explode(",", $value_3);
		foreach($tab_field as $key_4 => $value_4)
		{	
			$script_line .= "\t\t\tdocument.getElementById('".$value_4."').style.display='none';\n";
		}	
	}
 	$script_line .= "\t}\n";
 	$script_line .= "}\n";
 	$script_line .= "</script>\n";
 	
 	echo($script_line);
}


function hasGabaritRights ( $id_dic_data, $id_item )
{
	
	$retour 			= true;
	$strSQL 			= "SELECT id_"._CONST_BO_CODE_NAME."nav , id_"._CONST_BO_CODE_NAME."profil FROM "._CONST_BO_CODE_NAME."dic_data WHERE id_"._CONST_BO_CODE_NAME."dic_data = ".$id_dic_data;
	
	
	$sql_def 			= @mysql_query( $strSQL );
 	$table_rights = @mysql_result( $sql_def, 0, "id_"._CONST_BO_CODE_NAME."nav");
	$user_rights	= @mysql_result( $sql_def, 0, "id_"._CONST_BO_CODE_NAME."profil");

	if ( strlen ( $user_rights ) > 0 )
	{
		$retour 			= false;
		$user_rights	= split ( "," , $user_rights );
		if ( is_array ( $user_rights ) && in_array ( $_SESSION['ses_profil_user'], $user_rights ) )
			$retour 		= true;
	}
	else 
	{
		$retour = false;
	}
	
	if ( ( strlen ( $table_rights ) > 0 ) && ( $retour == true ) )
	{
		$retour 			= false;
		$table_rights	= split ( "," , $table_rights );
		if ( is_array ( $table_rights ) && in_array ( $id_item, $table_rights ) )
			$retour 		= true;
	}
	else 
	{
		$retour = false;
	}
	
	return $retour;
}

function stripAccents ($string){ 
 return retireAccents(strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'));
} 

//pour generer les fichiers de trad en front
function genereFichiersTrad($_tableDef)
{
		if(_CONST_TRAD_GENERE_FIC && $_tableDef == _ID_TRADOTRON)
        {
        	
        	$sqlGetLangues = "SELECT * FROM _langue ORDER BY ordre ";
        	$rstGetLangues = mysql_query($sqlGetLangues);
        	while ($aLangues = mysql_fetch_array($rstGetLangues, MYSQL_ASSOC)) 
        	{
            	$sqlTradLibs = "SELECT  * 
            					FROM tradotron t INNER JOIN trad_tradotron tr ON t.id_tradotron = tr. id__tradotron
            					WHERE tr.id__langue = '".$aLangues["id__langue"]."' ";	
            	
            	$rstTradLibs = mysql_query($sqlTradLibs);
            	$x=0; $sTradlibs = "";
            	while ($aTrads = mysql_fetch_array($rstTradLibs, MYSQL_ASSOC))
            	{
            		if($x>0) $sTradlibs .=",\n";
            		$sTradlibs .= "\"".stripAccents(utf8_decode($aTrads["code_libelle"]))."\" => \"".str_replace("\"","\\\"",$aTrads["libelle"])."\"";
            		$x++;
            	}

            	$sTradLibs = "<? global \$localisations;\n\$localisations = array($sTradlibs);\n?>";            	
				$fileName = "../include/language/lib_language_".$aLangues["_langue_abrev"].".inc.php";
				
				file_put_contents_php4($fileName,$sTradLibs,"w+");
        	}
        }
}

// fonction de protection anti-injection Mysql / anti XSS sur un element
function secure($s,$with_xss_protection=1, $with_mysql_protection=1) {
	if ($with_xss_protection) $s = htmlspecialchars($s);
	if ($with_mysql_protection) $s = mysql_real_escape_string($s);
	return ($s);
}

// fonction de protection anti-injection Mysql / anti XSS sur un tableau
function secureArray (&$item)
{
	if (is_array($item)) array_walk ($item, 'secure');
	else
	{
		$item = secure($item);		
	}
}

// fonction de protection global d'une page de recuperation d'un formulaire
function secureRequest() {
	secureArray($_POST);
	secureArray($_GET);
}


?>
