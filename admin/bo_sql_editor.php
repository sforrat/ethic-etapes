<?
$result = mysql_list_tables($BaseName);

//Mode modifiaction
if ($TableDefModif) {
	$StrSQL = "Select * from "._CONST_BO_CODE_NAME."table_def where id_"._CONST_BO_CODE_NAME."table_def = \"".$TableDefModif."\"";
	$RstTableDef = mysql_query($StrSQL);
	$TableSelect = @mysql_result($RstTableDef,0,"cur_table_name");
	$champ_selection = @mysql_result($RstTableDef,0,"champ_selection");
	//$tab_selec_deroulante = split(";",@mysql_result($RstTableDef,0,"deroulante_selection"));
}

//Au chargement de la page ---> table par defaut
if (empty($TableSelect)){
	$TableSelect = @mysql_tablename($result, 0);
}

//Liste des champs
$StrSQL = "select * from ".$TableSelect;
$RstTableSelect = mysql_query($StrSQL);

//Mode Modification
if ($mode=="modif") {
	$ArrayAffList		= array();
	$ArrayAffForm		= array();
	$ArrayFormUpdate	= array();
	$Arrayalias		= array();
	$TabForainKeys		= array();
	$FormChamp_selection 	= "";
	$SelecDerouleForm	= "";

	for ($j=0; $j< @mysql_num_fields($RstTableSelect); $j++) {
		// gestion de la section par liste deroulante
		if ($_REQUEST["CheckSelecForm".@mysql_field_name($RstTableSelect, $j)] == "1") {
			$FormChamp_selection = @mysql_field_name($RstTableSelect, $j);
		}

		$SelecDerouleForm = $SelecDerouleForm.$_REQUEST["SelecDerouleForm".@mysql_field_name($RstTableSelect, $j)].";";
		
		if ($_REQUEST["CheckAffList".@mysql_field_name($RstTableSelect, $j)] == "1"){
				array_push($ArrayAffList,$TableSelect.".".@mysql_field_name($RstTableSelect, $j));
		}

		if ($_REQUEST["CheckAffForm".@mysql_field_name($RstTableSelect, $j)] == "1") {
			$valeur_alias = $_REQUEST["alias".@mysql_field_name($RstTableSelect, $j)];
			if (substr(strtolower(@mysql_field_name($RstTableSelect, $j)),0,3) == "id_"){
				
				//Clef etrangere
				if (substr(@mysql_field_name($RstTableSelect, $j),0,strlen(@mysql_field_name($RstTableSelect, $j))-3)!=$TableSelect) {
					
					if ($valeur_alias){
						// API 02/03/05
						//array_push($ArrayAffForm,substr(@mysql_field_name($RstTableSelect, $j),-(strlen(@mysql_field_name($RstTableSelect, $j))-3)).".".@mysql_field_name($RstTableSelect, $j)." As ".${"alias".@mysql_field_name($RstTableSelect, $j)});
						array_push($ArrayAffForm,$TableSelect.".".@mysql_field_name($RstTableSelect, $j)." As ".${"alias".@mysql_field_name($RstTableSelect, $j)});
					}
					else {

						array_push($ArrayAffForm,$TableSelect.".".@mysql_field_name($RstTableSelect, $j));
					}
				}
				//Clef
				else {
					if ($valeur_alias){
						array_push($ArrayAffForm,$TableSelect.".".@mysql_field_name($RstTableSelect, $j)." As ".$valeur_alias);
					}
					else {
						array_push($ArrayAffForm,substr(@mysql_field_name($RstTableSelect, $j),-(strlen(@mysql_field_name($RstTableSelect, $j))-3)).".".@mysql_field_name($RstTableSelect, $j));
					}
				}
			}
			else {
				
				//Autres champs
				if ($valeur_alias){
					array_push($ArrayAffForm,$TableSelect.".".@mysql_field_name($RstTableSelect, $j)." As ".$valeur_alias);
				}
				else {
					array_push($ArrayAffForm,$TableSelect.".".@mysql_field_name($RstTableSelect, $j));
				}
			}

			//Preparation de la requete d'insertion dans la base
				array_push($ArrayFormUpdate,$TableSelect.".".@mysql_field_name($RstTableSelect, $j));
		}

		if ($_REQUEST["CheckAffForm".@mysql_field_name($RstTableSelect, $j)] == "1") {
//			if (${"alias".@mysql_field_name($RstTableSelect, $j)}){
//				array_push($ArrayFormUpdate,$TableSelect.".".@mysql_field_name($RstTableSelect, $j)." As ".${"alias".@mysql_field_name($RstTableSelect, $j)});
//			}
//			else {
//				array_push($ArrayFormUpdate,$TableSelect.".".@mysql_field_name($RstTableSelect, $j));
//			}
		}

		//Gestion des alias
		if ($_REQUEST["CheckAffList".@mysql_field_name($RstTableSelect, $j)] == "1"){
			//L'alias a ete saisie
			if ($_REQUEST["alias".@mysql_field_name($RstTableSelect, $j)]) {
				array_push($Arrayalias,$_REQUEST[${"alias".@mysql_field_name($RstTableSelect, $j)}]);
			}
			//L'alias n'as pas ete saisie, on prend le nom du champ
			else {
				array_push($Arrayalias,@mysql_field_name($RstTableSelect, $j));
			}
		}

		//Clef de la table
		if (strtolower(@mysql_field_name($RstTableSelect, $j)) == strtolower("id_".$TableSelect)) { // utilisation de la fonction strtolower a couse des probleme de majuscule entre Nt et linux
			$TableKey = strtolower("id_".$TableSelect);
		}
		//Clef etrangère
		elseif (substr(strtolower(@mysql_field_name($RstTableSelect, $j)),0,3) == "id_" && $_REQUEST["CheckAffForm".@mysql_field_name($RstTableSelect, $j)] == "1") {
			array_push($TabForainKeys,	substr(@mysql_field_name($RstTableSelect, $j), -(strlen(@mysql_field_name($RstTableSelect, $j))-3)));
		}
	}

		//Construction de la clause From de la requete SQL
		// *** API 02/03/05
		// => desactive la jointure sur les tables etrangeres
/*		if (count($TabForainKeys)>0){
			for ($i=0;$i<count($TabForainKeys);$i++){
				$StrSQLClauseWhere .= getTruename($TabForainKeys[$i]).".id_".getTruename($TabForainKeys[$i])."=".$TableSelect.".id_".$TabForainKeys[$i]." And ";
			}

			reset($tab_temp);
			for($a=0;$a<count($TabForainKeys);$a++) {
				if (!in_array(getTruename($TabForainKeys[$a]),$tab_temp)) {
					$tab_temp[] = getTruename($TabForainKeys[$a]);
				}
			}

			$ClauseFromWhere	= "From ".$TableSelect.", ".@join(",",$tab_temp)." Where ".substr($StrSQLClauseWhere,0,strlen($StrSQLClauseWhere)-5);

		}
		else {*/
			$ClauseFromWhere	= "From ".$TableSelect;
		//}


		for ($i=0;$i<count($TabForainKeys);$i++){
			//$Keys .= $TabForainKeys[$i].".id_".$TabForainKeys[$i].", ";
			$Keys .= $TableSelect.".id_".$TabForainKeys[$i].", ";
		}
		//$Keys = substr($Keys,0,strlen($Keys)-2);




//Na pas oublier si la clef n'est pas coché : ajouté le champ
//$TableSelect.".id_".$TableSelect.", ".

//				echo "<BR>".$Keys."<BR>".$ClauseFromWhere."<BR><BR>";




	//Gestion des options
	/*for ($i=0 ; $i < $nb_mode ; $i++) {
		if (${"mode_".$i}==1){
			if ($_REQUEST["mode_".$i."_mode"]=="nouveau"){
				if ($genre=="feminin") {
					$Form_titre_col[] = "Nouvelle";
				}
				else {
					$Form_titre_col[] = "Nouveau";
				}
				$Form_mode_col[] = $_REQUEST["mode_".$i."_mode"];				
			}
			else {
				$Form_mode_col[] = $_REQUEST["mode_".$i."_mode"];
				$Form_titre_col[] =$_REQUEST["mode_".$i."_txt"];
			}
		}			
	}*/
		for ($i=0 ; $i < $_REQUEST["nb_mode"] ; $i++) {
		
		if ($_REQUEST["mode_".$i]==1){
			
			if ($_REQUEST["mode_".$i."_mode"]=="nouveau"){
				if ($genre=="feminin") {
					$Form_titre_col[] = "Nouvelle";
				}
				else {
					$Form_titre_col[] = "Nouveau";
				}
				$Form_mode_col[] = $_REQUEST["mode_".$i."_mode"];				
			}
			else {
				$Form_mode_col[] = $_REQUEST["mode_".$i."_mode"];
				$Form_titre_col[] =$_REQUEST["mode_".$i."_txt"];
			}
		}			
	}

	$Form_mode_col  = join(";",$Form_mode_col);

	$Form_titre_bouton_array = "Cr&eacute;er;Modifier;Supprimer";
	$Form_titre_col = join(";",$Form_titre_col);
	
	//GESTION DES CASES A COCHERS TOUT AFFICHER
	if ($check_aff_all_list==1) {
		$select_liste = "select ".$TableSelect.".* ";
		$alias = "";
	}
	else {
		$select_liste = "Select ".$TableSelect.".id_".$TableSelect.",".@join(",",$ArrayAffList);
		$alias = "id;".@join(";",$Arrayalias);
	}

	if ($check_aff_all_form==1) {
		$select_modif_ajout = $select_update_insert = "select ".$TableSelect.".* ";
		$sql_body = "from ".$TableSelect;
	}
	else {
		$select_modif_ajout = "Select ".$TableSelect.".id_".$TableSelect.", ".@join(",",$ArrayAffForm);
		$select_update_insert = "Select ".$TableSelect.".id_".$TableSelect.", ".@join(",",$ArrayFormUpdate);
		$sql_body = $ClauseFromWhere;
	}

   //Modification
   if ($TableDefModif) {
		  $StrSQL = "UPDATE "._CONST_BO_CODE_NAME."table_def SET select_liste=\"".$select_liste."\",  alias=\"".$alias."\",  select_modif_ajout=\"".$select_modif_ajout."\", select_update_insert= \"".$select_update_insert."\",  sql_body=\"".$sql_body."\",  titre_rubrique_array=\"".$Form_titre_rubrique_array."\",  titre_bouton_array=\"".$Form_titre_bouton_array."\",  item=\"".$Form_item."\",  titre_col=\"".$Form_titre_col."\",  mode_col=\"".$Form_mode_col."\",  upload_path=\"".$Form_upload_path."\",  cur_table_name=\"".$Form_cur_table_name."\",  id_"._CONST_BO_CODE_NAME."menu=\"".$Form_id_bo_menu."\",  menu_title=\"".$Form_menu_title."\",  ordre_menu=\"".$Form_ordre_menu."\", deroulante_selection=\"".$SelecDerouleForm."\" WHERE id_"._CONST_BO_CODE_NAME."table_def='".$TableDefModif."'";
		$flag_nouv=0;
   }
   //Nouvel enregistrement
   else {
		  $StrSQL = "insert into "._CONST_BO_CODE_NAME."table_def (id_"._CONST_BO_CODE_NAME."menu, id_"._CONST_BO_CODE_NAME."profil,  date_auto, select_liste, alias, select_modif_ajout, select_update_insert, sql_body, titre_rubrique_array, titre_bouton_array, item, titre_col, mode_col, upload_path, cur_table_name, menu_title, ordre_menu, show_id,deroulante_selection) values ( ".$Form_id_bo_menu.", 1, NOW(),  \"".$select_liste."\",\"".$alias."\", \"".$select_modif_ajout."\", \"".$select_update_insert."\",\"".$sql_body."\", \"".$Form_titre_rubrique_array."\", \"".$Form_titre_bouton_array."\", \"".$Form_item."\", \"".$Form_titre_col."\", \"".$Form_mode_col."\", \"".$Form_upload_path."\", \"".$Form_cur_table_name."\", \"".$Form_menu_title."\", \"".$Form_ordre_menu."\", 0,\"".$SelecDerouleForm."\")";
		$flag_nouv=1;
   }


	//Insetion ou modification de la declaration de formulaire dans la table bo_table_def
	mysql_query($StrSQL);


	//Si on est en mode nouveau alors on recuper l'id de l'item ajouté pour voir se mettre en mode modif de l'item apres l'insertion
	if (empty($TableDefModif)) {
		$TableDefModif = mysql_insert_id();
	}


	// *** API insertion dans la table selection
	// *** 01/03/05
	if ($_REQUEST['active_select_champ']==1) {
		$is_actif = 1;
	}else{
		$is_actif = 0;
	}

	if ($_REQUEST['all_enable_select_champ']==1) {
		$is_all_enable = 1;
	}else{
		$is_all_enable = 0;
	}

	$chaine = "insert into "._CONST_BO_CODE_NAME."select_champ (champ_selection,libelle,down_description,specific_sql,flag_all_enable,flag_actif,id__table_def) values ('".$champ_selection_select_champ."','".$lib_select_champ."','".$down_desc_select_champ."','".$spec_sql_select_champ."','".$is_all_enable."','".$is_actif."','".$TableDefModif."')";
	if ($flag_nouv==0) {
		$str_verife = "select id_"._CONST_BO_CODE_NAME."table_def from "._CONST_BO_CODE_NAME."select_champ where id_"._CONST_BO_CODE_NAME."table_def=".$TableDefModif;
		$RSbis = mysql_query($str_verife);

		if (mysql_num_rows($RSbis)>0) {
			$chaine = "update "._CONST_BO_CODE_NAME."select_champ set flag_actif='".$is_actif."', libelle='".$lib_select_champ."', down_description='".$down_desc_select_champ."', champ_selection='".$champ_selection_select_champ."', specific_sql='".$spec_sql_select_champ."', flag_all_enable='".$is_all_enable."' where id__table_def=".$TableDefModif;
		}
	}

	mysql_query($chaine);

	//On redirige sur l'id de l'item pour le voir en mode modif
	redirect(NomFichier($_SERVER['PHP_SELF'],0)."?TableSelect=".$TableSelect."&TableDefModif=".$TableDefModif);

//	echo $StrSQL;
}

