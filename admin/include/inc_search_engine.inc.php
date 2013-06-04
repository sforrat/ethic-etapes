<? 
$icone_size = 20;
$color_true = get_inter_color($MenuBgColor,0.25);//"#FFA6A6";
$color_false = get_inter_color($MenuBgColor,0.25);//"#00C100";
?>
			<div>
			<form name="FormSearch" method="post" action="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING'];?>">
			  <table border="0" cellspacing="1" cellpadding="4" bgcolor="<?=$TableBgColor?>">
				<tr  bgcolor="<?=get_inter_color($MenuBgColor,0.25)?>"> 
				  <td> <?=$inc_search_engine_recherche?><br>
<table border="0" cellpadding="0" cellspacing="0"><tr>
<td>
					<input type="text" name="Search" class="InputText" value="<?=$Search;?>">
					<input type="hidden" name="Page" value="0">
</td>
<td>&nbsp;&nbsp;</td>
					<? 
					if ($Search) {
					?> 
						<td bgcolor="<?=$color_true?>" width="<?=$icone_size?>" height="<?=$icone_size?>" valign="middle" align="center"><a href="javascript:document.FormSearch.Search.value='';document.FormSearch.submit();"><img src="images/icones/icone_ed0.gif" alt="Supprimer le critère de recherche" border="0"></a></td>
					<?
					}
					?>
<td>&nbsp;&nbsp;</td>
					<td bgcolor="<?=$color_false?>" width="<?=$icone_size?>" height="<?=$icone_size?>" valign="middle" align="center"><a href="javascript:document.FormSearch.submit();"><img src="images/icones/icone_view.gif" alt="Rechercher" border="0"></a></td>

</tr></table>
					</td>
				</tr>
			  </table>
			</form>
			</div>
