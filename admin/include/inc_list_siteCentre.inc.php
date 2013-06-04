<tr>
  <td colspan="3"><br />
<a name="siteTouristique" />
  <? 
// traitement principal
if ($_REQUEST['mode'] != "nouveau") {	
  $strSQL = "SELECT 
          trad_centre_site_touristique.id__centre_site_touristique,
  			  trad_centre_site_touristique.libelle,
  			  centre_site_touristique.adresse, 
  			  centre_site_touristique.ordre
  			FROM
  			  trad_centre_site_touristique
  			  INNER JOIN centre_site_touristique ON (trad_centre_site_touristique.id__centre_site_touristique = centre_site_touristique.id_centre_site_touristique and centre_site_touristique.id_centre_1=".$_SESSION["ID"].")
  			WHERE
  			  (trad_centre_site_touristique.id__langue = '".$_SESSION["ses_langue"]."')
  			ORDER BY centre_site_touristique.ordre";
  			  
  
  //echo $strSQL;
  $rst = mysql_query($strSQL);
  $nb_rec = mysql_num_rows($rst);
}
$id_table = "id__centre_site_touristique";
$tabledef_fils = _CONST_TABLEDEF_SITE_CENTRE;
$table = "centre_site_touristique";
$id_pere = "id__centre";
$id_table_pere = "id_centre";
$vOrdre = "centre.id_centre";
$height = 500;
$width = 700;

echo("<table width='100%'><tr><td valign='top' colspan='3'><a name=heb style='text-decoration:none;'><b>Sites touristiques aux alentours</b> </a><br><hr style='color:".$ActiveItemColor."'></td></tr>");
echo("<tr><td colspan='3'>");
if ($_REQUEST['mode'] != "nouveau") {	
	echo "&nbsp;&nbsp;&nbsp;&gt;&nbsp;<a href=\"javascript:MM_openBrWindow('bo.php?InitTableDef=".$_GET["TableDef"]."&TableDef=".$tabledef_fils."&Referer=".NomFichier($PHP_SELF,0)."&InitTableDef=".$_GET["TableDef"]."&mode=nouveau&DisplayMode=PopUp&MasterKey=$id_table_pere&MasterValue=".$_SESSION['ID']."&reloadRef=1','PopUpUpdate','resizable=yes,scrollbars=yes,height=$height,width=$width')\">Cr&eacute;er une nouvelle entr&eacute;e</a>";
	echo("<br><br>");
	
		
	if ($nb_rec > 0) {
	
		echo("<table border='0' cellpading=2 cellspacing=2 width=100%><tr align=center bgcolor=".$TableEnTeteGgColor."><td>Libell&eacute;</td><td>Adresse</td><td>Ordre</td><td>&nbsp;</td><td>&nbsp;</td></tr>");
		
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
			$adresse  = mysql_result($rst,$i,"adresse");
			$libelle  = mysql_result($rst,$i,"libelle");
			$ordre  = mysql_result($rst,$i,"ordre");

	    echo "<tr bgcolor=".$fond_cellule." ".$ItemEvent." 
            onDblclick=\"javascript:MM_openBrWindow('".NomFichier($_SERVER['PHP_SELF'],0)."?InitTableDef=".$_GET["TableDef"]."&TableDef=".$tabledef_fils."&mode=modif&ID=".$id_per."&Search=$Search&DisplayMode=PopUp&DisplayMenu=$DisplayMenu&Page=$Page&formMain_selection=$formMain_selection&ordre=$ordre&AscDesc=$AscDesc&reloadRef=1&MasterKey=$id_pere&MasterValue=".$_SESSION['ID']."','PopUpHeb','resizable=yes,scrollbars=yes,height=$height,width=$widht');\" style=\"cursor:hand\" align=\"center\">";
			echo("<td>&nbsp;".$libelle."&nbsp;</td><td>&nbsp;".$adresse."&nbsp;</td><td>&nbsp;".$ordre."&nbsp;</td>");
			echo "<td align=\"center\" bgcolor='".get_inter_color($TableBgColor,0.4)."' ".$ItemEvent."><a href=\"javascript:MM_openBrWindow('".NomFichier($_SERVER['PHP_SELF'],0)."?InitTableDef=".$_GET["TableDef"]."&TableDef=".$tabledef_fils."&mode=modif&ID=".$id_per."&Search=$Search&DisplayMode=PopUp&DisplayMenu=$DisplayMenu&Page=$Page&formMain_selection=$formMain_selection&ordre=$vOrdre&AscDesc=$AscDesc&reloadRef=1&MasterKey=$id_pere&MasterValue=".$_SESSION['ID']."','PopUpHeb','resizable=yes,scrollbars=yes,height=$height,width=$width');\">"."Modifier"."</a></td>";
			echo"<td align=\"center\" bgcolor='".get_inter_color($TableBgColor,0.4)."' ".$ItemEvent."><a href=\"javascript:MM_openBrWindow('bo.php?InitTableDef=".$_GET["TableDef"]."&TableDef=".$tabledef_fils."&mode=supr&ID=".$id_per."&Search=&DisplayMode=PopUp&DisplayMenu=&Page=&formMain_selection=&ordre=$ordre&AscDesc=&reloadRef=1&MasterKey=$id_pere&MasterValue=".$_SESSION['ID']."','PopUpHebMedia','resizable=yes,scrollbars=yes,height=$height,width=$width');\">Supprimer</a></td>";
			echo("</tr>");
			$i++;
		}
		echo("</table>");
	} else {
		echo("Aucune entr&eacute; associ&eacute;e");		
	}
} else {
	echo "<br />";
	  $action_button2 = new bo_button();
		$action_button2->c1 = $MenuBgColor;
		$action_button2->c2 = $MainFontColor;
		$action_button2->name = "Ajouter un site touristique";
    $action_button2->action = "valid_form_plus_retour('#siteTouristique','".$_REQUEST["TableDef"]."')";
    $action_button2->display();

	//echo("Cr&eacute;ation d'un s&eacute;jour en cours...");
	//echo("<br>Merci de valider la cr&eacute;ation du centre avant de cr&eacute;er les plus du centre associ&eacute;s");
	$query=(eregi_replace("nouveau","modif",$HTTP_SERVER_VARS["QUERY_STRING"]));
	echo("<input type=\"hidden\" name=\"reload_form\" value=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?".$query."\">");
}
echo("</td></tr>");
echo("<tr><td colspan=3><br /></td></tr></table>");
?>
  </td>
</tr>
<?

if($_GET["siteTouristique"] == 1){
  echo "
    <script>";
      
    if ($nb_rec <= 0) {  
  echo"    MM_openBrWindow('bo.php?TableDef=".$tabledef_fils."&Referer=".NomFichier($PHP_SELF,0)."&InitTableDef=".$_GET["TableDef"]."&mode=nouveau&DisplayMode=PopUp&MasterKey=$id_table_pere&MasterValue=".$_GET['ID']."&reloadRef=1','PopUpUpdate','resizable=yes,scrollbars=yes,height=$height,width=$width');";
    }
    
    echo"</script>";
}
?>