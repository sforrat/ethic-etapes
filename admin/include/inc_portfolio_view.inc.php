<?
	set_time_limit( 30 );

  if (isset($_REQUEST['RubPort']) && ($_REQUEST['RubPort'] != ""))  {
  		$RubPort = $_REQUEST['RubPort'];	
  		
  }

	if( $_REQUEST['actiontype'] == "delrub" )
	{
		if( $_REQUEST['RubPort'] > 1 )
			echo "<script>window.open( \"include/inc_portfolio_popup.inc.php?Ac=delrub&Rp=".$_REQUEST['RubPort']."\", \"\", \"toolbar=no,menubar=no,resizable=no,scrollbars=yes\" );</script>";
	}
	elseif( $_REQUEST['actiontype'] == "moveimg" )
	{
		if( $_REQUEST['checkedattr'] )
		{
			
			$l = split( ";", $_REQUEST['checkedattr'] );
			
			for( $i = 0; $i < count( $l ); $i++ )
			{
			
				$SqlMoveimg = "UPDATE portfolio_img SET id_portfolio_rub='".$_REQUEST['imgsto']."' WHERE id_portfolio_img='".$l[$i]."'";
				$ResMove = mysql_query( $SqlMoveimg );
			}
		}
	}
	elseif( $_REQUEST['actiontype'] == "add2lib" )
	{
		$StrSql = "INSERT INTO portfolio_img( img, portfolio_img, id_portfolio_rub ) VALUES( '".$_REQUEST['filename']."','".$_REQUEST['filename']."','1')";
		
		mysql_query( $StrSql );
	}
	elseif( $_REQUEST['actiontype'] == "movemasseimg" )
	{		
		$liste_fic = split(";",$_REQUEST['checkedattr']);	
		$compteur_dep = 0;
		
		foreach($liste_fic as $id_fic)
		{
		   if ($id_fic!="")
		   {		      
		      if (isset($_REQUEST['rubtotal'])&&($_REQUEST['rubtotal']!="0"))
		      {
		      	  $cat = $_REQUEST['rubtotal'];
		      }
		      else
		      {
		      	   $cat = $_REQUEST['rubtrans_'.$id_fic];
		      }
		      $StrSql = "INSERT INTO portfolio_img( img, portfolio_img, id_portfolio_rub ) VALUES( '".$_REQUEST['filename_'.$id_fic]."','".$_REQUEST['filename_'.$id_fic]."',".$cat.")";
		      mysql_query( $StrSql );
		      $compteur_dep++;		      		     		      
		   }
		}
		$RubPort = -2; // ouvre docs du serveur	
	}
		
		
?>
<a href="#" name="topdoc"></a>
<STYLE type=text/css>#floater {	Z-INDEX: 1; LEFT: 0px; POSITION: relative; TOP: 0px } </STYLE>
<SCRIPT language=javascript src="js/floater.js" type=text/javascript></SCRIPT>
<table width="100%">
<tr>
<!-- Cellule de gauche ... -->
<td width="270" class="txt" valign="top">
<div id=floater>
<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="RubsPort">
<?=$bo_port_visualier_cat?>
<center>
<select name="RubPort" style="font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 11px; font-style: normal; font-weight: normal; color: #000000; line-height: normal; font-variant: normal; text-transform: none" size="1" onchange="window.document.forms['RubsPort'].submit( );">

<?	

	if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
	{		
		$StrSql = "SELECT * from portfolio_rub WHERE id__user ='".$_SESSION["ses_user_id"]."' ORDER BY portfolio_rub";
	}
	else 
	{		
		?>
			<option value='-2'<?= ($RubPort==-2?"selected":"")?>><?=$bo_port_rub_doc_serveur?></option>
			<option value='-1' <? echo ($RubPort && ( $RubPort != -1 ) )?"":"selected";?> ><?=$bo_port_rub_toute?></option>
		<?
		$StrSql = "SELECT * from portfolio_rub ORDER BY portfolio_rub";
	}
	
	$Res = mysql_query( $StrSql );
	
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
<!-- Suppression du répertoire courant ... -->
<input type="hidden" name="actiontype" value="">
<input type="image" name="delrub" src="images/icones/delete_cross.gif" alt="Supprimer la catégorie" onclick="window.document.forms['RubsPort'].actiontype.value='delrub';">
<img src="images/icones/icone_ed4.gif" alt="Nouvelle catégorie" style="cursor:pointer" onClick="window.open( 'include/inc_portfolio_popup.inc.php?Ac=newrub', '', 'toolbar=no,menubar=no,resizable=no,scrollbars=yes' );">
</form>
</center>
<!-- Gestion des images ... -->
<hr width="80%">
<center>
<?=$bo_port_gestion_images?>

