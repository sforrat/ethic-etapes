<tr>
  <td colspan="3"><a name="plussejour" />
  <? 
  
$id_table = "id__sejour_les_plus";
$table = "sejour_les_plus";
$height = 500;
$width = 700;
$tabledef_fils = _CONST_TABLEDEF_PLUS_SEJOUR;

$strSQL = "select cur_table_name from _table_def where id__table_def='".$_GET["TableDef"]."'";
$rst = mysql_query($strSQL);

$id_table_pere = "id_".mysql_result($rst,0,"cur_table_name");
$id_pere = "id_".mysql_result($rst,0,"cur_table_name");
$vOrdre = mysql_result($rst,0,"cur_table_name").".id_".mysql_result($rst,0,"cur_table_name");

// traitement principal
if ($_REQUEST['mode'] != "nouveau") {	
  $strSQL = "SELECT 
          trad_$table.id__$table,
  			  trad_$table.libelle
  			FROM
  			  trad_$table
  			  INNER JOIN $table ON (trad_$table.id__$table = $table.id_$table and $table.id__table_def=".$_GET["TableDef"].")
  			  INNER JOIN ".mysql_result($rst,0,"cur_table_name")." ON (sejour_les_plus.IdSejour = ".mysql_result($rst,0,"cur_table_name").".id_".mysql_result($rst,0,"cur_table_name")." AND ".mysql_result($rst,0,"cur_table_name").".id_".mysql_result($rst,0,"cur_table_name")."=".$_GET["ID"].") 
  			WHERE
  			  (trad_$table.id__langue = '".$_SESSION["ses_langue"]."')
        ORDER BY $table.ordre";
  			  
  
  
  $rst = mysql_query($strSQL);
  $nb_rec = mysql_num_rows($rst);
}