$array_mode			= array("nouveau","duplicate","modif","supr");
$array_mode_titre 	= array("Nouveau","Dupliquer","Modifier","Supprimer");

//On recupere les valeurs de l'enregistrement dans bo_table_def
if ($TableDefModif) {
	$cur_table_name			= @mysql_result($RstTableDef,0,"cur_table_name");
	$select_liste			= @mysql_result($RstTableDef,0,"select_liste");
	$alias					= split(";",@mysql_result($RstTableDef,0,"alias"));
	$select_modif_ajout		= @mysql_result($RstTableDef,0,"select_modif_ajout");
	$select_update_insert	= @mysql_result($RstTableDef,0,"select_update_insert");
	$sql_body				= @mysql_result($RstTableDef,0,"sql_body");
	$titre_rubrique_array	= @mysql_result($RstTableDef,0,"titre_rubrique_array");
	$titre_bouton_array		= @mysql_result($RstTableDef,0,"titre_bouton_array");
	$item					= @mysql_result($RstTableDef,0,"item");
	$titre_col				= @mysql_result($RstTableDef,0,"titre_col");
	$mode_col				= @mysql_result($RstTableDef,0,"mode_col");
	$upload_path			= @mysql_result($RstTableDef,0,"upload_path");
	$cur_table_name			= @mysql_result($RstTableDef,0,"cur_table_name");
	$menu_title				= @mysql_result($RstTableDef,0,"menu_title");
	$ordre_menu				= @mysql_result($RstTableDef,0,"ordre_menu");
	$id_bo_menu				= @mysql_result($RstTableDef,0,"id_"._CONST_BO_CODE_NAME."menu");

	// *** recuperation des champs specifics des listes des selections
	$str = "select * from "._CONST_BO_CODE_NAME."select_champ where id_"._CONST_BO_CODE_NAME."table_def=".$TableDefModif;
	$RS_select = mysql_query($str);

	if (mysql_num_rows($RS_select)>0) {
		$lib_select_champ = mysql_result($RS_select,0,"libelle");
		$down_desc_select_champ = mysql_result($RS_select,0,"down_description");
		$spec_sql_select_champ = mysql_result($RS_select,0,"specific_sql");

		$champ_selection_select_champ = mysql_result($RS_select,0,"champ_selection");

		if (mysql_result($RS_select,0,"flag_actif")==1) {
			$str_active_select_champ = " checked ";
		}else{
			$str_active_select_champ = " ";
		}

		if (mysql_result($RS_select,0,"flag_all_enable")==1) {
			$str_all_enable_select_champ = " checked ";
		}else{
			$str_all_enable_select_champ = " ";
		}
		
		
	}

}
//Valeur par defaut si on creer un nouveau formulaire
else {
	$titre_rubrique_array		= "Liste;Cr&eacute;ation;Modification;Suppression";
	$titre_bouton_array		= "Cr&eacute;er;Modifier;Supprimer";
	$item					= "";
	$titre_col				= "Nouveau;Dupliquer;Modifier;Supprimer";
	$mode_col				= "nouveau;duplicate;modif;supr";
	$upload_path				= "";
	$cur_table_name			= "";
	$menu_title				= "";
	$ordre_menu				= 0;
	$id_bo_menu				= 1;
}

