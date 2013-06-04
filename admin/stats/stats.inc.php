<? 
$Ratio  = 200;
$Hauteur = 10;

//Retourne les pere d'un element de l'arbo
function get_nav_path($id_pere) {
global $ArrayPath;

	$StrSQLFils = "
					Select *
					from "._CONST_BO_CODE_NAME."nav
					where id_"._CONST_BO_CODE_NAME."nav = ".$id_pere." 
					and "._CONST_BO_CODE_NAME."nav.selected=1
					";

	//Execution de la requete
	$RstMessageFils = mysql_query($StrSQLFils);

	for ($i=1;$i<=@mysql_num_rows($RstMessageFils);$i++) {
		$id_bo_nav_pere	= @mysql_result($RstMessageFils,$i-1,"id_"._CONST_BO_CODE_NAME."nav_pere");
		$bo_nav			= @mysql_result($RstMessageFils,$i-1,""._CONST_BO_CODE_NAME."nav");

		$ArrayPath .= "*-*".$bo_nav;
		get_nav_path($id_bo_nav_pere);
	}
}




if (empty($SwitchConnQuery)) {
	$SwitchConnQuery = "Connections";
}

if (empty($SwitchBackFront)) {
	$SwitchBackFront = "Front-Office";
}


if ($SwitchBackFront == "Front-Office") {
	$CheckedBack = "";
	$CheckedFront = "checked";
	$SwitchConnQuery = "Requêtes";
}
if ($SwitchBackFront == "Back-Office") {
	$CheckedBack = "checked";
	$CheckedFront = "";
}


if ($SwitchConnQuery == "Connections") {
	$CheckedConn = "checked";
	$CheckedQuery = "";
	$SwitchConnQuery1 = "where file_name = 'index.php' and interface = '".$SwitchBackFront."'";
	$SwitchConnQuery2 = "and file_name = 'index.php' and interface = '".$SwitchBackFront."'";
}
if ($SwitchConnQuery == "Requêtes") {
	$CheckedConn = "";
	$CheckedQuery = "checked";
	$SwitchConnQuery1 = "where interface = '".$SwitchBackFront."'";
	$SwitchConnQuery2 = "and interface = '".$SwitchBackFront."'";
}

?> 
<table border="0" cellspacing="1" cellpadding="0" bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>">
 <form method=post action="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$QUERY_STRING?>" name="FormSwitchBackFront">
  <tr> 
    <td> 
        <span class="titre">Statistiques <?=$SwitchBackFront?></span>&nbsp;&nbsp;&nbsp;&nbsp;Front-Office 
        <input type="radio" onClick="javascript:document.FormSwitchBackFront.submit();" name="SwitchBackFront" value="Front-Office" <?=$CheckedFront?>>
        Back-Office 
        <input type="radio" onClick="javascript:document.FormSwitchBackFront.submit();" name="SwitchBackFront" value="Back-Office" <?=$CheckedBack?>>
    </td>
  </tr>
 </form>
  <? 
if ($SwitchBackFront == "Back-Office") {
?>
  <form method=post action="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$QUERY_STRING?>" name="FormSwitchConnQuery">
    <tr> 
      <td align="right" bgcolor="<?=get_inter_color($MenuBgColor,0.1)?>"><i>Connections</i> 
        <input type="radio" onClick="javascript:document.FormSwitchConnQuery.submit();" name="SwitchConnQuery" value="Connections" <?=$CheckedConn?>>
      </td>
    </tr>
    <tr> 
      <td align="right" bgcolor="<?=get_inter_color($MenuBgColor,0.1)?>"><i>Requêtes</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="radio" onClick="javascript:document.FormSwitchConnQuery.submit();" name="SwitchConnQuery" value="Requêtes" <?=$CheckedQuery?>>
      <input type="hidden" name="SwitchBackFront" value="<?=$SwitchBackFront?>">
	  </td>
    </tr>
  </form>
<?
}
?> 
</table>
<br><br>
<?
/*
------------------------------------------------
          NOMBRE TOTAL DE CONNECTION
------------------------------------------------
*/
?>
<table border="0" cellspacing="1" cellpadding="3" bgcolor="<?=get_inter_color($MenuBgColor,0.07)?>">
  <tr> 
    <td colspan="2" bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>"> 
      <?
