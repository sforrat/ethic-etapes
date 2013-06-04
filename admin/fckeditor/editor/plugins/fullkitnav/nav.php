<?
session_start();
require "../../../../library/fonction.inc.php";
require "../../../../library_local/lib_global.inc.php";
connection();
require "../../../../library_local/lib_local.inc.php";
require "../../../../library/lib_tools.inc.php";
require "../../../../library/lib_bo.inc.php";
require "../../../../library/class_bo.inc.php";
require "../../../../library/class_SqlToTable.inc.php";
require "../../../../library/lib_design.inc.php";

include "../../../../include/inc_init_bo.inc.php";
?>
<link rel="StyleSheet" href="style.css" type="text/css">
<link rel="StyleSheet" href="../../../../css/css.php" type="text/css">
<script src="fck_nav.js" type="text/javascript"></script>
<script src="../../dialog/common/fck_dialog_common.js" type="text/javascript"></script>
<form method=post>
<br>
<table width="100%" cellpadding="5">
<tr>
	<td nowrap>
  <label for "nav">Rubrique :</label>
        <select id='nav' name='nav'>
            <?= get_arbo(0, "&nbsp;&nbsp;",0,0,$MenuBgColor,4,1,1)?>
        </select>
	</td>
  <td align="left">
  <label for "target">Cible :</label>
  			<select id='cmbTarget' name='cmbTarget'>
  					<option value='_self'>Meme fenetre (_self)</option>
  					<option value='_blank'>Nouvelle fenetre (_blank)</option>
  		 </select>
	</td>  					  
</tr>
</table> 
</form>