//Formulaire permettant de choisir le table
echo "<form method=\"post\" action=\"".NomFichier($_SERVER['PHP_SELF'],0)."?TableSelect=$TableSelect"."\" name=\"FormSelectTable\">\n";

//Titre
echo "S&eacute;lection de la table sur laquelle cr&eacute;er le Formulaire : <BR><BR>";

echo("<table cellspacing='0' cellpadding='0'>");
echo("<tr><td>");
//Liste des tables dans la listbox
	echo "<select class=\"InputText\" name=\"TableSelect\" onchange=\"javascript:document.FormSelectTable.submit();\">\n";
	for ($i=0 ; $i < @mysql_num_rows($result) ; $i++) {
		//Selection de l'item
		if ($TableSelect==@mysql_tablename($result, $i)) {$selected = "selected";}	else {$selected = "";}
		echo "	<option value=\"".@mysql_tablename($result, $i)."\"".$selected.">".@mysql_tablename($result, $i)."</option>\n";
	}
	echo "</select></td>\n";
echo("<td>&nbsp;&nbsp;&nbsp;</td><td>\n");

// *** Bouton sur alias de formulaire
	$action_button = new bo_button();
	$action_button->c1 = $MenuBgColor;
	$action_button->c2 = $MainFontColor;
	$action_button->name = "Alias of the Form >>";
	$action_button->action = "javascript:location.href='bo_include_launcher.php?file=bo_lib_field_form.php&TableDef=".$_REQUEST['TableDef']."';";
	$action_button->display();