if (empty($ConnectionBy)) {
	$ConnectionBy = "month";
}
?>
      <b>Nombre total de 
      <?=$SwitchConnQuery?>
      par</b> 
      <? 
if ($ConnectionBy == "dayofmonth") {
	?>
      <b>Jour</b> 
      <?
	$DateFormat = 3;
	$LabelObjPage = "Semaine";
	$NbEnrParPage = 7;
}
else {
	?>
      <a href="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$QUERY_STRING?>&SwitchBackFront=<?=$SwitchBackFront?>&SwitchConnQuery=<?=$SwitchConnQuery?>&ConnectionBy=dayofmonth&Page=1">Jour</a> 
      <?
}
if ($ConnectionBy == "month") {
	?>
      <b>Mois</b> 
      <?
	$DateFormat = 2;
	$LabelObjPage = "Année";
	$NbEnrParPage = 12;
}
else {
	?>
      <a href="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$QUERY_STRING?>&SwitchBackFront=<?=$SwitchBackFront?>&SwitchConnQuery=<?=$SwitchConnQuery?>&ConnectionBy=month&Page=1">Mois</a> 
      <?
}
if ($ConnectionBy == "year") {
	?>
      <b>Année</b> 
      <?
	$DateFormat = 1;
	$LabelObjPage = "Année";
	$NbEnrParPage = 5;
}
else {
	?>
      <a href="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$QUERY_STRING?>&SwitchBackFront=<?=$SwitchBackFront?>&SwitchConnQuery=<?=$SwitchConnQuery?>&ConnectionBy=year&Page=1">Année</a> 
      <?
}

$StrSQL = "
			select ".$ConnectionBy."("._CONST_BO_CODE_NAME."stat.date) as date, count(*) as 'connection', SUBSTRING(date,1,10) as MaDate
			from "._CONST_BO_CODE_NAME."stat
			".$SwitchConnQuery1."
			group by  date
			order by MaDate desc
			";

//echo "<br><br>".get_sql_format($StrSQL)."<br><br>";

$Rst = mysql_query($StrSQL);

?>
    </td>
  </tr>
  <tr> 
    <td> 
      <table border="0" cellspacing="0" cellpadding="3">
        <?

$ObjPage1 = new Page($Rst,$Page);
$ObjPage1->NbEnrPage($NbEnrParPage,$Rst,$Page);
$ObjPage1->Label=$LabelObjPage."s";
$ObjPage1->AffPageSurNbPage=false;
$ObjPage1->Fichier=NomFichier($_SERVER['PHP_SELF'],0);


$TConnection = 0;
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
	if ($TConnection<@mysql_result($Rst,$i,"connection")) {
		$TConnection = @mysql_result($Rst,$i,"connection");
	}
}

for ($i=$ObjPage1->Min;$i<$ObjPage1->Max;$i++) {

	$connection	 = @mysql_result($Rst,$i,"connection");
	$MaDate		 = @mysql_result($Rst,$i,"MaDate");

	if ($DateFormat == 1) {
		$DATE = split("/",CDate($MaDate,1));
		$DATE = $DATE[2];
	}
	elseif ($DateFormat == 2) {
		$DATE = split(" ",CDate($MaDate,3));
		$DATE = ucfirst($DATE[2])." ".$DATE[3];
	}
	elseif ($DateFormat == 3) {
		$DATE = CDate($MaDate,3);
	}

	$color = get_alea_color();

	?>
        <tr> 
          <td> 
            <?=$DATE?>
            :</td>
          <td align="right">[<?=$connection?>]</td>
          <td> 
            <table border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$color?>">
              <tr> 
                <td><img src="images/pixtrans.gif" height="<?=$Hauteur?>" width="<?=($connection*$Ratio)/$TConnection?>" border="0" alt="<?=$DATE?>"></td>
              </tr>
            </table>
          </td>
        </tr>
        <?
}
?>
      </table>
    </td>
    <td> 
      <table border="0" cellspacing="1" cellpadding="0" bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>">
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="2" bgcolor="<?=get_inter_color($MenuBgColor,0.1)?>">
              <tr bgcolor="<?=get_inter_color($MenuBgColor,0.5)?>"> 
                <td class="chemin">Date</th>
                <td class="chemin"> 
                  <?=$SwitchConnQuery?>
                </th>
              </tr>
              <?
