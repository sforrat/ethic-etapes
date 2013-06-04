<?
session_start();
require "../library/fonction.inc.php";
require "../library_local/lib_global.inc.php";

connection();

require "../library_local/lib_local.inc.php";
require "../library/lib_tools.inc.php";
require "../library/lib_bo.inc.php";
require "../library/class_bo.inc.php";
require "../library/class_SqlToTable.inc.php";
require "../library/lib_design.inc.php";

include "../include/inc_init_bo.inc.php";

?>
<html>
<head>
<link rel="STYLESHEET" href="../css/css.php" type="text/css">
<script language="javascript">
x=(screen.width/3.5);
y=(screen.height/4);
window.moveTo(x,y);

function valider_champs() {
	//alert(document.formulaire.champ_selection_select_champ.value);

	retour = "";
	for (i=0;i<document.formulaire.champ_selection_select_champ.length;i++) {
		if (document.formulaire.champ_selection_select_champ.options[i].selected) {
			if (retour=="") {
				retour = document.formulaire.champ_selection_select_champ.options[i].value;
			}else{
				retour = retour+","+document.formulaire.champ_selection_select_champ.options[i].value;
			}
		}
	}

	window.opener.document.FormDetailTable.<?=$_REQUEST['lib_champs']?>.value = retour;
	window.close();
}
</script>
</head>
<body leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">
<table width="100%" cellspacing="0" cellpadding="0">
<form name="formulaire" method="post" action="">
<tr>
<td><?=$bo_list_multi_select_field_multi?><br><br></td>
</tr>
<tr>
<td>
<?
$TableSelect = $_REQUEST['TableSelect'];

$tab = split(",",$_REQUEST['actu_champs']);

$StrSQL = "select * from ".$TableSelect;
$RstTableSelect = mysql_query($StrSQL);

echo("<select class=\"InputText\" name=\"champ_selection_select_champ\" multiple size='14'>");
for ($l=1; $l< @mysql_num_fields($RstTableSelect); $l++) {
	if (in_array(mysql_field_name($RstTableSelect, $l),$tab)) {
		$str_selected = " selected ";
	}else{
		$str_selected = " ";
	}
	
	echo("<option value=\"".mysql_field_name($RstTableSelect, $l)."\" ".$str_selected." >".mysql_field_name($RstTableSelect, $l)."</option>");
}
echo("</select>");
?>
</td>
</tr>

<tr><td><br>
<?
$action_button = new bo_button();
$action_button->c1 = $MenuBgColor;
$action_button->c2 = $MainFontColor;
$action_button->name = "Modifier >>";
$action_button->action = "javascript:valider_champs();";
$action_button->display();
?>
</td></tr>
</form>
</table>
</html>