<? 
$MaCouleurdefond = get_inter_color($MenuBgColor,0.5);
?>
<table width="100%" cellspacing="1" cellpadding="0" border="0" bgcolor="<?=get_inter_color($MenuTableBgColor,0.25)?>">
  <tr> 
    <td> 
      <table cellpadding="2" cellspacing="0" border="0"  width="100%">
        <tr> 
          <td bgcolor="<?=get_inter_color($MaCouleurdefond,0.5)?>"><b>Info. :</b></td>
        </tr>
        <tr> 
			<td bgcolor="<?=get_inter_color($MaCouleurdefond,0.15)?>"><?=$inc_info_taille;?><?=get_dir_size("../")?></td>
        </tr>
<!-- 		<tr>
			<td bgcolor="<?=//get_inter_color($MaCouleurdefond,0.5)?>"><?=$inc_info_panier;?><?=//get_nb_use_session("SesPanier")?></td>
		</tr>
 -->        <tr> 
          <td bgcolor="<?=get_inter_color($MaCouleurdefond,0.15)?>"><?=$inc_info_connexion;?><?=get_nb_use_session("ses_user",0,60)?></td>
        </tr>
<!-- 		<tr>
			<td bgcolor="<?=//get_inter_color($MaCouleurdefond,0.5)?>"><?=$inc_info_session;?></td>
		</tr>
        <tr> 
          <td bgcolor="<?=//get_inter_color($MaCouleurdefond,0.15)?>"><?=//get_nb_use_session(";",1)?></td>
        </tr>
 -->      </table>
    </td>
  </tr>
</table>
