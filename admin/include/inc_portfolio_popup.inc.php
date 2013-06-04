<?session_start();?>
<html>
<head>
<title>Gestion du Portfolio</title>
<style>
.txt{ 
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 11px; 
	font-style: normal; 
	font-weight: normal; 
	color: #000000; 
	line-height: normal; 
	font-variant: normal; 
	text-transform: none
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>

</head>

<script language="JavaScript">
window.moveTo( screen.width / 2 - 200, screen.height / 3 - 100 );
window.resizeTo( 400, 400 );
</script>
<?
	
	require "../library_local/lib_global.inc.php";
	require "../library_local/lib_local.inc.php";
	require "../library/fonction.inc.php";
	connection( );

	if (!isset($_SESSION['ses_user_id']) || $_SESSION['ses_user_id'] == "")
  {
  ?>

  <script>
    alert('Désolé,\nVos droits actuels sur l\'application ne vous autorisent pas à effectuer cette action.\nVeuillez contacter votre administrateur.');            
    history.go(-1);   
  </script>
  <?
     // et on arrete le script pour être sur qu'il ne se termine pas
     exit();
  }
	    
	// Confirmations d'actions pour la gestion du portfolio.
	if( $_REQUEST['val'] == "delrubok" )
	{
		$StrSelectDocsRub = "SELECT * FROM portfolio_img WHERE id_portfolio_rub ='".$_REQUEST['Rp']."'";
		$Res = mysql_query( $StrSelectDocsRub );
		
		while( $R = mysql_fetch_array( $Res, MYSQL_ASSOC ) )
		{
			if( $_REQUEST['fulldelrub'] )
			{
				$StrDelFilesRub = "DELETE FROM portfolio_img WHERE img='".$R["img"]."'";
				mysql_query( $StrDelFilesRub );
				$path = _CONST_PORTFOLIO_UPLOAD_PATH.$R["img"];
				unlink( $path );
			}
			else
			{
				$StrUpdRubFiles = "UPDATE portfolio_img SET id_portfolio_rub='1' WHERE id_portfolio_img='".$R["id_portfolio_img"]."'";
				mysql_query( $StrUpdRubFiles );
			}
		}
		
		
		$StrDelRub = "DELETE FROM portfolio_rub WHERE id_portfolio_rub ='".$_REQUEST['Rp']."'";
		mysql_query( $StrDelRub );
		
		echo "<script>window.opener.location.replace( window.opener.location );</script>";
		echo "<script>window.close();</script>";
	}
	elseif( $_REQUEST['val'] == "delimgok" )
	{
		$l = split( ";", $_REQUEST['ca'] );
		
		for( $i = 0; $i < count( $l ); $i++ )
		{
			if( $_REQUEST['fulldelfile'] )
			{
				$StrSelectDocs = "SELECT * FROM portfolio_img WHERE id_portfolio_img ='".$l[$i]."'";
				$Res = mysql_query( $StrSelectDocs );
		
				$R = mysql_result( $Res, 0, "img" );
	
				$path = _CONST_PORTFOLIO_UPLOAD_PATH.$R;
				unlink( $path );
			}
			
			$StrDelDoc = "DELETE FROM portfolio_img WHERE id_portfolio_img ='".$l[$i]."'";
			mysql_query( $StrDelDoc );
		}
		echo "<script>window.opener.location.replace( window.opener.location );</script>";
		echo "<script>window.close();</script>";
	}
	elseif( $_REQUEST['val'] == "modok" )
	{
		$StrMod = "UPDATE portfolio_img SET portfolio_img='".$_REQUEST['newlabel']."' WHERE id_portfolio_img='".$_REQUEST['id']."'";
		$R = mysql_query( $StrMod );
		echo "<script>window.opener.location.replace( window.opener.location );</script>";
		echo "<script>window.close();</script>";
	}
	elseif( $val == "add2libsuperfinal" )
	{
		$StrSql = "INSERT INTO portfolio_img( img, portfolio_img, id_portfolio_rub,auteur ) VALUES( '".$_REQUEST['filename']."','".$_REQUEST['filelabel']."','".$_REQUEST['cat']."','".$_REQUEST['fileauteur']."' )";
		mysql_query( $StrSql );
		echo "<script>window.opener.location.replace( window.opener.location );</script>";
		echo "<script>window.close();</script>";
	}
	elseif( $_REQUEST['val'] == "uploadfinal" )
	{
		if( isset($_FILES['upimgpath']) )
		{
			$Img = get_filename_from_text($_FILES["upimgpath"]["name"]);
			$ImgDir = _CONST_PORTFOLIO_UPLOAD_PATH;
			$label = ( $_REQUEST['idimg']!="" ?$_REQUEST['idimg']:$Img );		
      $auteur = 			$_REQUEST['fileauteur'];		
			
			//SPEC FFR EthIC ETAPES ==>
			if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
			{				
				if( in_array($_REQUEST['TableDef'],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]))				
				{
					$info = pathinfo($Img);
					$file_name =  basename($Img,'.'.$info['extension']);
					$rand = mt_rand(0, 32).time();
					$sql = "select login from _user WHERE id__user = '".$_SESSION["ses_user_id"]."' ";
					$rs = mysql_query($sql);
					$nomVille = mysql_result($rs,0,"login");			
					
					$sql = "select cur_table_name from _table_def where id__table_def = '".$_REQUEST['TableDef']."'";
					$rs = mysql_query($sql);
					$typeSejour = mysql_result($rs,0,"cur_table_name");			
					$Img = $typeSejour."_".$nomVille.'_'.$rand.'.'.$info['extension'];
				}
				elseif($_REQUEST['TableDef'] == _CONST_TABLEDEF_CENTRE) 
				{	
					$info = pathinfo($Img);
					$file_name =  basename($Img,'.'.$info['extension']);
					$rand = mt_rand(0, 32).time();
					$sql = "select login from _user WHERE id__user = '".$_SESSION["ses_user_id"]."' ";
					$rs = mysql_query($sql);			
					$Img = mysql_result($rs,0,"login").'_'.$rand.'.'.$info['extension'];
				}
			}
			
			if(( $_FILES["upimgpath"]["error"] != UPLOAD_ERR_OK )&&(strcmp("4.2.0",phpversion())<=0))			
			{
				echo "Error : ".$_FILES["upimgpath"]["error"];
			}
			else
			{
				
				$extensionsAutorisees = array("jpeg", "jpg", "gif", "pdf" , "doc", "png","JPEG","JPG","GIF");
				$nomOrigine = $_FILES['upimgpath']['name'];
				$elementsChemin = pathinfo($nomOrigine);
				$extensionFichier = $elementsChemin['extension'];
				if (!(in_array($extensionFichier, $extensionsAutorisees))) 
				{
					echo "Le fichier n'a pas l'extension attendue";
				}
				elseif($extensionFichier == "pdf" && $_FILES['upimgpath']['size']>4500000)
				{
				   echo "<b>Erreur lors du t&eacute;l&eacute;chargement du fichier ".$Img."<br>";
					echo "Le PDF t&eacute;l&eacute;charg&eacute;e ne doit pas d&eacute;passer les 450 ko.</b><br><br>";
			
        		}elseif($_FILES['upimgpath']['size']>150000000)
        		{
					echo "<b>Erreur lors du t&eacute;l&eacute;chargement du fichier ".$Img."<br>";
					echo "L'image ou la photo t&eacute;l&eacute;charg&eacute;e ne doit pas d&eacute;passer les 1.5 Mo.</b><br><br>";
				}
				elseif( is_uploaded_file( $_FILES['upimgpath']['tmp_name'] ) && move_uploaded_file( $_FILES['upimgpath']['tmp_name'], $ImgDir.$Img ) )
				{
					list($width, $height, $type, $attr) = getimagesize($ImgDir.$Img);

				



				if($width>720)
				{

					$image = $ImgDir.$Img;
					
					red_image($image,$image,720,"","");
					
					
					//red_image($Img,$Img,251,171,_CONST_PORTFOLIO_UPLOAD_PATH);

//die($ImgDir.$Img." ".$width);
					//if(resize_img($Img,$Img,_CONST_PORTFOLIO_UPLOAD_PATH,251)) echo "eeee"; else echo "fff";
				}
			
					$StrSql = "INSERT INTO portfolio_img( portfolio_img, img, id_portfolio_rub,auteur ) VALUES ( '".$label."', '".$Img."', '".$_REQUEST['cat']."','".$auteur."' )";
					$R = mysql_query( $StrSql );				
					chmod ($ImgDir.$Img, 0644);
					
					//FFR => rajout dans le portfolio a partir du formulaire inc_form.inc
					if($_REQUEST['form']=="1")
					{
						
						echo "<script>window.opener.updateFormJQ('".$_REQUEST["selectId"]."','".mysql_insert_id()."','$Img');</script>";	
					}
					else 
					{
						echo "<script>window.opener.location.replace( window.opener.location );</script>";
					}
					
					echo "<script>window.close();</script>";
					
					
				}
				else
				{
					echo "Erreur lors du t&eacute;l&eacute;chargement du fichier ".$Img."<br>";
					echo "iuf : ".is_uploaded_file( $_FILES['upimgpath']['tmp_name'] )."<br>";
					echo("Nom de l'image : $label<br>");
					echo("ImgDir : ".$ImgDir.$Img."<br>");
					echo "Error : ".$_FILES["upimgpath"]["error"]."<br>";
					
					var_dump( $_FILES );
					die();
				}
			}
			
			
		}
	}
	elseif( $_REQUEST['val'] == "addrub" )
	{
		$StrChk = "SELECT portfolio_rub FROM portfolio_rub WHERE portfolio_rub='".$_REQUEST['newrub']."'";
		
		$R = mysql_query( $StrChk );
		
		if( mysql_num_rows( $R ) == 0 )
		{
			$SQLCreateCat = "INSERT INTO portfolio_rub( portfolio_rub,id__user ) VALUES ('".$_REQUEST['newrub']."','".$_SESSION["ses_user_id"]."')";
			$Res = mysql_query( $SQLCreateCat );
		
			echo "<script>window.opener.location.replace( window.opener.location );</script>";
			echo "<script>window.close();</script>";
		}
		else
			echo $bo_port_popup_choose_other_name_cat;
	}
	elseif( $_REQUEST['val'] == "delno" )
	{
		echo "<script>window.close();</script>";
	}
	
	
		