echo("</td></tr></table>\n");
echo "</form>\n";


echo "<form method=\"post\" action=\"".NomFichier($_SERVER['PHP_SELF'],0)."?TableSelect=$TableSelect&mode=modif&TableDefModif=$TableDefModif\" name=\"FormDetailTable\">\n";
echo "<table ".$WidthTableType." border=\"$TableBorder\" cellspacing=\"$TableCellspacing\" cellpadding=\"$TableCellpadding\" bgcolor=\"$TableBgColor\">";
echo "<tr bgcolor=".$TableEnTeteGgColor.">\n";
echo "<th>Champs</th>\n";
echo "<th>alias</th>\n";
echo "<th>Afficher dans<BR>le listing</th>\n";
echo "<th>Afficher dans<BR>le formulaire</th>\n";
echo "<th colspan='2'>Libell&eacute; de s&eacute;lection</th>\n";
//echo "<th>Ordre</th>\n";
echo "</tr>\n";

$Cpalias = -1;

for ($j=1; $j< @mysql_num_fields($RstTableSelect); $j++) {
		if ($fond_cellule == $TdBgColor1) {
			$fond_cellule = $TdBgColor2;
		}
		else {
			$fond_cellule = $TdBgColor1;
		}

	
	if ($TableDefModif) {
		//On verifie si le champs est dans la liste
		if (
			eregi($TableSelect.".".@mysql_field_name($RstTableSelect, $j), $select_liste)
			|| eregi(@mysql_field_name($RstTableSelect, $j), $select_liste)
			|| eregi(str_replace("id_","",@mysql_field_name($RstTableSelect, $j)).".".@mysql_field_name($RstTableSelect, $j), $select_liste)
			) {
			$CheckedClauseSelect = "checked";
			$aliasAff =	$alias[$j-1-$Cpalias];
		}
		else {
			$CheckedClauseSelect = "";
			$aliasAff = "";
			$Cpalias++;
		}

		//Cas particulier pour les rubrique, on n'affiche pas d'alias
		if (ereg("id_"._CONST_BO_CODE_NAME."item_menu",$aliasAff)) {
			$aliasAff = "";
		}

		//On verifie si le champs existe dans la requete d'affichage du formulaire
		if (
			eregi($TableSelect.".".@mysql_field_name($RstTableSelect, $j),$select_modif_ajout)
			|| eregi(@mysql_field_name($RstTableSelect, $j),$select_modif_ajout)
			|| eregi(str_replace("id_","",@mysql_field_name($RstTableSelect, $j)).".".@mysql_field_name($RstTableSelect, $j), $select_modif_ajout)
			) {
			$CheckedForm = "checked";
		}
		else {
			$CheckedForm = "";
		}

		if (eregi(@mysql_field_name($RstTableSelect, $j),$champ_selection)) {
			$CheckedSelect = "checked";
		}else{
			$CheckedSelect = "";
		}
	}
	else {
		$CheckedForm = "checked";
	}

	echo "<tr bgcolor=".$fond_cellule.">\n";
	echo "<td>".@mysql_field_name($RstTableSelect, $j)."</td>";
	
	echo "<td align=\"center\"><input class=\"InputText\" type=\"text\" name=\"alias".@mysql_field_name($RstTableSelect, $j)."\" value=\"".$aliasAff."\"></td>\n";
	
	echo "<td align=\"center\"><input onClick=\"unchecked(this)\" id=\"CheckAffList_".$j."\" type=\"checkbox\" ".$CheckedClauseSelect." name=\"CheckAffList".@mysql_field_name($RstTableSelect, $j)."\" value=\"1\"></td>\n";
	
	echo "<td align=\"center\"><input onClick=\"unchecked(this)\" id=\"CheckAffForm_".$j."\" type=\"checkbox\" ".$CheckedForm." name=\"CheckAffForm".@mysql_field_name($RstTableSelect, $j)."\" value=\"1\"></td>\n";

	if (eregi("id_",@mysql_field_name($RstTableSelect, $j))) {
/*		echo("<td align=\"center\"><select class=\"InputText\" id=\"SelecDerouleForm_".$j."\" name=\"SelecDerouleForm".@mysql_field_name($RstTableSelect, $j)."\">");

		$chaine = "select * from ".getTruename(substr(@mysql_field_name($RstTableSelect, $j),3));
		$RS = mysql_query($chaine);

		for($i=0;$i<@mysql_num_fields($RS);$i++) {
			if (mysql_field_name($RS, $i)==$tab_selec_deroulante[$j]) {
				$SelectSelect = " selected ";
			}else{
				$SelectSelect = "";
			}
			echo("<option value=\"".@mysql_field_name($RS, $i)."\" ".$SelectSelect." >".@mysql_field_name($RS, $i)."</option>");
		}

		echo("</select></td>");*/

		//echo("<td align=\"center\"><input class=\"InputText\" type=\"text\" name=\"SelecDerouleForm".@mysql_field_name($RstTableSelect, $j)."\" value=\"".$tab_selec_deroulante[$j]."\"></td>");
		
		echo("<td align=\"center\"><input class=\"InputText\" type=\"text\" name=\"SelecDerouleForm".@mysql_field_name($RstTableSelect, $j)."\" value=\"".$tab_selec_deroulante_field[@mysql_field_name($RstTableSelect, $j)]."\"></td>");
		

		echo("<td><a href='javascript:openSelection(\"".getTruename(substr(@mysql_field_name($RstTableSelect, $j),3))."\",\"SelecDerouleForm".@mysql_field_name($RstTableSelect, $j)."\");'>Modifier</a></td>");
	}else{
		echo("<td colspan='2'>&nbsp;</td>");
	}

	echo "</tr>\n";
}

	//GESTION DES CASES A COCHERS : TOUT AFFICHER
	if (($TableDefModif && ereg($cur_table_name.".\*",$select_liste)) || empty($TableDefModif)) {
		$mon_checked1 = "checked";
	}
	else {
		$mon_checked1 = "";
	}

	if (($TableDefModif && ereg($cur_table_name.".\*",$select_modif_ajout)) || empty($TableDefModif)) {
		$mon_checked2 = "checked";
	}
	else {
		$mon_checked2 = "";
	}

	echo "<tr align=\"right\">\n";
	echo "<td colspan=\"2\"><b>Tout Afficher</b></td>";
	echo "<td align=\"center\"><input onClick=\"checked_all('CheckAffList',".$j.",this.checked)\" type=\"checkbox\" name=\"check_aff_all_list\" value=\"1\" ".$mon_checked1."></td>\n";
	echo "<td align=\"center\"><input onClick=\"checked_all('CheckAffForm',".$j.",this.checked)\" type=\"checkbox\" name=\"check_aff_all_form\" value=\"1\" ".$mon_checked2."></td>\n";
	echo("<td>&nbsp;</td>");
	echo "</tr>\n";

	?> 
	<script>
	function checked_all(input,i,value) {
		//alert(input+"--"+i+"--"+value);
		for (j=1;j<i;j++) {
			if (value==1) {
				document.all[input+"_"+j].checked = true;
				//document.all['CheckAffList_'+j].checked = true;
				//document.all['CheckAffForm_'+j].checked = true;
			}
			else {
				document.all[input+"_"+j].checked = false;
				//document.all['CheckAffList_'+j].checked = false;
				//document.all['CheckAffForm_'+j].checked = false;
			}
		}
	}
	function unchecked(me) {
		if (me.name.search("CheckAffList")!=-1) {
			document.all['check_aff_all_list'].checked=false;
		}
		else {
			document.all['check_aff_all_form'].checked=false;
		}
	}
	</script>
	<?
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
echo "</table>\n<br>";

