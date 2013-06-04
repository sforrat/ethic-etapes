<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN"><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?

//--------------
//Gestion du titre de la page
//--------------
if ($PageTitre) {
	$PageTitre = $StyleName." : ".$PageTitre." &gt; ".ucfirst(bo_strip_pre_suf($item))."s";
}
else {
	$PageTitre = $StyleName;
}
?>
<title> 
<?echo $PageTitre;?>
</title>
<link rel="SHORTCUT ICON" href="icone.ico" type="text/css">
<!--<link rel="STYLESHEET" href="../css/style.css" type="text/css">-->
<link rel="STYLESHEET" href="css/css.php" type="text/css">
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/swfobject.js" type="text/javascript"></script>
<script language="JavaScript1.2" src="js/lib_menu.js"></script>
<script type="text/javascript" language="javascript" src="js/lib_javascript.js"></script>
<script type="text/javascript" language="javascript" src="js/form_validation.js"></script>
<script type="text/javascript" language="javascript" src="js/message.js"></script>
<script language="javascript" src="calendar/AnchorPosition.js"></script>
<script language="javascript" src="calendar/PopupWindow.js"></script>
<script language="javascript" src="calendar/date.js"></script>
<script language="javascript" src="calendar/CalendarPopup.js"></script>
<script language="javascript">document.write(getCalendarStyles());</script>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #CC0000;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #CC0000;
}
.style5 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; color: #CC0000; }
.style8 {font-size: 16px}
.style10 {
	font-size: 16px;
	color: #CC0000;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style11 {
	color: #CC0000
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>
<body bgcolor="white" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
	<td colspan="3">
		<table style="background:url(images/skins/<?=$ImgFond?>)" background="images/skins/<?=$ImgFond?>" width="100%" border="0" cellspacing="0" cellpadding="0">
		<?
		//Onprend la taille la plus grande entre les deux images
		if ($ImgLogoInfo[1]>=$ImgBandeauHautRightInfo[1]) {
		$BandeauHeight = $ImgLogoInfo[1];	
		}
		else {
		$BandeauHeight = $ImgBandeauHautRightInfo[1];	
		}

		//Si il n'y a pas de photo pour l'entete des pages on affiche pas la ligne du tableau
		if ($ImgLogo || $ImgBandeauHautRight) {
			?>
		  <tr> 
			<td valign="top"><a href="../" target="_blank"><?=@TestPicture($ImgLogo, "images/skins/", $bo_inc_header_acces_website, "none", "none")?></a></td>
			<td align="right" valign="top"><?=@TestPicture($ImgBandeauHautRight, "images/skins/", "", "none", "none")?></td>
		  </tr>
		  <?
		}			
			?>
		  <tr> 
			<td valign="top" colspan="2"> 
			  <?
		if ($DisplayMode=="PopUp") {//Affichage des menus deroulant
			?>
			  <table border="0" cellspacing="0" cellpadding="2" width="100%" bgcolor="<?echo $MenuTableBgColor;?>">
				<tr> 
				  <td bgcolor="<?echo $MenuBgColor;?>">&nbsp;</td>
				</tr>
			  </table>
			  <?
		}
		else {
			//Inclusion des menus
			//Si page differente de la page de login (index.php)
			if (NomFichier($_SERVER['PHP_SELF'],0) != "index.php") {
				include "include/inc_menu.php";
			}
		}
			?>
			</td>
		  </tr>
		</table>
	</td>
  </tr>

  <tr>
  <td colspan="3"  bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>">
	<? 
        //BARRE DE MENUS
        get_bo_toolbar_separateur();
        if ($_SESSION['ses_profil_user']==1 && $DisplayMode!="PopUp") {
            include "include/inc_toolbar_admin.inc.php";
        }
        ?> 
        <table cellpadding="2" border="0" cellspacing="0" width="900">
        <tr>
        <? 
        if ($_SESSION['ses_profil_user'] && $DisplayMode!="PopUp") {
        ?>
            <td valign=bottom width=230><?include "include/inc_toolbar_tools.inc.php";?></td>
        <?
        }
        
				if ($_SESSION['ses_profil_user'] && $DisplayMode!="PopUp") {      
        	$StrSQL = "SELECT count(*) FROM _langue ";
	if( mysql_result(mysql_query($StrSQL),0,0) > 1) { ?>
	        <td valign=bottom align="right" ><?include "include/inc_toolbar_langue.inc.php";?></td>
<?      }
        }
        ?>
        </tr>
        </table>
        <?

        ?>
  </td>
  </tr>
  <!--<tr> 
    <td colspan="3">

    </td>
  </tr>-->
  <? 
	if ($TableDef && isset($_SESSION['ses_profil_user'])) {
		$bgcolor_td = "bgcolor=\"".get_inter_color($MenuBgColor,0.5)."\"";
	}
	else {
		$bgcolor_td = "";
	}
  ?>
  <tr> 
    <td valign="top" width="1%" <?=$bgcolor_td?>>
		<? 

		if (isset($_SESSION['ses_profil_user']) && $DisplayMode!="PopUp") {
			if ($punaise_value==1) {
				if ($_SESSION['ses_punaise_value']==0) {
					$ic = "on";
					$ic2 = "on";
					$view_punaise = "";
					$view_menu_left = "";
				}
			}
			else {
				if ($punaise_value == 0) {
					$ic = "off";
					$ic2 = "off";
					$view_punaise = "style=\"display:none\"";
					$view_menu_left = "style=\"display:none\"";
				}
			}
		?>
		<table border="0" cellpadding="0" cellspacing="1" bgcolor="<?=get_inter_color($MenuBgColor,1)?>" width="10">
			<tr>
				<td align="right" bgcolor="<?=get_inter_color($MenuBgColor,0.65)?>">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td width="90%" align="right">
              <? 
                if($_SESSION['ses_profil_user'] != _PROFIL_CENTRE){
              ?>
              <a href="javascript:show_item('bo_menu_left');show_item('punaise');"><img onclick="switch_picture(this, this.src)" src="images/fl_<?=$ic2?>.gif" name="img_view_menu" border="0"></a></td>
							<? }?><td>
								<table border="0" cellpadding="0" cellspacing="0" width="100%" id="punaise" <?=$view_punaise?>>
									<tr>
										<td><img src="images/traitv.gif"  border="0" alt=""></td>
											<form method=post action="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']?>" name="form_punaise">
										<td>
												<input type="hidden" name="punaise_value" value="<?=$punaise_value?>"><a href="javascript:document.form_punaise.submit();"><img onclick="switch_picture(this, this.src)" src="images/icones/pun_<?=$ic?>.gif" name="img_pun" border="0"></a>
										</td>
											</form>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr id="bo_menu_left" <?=$view_menu_left?>>
			<td bgcolor="<?=get_inter_color($MenuBgColor,0.4)?>" width="250">
		<? 
			//Insertion de la page contenant les infos propres au site
			//if ($_SESSION['ses_profil_user']==1 && $Home==1) {
			//	include "include/inc_info.inc.php";
			//}
			//include "include/inc_info.inc.php";
			//echo "<br>";

			get_arbo(1, "&nbsp;&nbsp;",0,$arr_user_nav_right,get_inter_color($MenuBgColor,0.8),3,0,1);
		?>
				</td>
			</tr>
		</table>
		<? 
		}
		?>
	</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="95%" valign="top">

        <table cellspacing="10" cellpadding="0" border="0" width="100%">
            <tr>
                <td>

                    <? 
                    //Affiche la barre d'outils contenant le chemin de fer
                    if ($DisplayMode!="PopUp") {
                        include "include/inc_toolbar_option.inc.php";
                    }
                    ?>
                    
                    <br>
