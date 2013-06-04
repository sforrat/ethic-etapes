<?
$path = "../";
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
?>
<html>
<head>
<link rel="STYLESHEET" href="../css/css.php" type="text/css">
<script language="javascript">
function majListe() {
	parent.location.href="index_nav.php?id_nav="+document.formulaire.id_nav.value;
}
</script>
</head>

<body bgcolor="white" leftmargin="0" topmargin="5" marginwidth="0" marginheight="0">
<table cellspacing="4" cellpadding="2" border="0" align="center">
<tr><td align="center"><b>Gestion de l'ordre de la nav</b></td>
</tr>
<tr>
<form name="formulaire" method="post" action="index_nav.php" target="">
<td><?
echo "<select width='20' class='InputText' ".$input_allow." id=\"id_nav\" onchange='majListe();'>";
if (eregi(""._CONST_BO_CODE_NAME."nav",$tablename)) {
	$StrPere = mysql_query("Select id_"._CONST_BO_CODE_NAME."nav_pere from "._CONST_BO_CODE_NAME."nav where id_"._CONST_BO_CODE_NAME."nav=".$id_item);
	$Pere = mysql_result($StrPere,0,"id_"._CONST_BO_CODE_NAME."nav_pere");
}
else {
	$Pere = $fieldvalue;
}

if (empty($show_tree_from)) {
	$show_tree_from = 0;
}

get_arbo($show_tree_from,"&nbsp;&nbsp;",0,$_REQUEST['id_nav'],$MenuBgColor,0,1,1);
echo "</select>"; ?>
</td>
</form>
</tr>
<tr> 
  <td align="center"> 
  <input type="image" border="0" src="fleche_haut.gif" alt="Monter" width="15" height="15" onclick="parent.main.valide(1);">
  &nbsp;&nbsp; 
  <input type="image" border="0" src="fleche_bas.gif" alt="Descendre" width="15" height="15" onclick="parent.main.valide(2);">
  </td>
</tr>
</table>   
 
</body>
</html>    