// Tableau du champs de sélection
echo "<b>Tableau du champs de s&eacute;lection</b><br><i>(Le libell&eacute; de la liste reprend celui du libell&eacute; de s&eacute;lection)</i><br><br><table ".$WidthTableType." border=\"$TableBorder\" cellspacing=\"$TableCellspacing\" cellpadding=\"$TableCellpadding\" bgcolor=\"$TableBgColor\">";
echo "<tr bgcolor=".$TableEnTeteGgColor.">\n";
echo "<th>Libell&eacute;</th>\n";
echo "<th>Down Description</th>\n";
echo "<th>SQL (avec le where)</th>\n";
echo "<th>Champs concern&eacute;</th>\n";
echo "<th>Tous autoris&eacute;</th>\n";
echo "<th>Activer</th>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td valign='middle' align=\"center\"><input class=\"InputText\" type=\"text\" name=\"lib_select_champ\" value=\"".$lib_select_champ."\"></td>\n";
echo "<td align=\"center\"><textarea class=\"InputText\" name=\"down_desc_select_champ\">".$down_desc_select_champ."</textarea></td>\n";
echo "<td align=\"center\"><textarea class=\"InputText\" name=\"spec_sql_select_champ\">".$spec_sql_select_champ."</textarea></td>\n";

echo("<td align=\"center\"><select class=\"InputText\" name=\"champ_selection_select_champ\">");