</center>
<hr width="80%">
<br>
<script>
function validthem( )
{
	var f = window.document.forms['ImgAct'];

	var n = f['imgcheck'].length;
	var txt="";
	var count = 0;

	if( n > 0 )
	{
		for( i = 0; i < n; i++ )
		{
			if( f['imgcheck'][i].checked )
			{
				if( count > 0 )
					txt += ";";
				txt += f['imgcheck'][i].value;
				count++;
			}
		}		
	}
	else
	{
		if ( f['imgcheck'].checked ) {
		txt += f['imgcheck'].value;
				count++;
	}
	}
	if ( count	== 0 ) {
			alert ("<?=$bo_port_aucune_image_sel?>");
			return "";
	}	
	else {
	return txt;
}
}

function validmassethem(tot_pict)
{
	var f = window.document.forms['ImgAct'];

	var tout = 0;
	
	if ( f['rubtotal'].options[f['rubtotal'].selectedIndex].value !=0 ) { tout=1; };

	var txt="";
	var count = 0;
	
	if( tot_pict > 0 )
	{
		for( i = 0; i < tot_pict; i++ )
		{
			var nom_select = 'rubtrans_'+i;
			var nom_filename = 'filename_'+i;			
						
			if(( f[nom_select].options[f[nom_select].selectedIndex].value != 0) || tout)
			{
				txt += ";";
				//txt += f[nom_filename].value;
				txt += i;
				count++;
			}
		}		
	}
	return txt;
}


function checkMove( )
{
	window.document.forms['ImgActions'].actiontype.value='moveimg';
	window.document.forms['ImgActions']['checkedattr'].value=validthem( );
}

function checkMasseMove(tot_pict)
{
	window.document.forms['ImgAct'].actiontype.value='movemasseimg';
	window.document.forms['ImgAct']['checkedattr'].value=validmassethem(tot_pict);
	window.document.forms['ImgAct'].submit();
}


function checkDel( )
{
	var names = validthem( );
	if ( names != "" ) {
	window.open( 'include/inc_portfolio_popup.inc.php?Ac=delimg&ca=' + names, '', 'toolbar=no,menubar=no,resizable=no,scrollbars=yes' );
}
}
</script>

<!-- Effacement des images sélectionnées ... -->
</center>
<b style="color:#CC0000">Suppression d'un ou plusieurs visuels : </b><br>
<?=$bo_port_supprimer?>
&nbsp;&nbsp;&nbsp;&nbsp;
<img name="delimg" src="images/icones/delete_cross.gif" style="cursor:pointer" alt="<?=$bo_port_supprimer?>" onclick="checkDel( );">
<br><br>
<!-- Déplacement des images sélectionnées ... -->
<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="ImgActions">
<input type="hidden" name="actiontype" value="">
<input type="hidden" name="checkedattr" value="">
<Label for="catsel"><?=$bo_port_deplacer_vers?></label><br>
<select id="catsel" name="imgsto" size="1" style="font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 11px; font-style: normal; font-weight: normal; color: #000000; line-height: normal; font-variant: normal; text-transform: none">
<?	
	if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
	{		
		$StrSql = "SELECT * from portfolio_rub WHERE id__user ='".$_SESSION["ses_user_id"]."' ORDER BY portfolio_rub";
	}
	else 
	{
		$StrSql = "SELECT * from portfolio_rub ORDER BY portfolio_rub";
	}
	
	$Res = mysql_query( $StrSql );
	
	for( $i = 0; $i < mysql_num_rows( $Res ); $i++ )
	{
		$R = mysql_fetch_array( $Res, MYSQL_ASSOC );
		
		echo "<option name=\"".$R["portfolio_rub"]."\" value=\"".$R["id_portfolio_rub"]."\" ";
				
		echo " >".$R["portfolio_rub"]."</option>\n";
	}