echo("<table width='100%'><tr><td valign='top' colspan='3'><a name=heb style='text-decoration:none;'><hr><b>Les plus s&eacute;jour *</b> </a><br></td></tr>");
echo("<tr><td colspan='3'>");
if ($_REQUEST['mode'] != "nouveau") {	

	echo "&nbsp;&nbsp;&nbsp;&gt;&nbsp;<a href=\"javascript:MM_openBrWindow('bo.php?InitTableDef=".$_GET["TableDef"]."&TableDef=".$tabledef_fils."&Referer=".NomFichier($PHP_SELF,0)."&InitTableDef=".$_GET["TableDef"]."&mode=nouveau&DisplayMode=PopUp&MasterKey=$id_table_pere&MasterValue=".$_GET['ID']."&reloadRef=1','PopUpUpdate','resizable=yes,scrollbars=yes,height=$height,width=$width')\">Cr&eacute;er une nouvelle entr&eacute;e</a>";
	echo("<br><br>");
	
		
	if ($nb_rec > 0) {
	
		echo("<table border='0' cellpading=2 cellspacing=2 width=100%><tr align=center bgcolor=".$TableEnTeteGgColor."><td>Libell&eacute;</td><td>&nbsp;</td><td>&nbsp;</td></tr>");
		
		$i=0;
		while ($i < $nb_rec) {
			
				if ($fond_cellule == $TdBgColor1) {
					$fond_cellule = $TdBgColor2;
				}
				else {
					$fond_cellule = $TdBgColor1;
				}
					//Roll over pour l'element selectionné
				$ItemEvent =  "onmouseover='ItemOn(this,\"".get_inter_color($ActiveItemColor,0.3)."\",\"".eregi_replace("px","",$FontSize)."\",\"".$nb_cols."\");'";
				$ItemEvent .= "onmouseout='ItemOff(this,\"".$FontColor."\",\"".eregi_replace("px","",$FontSize)."\",\"".$nb_cols."\");'";
			
			
			$id_per = mysql_result($rst,$i,$id_table);
			
			$libelle  = mysql_result($rst,$i,"libelle");
	    

	    echo "<tr bgcolor=".$fond_cellule." ".$ItemEvent." 
            onDblclick=\"javascript:MM_openBrWindow('".NomFichier($_SERVER['PHP_SELF'],0)."?InitTableDef=".$_GET["TableDef"]."&TableDef=".$tabledef_fils."&mode=modif&ID=".$id_per."&Search=$Search&DisplayMode=PopUp&DisplayMenu=$DisplayMenu&Page=$Page&formMain_selection=$formMain_selection&ordre=$ordre&AscDesc=$AscDesc&reloadRef=1&MasterKey=$id_pere&MasterValue=".$_GET['ID']."','PopUpHeb','resizable=yes,scrollbars=yes,height=$height,width=$widht');\" style=\"cursor:hand\" align=\"center\">";
			echo("<td>&nbsp;".$libelle."&nbsp;</td>");
			echo "<td align=\"center\" bgcolor='".get_inter_color($TableBgColor,0.4)."' ".$ItemEvent."><a href=\"javascript:MM_openBrWindow('".NomFichier($_SERVER['PHP_SELF'],0)."?InitTableDef=".$_GET["TableDef"]."&TableDef=".$tabledef_fils."&mode=modif&ID=".$id_per."&Search=$Search&DisplayMode=PopUp&DisplayMenu=$DisplayMenu&Page=$Page&formMain_selection=$formMain_selection&ordre=$vOrdre&AscDesc=$AscDesc&reloadRef=1&MasterKey=$id_pere&MasterValue=".$_GET['ID']."','PopUpHeb','resizable=yes,scrollbars=yes,height=$height,width=$width');\">"."Modifier"."</a></td>";
			echo"<td align=\"center\" bgcolor='".get_inter_color($TableBgColor,0.4)."' ".$ItemEvent."><a href=\"javascript:MM_openBrWindow('bo.php?InitTableDef=".$_GET["TableDef"]."&TableDef=".$tabledef_fils."&mode=supr&ID=".$id_per."&Search=&DisplayMode=PopUp&DisplayMenu=&Page=&formMain_selection=&ordre=$ordre&AscDesc=&reloadRef=1&MasterKey=$id_pere&MasterValue=".$_GET['ID']."','PopUpHebMedia','resizable=yes,scrollbars=yes,height=$height,width=$width');\">Supprimer</a></td>";
			echo("</tr>");
			$i++;
		}
		echo("</table>");
	} else {
		echo("Aucune entr&eacute;e associ&eacute;e");		
	}
} else {
	//echo("Cr&eacute;ation d'un s&eacute;jour en cours...");
	  echo "<br />";
	  $action_button2 = new bo_button();
		$action_button2->c1 = $MenuBgColor;
		$action_button2->c2 = $MainFontColor;
		$action_button2->name = "Ajouter les plus s&eacute;jour";
    $action_button2->action = "valid_form_plus_retour('#plussejour','".$_REQUEST["TableDef"]."')";
    $action_button2->display();
	
	
	//echo("<br>Merci de valider la cr&eacute;ation du s&eacute;jour avant de cr&eacute;er les plus du s&eacute;jour associ&eacute;");
	$query=(eregi_replace("nouveau","modif",$HTTP_SERVER_VARS["QUERY_STRING"]));
	echo("<input type=\"hidden\" name=\"reload_form\" value=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?".$query."\">");
}
echo("</td></tr>");
echo("<tr><td colspan=3><br /></td></tr></table>");






?>
  </td>
</tr>


<?

if($_GET["plussejour"] == 1){
  echo "
    <script>";
      
    if ($nb_rec <= 0) {  
  echo"    MM_openBrWindow('bo.php?TableDef=".$tabledef_fils."&Referer=".NomFichier($PHP_SELF,0)."&InitTableDef=".$_GET["TableDef"]."&mode=nouveau&DisplayMode=PopUp&MasterKey=$id_table_pere&MasterValue=".$_GET['ID']."&reloadRef=1','PopUpUpdate','resizable=yes,scrollbars=yes,height=$height,width=$width');";
    }
    
    echo"</script>";
}
?>