for ($l=1; $l< @mysql_num_fields($RstTableSelect); $l++) {
	if (substr(strtolower(@mysql_field_name($RstTableSelect, $l)),0,3) == "id_"){
		if ($champ_selection_select_champ==mysql_field_name($RstTableSelect, $l)) {
			$str_selected = " selected ";
		}else{
			$str_selected = " ";
		}
	
		echo("<option value=\"".mysql_field_name($RstTableSelect, $l)."\" ".$str_selected." >".mysql_field_name($RstTableSelect, $l)."</option>");
	}
}

echo("</select></td>\n");

echo "<td align=\"center\"><input id=\"all_enable_select_champ\" type=\"checkbox\" ".$str_all_enable_select_champ." name=\"all_enable_select_champ\" value=\"1\"></td>\n";


echo "<td align=\"center\"><input id=\"active_select_champ\" type=\"checkbox\" ".$str_active_select_champ." name=\"active_select_champ\" value=\"1\"></td>\n";

echo "</tr>\n";
echo "</table>\n";

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

//Masculin / feminin
echo "<p>Masculin<input type=\"radio\" name=\"genre\" value=\"masculin\">&nbsp;&nbsp;F&eacute;minin<input type=\"radio\" name=\"genre\" value=\"feminin\">";

//Liste des options de TableDef
echo "<table ".$WidthTableType." border=\"$TableBorder\" cellspacing=\"$TableCellspacing\" cellpadding=\"$TableCellpadding\" bgcolor=\"$TableBgColor\">\n";
echo "	<tr bgcolor=".$TableEnTeteGgColor.">\n";
echo "		<th>Champs</th>\n";
echo "		<th>Valeur</th>\n";
echo "	</tr>\n";
echo "	<tr bgcolor=".$fond_cellule.">\n";
echo "		<td>Titres (L,A,M,S) :</td>\n";
echo "		<td><input size=\"70\" class=\"InputText\" type=\"text\" name=\"Form_titre_rubrique_array\" value=\"".$titre_rubrique_array."\"></td>\n";
echo "	</tr>\n";
echo "	<tr bgcolor=".$fond_cellule.">\n";
echo "		<td>El&eacute;ments principal du formulaire :</td>\n";
echo "		<td><input size=\"70\" class=\"InputText\" type=\"text\" name=\"Form_item\" value=\"".$item."\"></td>\n";
echo "	</tr>\n";



