                    <td>
                <tr>
            </table>

        <br><br>

	</td>
</tr>
<? 
if ($TableDef==2) {
?> 
<tr> 
  <td colspan="3">&nbsp;</td>
  <td> <br><br>
    <?//=get_arbo(0, "&nbsp;&nbsp;",0,$Pere,$ActiveItemColor,1,1,1)?>
  </td>
</tr>
<?
}
?>
<tr> 
  <td colspan="3"> 
<?

if ($_SESSION['ses_profil_user']==1) {
	?><div style='display:none' id='SQL' style="background-color:#F2F2F2"><hr><br><?=get_sql_format($StrSQL)?><br><br><hr></div><?
}

//Si mode debug_mode Active:1 alors on affiche les requetes
if ($debug_mode == 1 && $_SESSION['ses_profil_user']==1) {

	if ($_SESSION['ses_profil_user']==1 && $_SESSION['ses_profil_user']) {

		//Affichage du temps d'execution de la page
		$time_end = getmicrotime();
		$time = $time_end - $time_start;

		echo "Temps d'éxecution : ".number_format($time,2,","," ")." seconde(s)";

	}

	//Affichage en brut des valeurs des filtre
	echo "<br><br><b>Filtres :</b>";
	foreach ($_SESSION['ses_filter'] as $value) {
		echo "<br>-".$value;
	}
	
	echo "<p style=\"font-size:11; color:red\">";
//	echo "<p style=\"font-size:9; color:red\">".str_replace("\n","<br>",$StrSQL);
	echo "SQLAfterUpdate :<br>".get_sql_format($SQLAfterUpdate)."<br><br>";
	echo "TableBgColor : ".$TableBgColor."<br>";
	echo "TableBorder : ".$TableBorder."<br>";
	echo "TableCellspacing : ".$TableCellspacing."<br>";
	echo "TableCellpadding : ".$TableCellpadding."<br>";
	echo "Retour : ".$Retour."<br>";
	echo "FieldWidthSize : ".$FieldWidthSize."<br>";
	echo "FieldHeightSize : ".$FieldHeightSize."<br>";
	echo "NbMaxCar : ".$NbMaxCar."<br>";
	echo "WidthType : ".$WidthType."<br>";
	echo "WidthTable : ".$WidthTable."<br>";
	echo "TdBgColor1 : ".$TdBgColor1."<br>";
	echo "TdBgColor2 : ".$TdBgColor2."<br>";
	echo "DefaultDate : ".$DefaultDate."<br>";
	echo "MenuBgColor : ".$MenuBgColor."<br>";
	echo "MenuTableBgColor : ".$MenuTableBgColor."<br>";
	echo "TableEnTeteGgColor : ".$TableEnTeteGgColor."<br>";
	echo "ImgTriAsc : ".$ImgTriAsc."<br>";
	echo "ImgTriDesc : ".$ImgTriDesc."<br>";
	echo "ImgCheckBoxOn : ".$ImgCheckBoxOn."<br>";
	echo "ImgCheckBoxOff : ".$ImgCheckBoxOff."<br>";
	echo "ImgAcceptExt : ".$ImgAcceptExt."<br>";
	echo "NoPictureTitle : ".$NoPictureTitle."<br>";
	echo "DisplayMode : ".$DisplayMode."<br>";
	echo "DisplayMenu : ".$DisplayMenu."<br>";
	echo "ItemListerTitle : ".$ItemListerTitle."<br>";
	echo "NbEnrPage : ".$NbEnrPage."<br>";
	echo "NbPageTot : ".$NbPageTot."<br>";
	echo "debug_mode : ".$debug_mode."<br>";

}
?>
  </td>
</tr>
</table>
</body>
</html>
<? 
    //--------------
	//Gestion du Dump SQL de la base
	//--------------
	if ($Dump == 1) {
		make_dump($Host, $BaseName,$UserName, $UserPass,1);
	}
    
    //--------------
	//Gestion du Dump xml
	//--------------
	if ($exp == 1) {
		make_xml_file($Host, $BaseName,$UserName, $UserPass, $StrSQL, $CurrentTableName);
	}
    //--------------
	//Gestion du Dump csv
	//--------------
	if ($exp == 2) {
		make_csv_file($StrSQL, $CurrentTableName);
	}
mysql_close();
?>