for ($i=$ObjPage1->Min;$i<$ObjPage1->Max;$i++) {
	$connection	 = @mysql_result($Rst,$i,"connection");
	$MaDate		 = @mysql_result($Rst,$i,"MaDate");

	if ($DateFormat == 1) {
		$DATE = split("/",CDate($MaDate,1));
		$DATE = $DATE[2];
	}
	elseif ($DateFormat == 2) {
		$DATE = split(" ",CDate($MaDate,3));
		$DATE = ucfirst($DATE[2])." ".$DATE[3];
	}
	elseif ($DateFormat == 3) {
		$DATE = CDate($MaDate,2);
	}


	?>
              <tr> 
                <td> 
                  <?=$DATE?>
                </td>
                <td align='right'> 
                  <?=$connection?>
                </td>
              </tr>
              <?
}
?>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2"> 
      <?
	$ObjPage1->Affiche($Rst, $Page, $QUERY_STRING); ?>
    </td>
  </tr>
  <?

/*
------------------------------------------------
     NOMBRE TOTAL DE CONNECTION PAR PERSONNE
------------------------------------------------
*/
if ($SwitchBackFront == "Back-Office") {
?>
  <tr> 
    <td colspan="2"  bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>"> 
      <?

if (empty($ConnectionUserBy)) {
	$ConnectionUserBy = "month";
}

?>
      <b>Nombre total de 
      <?=$SwitchConnQuery?>
      par personne et par </b> 
      <? 
if ($ConnectionUserBy == "dayofmonth") {
	?>
      <b>Jour</b> 
      <?
	$DateFormat = 3;
	$LabelObjPage = "Jour";
	$NbEnrParPage = 7*3;
}
else {
	?>
      <a href="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$QUERY_STRING?>&SwitchBackFront=<?=$SwitchBackFront?>&SwitchConnQuery=<?=$SwitchConnQuery?>&ConnectionUserBy=dayofmonth&Page2=1">Jour</a> 
      <?
}
if ($ConnectionUserBy == "month") {
	?>
      <b>Mois</b> 
      <?
	$DateFormat = 2;
	$LabelObjPage = "Moi";
	$NbEnrParPage = 12*3;

}
else {
	?>
      <a href="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$QUERY_STRING?>&SwitchBackFront=<?=$SwitchBackFront?>&SwitchConnQuery=<?=$SwitchConnQuery?>&ConnectionUserBy=month&Page2=1">Mois</a> 
      <?
}
if ($ConnectionUserBy == "year") {
	?>
      <b>Année</b> 
      <?
	$DateFormat = 1;
	$LabelObjPage = "Année";
	$NbEnrParPage = 5*3;
}
else {
	?>
      <a href="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$QUERY_STRING?>&SwitchBackFront=<?=$SwitchBackFront?>&SwitchConnQuery=<?=$SwitchConnQuery?>&ConnectionUserBy=year&Page2=1">Année</a> 
      <?
}

$StrSQL = "
		select ".$ConnectionUserBy."("._CONST_BO_CODE_NAME."stat.date) as date, "._CONST_BO_CODE_NAME."user.nom, "._CONST_BO_CODE_NAME."user.prenom, count(*) as connection, SUBSTRING(date,1,10) as MaDate
		from "._CONST_BO_CODE_NAME."stat, "._CONST_BO_CODE_NAME."user
		where "._CONST_BO_CODE_NAME."user.id_"._CONST_BO_CODE_NAME."user = "._CONST_BO_CODE_NAME."stat.id_"._CONST_BO_CODE_NAME."user
		".$SwitchConnQuery2."
		group by "._CONST_BO_CODE_NAME."user.id_"._CONST_BO_CODE_NAME."user, date
		order by MaDate desc, "._CONST_BO_CODE_NAME."user.nom
";

$Rst = mysql_query($StrSQL);

//echo "<br><br>".get_sql_format($StrSQL)."<br><br>";

$ObjPage2 = new Page($Rst,$Page2);
$ObjPage2->NbEnrPage($NbEnrParPage,$Rst,$Page2);
$ObjPage2->NomVar="Page2";
$ObjPage2->Label=$LabelObjPage."s";
$ObjPage2->AffPageSurNbPage=false;
$ObjPage2->Fichier=NomFichier($_SERVER['PHP_SELF'],0);


?>
    </td>
  </tr>
  <tr> 
    <td> 
      <table border="0" cellspacing="0" cellpadding="3">
        <?
$TConnection = 0;
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
	if ($TConnection<@mysql_result($Rst,$i,"connection")) {
		$TConnection = @mysql_result($Rst,$i,"connection");
	}
}

