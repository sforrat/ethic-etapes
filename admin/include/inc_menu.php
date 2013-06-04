<?
//Ratio pour la position haute du menu
//En fonction de la taille de la police
if ($FontSize==11) {
	$FontRatio = -1;
}
elseif ($FontSize==12) {
	$FontRatio = 2;
}
elseif ($FontSize==13) {
	$FontRatio = 3;
}

$HauteurMenu = $BandeauHeight + ($FontSize*2)-$FontRatio;


$StrSQL = "
			select "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu_1,"._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil,"._CONST_BO_CODE_NAME."table_def.item,menu_width,menu_title,"._CONST_BO_CODE_NAME."menu,cur_table_name,id_"._CONST_BO_CODE_NAME."table_def, "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu 
			from "._CONST_BO_CODE_NAME."table_def, "._CONST_BO_CODE_NAME."menu , "._CONST_BO_CODE_NAME."profil
			where "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu = "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."menu
			and "._CONST_BO_CODE_NAME."profil.id_"._CONST_BO_CODE_NAME."profil = "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil
			and "._CONST_BO_CODE_NAME."menu.afficher=1
            and "._CONST_BO_CODE_NAME."table_def.display_on_menu=1
            ";
//Affichage des menu associes a l'utilisateur
if ($_SESSION['ses_profil_user']!=1) {//Si user n'est pas administrateur, alors retriction des menus
//	$StrSQL .= " and "._CONST_BO_CODE_NAME."profil.id_"._CONST_BO_CODE_NAME."profil = ".$_SESSION['ses_profil_user'];
	$StrSQL .= "
			and (
				"._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil = '".$_SESSION['ses_profil_user']."'
			or
				"._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil like('%,".$_SESSION['ses_profil_user']."') 
			or 
				"._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil like('%,".$_SESSION['ses_profil_user'].",%')
			or
				"._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil like('".$_SESSION['ses_profil_user'].",%')
			)
	";

}

//echo get_sql_format($StrSQL." group by "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu order by "._CONST_BO_CODE_NAME."menu.ordre");

$RstMenuProfil = mysql_query($StrSQL." group by "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu order by "._CONST_BO_CODE_NAME."menu.ordre,"._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu  ");

