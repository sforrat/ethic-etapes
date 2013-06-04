<?
session_start();
require "../../../library/fonction.inc.php";
require "../../../library_local/lib_global.inc.php";
connection();
require "../../../library_local/lib_local.inc.php";
require "../../../library/lib_tools.inc.php";
require "../../../library/lib_bo.inc.php";
require "../../../library/class_bo.inc.php";
require "../../../library/class_SqlToTable.inc.php";
require "../../../library/lib_design.inc.php";

$init_portfolio = 1;
include "../../../include/inc_init_bo.inc.php";

function get_bo_portfolio_fsck($path = "", $path_img = "../images/upload/portfolio_img/") {

    global $fieldvalue, $form_fieldname, $StyleChamps, $portfolio_default_img;

    $return =  "
        <table border='0' cellpadding='0' cellspacing='0' width='80%'>
            <tr>
               <td colspan=\"2\" valign=\"top\" align=\"left\" nowrap><font size=-1>Sélectionner un fichier du portfolio : <br><br></font></td>
            </tr>
            <td>
            <td valign=\"top\">
    ";

        $return .= "
            <script>

                function JS_change_portfolio_preview(path, source, target) {                		
                    if (source.value != \"\")
                    {
                       if (JS_get_portfolio_img_type(source.value) == \"img\") {
                       	   // Gestion des images
                           document.getElementById(target).src = path + JS_get_portfolio_img_path(source.value);
                           window.parent.document.getElementById('txtUrl').value = document.getElementById(target).src;                              
													 window.parent.document.getElementById('txtLnkUrl').value = '';
													 window.parent.document.getElementById('cmbLnkTarget').value = '';                            
                           
                       }
                       else {
                           // Gestion des documents types fichiers
                           document.getElementById(target).src = '"._CONST_APPLI_URL."images/icones/' + JS_get_portfolio_img_path(source.value);
                           window.parent.document.getElementById('txtBorder').value = 0;
                           window.parent.document.getElementById('txtUrl').value = document.getElementById(target).src;
													 window.parent.document.getElementById('txtLnkUrl').value = '"._CONST_PORTFOLIO_PATH."'+JS_get_portfolio_img_type(source.value);                              
													 window.parent.document.getElementById('cmbLnkTarget').value = '_blank';                            
                       }                                                               
                    }
                    else
                    {
                    	// choix aucune
                    	document.getElementById(target).src = '".$path."images/pixtrans.gif';
                    	window.parent.document.getElementById('txtUrl').value = '';                    	
                    }
                    window.parent.UpdatePreview();
                }

            </script>
        ";

    $return .= "
    <select name=\"".$form_fieldname."_port\" onChange=\"JS_change_portfolio_preview('".$path.$path_img."', this, 'img_portfolio_preview_".$form_fieldname."')\" class=\"".$StyleChamps."\">
                            ";
    $str_portfolio_rub = "
                            SELECT 
                                    *
                            FROM
                                    portfolio_rub
                            ORDER BY
                                    portfolio_rub

    ";

    $rst_portfolio_rub = mysql_query($str_portfolio_rub);

    for ($pfi=0; $pfi<@mysql_num_rows($rst_portfolio_rub) ; $pfi++) {

        $id_portfolio_rub = @mysql_result($rst_portfolio_rub,$pfi,0);
        $portfolio_rub    = @mysql_result($rst_portfolio_rub,$pfi,1);

        if ($pfi==0) {
            $return .= "<option value=\"\">".$portfolio_rub."</option>\n";
        }
        else {
            $return .= "<optgroup label=\"".$portfolio_rub."\">\n";
        }

        $str_portfolio_img = "
                                SELECT 
                                        *
                                FROM
                                        portfolio_img
                                WHERE
                                        id_portfolio_rub = ".$id_portfolio_rub."
                                ORDER BY
                                        portfolio_img

        ";
        $rst_portfolio_img = mysql_query($str_portfolio_img);

        for ($pfj=0; $pfj<@mysql_num_rows($rst_portfolio_img) ; $pfj++) {

            $id_portfolio_img       = @mysql_result($rst_portfolio_img,$pfj,0);
            $portfolio_img          = @mysql_result($rst_portfolio_img,$pfj,1);
            $portfolio_img_name     = @mysql_result($rst_portfolio_img,$pfj,2);

            if ($id_portfolio_img == $fieldvalue) {
                $selected = "selected";
                $portfolio_default_img = $path.$path_img.$portfolio_img_name;
            }
            else {
                $selected = "";
            }

            $return .= "<option value=\"".$id_portfolio_img."\" ".$selected.">".$portfolio_img."</option>\n";
        }
    }
    
    if (empty($portfolio_default_img)) {
        $portfolio_default_img = $path."images/pixtrans.gif";
    }

    $return .= "
                </select>
                </td>
                <td valign=\"top\" align=\"left\">
                   <img src=\"".$portfolio_default_img."\" name=\"img_portfolio_preview_".$form_fieldname."\" id=\"img_portfolio_preview_".$form_fieldname."\" width=\"100\">
            		</td>
            </tr>
         </table>
    ";

    return $return;
}
?>
<link rel="StyleSheet" href="../plugins/fullkitnav/style.css" type="text/css">
<link rel="StyleSheet" href="../../../css/css.php" type="text/css">
<script>
function set_link(mode) {

    if (mode=="false") {
        el.execCommand("Unlink");
    }
    else {
        el.askLink(false);
        
        if (el.obj)
        {
           el.obj.lnkType = '';
           el.obj.lnkTarget = '_blank';
           el.obj.lnkValue = '<?=_CONST_PORTFOLIO_PATH ?>' + JS_get_portfolio_img_type(document.all._port.value);
           el.setLink();       
           window.close();
        }
        else
        {
           alert('Attention ! Vous devez sélectionner en premier lieu la portion de texte sur laquelle vous souhaitez créer un lien sur ce document.');
        }           
    }
}

function select_type(mode) {
    //fichier = "../../images/upload/portfolio_img/" + JS_get_portfolio_img_path(document.all._port.value);
    if (JS_get_portfolio_img_type(document.getElementById[_port].value) == "img") {
        set_img();
    }
    else {
        set_link("true");
    }

}
</script>
<table width="100%" cellpadding="5">
<form method=post>
<tr>
	<td nowrap>
    <?= get_bo_portfolio_fsck("../../../");?>
  </td>
</tr>
</form>
</table>