?>

<html>
<head>
<title>Gestion du Portfolio</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="../js/scripts.js"></script>
</head>
<body bgcolor="#F2F2E8" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?
	if( $_REQUEST['Ac'] == "delrub" )
	{
		echo "<br><br><center>&Ecirc;tes-vous s&ucirc;r de vouloir effacer cette rubrique et tous les documents qu'elle contient?";
?>
		<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="DelRub">
		<input type="hidden" name="val" id="val" value="">
		<input type="checkbox" name="fulldelrub" id="fulldelrub" checked>Effacer tous les fichiers de la rubrique.<br><br><br>
		<input type="image" name="confirmdelrub" id="confirmdelrub" src="../images/icones/ok.gif" alt="Effacer" onclick="document.forms['DelRub'].val.value='delrubok';" >
		&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../images/icones/delete_cross.gif" style="cursor:pointer" alt="Annuler" onclick="javascript:window.close( );">
		</form>
		</center>
<?
	}
	
	elseif( $_REQUEST['Ac'] == "delimg" )
	{
		echo "<br><br><center>&Ecirc;tes-vous s&ucirc;r de vouloir effacer ce(s) document(s)?";
?>
		<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="DelImg">
		<input type="hidden" name="val" id="val" value="">
		<input type="checkbox" name="fulldelfile" id="fulldelfile" checked>Effacer le fichier.<br><br><br>
		<input type="image" name="confirmdelimgs" id="confirmdelimgs" src="../images/icones/ok.gif" alt="Effacer" onclick="document.forms['DelImg'].val.value='delimgok';" >
		&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../images/icones/delete_cross.gif" style="cursor:pointer" alt="Annuler" onclick="javascript:window.close( );">
		</form>
		</center>
<?
	}
	elseif( $_REQUEST['Ac'] == "modlabel" )
	{
		if( !$_REQUEST['idimg'] )
		{
			echo "Appel de fonction incorrect.<br>";
			echo "<a href=\"#\" onclick=\"javascript:window.close( );\">Fermer</a>";
		}
		else
		{
			$StrSql = "SELECT * FROM portfolio_img WHERE id_portfolio_img='".$_REQUEST['idimg']."'";
			$R = mysql_query( $StrSql );
			$Row = mysql_fetch_array( $R, MYSQL_ASSOC );
						
			echo "<br><br><center>Modifier le nom de ce document.";
?>
			<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="ModLabel">
			<input type="text" name="newlabel" id="newlabel" value="<?echo $Row["portfolio_img"];?>">
			<input type="hidden" name="val" id="val" value="">
			<input type="hidden" name="id" id="id" value="<?echo $_REQUEST['idimg'];?>">
			<input type="image" name="confirmdelimgs" id="confirmdelimgs" src="../images/icones/ok.gif" alt="Effacer" onclick="document.forms['ModLabel'].val.value='modok';" >
			&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="../images/icones/delete_cross.gif" style="cursor:pointer" alt="Annuler" onclick="javascript:window.close( );">
			</form>
			</center>
<?
		}
	}
	elseif( $_REQUEST['Ac'] == "add2lib" )
	{
		if( !$_REQUEST['fn'] )
		{
			echo "Appel de fonction incorrect.<br>";
			echo "<a href=\"#\" onclick=\"javascript:window.close( );\">Fermer</a>";
		}
		else
		{
?>
			Ajouter un document du serveur:
			<br>
			<center>
			<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="add2libfinal">
			<input type="hidden" name="val" id="val" value="add2libsuperfinal">
			<table width="100%" cellspacing="3" cellpadding="3">
			<tr>
				<td width="30%">Document:</td>
				<td>
					<input type="text" name="filename" id="filename" readonly size="30" value="<?echo $_REQUEST['fn'];?>" >
				</td>
			</tr>
			<tr>
				<td width="30%">Nom de l'image:</td>
				<td>
					<input type="text" name="filelabel" id="filelabel" size="30"><br>
				</td>
			</tr>
			<tr>
				<td width="30%">Auteur :</td>
				<td>
					<input type="text" name="fileauteur" id="fileauteur" size="30"><br>
				</td>
			</tr>
			<tr>
				<td class="txt" width="30%">Cat&eacute;gorie:</td>
				<td  class="txt">
					<select name="cat" id="cat" size="1" class="txt">
<?	

					if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
					{
						$StrSql = "SELECT * from portfolio_rub  WHERE portfolio_rub.id__user = '".$_SESSION["ses_user_id"]."'  ORDER BY id_portfolio_rub";
					}
					else 
					{
						$StrSql = "SELECT * from portfolio_rub ORDER BY id_portfolio_rub";
					}
					echo $StrSql;
					$Res = mysql_query( $StrSql );
					
					echo "num :".mysql_num_rows( $Res );
					
					for( $i = 0; $i < mysql_num_rows( $Res ); $i++ )
					{
						$R = mysql_fetch_array( $Res, MYSQL_ASSOC );
						
						echo "<option name=\"".$R["portfolio_rub"]."\" value=\"".$R["id_portfolio_rub"]."\" ";
						
						if( $RubPort && ($RubPort == $R["id_portfolio_rub"] ) )
							echo "selected";
								
						echo " >".$R["portfolio_rub"]."</option>\n";
					}
?>
					</select>
				</td>
			</tr>
			</table>
			<br>
			<input type="image" name="add2itimg" id="add2itimg" src="../images/icones/ok.gif" alt="Ajouter le document">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="../images/icones/delete_cross.gif" style="cursor:pointer" alt="Annuler" onclick="javascript:window.close( );">

			</form>
			</center>
<?	
		}
	}
	elseif( $_REQUEST['Ac'] == "upload" )
	{
?>
		<br>
		<center>
		<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="UpImg" enctype="multipart/form-data" >
		<input type="hidden" name="val" id="val" value="uploadfinal">
		<?			
			//FFR => rajout dans le portfolio a partir du formulaire
			if($_REQUEST['form']=="1") echo "<input type=\"hidden\" name=\"form\" id=\"form\" value=\"1\">";
		?>
		<table width="100%" cellspacing="3" cellpadding="3">
		<tr>
			<td>
				Nom de l'image : 
			</td>
			<td>
				<input type="text" name="idimg" id="idimg" >
			</td>
		</tr>
		<tr>
			<td>
				Auteur : 
			</td>
			<td>
				<input type="text" name="fileauteur" id="fileauteur" >
			</td>
		</tr>
		<tr>
			<td  class="txt">
				Fichier :
			</td>
			<td  class="txt">
				<input type="file" name="upimgpath" id="upimgpath">
			</td>
		</tr>
		<tr>
			<td width="30%">Cat&eacute;gorie:</td>
			<td>				
<?	

				if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
				{
					$StrSql = "SELECT * from portfolio_rub  WHERE portfolio_rub.id__user = '".$_SESSION["ses_user_id"]."'  ORDER BY id_portfolio_rub";
				}
				else 
				{
					$StrSql = "SELECT * from portfolio_rub ORDER BY id_portfolio_rub";
				}				
				$Res = mysql_query( $StrSql );				
				?>
				<select name="cat" id="cat" size="1">
				<?
				for( $i = 0; $i < mysql_num_rows( $Res ); $i++ )
				{
					$R = mysql_fetch_array( $Res, MYSQL_ASSOC );
					
					echo "<option name=\"".$R["portfolio_rub"]."\" value=\"".$R["id_portfolio_rub"]."\" ";
					
					if( $RubPort && ($RubPort == $R["id_portfolio_rub"] ) )
						echo "selected";
							
					echo " >".$R["portfolio_rub"]."</option>\n";
				}
?>
				</select>
			</td>
		</tr>

		</table>
		<br><br>
		<input type="image" name="upimg" id="upimg" src="../images/icones/ok.gif" alt="Uploader le document s&eacute;lectionn&eacute;" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../images/icones/delete_cross.gif" style="cursor:pointer" alt="Annuler" onclick="javascript:window.close( );">
		</form>
		</center>

<?
	}
	elseif( $_REQUEST['Ac'] = "newrub" )
	{
?>		
		<br>
		&nbsp;&nbsp;Nouvelle rubrique: <br>
		<center>
		<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="RubsCreate" >
		<input type="hidden" name="val" id="val" value="addrub">
		<input type="text" name="newrub" id="newrub" size="50" style="font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 9px; font-style: normal; font-weight: normal; color: #000000; line-height: normal; font-variant: normal; text-transform: none">
		<br><br><br>
		<input type="image" name="addrub"  id="addrub" src="../images/icones/ok.gif" alt="Cr&eacute;er la nouvelle cat&eacute;gorie" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../images/icones/delete_cross.gif" style="cursor:pointer" alt="Annuler" onclick="javascript:window.close( );">
		</form>
		</center>
<?
	}
	
?>
</body>
</html>

