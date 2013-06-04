<tr>
    <td colspan="3">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr><td class="bg"><img src="/images/pixtrans.gif" width="1" height="1"></td></tr>
        </table>
    </td>
</tr>
<tr>
    <td colspan="3"><?=_TITRE_FORM_ELEMENT?></td>
</tr>
<?
//***************  On récupere les noms des tables concernant le formulaire 
//On les definit par defaut
$table_gab_formulaire = "";
$table_form_elementform = "";
$table_form_biblio_champs = "";
$table_form_type_champs = "";
$table_form_unite = "";


$sql_table_form = "SELECT cur_table_name, id_"._CONST_BO_CODE_NAME."table_def".
		" from "._CONST_BO_CODE_NAME."table_def".
		" where ( id_"._CONST_BO_CODE_NAME."table_def = "._CONST_TABLEDEF_GAB_FORMULAIRE.
		" or id_"._CONST_BO_CODE_NAME."table_def = "._CONST_TABLEDEF_FORM_ELEMENTFORM.
		" or id_"._CONST_BO_CODE_NAME."table_def = "._CONST_TABLEDEF_FORM_TYPE_CHAMPS.
		" or id_"._CONST_BO_CODE_NAME."table_def = "._CONST_TABLEDEF_FORM_BIBLIO_CHAMPS.
		" or id_"._CONST_BO_CODE_NAME."table_def = "._CONST_TABLEDEF_FORM_UNITE . ")";
$Rst_table_form = mysql_query($sql_table_form);

?>
<tr><td colspan="3">

<?
for ($j=0; $j< mysql_numrows($Rst_table_form); $j++)
{
	switch(mysql_result($Rst_table_form, $j, "id_"._CONST_BO_CODE_NAME."table_def"))
	{
		case _CONST_TABLEDEF_GAB_FORMULAIRE:
			$table_gab_formulaire = mysql_result($Rst_table_form, $j, "cur_table_name");
			break;
		case _CONST_TABLEDEF_FORM_ELEMENTFORM :
			$table_form_elementform = mysql_result($Rst_table_form, $j, "cur_table_name");
			break;
		case _CONST_TABLEDEF_FORM_TYPE_CHAMPS :
			$table_form_type_champs = mysql_result($Rst_table_form, $j, "cur_table_name");
			break;
		case _CONST_TABLEDEF_FORM_BIBLIO_CHAMPS :
			$table_form_biblio_champs = mysql_result($Rst_table_form, $j, "cur_table_name");
			break;
		case _CONST_TABLEDEF_FORM_UNITE :
			$table_form_unite = mysql_result($Rst_table_form, $j, "cur_table_name");
			break;
	}
}
?>
</td></tr>
<?

$sql_form_element = "SELECT F_EF.id_".$table_form_elementform.
		",F_EF.id_".$table_gab_formulaire.
		",F_EF.LibelleChamp".
		",F_BC.Libelle".
		",F_TC.Type_Champ".
		",F_EF.ValeurInitiale".
		",F_U.unite".
		",F_EF.obligatoire".
		",F_EF.Afficher".
		" FROM ".$table_form_elementform." F_EF,".$table_form_biblio_champs." F_BC".",".$table_form_type_champs." F_TC".",".$table_form_unite." F_U".
		" where F_EF.id_".$table_gab_formulaire."=".$ID.
		" and F_EF.id_".$table_form_biblio_champs."=F_BC.id_".$table_form_biblio_champs.
		" and F_TC.id_".$table_form_type_champs."=F_BC.id_".$table_form_type_champs.
		" and F_U.id_".$table_form_unite."=F_BC.id_".$table_form_unite.
		" order by F_EF.ordre";
$Rst_form_element = mysql_query($sql_form_element);
if(mysql_numrows($Rst_form_element)>0)
{
	?>
	<tr>
	 <td colspan="3">
	 	<table border="0" cellspacing="1" cellpadding="2" bgcolor="<?=$TableBgColor?>">
				<tr bgcolor="<?=$TableEnTeteGgColor?>">
				<?
				for ($ncols=2; $ncols< @mysql_num_fields($Rst_form_element); $ncols++)
				{
					echo("<th>".bo_strip_pre_suf(mysql_fieldname($Rst_form_element,$ncols),@mysql_field_type($Rst_form_element,$ncols),@mysql_field_len($Rst_form_element,$ncols))."</th>");
				}
				?>
				</tr>
				<?
				for ($i=0; $i< mysql_numrows($Rst_form_element); $i++)
				{
					if ($fond_cellule == $TdBgColor1) {
						$fond_cellule = $TdBgColor2;
					}
					else {
						$fond_cellule = $TdBgColor1;
					}
					echo("<tr bgcolor=".$fond_cellule.">");
					
					for ($ncols=2; $ncols< @mysql_num_fields($Rst_form_element); $ncols++)
					{
						$fieldtype_form =	@mysql_field_type($Rst_form_element, $ncols);
						$fieldlen_form  =	@mysql_field_len($Rst_form_element, $ncols);
						//Si c'est des cases à cocher
						if ($fieldtype_form==$mysql_datatype_integer && $fieldlen_form==ereg_replace("(.*)\((.*)\)","\\2",$datatype_booleen))
						{
							if (mysql_result($Rst_form_element ,$i,mysql_fieldname($Rst_form_element,$ncols)) == 1) {
						echo "<td style=\"text-align:center\">".$ImgCheckBoxOn."</td>";
					}
					else {
						echo "<td style=\"text-align:center\">".$ImgCheckBoxOff."</td>";
					}
						}
						else
							echo("<td>".mysql_result($Rst_form_element ,$i,mysql_fieldname($Rst_form_element,$ncols))."</td>");
					}
					echo("</tr>");
				}
				?>
			</table>
		</td>
	</tr>
	<?
}
else
{
	?>
	<tr>
    <td colspan="3"><?=$bo_obj_form_no_field_associated?><br></td>
</tr>
<?
}
?>
<?
//Si on modifie un formulaire on permet l'ajout de champs pour celui-ci
if ($mode=="modif")
{
	//AFFICHAGE DU BOUTON ACTION
	$add_field_button = new bo_button();
	$add_field_button->c1 = $MenuBgColor;
	$add_field_button->c2 = $MainFontColor;
	$add_field_button->name = $bo_obj_form_manage_form_fields;
	$add_field_button->action = "javascript:document.location.href='bo.php?TableDef="._CONST_TABLEDEF_FORM_ELEMENTFORM."&DisplayMode=".$DisplayMode."OptionOn".$OptionOn."&filter_1=".$table_form_elementform.".id_".$table_gab_formulaire."=".$ID."'";
?>
<tr>
    <td colspan="3" style="text-align:right"><?$add_field_button->display();?></td>
</tr>
<?
}
?>