?>
</select>
<input type="image" name="moveimg" src="images/icones/ok.gif" alt="D&eacute;placer les documents" onclick="checkMove( );" >
</form>
<!-- Upload de nouveaux documents ... -->
<br>
<b style="color:#CC0000">Enregistrement d'un visuel : </b><br>
<?=$bo_port_creer_doc_petit?> <a href="" onclick="javascript:window.open( 'include/inc_portfolio_popup.inc.php?Ac=upload', '', 'toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=300,height=400' ); return false;">Cliquez ici.</a><br /><b>Attention, la taille du visuel ne doit pas d&eacute;passer les 1.5 MO<br /><br />Les extensions autoris&eacute;es sont ".jpeg", ".jpg", ".gif", ".pdf" , ".doc", ".png"<br /></b>
<br><br>
<? if( !strcmp(_CONST_FTP_PORTOFOLIO_ENABLE,"true") ) { ?>
<?=$bo_port_creer_doc_gros?>
<a href="<? echo _CONST_FTP_PORTOFOLIO_URL; ?>" target="_blank">Via Ftp.</a>
<br>
<?=$bo_port_doc_place_ds_rub?>

<br>
<? } ?>
<center>
<br>
<hr width="80%">
<a href="#topdoc"><?=$bo_port_retour_haut?></a>
<br>
<hr width="80%">
<!--<a href="#" onclick="window.close( );" >Fermer cette fen&ecirc;tre</a> -->

</center>
</div>
</td>

<!-- Cellule de droite ... -->