echo "	<tr bgcolor=".$fond_cellule.">\n";
echo "		<td>Modes associ&eacute;s au colonnes :</td>\n";
echo "<td>";

$mode_col =  split(";",$mode_col);
$titre_col = split(";",$titre_col);

for ($i=0 ; $i < count($mode_col) ; $i++) {
	if (!in_array($mode_col[$i],$array_mode)){
		$array_mode[] = $mode_col[$i];
		$array_mode_titre[] = $titre_col[$i];
	}
}

for ($i=0 ; $i < count($array_mode) ; $i++) {
	if (in_array($array_mode[$i],$mode_col)){
		$checked = "checked"; 
	}
	else {
		$checked = "";
	}
	
	echo "&nbsp;".$array_mode_titre[$i]."<input type=\"checkbox\" name=\"mode_".$i."\" value=\"1\" ".$checked.">";
	echo "<input type=\"hidden\" name=\"mode_".$i."_mode\" value=\"".$array_mode[$i]."\">";	
	echo "<input type=\"hidden\" name=\"mode_".$i."_txt\" value=\"".$array_mode_titre[$i]."\">";
	echo "&nbsp;|";

} 

echo "<input type=\"hidden\" name=\"nb_mode\" value=\"".count($array_mode)."\">";

echo "</td>";
echo "	</tr>\n";


