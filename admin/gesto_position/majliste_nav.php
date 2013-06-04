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

for ($i=1;$i<=$_REQUEST['taille'];$i++) {
	$temp_lib = "frm".$i;
	$chaine = "update _nav set ordre=".$i." where id__nav=".$_REQUEST[$temp_lib];
	$RS = mysql_query($chaine);
}
?>
<script language="javascript">
  	top.opener.history.go(0);
  	parent.window.close();   	
</script>