for ($i=$ObjPage2->Min;$i<$ObjPage2->Max;$i++) {

	$connection	 = @mysql_result($Rst,$i,"connection");
	$prenom		 = @mysql_result($Rst,$i,"prenom");
	$nom		 = @mysql_result($Rst,$i,"nom");
	$date		 = @mysql_result($Rst,$i,"date");
	$MaDate		 = @mysql_result($Rst,$i,"MaDate");

	if ($DateFormat == 1) {
		$DATE = split("/",CDate($MaDate,1));
		$DATE = $DATE[2];
	}
	elseif ($DateFormat == 2) {
		$DATE = split(" ",CDate($MaDate,3));
		$DATE = ucfirst($DATE[2])." ".$DATE[3];
	}
	elseif ($DateFormat == 3) {
		$DATE = CDate($MaDate,3);
	}

	$color = get_alea_color();

	if ($date != $DateSauv) {
		?>
        <tr> 
          <td colspan=2><b> 
            <?=$DATE?>
            </b></td>
        </tr>
        <?
		
	}

	?>
        <tr> 
          <td> 
            <?=$nom." ".$prenom?>
            :</td>
          <td align="right">[<?=$connection?>]</td>
          <td> 
            <table border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$color?>">
              <tr> 
                <td><img src="images/pixtrans.gif" height="<?=$Hauteur?>" width="<?=($connection*$Ratio)/$TConnection?>" border="0" alt="<?=$nom." ".$prenom?>"></td>
              </tr>
            </table>
          </td>
        </tr>
        <?
	$DateSauv = $date;
}
?>
      </table>
    </td>
    <td> 
      <table border="0" cellspacing="1" cellpadding="0" bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>">
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="2" bgcolor="<?=get_inter_color($MenuBgColor,0.1)?>">
              <tr bgcolor="<?=get_inter_color($MenuBgColor,0.5)?>"> 
                <td class="chemin">Date</th>
                <td class="chemin">Nom</th>
                <td class="chemin"> 
                  <?=$SwitchConnQuery?>
                </th>
              </tr>
              <?
for ($i=$ObjPage2->Min;$i<$ObjPage2->Max;$i++) {
	$connection	 = @mysql_result($Rst,$i,"connection");
	$MaDate		 = @mysql_result($Rst,$i,"MaDate");
	$prenom		 = @mysql_result($Rst,$i,"prenom");
	$nom		 = @mysql_result($Rst,$i,"nom");

	if ($DateFormat == 1) {
		$DATE = split("/",CDate($MaDate,1));
		$DATE = $DATE[2];
	}
	elseif ($DateFormat == 2) {
		$DATE = split(" ",CDate($MaDate,3));
		$DATE = ucfirst($DATE[2])." ".$DATE[3];
	}
	elseif ($DateFormat == 3) {
		$DATE = CDate($MaDate,2);
	}

?>
              <tr> 
                <td> 
                  <?=$DATE?>
                </td>
                <td>
                  <?=$nom?>
                  <?=$prenom?>
                </td>
                <td align='right'>
                  <?=$connection?>
                </td>
              </tr>
              <?
}
?>
            </table>
          </td>
        </tr>
      </Table>
    </td>
  </tr>
  <tr>
    <td colspan="2"> 
      <? 	
		$ObjPage2->Affiche($Rst, $Page2, "&SwitchBackFront=".$SwitchBackFront."&SwitchConnQuery=".$SwitchConnQuery."&ConnectionUserBy=".$ConnectionUserBy); 
		?>
    </td>
  </tr>
  <?
}
/*
-------------------------------------------------------------
      NOMBRE TOTAL DE CONNECTION PAR JOUR DE LA SEMAINE
-------------------------------------------------------------
*/

?>
  <tr> 
    <td colspan="2"  bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>"> <b>Nombre 
      total de 
      <?=$SwitchConnQuery?>
      par jour de la semaine </b> </td>
  </tr>
  <tr> 
    <td> 
      <?
