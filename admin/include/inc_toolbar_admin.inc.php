<?
	//Taille des cases des elements du tableau
	$ItemSize = 21;
	$OptionContourColor	= get_inter_color($MenuBgColor,0.3);
	
	$ItemEvent =  "onmouseover='ItemOn(this,\"".get_inter_color($ActiveItemColor,0.3)."\",\"\",\"1\");'";
	$ItemEvent .= " onmouseout='ItemOff(this,\"".get_inter_color($MenuBgColor,0.3)."\",\"\",\"1\");'";

	?>
	<table height="22" bgcolor="<?=$MenuBgColor?>" border="0" cellspacing="0" cellpadding="0">
		<tr>
            <td bgcolor="<?=$OptionContourColor?>">&nbsp;Admin&nbsp;&nbsp;</td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="<?echo NomFichier($_SERVER['PHP_SELF'],0);?>?<?echo $_SERVER['QUERY_STRING'];?>&Debug=<?echo $Debug;?>"><img src="images/icones/play.gif"  border="0" alt="Mode Debug"></a>
			</td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="javascript:show_item('SQL');"><img src="images/icones/icone_sql.gif" border="0" alt="Voir la requête SQL exécutée"></a>
			</td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo_include_launcher.php?file=include/inc_sql_maker.inc.php"><img src="images/icones/icone_base.gif" border="0" alt="<?=$inc_toolbar_admin_bdd?>"></a>
			</td>
			<td bgcolor="<?=$OptionContourColor?>"><img src="images/traitv.gif"  border="0" alt=""></td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo_include_launcher.php?file=bo_sql_editor.php">
				<img src="images/icones/espion.gif"  border="0" alt="<?=$inc_toolbar_admin_edit_form?>">
				</a>
			</td>

			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo_include_launcher.php?file=bo_sql_editor.php&TableDefModif=<?echo $TableDef;?>&TableDef=<?echo $TableDef;?>">
				<img src="images/icones/group.gif"  border="0" alt="<?=$inc_toolbar_admin_edit_curform?>">
				</a>
			</td>

			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo.php?TableDef=1&mode=modif&ID=<?=$TableDef?>">
				<img src="images/icones/code.gif"  border="0" alt="<?=$inc_toolbar_admin_edit_curform_sql?>">
				</a>
			</td>

			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo.php?TableDef=1">
				<img src="images/icones/all_form.gif"  border="0" alt="<?=$inc_toolbar_admin_form_list?>">
				</a>
			</td>

			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo.php?TableDef=11&mode=modif&ID=<?=$TableDef?>">
				<img src="images/icones/form_sep.gif"  border="0" alt="<?=$inc_toolbar_admin_evt?>">
				</a>
			</td>

		<!--  --><td bgcolor="<?=$OptionContourColor?>"><img src="images/traitv.gif"  border="0" alt=""></td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="<?echo NomFichier($_SERVER['PHP_SELF'],0);?>?TableDef=<?echo $TableDef;?>&ShowFields=1">
				<img src="images/icones/proprietes.gif"  border="0" alt="<?=$inc_toolbar_admin_detail?>">
				</a>
			</td>

			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="<?echo NomFichier($_SERVER['PHP_SELF'],0);?>?TableDef=<?echo $TableDef;?>&ShowAllRec=1">
				<img src="images/icones/form2.gif"  border="0" alt="<?=$inc_toolbar_admin_champs?>">
				</a>
			</td>


		<!--  --><td bgcolor="<?=$OptionContourColor?>"><img src="images/traitv.gif"  border="0" alt=""></td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="javascript:ConfirmDelete('<?=NomFichier($_SERVER['PHP_SELF'],0)?>')">
				<img src="images/icones/icone_ed0.gif"  border="0" alt="<?=$inc_toolbar_admin_vider?>">
				</a>
			</td>

			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&Dump=1";?>">
				<img src="images/icones/icon_save.gif"  border="0" alt="<?=$inc_toolbar_admin_dump?>">
				</a>
			</td>

		<!--  --><td bgcolor="<?=$OptionContourColor?>"><img src="images/traitv.gif"  border="0" alt=""></td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo.php?TableDef=6">
				<img src="images/icones/apparence.gif"  border="0" alt="<?=$inc_toolbar_admin_apparence?>" width=16>
				</a>
			</td>

		</tr>
	</table>
	<?
	get_bo_toolbar_separateur();	
	unset($ItemSize);
	?>
