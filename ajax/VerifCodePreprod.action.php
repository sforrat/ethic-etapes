<?
session_start();
if($_POST["login"] == "ethicetapes" && $_POST["passe"] == "Kfgy54"){
	$_SESSION["AccessPreprodOK"] = 1;
	echo "|OK";
}else{
	echo "|KO";
}
?>