?>
<script language="JavaScript">
<!--
function fwLoadMenus() {
<?
	for ($i=1;$i<=@mysql_num_rows($RstMenuProfil);$i++) {
		$ArrayMenuChilds	= split(",",@mysql_result($RstMenuProfil,$i-1,""._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu_1"));

		//Childs Menu
		for ($k=0; $k<count($ArrayMenuChilds) ;$k++) {
			$rst_menu_child = mysql_query("Select * from "._CONST_BO_CODE_NAME."menu where id_"._CONST_BO_CODE_NAME."menu=".$ArrayMenuChilds[$k]);
			
			$MenuTitle  = @mysql_result($rst_menu_child,0,""._CONST_BO_CODE_NAME."menu");
			$MenuWidth  = @mysql_result($rst_menu_child,0,"menu_width");

			echo "	if (window.MnChild_".$i."_".$k.") return;\n";
			echo "		window.MnChild_".$i."_".$k." = new Menu(\"".$MenuTitle."\",".intval($MenuWidth-50).",20);\n";

			$rst_menu_child_item = mysql_query("Select * from "._CONST_BO_CODE_NAME."table_def where id_"._CONST_BO_CODE_NAME."menu=".$ArrayMenuChilds[$k]." order by ordre_menu, menu_title");
			
			for ($l=0; $l<@mysql_num_rows($rst_menu_child_item) ;$l++) {
				$MenuTitle			= @mysql_result($rst_menu_child_item,$l,"menu_title");
				$BoCat				= @mysql_result($rst_menu_child_item,$l,""._CONST_BO_CODE_NAME."menu");
				$CurTableName		= @mysql_result($rst_menu_child_item,$l,"cur_table_name");
				$id_BoTableDef		= @mysql_result($rst_menu_child_item,$l,"id_"._CONST_BO_CODE_NAME."table_def");
				$ITEM				= @mysql_result($rst_menu_child_item,$l,"item");

				if ($CurTableName == "none") {
					$MenuLien = "bo_include_launcher.php?file=".$ITEM."&TableDef=".$id_BoTableDef;
				}
				else {
					$MenuLien = "bo.php?TableDef=".$id_BoTableDef;
				}

				//Indice
				//intval($l+1).". ".
				echo "		MnChild_".$i."_".$k.".addMenuItem(\"".bo_strip_pre_suf($MenuTitle)."\",\"location='$MenuLien'\");\n";
			}

			
			//$hsv = get_hsv_color($ActiveItemColor);
			//if ($hsv[2]>80) {
				$txt_color = "white";
			//}
			//else {
			//	$txt_color = "black";
			//}
			

			echo "		MnChild_".$i."_".$k.".fontFamily			= '$FontType';\n";
			echo "		MnChild_".$i."_".$k.".fontSize				= '$FontSize';\n";
			echo "		MnChild_".$i."_".$k.".menuBorder			= 1;\n";
			echo "		MnChild_".$i."_".$k.".menuItemBorder		= 0;\n";
			echo "		MnChild_".$i."_".$k.".fontColor				= '".$txt_color."';\n";
			echo "		MnChild_".$i."_".$k.".fontColorHilite		= '".get_inter_color($MenuFontColor,0.9)."';\n";
			echo "		MnChild_".$i."_".$k.".menuItemBgColor		= '".get_inter_color($ActiveItemColor,0.8)."';\n";
			echo "		MnChild_".$i."_".$k.".menuHiliteBgColor		= '".get_inter_color($MenuBgColor,0.9)."';\n";
			echo "		MnChild_".$i."_".$k.".menuLiteBgColor		= 'black';\n";
			echo "		MnChild_".$i."_".$k.".menuBorderBgColor		= 'white';\n";
			echo "		MnChild_".$i."_".$k.".menuContainerBgColor	= '$MenuBgColor';\n";
			echo "		MnChild_".$i."_".$k.".bgColor				= '$MenuTableBgColor';\n";

		}

		$MenuWidth			= @mysql_result($RstMenuProfil,$i-1,"menu_width");

		echo "	if (window.Mn$i) return;\n";
		echo "		window.Mn$i = new Menu(\"root\",$MenuWidth,20);\n";


		echo "		Mn$i.fontFamily				= '$FontType';\n";
		echo "		Mn$i.fontSize				= '$FontSize';\n";

		echo "		Mn$i.menuBorder				= 0;\n";
		echo "		Mn$i.menuItemBorder			= 0;\n";

		echo "		Mn$i.fontColor				= 'white';\n"; //$MenuFontColor
		echo "		Mn$i.fontColorHilite		= '$MenuFontColor';\n"; //$ActiveItemColorLight

		echo "		Mn$i.menuItemBgColor		= '$ActiveItemColor';\n"; //Couleur Fond par defaut
		echo "		Mn$i.menuHiliteBgColor		= '$MenuBgColor';\n";

		echo "		Mn$i.menuLiteBgColor		= 'black';\n";
		echo "		Mn$i.menuBorderBgColor		= 'white';\n"; //Cadre menu haut et gauche
		echo "		Mn$i.menuContainerBgColor	= '$MenuBgColor';\n";
		echo "		Mn$i.bgColor				= '$MenuTableBgColor';\n";


		//Affichage des MenuChilds
		if ($ArrayMenuChilds[0]!=1 && count($ArrayMenuChilds)>0) {
			for ($k=0; $k<count($ArrayMenuChilds) ;$k++) {
				echo "		Mn$i.addMenuItem(MnChild_".$i."_".$k.");\n";
			}
		}


		$StrSQL2 = $StrSQL. " and "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu=".@mysql_result($RstMenuProfil,$i-1,""._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu")." order by "._CONST_BO_CODE_NAME."menu.ordre,"._CONST_BO_CODE_NAME."table_def.ordre_menu, "._CONST_BO_CODE_NAME."table_def.menu_title";

		//echo get_sql_format($StrSQL2);
		$RstBoTableDef = mysql_query($StrSQL2);
	
		for ($j=1;$j<=@mysql_num_rows($RstBoTableDef);$j++) {

			$MenuTitle			= @mysql_result($RstBoTableDef,$j-1,"menu_title");
			$BoCat				= @mysql_result($RstBoTableDef,$j-1,""._CONST_BO_CODE_NAME."menu");
			$CurTableName		= @mysql_result($RstBoTableDef,$j-1,"cur_table_name");
			$id_BoTableDef		= @mysql_result($RstBoTableDef,$j-1,"id_"._CONST_BO_CODE_NAME."table_def");
			$ITEM				= @mysql_result($RstBoTableDef,$j-1,"item");

			if ($CurTableName == "none") {
				$MenuLien = "bo_include_launcher.php?file=".$ITEM."&TableDef=".$id_BoTableDef;
			}
			else {
				$MenuLien = "bo.php?TableDef=".$id_BoTableDef;
			}
			
			
			//if ($debug_mode == 1 && $_SESSION['ses_profil_user']==1) {
			//	$get_media_info = get_info_from_table_annexe($BaseName,$CurTableName, $MenuBgColor , $ActiveItemColor);

			//	if ( $get_media_info[0] == "") {
			//		$border_color = "";
			//	}
			//	else {
			//		$border_color = "bgcolor='white'";
			//	}

			//	echo "		Mn$i.addMenuItem(\"<table cellpadding='0' cellspacing='0' border='0'><tr><td align='center' valign='center'><table align='left' title=".($get_media_info[1])." cellpadding='0' cellspacing='1' border='0' ".$border_color."><tr><td bgcolor='".$get_media_info[0]."'><img src='images/pixtrans.gif' width='11' height='11' border='0'></td></tr></table></td><td><table cellpadding='0' cellspacing='0' border='0'><tr><td style=color:white>&nbsp;&nbsp;".$MenuTitle."</td></tr></table></td></table>\",\"location='$MenuLien'\");\n";
			//}
			//else {
				echo "		Mn$i.addMenuItem(\"$j. ".bo_strip_pre_suf($MenuTitle)."\",\"location='$MenuLien'\");\n";
			//}
		}
		unset($ITEM);
	}


if (@mysql_num_rows($RstMenuProfil)>=1) {
	echo "  Mn1.writeMenus();";
}
?>
} // fwLoadMenus()

//-->
</script>
<script language="JavaScript1.2">fwLoadMenus();</script>

      <table border="0" cellspacing="0" cellpadding="2" width="100%" bgcolor="<?echo $MenuTableBgColor;?>">
        <tr height="23"> 
          <?
$StrSQL = "
			select "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil, menu_width,menu_title,"._CONST_BO_CODE_NAME."menu,cur_table_name,id_"._CONST_BO_CODE_NAME."table_def, "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu , "._CONST_BO_CODE_NAME."profil."._CONST_BO_CODE_NAME."profil
			from "._CONST_BO_CODE_NAME."table_def, "._CONST_BO_CODE_NAME."menu , "._CONST_BO_CODE_NAME."profil
			where "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu = "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."menu
			and "._CONST_BO_CODE_NAME."profil.id_"._CONST_BO_CODE_NAME."profil = "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil
			and "._CONST_BO_CODE_NAME."menu.afficher=1
            and "._CONST_BO_CODE_NAME."table_def.display_on_menu=1
		";

//Affichage des menu associes a l'utilisateur


if ($_SESSION['ses_profil_user']!=1) {//Si user n'est pas administrateur, alors retriction des menus
	//$StrSQL .= " and "._CONST_BO_CODE_NAME."profil.id_"._CONST_BO_CODE_NAME."profil = ".$_SESSION['ses_profil_user'];

	$StrSQL .= "
			and (
				"._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil = '".$_SESSION['ses_profil_user']."'
			or
				"._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil like('%,".$_SESSION['ses_profil_user']."') 
			or 
				"._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil like('%,".$_SESSION['ses_profil_user'].",%')
			or
				"._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil like('".$_SESSION['ses_profil_user'].",%')
			)
	";

}

//echo $StrSQL."Group By "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu order by "._CONST_BO_CODE_NAME."menu.ordre";
$RstBoCat = mysql_query($StrSQL." Group By "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu order by "._CONST_BO_CODE_NAME."menu.ordre,"._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu  ");

$MenuLeft = 0;

?> 
	<script>
	function Td_startTimeout(Obj,Color1,Color2) {

		MonId = Obj.split("_");
		for (i=1;i<<?=intval(@mysql_num_rows($RstBoCat)+1)?>;i++) {
			if (eval(MonId[1])!=i) {
				//setTimeout('Rtest("'+'TdMenu_'+i+'","'+Color1+'","'+Color2+'")', 2000);
				Rtest('TdMenu_' + i, Color1, Color2);
			}
		}
	}
	function Rtest(Obj,Color1,Color2) {
		//MDI 21/08/08 correction pour firefox
		if (document.all) {
			document.all[Obj].style.backgroundColor=Color1;
			document.all[Obj].style.color=Color2;
		} else {
			document.getElementById(Obj).style.backgroundColor=Color1;
			document.getElementById(Obj).style.color=Color2;			
		}		
			
	}
	</script>

<?

for ($i=1;$i<=@mysql_num_rows($RstBoCat);$i++) {
	$BoCat		= @mysql_result($RstBoCat,$i-1,""._CONST_BO_CODE_NAME."menu");
	$MenuWidth	= @mysql_result($RstBoCat,$i-1,"menu_width");

	$NbPixCar = 6; //La multiplication est un rapport largeur par caractere

	$BoCat = "     ".$BoCat;

	$TdWidth = strlen(GetTxtFromHtml($BoCat))*$NbPixCar;

	$WidthMin = 100; // Largeur mini des td menu
	if ($TdWidth<$WidthMin) {
		$TdWidth = $WidthMin;
	}
	?> 
	<td width="<?=$TdWidth?>" id="TdMenu_<?=$i?>" onMouseOut="FW_startTimeout();Td_startTimeout('TdMenu_<?=$i?>','<?=ereg_replace("#","",$MenuBgColor)?>','<?=ereg_replace("#","",$MenuFontColor)?>');" onMouseOver="window.FW_showMenu(window.Mn<?=$i?>, <?=$MenuLeft?>, <?=$HauteurMenu?>);this.style.cursor='default';this.style.backgroundColor='<?=$ActiveItemColor?>';this.style.color='white'" bgcolor="<?=$MenuBgColor?>" style="font-weight:bold;color:<?=$MenuFontColor?>">&nbsp;<?=$BoCat?></td>
	<?
	$MenuLeft += $TdWidth+4;
}
	?>
          <td align="right" bgcolor="<?echo $MenuBgColor;?>" style="color:<?echo $MenuFontColor;?>"> 
            <?
//Affichage du nom Utilisateur
if ($_SESSION['ses_trig_user']) {
	echo "&nbsp;".$inc_toolbar_tools_utilisateurs."&nbsp;:&nbsp;".$_SESSION['ses_trig_user']."&nbsp;|&nbsp;Profil&nbsp;:&nbsp;".@mysql_result(mysql_query("select "._CONST_BO_CODE_NAME."profil."._CONST_BO_CODE_NAME."profil from "._CONST_BO_CODE_NAME."profil, "._CONST_BO_CODE_NAME."user where "._CONST_BO_CODE_NAME."user.id_"._CONST_BO_CODE_NAME."profil="._CONST_BO_CODE_NAME."profil.id_"._CONST_BO_CODE_NAME."profil and id_"._CONST_BO_CODE_NAME."user=".$_SESSION['ses_id_bo_user']),0,""._CONST_BO_CODE_NAME."profil."._CONST_BO_CODE_NAME."profil")."&nbsp;&nbsp;";
}	
	?>
          </td>
		</tr>
      </table>
