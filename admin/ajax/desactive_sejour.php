<?
// Initialisation de la page 
$path="../../";
require($path."include/inc_header.inc.php");

$sql_S = "select cur_table_name from _table_def where id__table_def='".$_POST["tableId"]."'";
$result_S = mysql_query($sql_S);
$table = mysql_result($result_S,0,"cur_table_name");


$sql_U = "UPDATE $table set etat=0 where id_$table='".$_POST["id"]."'";
$result_U = mysql_query($sql_U);
echo $sql_U;
?>