echo "	<tr bgcolor=".$fond_cellule.">\n";
echo "		<td>Path des images à Uploader :</td>\n";
echo "		<td><input size=\"70\" class=\"InputText\" type=\"text\" name=\"Form_upload_path\" value=\"".$upload_path."\"></td>\n";
echo "	</tr>\n";
echo "	<tr bgcolor=".$fond_cellule.">\n";
echo "		<td>Table concern&eacute;e :</td>\n";
echo "		<td><input size=\"70\" class=\"InputText\" type=\"text\" name=\"Form_cur_table_name\" value=\"".$TableSelect."\"></td>\n";
echo "	</tr>\n";

//Liste des menus
echo "<tr bgcolor=".$fond_cellule."><td>Menu :</td><td><select class=\"InputText\" name=\"Form_id_bo_menu\">\n";
	$RstCat = mysql_query("Select * from "._CONST_BO_CODE_NAME."menu order by "._CONST_BO_CODE_NAME."menu");
	for ($i=0;$i<@mysql_num_rows($RstCat);$i++) {
		if (@mysql_result($RstCat,$i,"id_"._CONST_BO_CODE_NAME."menu")==$id_bo_menu) {$selected = "selected";} else {$selected = "";}
		echo "<option value=\"".@mysql_result($RstCat,$i,"id_"._CONST_BO_CODE_NAME."menu")."\" ".$selected.">".@mysql_result($RstCat,$i,""._CONST_BO_CODE_NAME."menu")."</option>";
	}
echo "</select></td></tr>\n";

echo "<tr bgcolor=".$fond_cellule."><td>Nom affich&eacute; dans le menu :</td><td><input size=\"70\" class=\"InputText\" type=\"text\" name=\"Form_menu_title\" value=\"".$menu_title."\"></td></tr>\n";
echo "<tr bgcolor=".$fond_cellule."><td>Ordre d'affichage dans le menu :</td><td><input size=\"5\" class=\"InputText\" type=\"text\" name=\"Form_ordre_menu\" value=\"".$ordre_menu."\"></td></tr>\n";
echo "</table>";
if ($TableDefModif) {
	$BotonFormTitle = "Modifier";
}
else {
	$BotonFormTitle = "Nouveau";
}


//AFFICHAGE DU BOUTON ACTION
echo "<p><blockquote><blockquote><blockquote><blockquote><blockquote><blockquote>";
$action_button = new bo_button();
$action_button->c1 = $MenuBgColor;
$action_button->c2 = $MainFontColor;
$action_button->name = $BotonFormTitle;
$action_button->action = "javascript:document.FormDetailTable.submit();";
$action_button->display();
echo "</blockquote></blockquote></blockquote></blockquote></blockquote></blockquote>\n";

echo "</form>\n";


//Affichage de la requete en mode modif
if ($TableDefModif) {
	echo get_sql_format($select_liste.$sql_body);
	echo "<hr>";
	echo get_sql_format($select_modif_ajout.$sql_body);
	echo "<hr>";	
	echo get_sql_format($select_update_insert.$sql_body);
}




//GESTION DE L'ETAT PAR DEFAUT DES CASES A COCHER
if (($TableDefModif && ereg($cur_table_name.".\*",$select_liste)) || empty($TableDefModif)) {
	?><script>
	checked_all('CheckAffList',<?=$j?>,true);
	</script><?
}
if (($TableDefModif && ereg($cur_table_name.".\*",$select_modif_ajout)) || empty($TableDefModif)) {
	?><script>
	checked_all('CheckAffForm',<?=$j?>,true);
	</script><?
}
?> 
