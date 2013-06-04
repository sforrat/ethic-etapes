<?
	//Taille des cases des elements du tableau
	$ItemSize = 21;
	$OptionContourColor	= get_inter_color($MenuBgColor,0.3);
	
	$ItemEvent =  "onmouseover='ItemOn(this,\"".get_inter_color($ActiveItemColor,0.3)."\",\"\",\"1\");'";
	$ItemEvent .= " onmouseout='ItemOff(this,\"".get_inter_color($MenuBgColor,0.3)."\",\"\",\"1\");'";

	?>
	<table height="22" bgcolor="<?=$MenuBgColor?>" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<? 
    
        if ($_SESSION['ses_profil_user']==1) 
        {
    ?>
            <td bgcolor="<?=$OptionContourColor?>">&nbsp;<?=$inc_toolbar_tools_outils?>&nbsp;&nbsp;</td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo.php?TableDef=3&viewTask=1">
				<img src="images/icones/taches.gif"  border="0" alt="Tâches" width=16>
				</a>
			</td>
			
    <?
  	} 
        if ($_SESSION['ses_profil_user']>=1 && $_SESSION['ses_profil_user']<=2) {
    ?>
		<!--  --><td bgcolor="<?=$OptionContourColor?>"><img src="images/traitv.gif"  border="0" alt=""></td>
		  <td bgcolor="<?=$OptionContourColor?>">&nbsp;<?=$inc_toolbar_tools_arbo?>&nbsp;&nbsp;</td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo.php?TableDef=2">
				<img src="images/icones/arbo.gif"  border="0" alt="<?=$inc_toolbar_tools_arbo?>" width=16>
				</a>
			</td>
		<!--  --><td bgcolor="<?=$OptionContourColor?>"><img src="images/traitv.gif"  border="0" alt=""></td>
            <td bgcolor="<?=$OptionContourColor?>">&nbsp;<?=$inc_toolbar_tools_utilisateurs?>&nbsp;&nbsp;</td>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo.php?TableDef=8">
				<img src="images/icones/user.gif"  border="0" alt="<?=$inc_toolbar_tools_utilisateurs?>" width=16>
				</a>
			</td>
    <? 
    }
        if ($_SESSION['ses_profil_user']==1) {
    ?>
			<td bgcolor="<?=$OptionContourColor?>" valign="middle" align="center" height="<?=$ItemSize?>" width="<?=intval($ItemSize+3)?>" <?=$ItemEvent?>>
				<a href="bo.php?TableDef=9">
				<img src="images/icones/profil.gif"  border="0" alt="<?=$inc_toolbar_tools_profils?>" width=16>
				</a>
			</td>
		<!--  --><td bgcolor="<?=$OptionContourColor?>"><img src="images/traitv.gif"  border="0" alt=""></td>
    <? 
        }
    ?>
		</tr>
	</table>
	<?
	get_bo_toolbar_separateur();	
	unset($ItemSize);
	?>
