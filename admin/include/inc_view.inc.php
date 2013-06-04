<?
if ($mode=="view") {

$CtImUpload=0;

echo "<p class=\"titre\">".$TitreRubriqueArray[4]."</p>";

echo "<table ".$WidthTableType." border=\"$TableBorder\" cellspacing=\"$TableCellspacing\" cellpadding=\"$TableCellpadding\" bgcolor=\"$TableBgColor\">";

for ($k=0; $k<$nb_cols; $k++) {

	$fieldname	=	@mysql_field_name($result, $k);
	$fieldtype	=	@mysql_field_type($result, $k);
	$fieldlen	=	@mysql_field_len($result, $k);
	$tablename	=	@mysql_field_table($result, $k);
	$fieldvalue =	@mysql_result($result, $id ,@mysql_field_name($result, $k));


	if ($fond_cellule == $TdBgColor1) {
		$fond_cellule = $TdBgColor2;
	}
	else {
		$fond_cellule = $TdBgColor1;
	}

	//Gestion des type particulers
	if ($fieldtype=="date") {
		$fieldvalue	= CDate($fieldvalue,3);
	}
	elseif ($fieldname=="email") {
		$fieldvalue	= "<a href=\"mailto:".$fieldvalue."\">".$fieldvalue."</a>";
	}
	elseif ($fieldtype=="int" && $fieldlen==1 ) {//Case a cocher
		if ($fieldvalue == 1) {
			$fieldvalue = $ImgCheckBoxOn;
		}
		else {
			$fieldvalue = $ImgCheckBoxOff;
		}
	}
	elseif ($fieldtype=="string" && $fieldlen==20 ) {//Case a cocher

		//On recupere la taille de l'image
		$ArrayImgInfo = @getimagesize($UploadPath[$CtImUpload].$fieldvalue);
		$ImgHeight	= $ArrayImgInfo[1];
		$ImgWidth	= $ArrayImgInfo[0];

//		$fieldvalue = "<A HREF=\"javascript:JustSoPicWindow('".$UploadPath[$CtImUpload].$fieldvalue."','".$ImgWidth."','".$ImgHeight."','','#FFFFFF','hug image','0');\"><img src=\"".$UploadPath[$CtImUpload].$fieldvalue."\" border=\"0\" alt=\"$fieldname\"></A>";
		$fieldvalue = "<img src=\"".$UploadPath[$CtImUpload].$fieldvalue."\" border=\"0\" alt=\"$fieldname\">";
	}
	?>
		<tr>
			<td valign="top" bgcolor="<?echo $fond_cellule;?>"><?echo UCfirst($fieldname);?> : </td>
			<td bgcolor="<?echo $fond_cellule;?>"><?echo $fieldvalue;?></td>
		</tr>
	<?
}
$RetourTarget = NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=$TableDef&DisplayMode=".$DisplayMode."&ordre=".$ordre."&AscDesc=".$AscDesc;

echo "<table><tr><td colspan=\"2\"><br><A HREF=\"".$RetourTarget."\">".$Retour."</A></td></tr></table>";

?>
</table>	
<?
}
?>