$StrSQL = "
		Select dayofweek("._CONST_BO_CODE_NAME."stat.date) as date, count(*) as connection, SUBSTRING(date,1,10) as MaDate
		From "._CONST_BO_CODE_NAME."stat
		".$SwitchConnQuery1."
		Group by date
		Order by date
		";

$Rst = mysql_query($StrSQL);

//echo "<br><br>".get_sql_format($StrSQL)."<br><br>";

?>
      <table border="0" cellspacing="0" cellpadding="3" align="center">
        <tr> 
          <?
$TConnection = 0;
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
	if ($TConnection<@mysql_result($Rst,$i,"connection")) {
		$TConnection = @mysql_result($Rst,$i,"connection");
	}
}
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {

	$connection	 = @mysql_result($Rst,$i,"connection");
	$date		 = @mysql_result($Rst,$i,"date");
	$MaDate		 = @mysql_result($Rst,$i,"MaDate");

	$color = get_alea_color();

	?>
          <td valign="bottom" align="center">[<?=$connection?>]<br>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$color?>">
              <tr> 
                <td><img src="images/pixtrans.gif" height="<?=($connection*($Ratio/2))/$TConnection?>" width="<?=$Hauteur*1.5?>" border="0" alt=""></td>
              </tr>
            </table>
          </td>
          <?
}
?>
        </tr>
        <tr> 
          <?
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
	$connection	 = @mysql_result($Rst,$i,"connection");
	$MaDate		 = @mysql_result($Rst,$i,"MaDate");

	$DATE = Split(" ",CDate($MaDate,3));
	$DATE = $DATE[0];

	$VDate = "";
//	for ($j=0;$j<strlen($DATE);$j++) {
//		$VDate .= substr($DATE,$j,1)."<br>";
//	}
	$DATE = substr($DATE,0,3).".";
	?>
          <td valign="top" align="center"> 
            <?=$DATE?>
          </td>
          <?
}
?>
        </tr>
      </table>
    </td>
    <td> 
      <table border="0" cellspacing="1" cellpadding="0" bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>">
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="2" bgcolor="<?=get_inter_color($MenuBgColor,0.1)?>">
              <tr bgcolor="<?=get_inter_color($MenuBgColor,0.5)?>"> 
                <td class="chemin">Date</th>
                <td class="chemin"> 
                  <?=$SwitchConnQuery?>
                </th>
              </tr>
              <?
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
	$connection	 = @mysql_result($Rst,$i,"connection");
	$MaDate		 = @mysql_result($Rst,$i,"MaDate");

	$DATE = Split(" ",CDate($MaDate,3));
	$DATE = $DATE[0];

?>
              <tr> 
                <td> 
                  <?=$DATE?>
                </td>
                <td align='right'> 
                  <?=$connection?>
                </td>
              </tr>
              <?
}
?>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <? 
/*
-------------------------------------------------------------
      NOMBRE TOTAL DE CONNECTION PAR JOUR HEURE
-------------------------------------------------------------
*/

?>
  <tr> 
    <td colspan="2"  bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>"> <b>Nombre 
      total de 
      <?=$SwitchConnQuery?>
      par par tranche horaire</b> </td>
  </tr>
  <tr> 
    <td> 
      <table border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <?

$TConnection = 0;
for ($i=0;$i<12;$i++) {
	$StrSQL = "
			Select *
			From "._CONST_BO_CODE_NAME."stat
			Where SUBSTRING(date,12,2)>=".intval($i*2)."
			and   SUBSTRING(date,12,2)<".intval(($i+1)*2)."
			".$SwitchConnQuery2;

	$Rst = mysql_query($StrSQL);
	if ($TConnection<@mysql_num_rows($Rst)) {
		$TConnection = @mysql_num_rows($Rst);
	}

	$ValTrancheHoraire[] = @mysql_num_rows($Rst);
}
for ($i=0;$i<12;$i++) {
	$connection = $ValTrancheHoraire[$i];
	$color = get_alea_color();
	?>
          <td valign="bottom" align="center">[<?=$connection?>]<br>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$color?>">
              <tr> 
                <td><img src="images/pixtrans.gif" height="<?=($connection*($Ratio/2))/$TConnection?>" width="<?=$Hauteur*1.5?>" border="0" alt=""></td>
              </tr>
            </table>
          </td>
          <?
}
?>
        </tr>
        <? 
