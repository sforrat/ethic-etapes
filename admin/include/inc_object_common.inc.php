<?
    if ($RstObj && mysql_result($RstObj,0,$id_bo_object)) {
        ?><input type="hidden" name="idObj" value="<?=$idObj?>"><?
    }

    if (empty($_REQUEST['idItem'])) {
        ?><input type="hidden" name="stay_on_current_form" value="1"><?
    }
?>
<tr>
    <td colspan="3">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr><td class="bg"><img src="/images/pixtrans.gif" width="1" height="1"></td></tr>
        </table>
    </td>
</tr>
<tr>
    <td valign="top"><?=$inc_object_common_nom?>&nbsp;:</td>
    <td colspan="2">
        <input class="<?=$StyleChamps?>" type="text" <?=$input_allow?> name="object_name" size="70" value="<?= mysql_result($RstObj,0,"name_req")?><? if (isset($_REQUEST['methode']) && $_REQUEST['methode'] == "duplicate" ) {echo($bo_inc_obj_common_duplicated); }?>">
    </td>
</tr>
<!-- <tr>
    <td valign="top"><?=$inc_object_common_desc?>&nbsp;:</td>
    <td colspan="2">
        <textarea rows="5" cols="69" name="object_desc" class="<?=$StyleChamps?>"><?=@mysql_result($RstObj,0,"description")?></textarea>
    </td>
</tr> -->
<tr>
    <td valign="top"><?=$inc_object_common_rubrique?>&nbsp;:</td>
    <td colspan="2">
       <?
            echo "<select class=\"".$StyleChamps."\" name=\"object_bo_nav\" ".$input_allow.">";
            if (mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."nav")) {
                $rubid=mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."nav");
            }
            else{
                $rubid=$idItem;
            }

            //get_arbo(0, "&nbsp;&nbsp;",0,$rubid,$MenuBgColor,0,1,1,""," and selected=1");
            get_arbo(0, "&nbsp;&nbsp;",0,$rubid,$MenuBgColor,0,1,1,"","");

            echo "</select>";
       ?>
    </td>
</tr>

<?
// BBO 27/09/2007 : Pour les gabarits de type 3, on n'affiche pas la langue (choix par onglets)
if ($object_type!=3) 
{
?>

<tr>
    <td valign="top"><?=$inc_object_common_langue?> :</td>
    <td colspan="2">
       <?
            echo "<select class=\"".$StyleChamps."\" name=\"object_bo_langue\" ".$input_allow.">";

			$SqlLangue = "Select * from "._CONST_BO_CODE_NAME."langue";
			
			// On met que les langues possible pour le user si pas root
      if ($_SESSION['ses_profil_user'] != 1) {
      	$SqlLangue .= " WHERE id_"._CONST_BO_CODE_NAME."langue in ( ".$_SESSION['ses_id_langue_user'].")";
      }
      $RstLangue = mysql_query($SqlLangue);              

			for ($i=0; $i<mysql_num_rows($RstLangue) ;$i++) {

				if (mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."langue")==mysql_result($RstLangue,$i,"id_"._CONST_BO_CODE_NAME."langue")){
					$selected = "selected";

				}
                elseif ($mode=="nouveau" && ($_SESSION['ses_langue'] == mysql_result($RstLangue,$i,"id_"._CONST_BO_CODE_NAME."langue"))) {
					$selected = "selected";
                }
                else{
					$selected = "";
				}
				echo "<option value=\"".mysql_result($RstLangue,$i,"id_"._CONST_BO_CODE_NAME."langue")."\" ".$selected.">".mysql_result($RstLangue,$i,""._CONST_BO_CODE_NAME."langue")."</option>";
			}
            echo "</select>";
       ?>
    </td>
</tr>

<?
// BBO 27/09/2007 : Pour les gabarits de type 3, on n'affiche pas la langue (choix par onglets)
}
?>

<?
 // modif lac 23/02 : si mode creation ou duplique, on positionne le champ position au max Position de la nav courante
 if ( (isset ($_REQUEST['mode']) && $_REQUEST['mode']=="nouveau") || (isset($_REQUEST['methode']) && $_REQUEST['methode'] == "duplicate" ) )
 {
    $position = (mysql_result(mysql_query("SELECT max(ordre) from "._CONST_BO_CODE_NAME."object WHERE id"._CONST_BO_CODE_NAME."_nav = ".$_REQUEST['idItem']." AND id"._CONST_BO_CODE_NAME."_workflow_state = "._WF_DISPLAYED_STATE_VALUE),0,0)+1);
 }
 else
 {
    $position = mysql_result($RstObj,0,"ordre");
 }
?>
<tr>
    <td valign="top"><?=$inc_object_common_position?> :</td>
    <td colspan="2">
        <input class="<?=$StyleChamps?>" type="text" <?=$input_allow?> name="object_ordre" size="10" value="<?= $position ?>">
    </td>
</tr>
<tr align=left>
    <td valign="top"><?=$inc_object_common_date_creation?></td>
    <td colspan=2>
    <?
    	$date_creation = (mysql_result($RstObj,0,"date_create_auto")!=""?mysql_result($RstObj,0,"date_create_auto"):Date("Y-m-d"));
    	$id_auteur = (mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."user_autor")!=""?mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."user_autor"):$_SESSION['ses_user_id']);    	
   ?>
   <?= Cdate($date_creation,4,"fr") ?>,&nbsp;par : <?= get_user_name($id_auteur)?>
   </td>
</tr>
    <td valign="top"><?=$inc_object_common_date_derniere?></td>    
    <td colspan=2>
    <? 
       $date_der_modif = (mysql_result($RstObj,0,"date_update_auto")!=""?mysql_result($RstObj,0,"date_update_auto"):Date("Y-m-d H:i:s"));
       $id_auteur_modif = (mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."user")!=""?mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."user"):$_SESSION['ses_user_id']);    	
    ?>
    <?= Cdate($date_der_modif,4,"fr") ?>,&nbsp;<?=$inc_object_common_par?> : <?= get_user_name($id_auteur_modif) ?>
       <?
      // LAC : 24/02/2004 : ajout d'un lien vers l'objet source s'il existe
      if ((mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."object_source")!="") && (mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."object_source")!=0))
      {
      	$tab_id = split("-",mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."object_source"));      	    	
      	echo("<div align=right><a href=\"./bo.php?idItem=".mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."nav")."&TableDef=".mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."table_def")."&mode=modif&ID=".$tab_id[1]."&idObj=".$tab_id[0]."\" target=\"_blank\"><img src=\"images/icones/loupe.gif\" border=0 align=absmiddle></a>&nbsp;<a href=\"./bo.php?idItem=".mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."nav")."&TableDef=".mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."table_def")."&mode=modif&ID=".$tab_id[1]."&idObj=".$tab_id[0]."\" target=\"_blank\">Voir l'objet source</a></div>");
      }
   ?>
    </td>
</tr>
<tr>
    <td colspan="3">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr><td class="bg"><img src="/images/pixtrans.gif" width="1" height="1"></td></tr>
        </table>
    </td>
</tr>
