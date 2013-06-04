<?
 session_start();
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <title>Site sécurisé</title>
  <style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #CC0000;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #CC0000;
}
.style5 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; color: #CC0000; }
.style8 {font-size: 16px}
.style10 {
	font-size: 16px;
	color: #CC0000;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style11 {
	color: #CC0000
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.pEdito{
	padding:4px;
}
-->
</style>
<script src="js/jquery.js" type="text/javascript"></script>

<script language="javascript" src="js/scripts.js"></script>

  </head>
  <body>
  <?
 
  //echo "login  : ethicetapes<br>passe = Kfgy54<br>";
  
    //echo "session  : ".$_SESSION["AccessPreprodOK"];
  
  ?>
  		<form id="identification" name="identification" method="POST" onsubmit="VerifCodePreprod();return false;" action="http://test1.c2is.fr/ethic_etapes_www/">
			<table align="center" style="border:3px solid #778F17;border-collapse:collapse;">
				<tr>
					<td colspan="2"><img src="images/logo_preprod.jpg" /></td>
				</tr>
				<tr>
					<td colspan="2"><p class="pEdito"><br>Vous allez visiter le nouveau site ethic-etapes.com, en avant-premi&egrave;re.<br />
		Nous vous souhaitons une bonne visite du site.<br /><br/><br></p></td>
					
				</tr>
				<tr>
					<td>&nbsp;Login : </td>
					<td><input type="text" id="login" name="login" /></td>
				</tr>
				<tr>
					<td>&nbsp;Passe : </td>
					<td><input type="password" id="passe" name="passe" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" value="Envoyer" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
					
				</tr>
			</table>
		</form>
  </body>
</html>