for ($i=0;$i<12;$i++) {
	?>
        <td valign="top" align="center"> 
          <?=intval($i*2)?>-<?=intval(($i+1)*2)?>
        </td>
        <?
}
?>
      </table>
    </td>
    <td> 
      <table border="0" cellspacing="1" cellpadding="0" bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>">
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="2" bgcolor="<?=get_inter_color($MenuBgColor,0.1)?>">
              <tr bgcolor="<?=get_inter_color($MenuBgColor,0.5)?>"> 
                <td class="chemin">Heure</th>
                <td class="chemin"> 
                  <?=$SwitchConnQuery?>
                </th>
              </tr>
              <?
for ($i=0;$i<12;$i++) {
	$connection = $ValTrancheHoraire[$i];
	
	?>
              <tr> 
                <td> 
                  <?=intval($i*2)?>
                  h-
                  <?=intval(($i+1)*2)?>
                  h </td>
                <td align='right'> 
                  <?=$connection?>
                </td>
              </tr>
              <?
}
?>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <?
/*
-------------------------------------------------------------
      NOMBRE TOTAL DE REQUETES
-------------------------------------------------------------
*/
if ($SwitchBackFront == "Back-Office") {
?>
  <tr> 
    <td colspan="2"  bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>"> <b>Nombre 
      de requête par rubriques</b> </td>
  </tr>
  <tr> 
    <td> 
      <table border="0" cellspacing="0" cellpadding="3">
        <?
$StrSQL = "
			select "._CONST_BO_CODE_NAME."table_def.menu_title, count("._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."table_def) as connection
			from "._CONST_BO_CODE_NAME."stat, "._CONST_BO_CODE_NAME."table_def
			where "._CONST_BO_CODE_NAME."stat.id_"._CONST_BO_CODE_NAME."table_def = "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."table_def
			".ereg_replace("and file_name = \'index.php\'","",$SwitchConnQuery2)."
			group by "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."table_def
			order by connection desc
";

//echo "<br><br>".get_sql_format($StrSQL)."<br><br>";

$Rst = mysql_query($StrSQL);

$ObjPage3 = new Page($Rst,$Page3);
//$ObjPage3->NbEnrPage($NbEnrParPage,$Rst,$Page3);
$ObjPage3->NomVar="Page2";
//$ObjPage3->Label=$LabelObjPage."s";
$ObjPage3->AffPageSurNbPage=false;
$ObjPage3->Fichier=NomFichier($_SERVER['PHP_SELF'],0);


$TConnection = 0;
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
	if ($TConnection<@mysql_result($Rst,$i,"connection")) {
		$TConnection = @mysql_result($Rst,$i,"connection");
	}
}

for ($i=$ObjPage3->Min;$i<$ObjPage3->Max;$i++) {

	$connection	 = @mysql_result($Rst,$i,"connection");
	$menu_title	 = @mysql_result($Rst,$i,"menu_title");


	$color = get_alea_color();

	?>
        <tr> 
          <td> 
            <?=$menu_title?>
            :</td>
          <td align="right">[<?=$connection?>]</td>
          <td> 
            <table border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$color?>">
              <tr> 
                <td><img src="images/pixtrans.gif" height="<?=$Hauteur?>" width="<?=($connection*$Ratio)/$TConnection?>" border="0" alt="<?=$menu_title?>"></td>
              </tr>
            </table>
          </td>
        </tr>
        <?
}
?>
      </table>
    </td>
    <td> 
      <table border="0" cellspacing="1" cellpadding="0" bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>">
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="2" bgcolor="<?=get_inter_color($MenuBgColor,0.1)?>">
              <tr bgcolor="<?=get_inter_color($MenuBgColor,0.5)?>"> 
                <td class="chemin">Rubriques</th>
                <td class="chemin"> Requêtes </th>
              </tr>
              <?
