<script>
function chg_state(to_state){
    tab_state = new Array;
    <?
    $nb_trans = mysql_num_rows($RstWkt);
    for ($i=0;$i<$nb_trans;$i++) {
        echo "tab_state[".$i."]= ".@mysql_result($RstWkt,$i,"id_"._CONST_BO_CODE_NAME."workflow_state_1").";\n";
    }
    ?>
    if (document.getElementById('to_state'+to_state).className!="active_state"){
        document.getElementById('from_state').className="";
        for (i=0;i<tab_state.length;i++){
            if (tab_state[i]==to_state){            
                document.getElementById('to_state'+to_state).className="active_state";
                document.getElementById('imgtrans'+to_state).src="images/fleche_g.gif";
            }else{
                document.getElementById('to_state'+tab_state[i]).className="";
                document.getElementById('imgtrans'+tab_state[i]).src="images/fleche_d.gif";
            }
        }
        document.getElementById('id_bo_workflow_state').value=to_state;
    }else{
        document.getElementById('from_state').className="active_state";
        document.getElementById('to_state'+to_state).className="";
        document.getElementById('imgtrans'+to_state).src="images/fleche_d.gif";
        document.getElementById('id_bo_workflow_state').value="<?=@mysql_result($RstWkt,0,"id_"._CONST_BO_CODE_NAME."workflow_state")?>";
    }
}
</script>
<tr>
    <td colspan="3">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr><td class="bg"><img src="/images/pixtrans.gif" width="1" height="1"></td></tr>
        </table>
    </td>
</tr>
<tr>
    <td valign="top"><!-- Statut&nbsp;: -->&nbsp;</td>
    <td colspan="2">
        <table border=0 cellspacing=1 cellpadding=5 bgcolor=#B4B4B4>
            <tr>
            <td class=wfActiveStateTitle><?=$inc_object_workflow_statut?></td>
            <td  class=wfActiveStateTitle><?=$inc_object_workflow_action?></td>
            </tr>
            <tr bgcolor=white>
                <td>
                    <table border=0 cellspacing=0 cellpadding=0 width=100>
                    <tr>
                        <td>
                            <table border=0 cellspacing=1 cellpadding=2 width="100" bgcolor=#B4B4B4>
                                <tr>
                                    <td id="from_state" class="active_state" bgcolor=#DDDDDD>
                                        <?=@mysql_result($RstWks,0,""._CONST_BO_CODE_NAME."workflow_state")?>
                                    </td>
                                    <td bgcolor=#B4B4B4 width=10 align=center>
                                    <img src="images/fl_menu_child.gif">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </table>
                </td>
                <td colspan=2>
                    <table border=0 cellspacing=3 cellpadding=0>
                    <?

                    for ($i=0;$i<$nb_trans;$i++) {
                        $to_state = @mysql_result($RstWkt,$i,"id_"._CONST_BO_CODE_NAME."workflow_state_1");
                    ?>
                        <tr>
                            <td valign="bottom">
                                <table border=0 cellspacing=1 cellpadding=2 width="100" bgcolor=gray>
                                <tr>
                                    <td align=center  bgcolor=#B4B4B4 width=20 onmouseover="this.style.cursor='pointer'"><img id="imgtrans<?=$to_state?>" src="images/fleche_d.gif" border="0" alt="<?=@mysql_result($RstWkt,$i,""._CONST_BO_CODE_NAME."workflow_trans")?>" onclick="chg_state(<?=$to_state?>)"></td>

                                    <td align=center id="to_state<?=$to_state?>"  bgcolor=#DDDDDD><?=@mysql_result($RstWkt,$i,""._CONST_BO_CODE_NAME."workflow_trans")?></td>
                                </tr>
                                </table>
                            </td>
                            <td >
<!--                                 <table border=0 cellspacing=1 cellpadding=0 width=100 bgcolor=#B4B4B4>
                                    <tr>
                                        <td bgcolor=#B4B4B4 width=20 align=center>
                                            <img src="images/fl_menu_child.gif">&nbsp;<img src="images/fl_menu_child.gif">
                                        </td>
                                        <td bgcolor=#DDDDDD align=right  id="to_state<?=$to_state?>"><?//=@mysql_result($RstWkt,$i,""._CONST_BO_CODE_NAME."workflow_state")?></td>
                                    </tr>
                                </table> -->
                            </td>
                        </tr>
                    <?
                    }
                    if ($nb_trans==0) {
                        echo "<tr><td>".$inc_object_workflow_aucun."</td></tr>";
                    }
                    ?>
                    </table>
                </td>
            </tr>
        </table>        
    </td>
</tr>
<input type="hidden" name="id_bo_workflow_state" id="id_bo_workflow_state" value="<?=$wks_id?>">
<tr>
    <td colspan="3">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr><td class="bg"><img src="/images/pixtrans.gif" width="1" height="1"></td></tr>
        </table>
    </td>
</tr>
