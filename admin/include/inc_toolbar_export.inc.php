<?
	//Taille des cases des elements du tableau
	$ItemSize = 21;
	$OptionContourColor	= get_inter_color($MenuBgColor,0.3);
	
	$ItemEvent =  "onmouseover='ItemOn(this,\"".get_inter_color($ActiveItemColor,0.3)."\",\"\",\"1\");'";
	$ItemEvent .= " onmouseout='ItemOff(this,\"".get_inter_color($MenuBgColor,0.3)."\",\"\",\"1\");'";

    if ($TableDef && $CurrentTableName != "none"){    
	?>
	<table height="22" bgcolor="<?=$MenuBgColor?>" border="0" cellspacing="0" cellpadding="0">
		<tr>			
            <td bgcolor="<?=$OptionContourColor?>">&nbsp;Exports&nbsp;&nbsp;</td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&exp=1&Search=".$Search;?>">
				<img src="images/icones/icon_xml.gif"  border="0" alt="<?=$inc_toolbar_export_dump_xml?>">
				</a>
			</td>
            <td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&exp=2&Search=".$Search;?>">
				<img src="images/icones/icon_xls.gif"  border="0" alt="<?=$inc_toolbar_export_dump_csv?>">
				</a>
			</td>
		<!--  --><td bgcolor="<?=$OptionContourColor?>"><img src="images/traitv.gif"  border="0" alt=""></td>
            <td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="javascript:ConfirmEmptyTable('<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&empty_current_table=1"?>')">
				<img src="images/icones/empty_table.gif"  border="0" alt="<?=$inc_toolbar_export_vider?>">
				</a>
			</td>
		</tr>
	</table>
	<?}
	get_bo_toolbar_separateur();
	unset($ItemSize);
	?>
