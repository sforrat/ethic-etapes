<script language="javascript">
function check_requette() {
	if (document.formulaire.requette.value!="" && document.formulaire.requette.value!=" ") {
		document.formulaire.submit();
	}else{
		alert("<?=$inc_sql_maker_sql_vide?>");
	}
}

function exec_select(table) {
	document.formulaire.requette.value="select * from "+table;
	document.formulaire.submit();
}

function vider(table) {
	if (confirm("<?=$inc_sql_maker_sql_vide_table?>")) {
		document.formulaire.requette.value="delete from "+table;
		document.formulaire.submit();
	}
}

function charge_csv() {
	if (document.formulaire.fichier_csv.value!="") {
		if (confirm("<?=$inc_sql_maker_csv_import?>")) {
			document.formulaire.submit();
		}
	}else{
		alert("<?=$inc_sql_maker_csv_vide?>");
	}
}
</script>
<? if ($requette=="") {
	if ($fichier_csv_name!='') {
		$fp = fopen ($fichier_csv,"r");

		$nbe=0;
		while ($data = fgetcsv ($fp, 5000, ";")) {
	   		$num = count ($data);
			$nbe++;

			$RS = mysql_query("SHOW FIELDS FROM ".$_REQUEST['csv_table']);
			
			$str_champs = "";
			for($i=1;$i< mysql_num_rows($RS) ;$i++) {
				if ($i==1) {
					$str_champs = mysql_result($RS, $i, "field");
				}else{
					$str_champs = $str_champs.",".mysql_result($RS, $i, "field");
				}
			}

			$chaine = "insert into ".$_REQUEST['csv_table']." (".$str_champs.") values (";

			for ($c=0; $c < $num; $c++) {
				if ($c==($num-1)) {
					$chaine = $chaine."'".$data[$c]."'";
				}else{
					$chaine = $chaine."'".$data[$c]."',";
				}
			}
			$chaine = $chaine.")";
			$RS = mysql_query($chaine);
		}

		echo("INSERTION TERMINEE : <b>".$nbe."</b> insertions.");
		fclose ($fp);

		echo("<br><table cellspacing=1 cellpadding=1><tr><td>");
		$action_button = new bo_button();
		$action_button->c1 = $MenuBgColor;
		$action_button->c2 = $MainFontColor;
		$action_button->name = "RETOUR";
		$action_button->action = "javascript:history.go(-1);";
		$action_button->display();
	}else{ ?>
		<table border="1">
		<tr>
		<td rowspan="2" valign="top" bgcolor="<?=$MenuBgColor?>">
		<?
		// *** LISTE DES TABLES
		$RS = mysql_list_tables($BaseName);
		if ($TableName=="") {
			$CurTable = mysql_tablename($RS, 0);
		}else{
			$CurTable = $TableName;
		}	
	
		for($i=0;$i< mysql_num_rows($RS) ;$i++) { 
			if ($CurTable==mysql_tablename($RS, $i)) { 
				echo (mysql_tablename($RS, $i));
			}else{ ?>
				<a href="bo_include_launcher.php?file=include/inc_sql_maker.inc.php&TableName=<?=mysql_tablename($RS, $i)?>"><?=mysql_tablename($RS, $i)?></a>
		<?	}
			echo("<br>");
		} ?>
		</td>
		<td valign="top">
		<form name="formulaire" action="bo_include_launcher.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="file" value="include/inc_sql_maker.inc.php">
	<?	$RS = mysql_query("select count(*) as nbe FROM ".$CurTable); ?>
		<table>
		<tr>
		<td><b>TABLE : </b></td>
		<td><?=$CurTable?></td>
		<td>&nbsp;|&nbsp;</td>
		<td><?=mysql_result($RS,0,"nbe")?> <?=$inc_sql_maker_sql_enreg?></td>
		<td>&nbsp;|&nbsp;</td>
		<td><a href='javascript:exec_select("<?=$CurTable?>");'><?=$inc_sql_maker_sql_afficher?></a></td>
		<td><a href='javascript:vider("<?=$CurTable?>");'><?=$inc_sql_maker_sql_vider?></a></td>
		</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="2">
		<tr><td>
			<table border="1" cellpadding="1" cellspacing="0">
			<tr bgcolor="<?=$MenuBgColor?>">
			<td><b>Nom</b></td>
			<td><b>Type</b></td>
			<td><b>Null</b></td>
			<td><b>Clef</b></td>
			<td><b>Default</b></td>
			<td><b>Extra</b></td>
			</tr>
		<?	// *** LISTE DES CHAMPS
			$RS = mysql_query("SHOW FIELDS FROM ".$CurTable);
			/*
			$fieldname			=	@mysql_field_name($result_fieldname, $k);
			$fieldname_alias		=	@mysql_field_name($result, $k);
			$fieldtype			=	@mysql_field_type($result, $k);
			$fieldlen			=	@mysql_field_len($result, $k);
			$tablename			=	@mysql_field_table($result, $k);*/
			
			for($i=0;$i< mysql_num_rows($RS) ;$i++) {
				echo("<tr>");
				echo("<td>&nbsp;".mysql_result($RS, $i, "field")."</td>");
				echo("<td>&nbsp;".mysql_result($RS, $i, "type")."</td>");
				echo("<td>&nbsp;".mysql_result($RS, $i, "null")."</td>");
				echo("<td>&nbsp;".mysql_result($RS, $i, "key")."</td>");
				echo("<td>&nbsp;".mysql_result($RS, $i, "default")."</td>");
				echo("<td>&nbsp;".mysql_result($RS, $i, "extra")."</td>");
				echo("</tr>");
			} ?>
			</table>
		</td>
		<td>
			<table border="1" cellpadding="1" cellspacing="0">
			<input type="hidden" name="csv_table" value="<?=$CurTable?>">
			<tr bgcolor="<?=$MenuBgColor?>">
			<td><b>Charger un fichier "csv"</b></td>
			</tr>
			<tr>
			<td><input type="file" name="fichier_csv"></td>
			</tr>
			<tr><td align="center"><br>
	<?		//AFFICHAGE DU BOUTON ACTION
			$action_button = new bo_button();
			$action_button->c1 = $MenuBgColor;
			$action_button->c2 = $MainFontColor;
			$action_button->name = "Charger";
			$action_button->action = "javascript:charge_csv();";
			$action_button->display(); ?>
			</td></tr>
			</table>
		</td></tr>
		</table>
		</td>
		</tr>
		<tr>
		<td height="300" valign="top"><br>
		<textarea name="requette" cols="80" rows="12"><?=$requette?></textarea>
		<br><center>
		<?
		//AFFICHAGE DU BOUTON ACTION
		$action_button = new bo_button();
		$action_button->c1 = $MenuBgColor;
		$action_button->c2 = $MainFontColor;
		$action_button->name = "Executer";
		$action_button->action = "javascript:check_requette();";
		$action_button->display();
		?>
		</center>
		</td>
		</tr>
		</table>
		</form>
<?	}
}else{ 
	$requette = stripslashes($requette);

	echo("<table cellspacing=1 cellpadding=1><tr><td>");
	$action_button = new bo_button();
	$action_button->c1 = $MenuBgColor;
	$action_button->c2 = $MainFontColor;
	$action_button->name = "RETOUR";
	$action_button->action = "javascript:history.go(-1);";
	$action_button->display();
	echo("</td><td>");
	echo("Vous avez lancé la requette suivante : <b>".$requette."</b>");
	echo("</td></tr></table>");
	echo("<br>");
	/*if (ereg("DELETE",strtoupper($requette))) {
		echo("<b>POUR DES RAISONS DE SECURITE CET OUTIL NE PERMET PAS DE FAIRE DE DELETE !</b>");
	}*/
	if (ereg("DROP",strtoupper($requette))) {
		echo("<b>POUR DES RAISONS DE SECURITE CET OUTIL NE PERMET PAS DE FAIRE DE DROP !</b>");
	}elseif (ereg("SELECT",strtoupper($requette))) {
		$RS = mysql_query($requette);

		echo("Il y a <b>".mysql_num_rows($RS)." resultats</b>.");
		echo("<br><br>");
		echo("<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\">");
		echo("<tr bgcolor=\"".$MenuBgColor."\">");
		for($j=0;$j< mysql_num_fields($RS) ;$j++) {
			$tab[] = mysql_field_name($RS, $j);
			echo("<td align=\"center\">&nbsp;<b>".mysql_field_name($RS, $j)."</b></td>");
		}
		echo("</tr>");

		for($i=0;$i< mysql_num_rows($RS) ;$i++) {
			echo("<tr>");
			for($j=0;$j<count($tab);$j++) {
				echo("<td>&nbsp;".mysql_result($RS, $i, $tab[$j])."</td>");
			}
			echo("</tr>");			
		}

		echo("</table>");
	}else{
		$RS = mysql_query($requette);
		echo("<b>REQUETTE EFFECTUEE !</b>");
	}
} ?>