<table>
<tr>
	<td colspan="2">&nbsp;&nbsp;<b>Modification du menu boutique</b><br><br>
	&nbsp;&nbsp;Nouveau Rayon : <a href="bo?TableDef=2&mode=nouveau&show_tree_from=0&target=<?=NomFichier($_SERVER['PHP_SELF'],0)?>"><img src="images/icones/img_new.gif" border="0" alt="Nouveau Rayon"></a>
	</td>
</tr>
<tr>
	<td width="60">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><?=get_arbo_boutique(1, "&nbsp;&nbsp;",0,@split(",","32,35"),$MenuBgColor,3,1,1);?></td>
</tr>
</table>

<? 
//Retourne l'arbo du site
function get_arbo_boutique($id_pere, $Indic, $Level, $id_item, $BgColor, $Mode=0, $ShowInd=0, $ShowNum=0, $FilterNum="") {
	global $nb,$_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], $arr_secure_bouique_items;
    global $idItem;
	$nb++;

	//$ArrayPuce		= array("-","*","°","+",">","¤");

	$FontColorStyle = "color=black";

	$StrSQLFils = "
					Select 
                            *
					from 
                            _nav 
					where
                            id__nav_pere = ".$id_pere."
					";

	if ($Level==0) {
			?>
			<!-- Debut --><table cellspacing="0" cellpadding="4" border="0" >
			<?
			$traitement_fin = "</table>";
	}


	$StrSQLFils .= " group by _nav.id__nav order by ordre, _nav";

//echo $StrSQLFils;

	//Execution de la requete
	$RstMessageFils = mysql_query($StrSQLFils);

	if (@mysql_num_rows($RstMessageFils)) {
		$Level++; //On compte les niveau

		for ($i=1;$i<=@mysql_num_rows($RstMessageFils);$i++) {
			$id_bo_nav	= @mysql_result($RstMessageFils,$i-1,"id__nav");

			//Mode Arbre
			$nom			= $ArrayPuce[$Level]."&nbsp;".((@mysql_result($RstMessageFils,$i-1,"_nav")));
			$selected			= @mysql_result($RstMessageFils,$i-1,"selected");
			$nb					= @mysql_result($RstMessageFils,$i-1,"nb");
			
			if (is_array($id_item) && in_array($id_bo_nav,$id_item)) {
				$Selected = "Selected";
			}
			elseif ($id_bo_nav == $id_item) {
				$Selected = "Selected";
			}
			else {
				$Selected = "";
			}



			$Ind=$Indic.$i.".";

			//Affichage ou non de l'indentation
			if ($ShowInd == 1) {
				$Indentation = str_repeat("&nbsp;&nbsp;",($Level));
			}

			//Affichage ou non de la numerotation
			if ($ShowNum == 1) {
				$Numerotation = "<span style=\"font-size:9\"><i>".$Ind."</i></span>";
			}

			if ($idItem==$id_bo_nav){
				$color = "red";
			}
			else{
				$color = $BgColor;
			}
			echo "<tr><td style=\"".$FontColorStyle."\" bgcolor=\"".$color."\" >".$Indentation.$Numerotation."&nbsp;";
			
			if ($selected==1) {
				echo "<u>";
			}
			echo str_replace("&nbsp;","",$nom);

			if ($selected==1) {
				echo "</u>";
			}
			echo "&nbsp;(".$nb.")";

			echo "</td>";
			echo "<td width='40' bgcolor=\"".get_inter_color($color,0.7)."\">";
			if ($selected==1) {
				echo "<img src='images/on2_1.gif' border='0'>";
			}
			else {
				echo "<img src='images/off2_1.gif' border='0'>";
			}
			echo "</td>";
			
			echo "<td width='16' bgcolor=\"".get_inter_color($color,0.7)."\">";

			if (in_array($id_bo_nav ,$arr_secure_bouique_items)) {
				echo "&nbsp;";
			}
			else {
				echo "<a href=\"bo?TableDef=2&mode=modif&ID=".$id_bo_nav."&show_tree_from=0&target=".NomFichier($_SERVER['PHP_SELF'],0)."\" class=\"LienBlanc\"><img src='images/icones/icone_ed1.gif' border='0' alt='Modifier'></a>";
			}

			echo "</td><td width='16' bgcolor=\"".get_inter_color($color,0.7)."\">";

			if (in_array($id_bo_nav ,$arr_secure_bouique_items)) {
				echo "&nbsp;";
			}
			else {
				echo "<a href=\"bo?TableDef=2&mode=supr&ID=".$id_bo_nav."&target=".NomFichier($_SERVER['PHP_SELF'],0)."\" class=\"LienBlanc\"><img src='images/icones/icone_ed0.gif' border='0' alt='Supprimer'></a>";
			}

			echo "</td></tr>\n";

			get_arbo_boutique($id_bo_nav, $Ind, $Level, $id_item, get_inter_color($BgColor,0.8), $Mode, $ShowInd, $ShowNum, $FilterNum);

		}
	}

	echo $traitement_fin;

}

?>