for ($i=$ObjPage3->Min;$i<$ObjPage3->Max;$i++) {
	$connection	 = @mysql_result($Rst,$i,"connection");
	$menu_title	 = @mysql_result($Rst,$i,"menu_title");

	?>
              <tr> 
                <td> 
                  <?=$menu_title?>
                </td>
                <td align='right'> 
                  <?=$connection?>
                </td>
              </tr>
              <?
}
?>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2"> 
      <?
	$ObjPage3->Affiche($Rst, $Page3,"&SwitchBackFront=".$SwitchBackFront."&SwitchConnQuery=".$SwitchConnQuery."&ConnectionUserBy=".$ConnectionUserBy); ?>
    </td>
  </tr>
  <?
}
/*
-------------------------------------------------------------
      LISTE DES PAGES VUE
-------------------------------------------------------------
*/
if ($SwitchBackFront == "Front-Office") {
?>
  <tr> 
    <td colspan="2"  bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>"> <b>Nombre 
      de requête par rubriques</b> </td>
  </tr>
  <tr> 
    <td> 
      <table border="0" cellspacing="0" cellpadding="3">
        <?
$StrSQL = "
			select "._CONST_BO_CODE_NAME."nav.id_"._CONST_BO_CODE_NAME."nav, "._CONST_BO_CODE_NAME."nav."._CONST_BO_CODE_NAME."nav, count("._CONST_BO_CODE_NAME."nav.id_"._CONST_BO_CODE_NAME."nav) as connection
			from "._CONST_BO_CODE_NAME."stat, "._CONST_BO_CODE_NAME."nav
			where "._CONST_BO_CODE_NAME."stat.id_"._CONST_BO_CODE_NAME."table_def = "._CONST_BO_CODE_NAME."nav.id_"._CONST_BO_CODE_NAME."nav
			".ereg_replace("and file_name = \'index.php\'","",ereg_replace("Back-Office","Front-Office",$SwitchConnQuery2))."
			group by "._CONST_BO_CODE_NAME."nav.id_"._CONST_BO_CODE_NAME."nav
			order by connection desc
		";
//echo "<br><br>".get_sql_format($StrSQL)."<br><br>";

$Rst = mysql_query($StrSQL);

$ObjPage4 = new Page($Rst,$Page4);
//$ObjPage3->NbEnrPage($NbEnrParPage,$Rst,$Page3);
$ObjPage4->NomVar="Page4";
//$ObjPage3->Label=$LabelObjPage."s";
$ObjPage4->AffPageSurNbPage=false;
$ObjPage4->Fichier=NomFichier($_SERVER['PHP_SELF'],0);


$TConnection = 0;
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
	if ($TConnection<@mysql_result($Rst,$i,"connection")) {
		$TConnection = @mysql_result($Rst,$i,"connection");
	}
}

for ($i=$ObjPage4->Min;$i<$ObjPage4->Max;$i++) {

	$connection	 = @mysql_result($Rst,$i,"connection");
	$bo_nav	 = @mysql_result($Rst,$i,""._CONST_BO_CODE_NAME."nav");


	$color = get_alea_color();

	?>
        <tr> 
          <td> 
            <?=$bo_nav?>
            :</td>
          <td align="right">[<?=$connection?>]</td>
          <td> 
            <table border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$color?>">
              <tr> 
                <td><img src="images/pixtrans.gif" height="<?=$Hauteur?>" width="<?=($connection*$Ratio)/$TConnection?>" border="0" alt="<?=$bo_nav?>"></td>
              </tr>
            </table>
          </td>
        </tr>
        <?
}
?>
      </table>
    </td>
    <td> 
      <table border="0" cellspacing="1" cellpadding="0" bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>">
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="2" bgcolor="<?=get_inter_color($MenuBgColor,0.1)?>">
              <tr bgcolor="<?=get_inter_color($MenuBgColor,0.5)?>"> 
                <td class="chemin">Rubriques</th>
                <td class="chemin"> Requêtes </th>
              </tr>
              <?
