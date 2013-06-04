<?
// *** MAJ BDD
if ($_REQUEST['FLAG_PASSAGE']==1) {
	// >> suppression
	$chaine = "delete from "._CONST_BO_CODE_NAME."lib_champs where id_"._CONST_BO_CODE_NAME."table_def=".$_REQUEST['TableDef'];
	$RSsupp = mysql_query($chaine);

	// >> insertion
	$chaine = "select cur_table_name from "._CONST_BO_CODE_NAME."table_def where id_"._CONST_BO_CODE_NAME."table_def=".$_REQUEST['TableDef'];
	$RS = mysql_query($chaine);

	if (mysql_num_rows($RS)>0) {
		$chaine = "select * from ".mysql_result($RS,0,"cur_table_name");
		$RS2 = mysql_query($chaine);
	
		for ($i=0; $i< @mysql_num_fields($RS2); $i++) {
			$field_list = mysql_field_name($RS2, $i)."_list";
			$field = mysql_field_name($RS2, $i)."_champs";
			$fieldTitle = mysql_field_name($RS2, $i)."_uptitle";
			$fieldDesc = mysql_field_name($RS2, $i)."_desc";
			$fieldmultilingue = mysql_field_name($RS2, $i)."_multilingue";
			
			
			//("\n --field_list = " . $field_list);
			//("\n --field = " . $field);
			//("\n --fieldTitle = " . $fieldTitle);
			//("\n --fieldDesc = " . $fieldDesc);
			//("\n --fieldmultilingue = " . $fieldmultilingue);
			
			//("\n --Request(var_multilingue) = " . $_REQUEST['multilingue']);
			

			if (($_REQUEST[$field]!="") || ($_REQUEST[$field_list]!="") || $_REQUEST[$fieldmultilingue] == 1) 
			{
				$chaine = "insert into "._CONST_BO_CODE_NAME."lib_champs (field,list_libelle,libelle,id_"._CONST_BO_CODE_NAME."table_def,up_title,description,multilingue) values ('".mysql_field_name($RS2, $i)."','".$_REQUEST[$field_list]."','".$_REQUEST[$field]."',".$_REQUEST['TableDef'].",'".$_REQUEST[$fieldTitle]."','".$_REQUEST[$fieldDesc]."','". $_REQUEST[$fieldmultilingue] . "')";
				if (!mysql_query($chaine)) die("Erreur lors de la mise à jour : ".$chaine." : ".mysql_error());
			}
		}
	}

	echo("<script language='javascript'>");
	echo("location.href='bo_include_launcher.php?file=bo_sql_editor.php&TableDefModif=".$_REQUEST['TableDef']."&TableDef=".$_REQUEST['TableDef']."';");
	echo("</script>");

// *** AFFICHAGE FORMULAIRE
}else{
	$chaine = "select cur_table_name from "._CONST_BO_CODE_NAME."table_def where id_"._CONST_BO_CODE_NAME."table_def=".$_REQUEST['TableDef'];
	$RS = mysql_query($chaine);
		
	echo "<form method=\"post\" action=\"".NomFichier($_SERVER['PHP_SELF'],0)."\" name=\"FormChamps\">\n";
	echo("<input type='hidden' name='FLAG_PASSAGE' value='1'>");
	echo("<input type='hidden' name='TableDef' value='".$_REQUEST['TableDef']."'>");

	if (mysql_num_rows($RS)>0) {
		echo "<table ".$WidthTableType." border=\"$TableBorder\" cellspacing=\"$TableCellspacing\" cellpadding=\"$TableCellpadding\" bgcolor=\"$TableBgColor\">";

		echo("<tr bgcolor=".$TableEnTeteGgColor."><th>".$bo_lib_field_form_field."</td>");
		echo("<th>".$bo_lib_field_list_alias."</td>");
		echo("<th>".$bo_lib_field_form_alias."</td>");
		echo("<th>".$bo_lib_field_form_uptitle."</td>");
		echo("<th>".$bo_lib_field_form_downdesc."</td></tr>");
	
		$chaine = "select * from ".mysql_result($RS,0,"cur_table_name");
		$RS2 = mysql_query($chaine);
	
		for ($i=0; $i< @mysql_num_fields($RS2); $i++) {
			if ($fond_cellule == $TdBgColor1) {
				$fond_cellule = $TdBgColor2;
			}
			else {
				$fond_cellule = $TdBgColor1;
			}

			echo "<tr bgcolor=".$fond_cellule.">\n";
			echo "<td valign='top'>".mysql_field_name($RS2, $i)."</td>\n";

			$str = "select list_libelle, libelle, up_title, description, multilingue from "._CONST_BO_CODE_NAME."lib_champs where field='".mysql_field_name($RS2, $i)."' and id__table_def=".$_REQUEST['TableDef'];

			$RSval = mysql_query($str);

			if (mysql_num_rows($RSval)>0) {
				$var_list = mysql_result($RSval,0,"list_libelle");
				$var_val = mysql_result($RSval,0,"libelle");
				$var_tit = mysql_result($RSval,0,"up_title");
				$var_desc = mysql_result($RSval,0,"description");
				$var_multilingue = mysql_result($RSval,0,"multilingue");
				
				//("\n var_multilingue = " . $var_multilingue);
				
			}else{
				$var_list = "";
				$var_val = "";
				$var_tit = "";
				$var_desc = "";
				$var_multilingue = "";
			}

			echo "<td valign='top'><input type='text' name='".mysql_field_name($RS2, $i)."_list' value='".$var_list."' class='InputText'></td>\n";
			echo "<td valign='top'><input type='text' name='".mysql_field_name($RS2, $i)."_champs' value='".$var_val."' class='InputText'></td>\n";

			echo "<td valign='top'><input type='text' name='".mysql_field_name($RS2, $i)."_uptitle' value='".$var_tit."' class='InputText'></td>\n";
			echo "<td valign='top'><textarea cols='30' rows='2' class='InputText' name='".mysql_field_name($RS2, $i)."_desc'>".$var_desc."</textarea></td>\n";
			
			echo "<td valign='top'><input type='hidden' class='InputText' value='".$var_multilingue."' name='".mysql_field_name($RS2, $i)."_multilingue'></td>\n";
			echo "</tr>\n";
		}

		echo("<tr bgcolor=".$TableEnTeteGgColor."><td colspan='5'>&nbsp;</td></tr>");
		echo("</table>");

		echo("<br><i>Attention, les champs \"Up Title\" et \"Down Description\" ne sont affich&eacute;s que si le champ \"Alias Form\" est renseign&eacute;.<br></i>");

		//AFFICHAGE DU BOUTON ACTION
		echo("<br><table cellspacing='0' cellpadding='0' border='0'><tr>");
		echo("<td>");
			$action_button = new bo_button();
			$action_button->c1 = $MenuBgColor;
			$action_button->c2 = $MainFontColor;
			$action_button->name = $bo_lib_field_form_cancel;
			$action_button->action = "javascript:location.href='bo_include_launcher.php?file=bo_sql_editor.php&TableDefModif=".$_REQUEST['TableDef']."&TableDef=".$_REQUEST['TableDef']."';";
			$action_button->display();
		echo("</td><td>&nbsp;&nbsp;</td><td>");
			$action_button = new bo_button();
			$action_button->c1 = $MenuBgColor;
			$action_button->c2 = $MainFontColor;
			$action_button->name = $bo_lib_field_form_valide;
			$action_button->action = "javascript:document.FormChamps.submit();";
			$action_button->display();
		echo("</td></tr></table>");

	}
		
	echo "</form>\n";
}
?>