<td valign="top">
<?	
	if( !isset($_REQUEST['RubPort']) || ($_REQUEST['RubPort'] == "") )
		$RubPort = -1;

	if( $RubPort > 0 )
	{
		if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
		{		
			$StrSql = "SELECT * from portfolio_rub WHERE id__user ='".$_SESSION["ses_user_id"]."' AND  id_portfolio_rub='".$RubPort."' ";
		}
		else 
		{
			$StrName = "SELECT portfolio_rub FROM portfolio_rub WHERE id_portfolio_rub='".$RubPort."'";		
		}
		
		$R = mysql_query( $StrName );
		$Name = mysql_result( $R, 0, "portfolio_rub" );
	}
	elseif( $RubPort == -1 )
	{
		$Name = $bo_port_rub_toute ;		
	}
	elseif( $RubPort == -2 )
	{
		$Name = $bo_port_rub_doc_serveur;
	}
	else
	{
		echo $bo_port_erreur_rub;
		exit( -1 );		
	}
	
	echo "<br><br><table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr><td align=\"left\" valign=\"top\"><SPAN class=\"titbleu\"><b><u>".$Name."</u></b></span>";

	if( $RubPort != -2 )
	{
		// select *, substring_index( img, '.', -1 ) AS F FROM portfolio_img ORDER BY F ASC, img ASC
		if( !isset($_REQUEST['Sort']) || ($_REQUEST['Sort'] == "") )
			$Sort = -1;
		else
			$Sort = $_REQUEST['Sort'];
		if( $RubPort && ( $RubPort >= 0 ) )
		{
			if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
			{		
				$StrSqlWhere = " WHERE id_portfolio_rub='".$RubPort."'";
			}
			else 
			{
				$StrSqlWhere = " WHERE id_portfolio_rub='".$RubPort."'";
			}
		}
		elseif($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
		{
			$StrSqlWhere = " INNER JOIN portfolio_rub ON portfolio_rub.id_portfolio_rub = portfolio_img.id_portfolio_rub
							 WHERE portfolio_rub.id__user = '".$_SESSION["ses_user_id"]."'   ";
		}


		switch( $Sort )
		{
		case 0:
			$StrSqlImg = "SELECT * FROM portfolio_img ".$StrSqlWhere." ORDER BY portfolio_img ASC";
			break;	
		case 1:
			$StrSqlImg = "SELECT * FROM portfolio_img ".$StrSqlWhere." ORDER BY portfolio_img DESC";
			break;
		case 2:
			$StrSqlImg = "SELECT *, SUBSTRING_INDEX( img, '.', -1 ) AS F FROM portfolio_img ".$StrSqlWhere." ORDER BY F ASC, img ASC";
			break;
		case 3:
			$StrSqlImg = "SELECT *, SUBSTRING_INDEX( img, '.', -1 ) AS F FROM portfolio_img ".$StrSqlWhere." ORDER BY F DESC, img DESC";
			break;
		default:
			$StrSqlImg = "SELECT * FROM portfolio_img ".$StrSqlWhere." ORDER BY id_portfolio_img ASC";
			break;
		}
//		echo $StrSqlImg;
		$ResImg = mysql_query( $StrSqlImg );
		
		// Affichage du nombre de fichiers de la rubrique 
		echo "<span class=\"txt\">  - ".mysql_num_rows( $ResImg )." fichier(s)";
		
		
		// Récupération des données de la table portfolio_img et calcul
		// de la taille des fichiers et de la taille globale.
		$Size = 0;
		$Results = array( );
		$z = 0;
			
		for( $j = 0; $j < mysql_num_rows( $ResImg ); $j++ )
		{
			$RImg = mysql_fetch_array( $ResImg, MYSQL_ASSOC );
			
			$Results[$z] = $RImg;
			
			$ImgSrc = _CONST_PORTFOLIO_PATH.$RImg["img"];
			
			$s = filesize( $ImgSrc );
			if( $s )
			{
				$Results[$z]["filesize"] = $s;
				$Size += $s;
			}
			else
				$Results[$z]["filesize"] = 0;
			
			$z++;
		}
		
		
		// Conversion de la taille globale des fichiers en l'unité correspondante.
		// Rappel : 1ko = 1024 octets, 1Mo = 1024ko, etc...
		$ext = 0;
		$ext_array = array( "o", "Ko", "Mo", "Go", "To" );
		while( $Size >= 1024 )
		{
			$Size /= 1024;
			$ext++;
		}
		
		// Affichage de la taille sur disque.
		$Sf = sprintf( "%01.2f", $Size );
		echo " - Taille : ".$Sf." ".$ext_array[$ext]."</span></td>";
?>		
		<td align="right" valign="top" >
		<?=$bo_port_tri_par?>
		<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="Sorting" >
		<input type="hidden" name="RubPort" value="<?echo $RubPort;?>">
		<select name="Sort" size="1" onchange="submit( );">
		<option value='-1'><?=$bo_port_tri_defaut?></option>
		<option value='0'><?=$bo_port_tri_label_crois?></option>
		<option value='1'><?=$bo_port_tri_label_decrois?></option>
		<option value='2'><?=$bo_port_tri_ext_crois?></option>
		<option value='3'><?=$bo_port_tri_ext_decrois?></option>
		<option value='4'><?=$bo_port_tri_taille_crois?></option>
		<option value='5'><?=$bo_port_tri_taille_decrois?></option>
		</select>
		</form>
		</td></tr></table>
		<br>
<?		
		if( $Sort > 3 )
			sortResults( $Results, $Sort );



		// Affichage des documents de la rubrique dans une table sur 3 colones.
		echo "<table width=\"100%\" cellspacing=\"10\" cellpadding=\"10\" border=\"1\">\n<tr>\n";
		$k = 0;
?>	
		<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="ImgAct">
<?		
		for( $j = 0; $j < count( $Results ); $j++ )
		{
			$RImg = $Results[$j];
			
			// Récupération des attributs de l'image (cf. fonction).
			$ImgAtt = getthumb( $RImg["img"] );
			
			// Si la largeur de l'image est supérieure à 50, on contraint sa largeur.
			if( $ImgAtt[3] > 50 )
				$Width = 50;
			else
				$Width = $ImgAtt[3];
				
			// Affichage de l'image correspondant au doc.
			echo "<td valign=\"bottom\" align=\"center\" class=\"txt\">";
?>
			<img src="<? echo $ImgAtt[2]; ?>" width="<? echo $Width; ?>" style="cursor:pointer" alt="Voir le document" onclick="javascript:window.open( '<?echo $ImgAtt[7];?>', '', 'toolbar=no,menubar=no,resizable=yes,width=<?echo ( ( $s = @getimagesize( $ImgAtt[8] ) )?$s[0] + 25:800 );?>, height=<?echo ( ( $s = @getimagesize( $ImgAtt[8] ) )?$s[1] + 25:600 );?>' );" >
<?			echo "<input type=\"checkbox\" name=\"imgcheck\" value=\"".$RImg["id_portfolio_img"]."\">";			
			
			// Affichage de la légende du document 
			if( $RImg["portfolio_img"] )
				echo "<br>".$RImg["portfolio_img"];
			else
				echo "<br>Pas de description";
			
			// Icônes d'édition et de visualisation du doc.
?>
			<img src="images/icones/icone_ed10.gif" style="cursor:pointer" alt="Modifier le nom de l'image" onclick="javascript:window.open( 'include/inc_portfolio_popup.inc.php?Ac=modlabel&idimg=<?echo $RImg["id_portfolio_img"];?>', '', 'toolbar=no,menubar=no,resizable=no,scrollbars=yes' );">
			<img src="images/icones/icone_view.gif" style="cursor:pointer" alt="Voir le document" onclick="javascript:window.open( '<?echo $ImgAtt[7];?>', '', 'toolbar=no,menubar=no,resizable=yes,width=<?echo ( ( $s = @getimagesize( $ImgAtt[8] ) )?$s[0] + 25:800 );?>, height=<?echo ( ( $s = @getimagesize( $ImgAtt[8] ) )?$s[1] + 25:600 );?>' );" >
			<br>
<?
			// Affichage du nom du document.
			echo "<br>".$ImgAtt[1]."<br>";
			
			// Affichage des dimensions si le document est une image.
			if( $ImgAtt[0] != -1 )
				echo "w : ".$ImgAtt[3]."px - h : ".$ImgAtt[4]."px<BR>";
	
			// Affichage de la taille du fichier converti en l'unité adéquate.
			if( $S = $RImg["filesize"] )
			{
				$ext = 0;
				$ext_array = array( "o", "Ko", "Mo", "Go", "To" );
				while( $S >= 1024 )
				{
					$S /= 1024;
					$ext++;
				}
				$Sf = sprintf( "%01.2f", $S );
				echo "Taille : ".$Sf." ".$ext_array[$ext];
			}
			
			echo"</td>\n";
			
			// Si on a plus de 3 colones, on ferme la rangée et on en commence une autre.
			if( $k >= 2 )
			{
				$k = 0;
				echo "</tr><tr>";
			}
			else
				$k++;
		}
?>
		</form>
<?
		
	}
// DOCUMENTS DU SERVEUR 
	else
	{
?>
		<form method="POST" action="<?echo $_SERVER['REQUEST_URI'];?>" name="ImgAct">
		<input type="hidden" name="actiontype" value="">
		<input type="hidden" name="checkedattr" value="">
<?		
		$SqlFiles = "SELECT img FROM portfolio_img ORDER BY img";
		$R = mysql_query( $SqlFiles );
		
		$Af = array( );
		$i = 0;
		
		while( $Row = mysql_fetch_array( $R, MYSQL_ASSOC ) )
		{
			$Af[$i] = ( $Row["img"] );
			$i++;
		}
		
		clearstatcache();
		
		$d = opendir( _CONST_PORTFOLIO_UPLOAD_PATH );
		
		if ($compteur_dep) echo("<b><font color=red>- ".$compteur_dep.$bo_port_nb_file_moved."</font></b><br>");
?>		
		<table width="50%" align="left">
<?		
		$tot_pict=0;
		
		while (false !== ($f = readdir($d))) 
		{						
			if( strcmp( $f, "." ) && strcmp( $f, ".." ))
			{
				if( !isInArray( $f, $Af ) )
				{
					echo "<tr><td>";					
					if (!is_dir(_CONST_PORTFOLIO_UPLOAD_PATH.$f))
					{
					   echo $f;
					   echo "</td><td width=\"5%\"><img src=\"images/icones/icone_ed4.gif\" style=\"cursor:pointer\" alt=\"Ajouter à la biblioth&egrave;que\" onclick=\"javascript:window.open( 'include/inc_portfolio_popup.inc.php?Ac=add2lib&fn=$f', '', 'toolbar=no,menubar=no,resizable=no,scrollbars=yes' );\">";
					   echo "</td><td width=\"5%\"><img src=\"images/icones/icone_view.gif\" style=\"cursor:pointer\" alt=\"Voir le document\" onclick=\"window.open( '"._CONST_PORTFOLIO_PATH.$f."' );\" >";
					   echo("<td>&nbsp;&nbsp;</td><td>");
					   ?>
					   <select name="rubtrans_<?= $tot_pict ?>" style="font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 11px; font-style: normal; font-weight: normal; color: #000000; line-height: normal; font-variant: normal; text-transform: none" size="1">
					   <option value="0">----------------------------</option>
<?	
					if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
					{		
						$StrSql = "SELECT * from portfolio_rub WHERE id__user ='".$_SESSION["ses_user_id"]."' ORDER BY portfolio_rub";
					}
					else 
					{
						$StrSql = "SELECT * from portfolio_rub ORDER BY id_portfolio_rub";
					}
	
					$Res = mysql_query( $StrSql );
	
					for( $i = 0; $i < mysql_num_rows( $Res ); $i++ )
					{
						$R = mysql_fetch_array( $Res, MYSQL_ASSOC );
		
						echo "<option name=\"".$R["portfolio_rub"]."\" value=\"".$R["id_portfolio_rub"]."\" ";									
						echo " >".$R["portfolio_rub"]."</option>\n";
					}
?>
					</select><input type="hidden" name="filename_<?= $tot_pict ?>" value="<?= $f ?>">
					<?
					   $tot_pict++;	
					}
					else
					{
					   echo "(<b><i>".$f."</b></i>)";
					}
																
					echo "</td></tr>";
				}
			}		   
		}
		closedir($d);

   if ($tot_pict>0) { 
?>
		<tr>
		   <td colspan=4><br><br><?=$bo_port_doc_moved_cat?></td>
		   <td>
		   <select name="rubtotal" style="font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 11px; font-style: normal; font-weight: normal; color: #000000; line-height: normal; font-variant: normal; text-transform: none" size="1">
					   <option value="0">----------------------------</option>
<?	

					if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
					{		
						$StrSql = "SELECT * from portfolio_rub WHERE id__user ='".$_SESSION["ses_user_id"]."' ORDER BY id_portfolio_rub";
					}
					else 
					{
						$StrSql = "SELECT * from portfolio_rub ORDER BY id_portfolio_rub";
					}
	
					$Res = mysql_query( $StrSql );
	
					for( $i = 0; $i < mysql_num_rows( $Res ); $i++ )
					{
						$R = mysql_fetch_array( $Res, MYSQL_ASSOC );
		
						echo "<option name=\"".$R["portfolio_rub"]."\" value=\"".$R["id_portfolio_rub"]."\" ";									
						echo " >".$R["portfolio_rub"]."</option>\n";
					}
?>
					</select>
		   </td>
		</tr>
		<tr>		 
		   <td colspan=5 align="right">
		      <br><br><input type="button" onClick="checkMasseMove(<?= $tot_pict ?>)" value=">> Mise à jour de masse">
		   </td>
		</tr>
<?  
		}
		else
		{			
?>
		<tr>		 
		   <td colspan=5 align="center"><br>Aucun fichier / image dans cette cat&eacute;gorie
		      <br><br>
		   </td>
		</tr>
<?
	}
?>
		</table></td>
<?
	}
	echo "</tr>\n</table></form>\n";



	function getthumb( $im )
	{
		$ImgSrc = _CONST_PORTFOLIO_PATH.$im;
		
		if( $i = @getimagesize( _CONST_PORTFOLIO_UPLOAD_PATH.$im ) )
		{
			$Res = array( 0, $im, $ImgSrc, $i[0], $i[1], $i[2], $i[3], $ImgSrc, _CONST_PORTFOLIO_UPLOAD_PATH.$im );
		}
		else
		{
			$end = strrchr( $im, "." );
			
			if( $end == ".pdf" )
			{
				$A = getimagesize( _PATH_TO_APPLI."admin/images/icones_explorer/icone_pdf.gif" );				
				
				$Res = array( -1, "<a href=\""._CONST_PORTFOLIO_PATH.$im."\" target=\"_blank\">PDF Document</a> :<br>".$im, "images/icones_explorer/icone_pdf.gif", 16, $A[1], $A[2], 16, $ImgSrc, _CONST_PORTFOLIO_UPLOAD_PATH.$im );
			}
			elseif( $end == ".xls" )
			{				
				$A = getimagesize( _PATH_TO_APPLI."admin/images/icones_explorer/icone_xls.gif" );				
				
				$Res = array( -1, "<a href=\""._CONST_PORTFOLIO_PATH.$im."\" target=\"_blank\">MS Excel Document</a> :<br>".$im, "images/icones_explorer/icone_xls.gif", 16, $A[1], $A[2], $A[3], $ImgSrc, _CONST_PORTFOLIO_UPLOAD_PATH.$im );
			}
			elseif( $end == ".doc" )
			{				
				$A = getimagesize( _PATH_TO_APPLI."admin/images/icones_explorer/icone_doc.gif" );				
				
				$Res = array( -1, "<a href=\""._CONST_PORTFOLIO_PATH.$im."\" target=\"_blank\">MS Word Document</a> :<br>".$im, "images/icones_explorer/icone_doc.gif", 16 , $A[1], $A[2], $A[3], $ImgSrc, _CONST_PORTFOLIO_UPLOAD_PATH.$im );
			}			
			elseif( $end == ".ppt" )
			{				
				$A = getimagesize( _PATH_TO_APPLI."admin/images/icones_explorer/icone_ppt.gif" );				
				
				$Res = array( -1, "<a href=\""._CONST_PORTFOLIO_PATH.$im."\" target=\"_blank\">MS Powerpoint Document</a> :<br>".$im, "images/icones_explorer/icone_ppt.gif", 16 , $A[1], $A[2], $A[3], $ImgSrc, _CONST_PORTFOLIO_UPLOAD_PATH.$im );
			}			
			elseif( $end == ".zip" )
			{				
				$A = getimagesize( _PATH_TO_APPLI."admin/images/icones_explorer/icone_zip.gif" );				
				
				$Res = array( -1, "<a href=\""._CONST_PORTFOLIO_PATH.$im."\" target=\"_blank\">WinZip Archive</a> :<br>".$im, "images/icones_explorer/icone_zip.gif", 16 , $A[1], $A[2], $A[3], $ImgSrc, _CONST_PORTFOLIO_UPLOAD_PATH.$im );
			}
			else
			{
				$A = getimagesize( _PATH_TO_APPLI."admin/images/icones_explorer/icone_no_ext_pt.gif" );
				$Res = array( -1, "<a href=\""._CONST_PORTFOLIO_PATH.$im."\" target=\"_blank\">Unknown Document</a> :<br>".$im, "images/icones_explorer/icone_no_ext_pt.gif", 16 , $A[1], $A[2], $A[3], $ImgSrc, _CONST_PORTFOLIO_UPLOAD_PATH.$im );
			}
		}

		return $Res;
	}
	
	
	
	function sortResults( &$table, $order )
	{
		bubblesort( $table, "filesize", $order );
	}
	
	
	function bubbleSort( &$a, $col, $order )
	{
		for( $j = count( $a ) - 1; $j > 0; $j-- )
		{
			for( $i = 0; $i < $j ; $i++ )
			{
				if( $order == 4 )
				{
					if( $a[$i][$col] > $a[$i + 1][$col] )
					{
						$t = $a[$i];
						$a[$i] = $a[$i + 1];
						$a[$i + 1] = $t;
					}
				}
				elseif( $order == 5 )
				{
					if( $a[$i][$col] < $a[$i + 1][$col] )
					{
						$t = $a[$i];
						$a[$i] = $a[$i + 1];
						$a[$i + 1] = $t;
					}
				}
			}
		}
	}


	function isInArray( $needle, $array )
	{
		foreach( $array as $key => $val )
		{
			if( !strcmp( $val, $needle ) )
				return true;
		}
		
		return false;
	}
?>
</td>
</tr>

</table>

</body>
</html>