for ($i=$ObjPage4->Min;$i<$ObjPage4->Max;$i++) {
	$connection		= @mysql_result($Rst,$i,"connection");
	$id_bo_nav	= @mysql_result($Rst,$i,"id_"._CONST_BO_CODE_NAME."nav");

	$ArrayPath = "";
	get_nav_path($id_bo_nav);
	$Arr = @split("\*-\*", $ArrayPath);
	$Arr = @array_reverse($Arr);
	@array_shift($Arr);
	$Chemin = @substr(@join(" -> ",$Arr),0,@strlen(@join(" -> ",$Arr))-4);

	if (empty($Chemin)) {
		$Chemin = "Home";
	}

	?>
              <tr> 
                <td> 
                  <?=$Chemin?>
                </td>
                <td align='right'> 
                  <?=$connection?>
                </td>
              </tr>
              <?
}
?>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2"> 
      <?
	$ObjPage4->Affiche($Rst, $Page4,"&SwitchBackFront=".$SwitchBackFront."&SwitchConnQuery=".$SwitchConnQuery."&ConnectionUserBy=".$ConnectionUserBy); ?>
    </td>
  </tr>
  <? 
}	

/*
-------------------------------------------------------------
      LISTE DES NAVIGATEUR
-------------------------------------------------------------
*/
?>
  <tr> 
    <td colspan="2"  bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>"> <b>Statistiques par navigateurs</b> </td>
  </tr>
  <tr> 
    <td colspan="2"> 
      <table border="0" cellspacing="0" cellpadding="3">
        <?
$StrSQL = "
			Select agent, count(id_"._CONST_BO_CODE_NAME."stat) as nb
			From "._CONST_BO_CODE_NAME."stat
			".$SwitchConnQuery1."
			Group by "._CONST_BO_CODE_NAME."stat.agent 
			order by nb desc
		";
//echo "<br><br>".get_sql_format($StrSQL)."<br><br>";

$Rst = mysql_query($StrSQL);

$TConnection = 0;
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
	$TotalConnection += @mysql_result($Rst,$i,"nb");
}

for ($i=0;$i<@mysql_num_rows($Rst);$i++) {

	$nb	 = @mysql_result($Rst,$i,"nb");

	$user_agent  = @mysql_result($Rst,$i,"agent"); 

	$color = get_alea_color();

	$Pourcentage = ($nb/$TotalConnection)*100;;
	?>
        <tr> 
          <td> 
            <?=$user_agent?> :</td>
          <td align="right">[<?=number_format($Pourcentage,2,","," ")?>%]</td>
          <td> 
            <table border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$color?>">
              <tr> 
                <td><img src="images/pixtrans.gif" height="<?=$Hauteur?>" width="<?=($Pourcentage*($Ratio/50))?>" border="0" alt="<?=$bo_nav?>"></td>
              </tr>
            </table>
          </td>
        </tr>
        <?
}
?>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2"> 
		&nbsp;
    </td>
  </tr>

<?
/*
-------------------------------------------------------------
      LISTE DES OS
-------------------------------------------------------------
*/
?>
  <tr> 
    <td colspan="2"  bgcolor="<?=get_inter_color($MenuBgColor,0.3)?>"> <b>Statistiques par Os</b> </td>
  </tr>
  <tr> 
    <td colspan="2"> 
      <table border="0" cellspacing="0" cellpadding="3">
        <?
$StrSQL = "
			Select os, count(id_"._CONST_BO_CODE_NAME."stat) as nb
			From "._CONST_BO_CODE_NAME."stat
			".$SwitchConnQuery1."
			Group by "._CONST_BO_CODE_NAME."stat.os 
			order by nb desc
		";
//echo "<br><br>".get_sql_format($StrSQL)."<br><br>";

$Rst = mysql_query($StrSQL);

$TotalConnection = 0;
for ($i=0;$i<@mysql_num_rows($Rst);$i++) {
	$TotalConnection += @mysql_result($Rst,$i,"nb");
}

for ($i=0;$i<@mysql_num_rows($Rst);$i++) {

	$nb	 = @mysql_result($Rst,$i,"nb");

	$user_agent  = @mysql_result($Rst,$i,"os"); 

	$color = get_alea_color();

	$Pourcentage = ($nb/$TotalConnection)*100;;
	?>
        <tr> 
          <td> 
            <?=$user_agent?> :</td>
          <td align="right">[<?=number_format($Pourcentage,2,","," ")?>%]</td>
          <td> 
            <table border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$color?>">
              <tr> 
                <td><img src="images/pixtrans.gif" height="<?=$Hauteur?>" width="<?=($Pourcentage*($Ratio/50))?>" border="0" alt="<?=$bo_nav?>"></td>
              </tr>
            </table>
          </td>
        </tr>
        <?
}
?>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2"> 
		&nbsp;
    </td>
  </tr>


</table>
