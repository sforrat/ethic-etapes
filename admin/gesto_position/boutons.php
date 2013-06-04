<html>
<head>
<link rel="STYLESHEET" href="../css/css.php" type="text/css">
<script language="javascript">
function autobout() {
	if (event.keyCode==56) {
		parent.main.valide(1);
	}else if (event.keyCode==50) {
		parent.main.valide(2);
	}
}

document.onkeypress = autobout;
</script>
</head>

<body bgcolor="white" leftmargin="0" topmargin="5" marginwidth="0" marginheight="0">
<table cellspacing="4" cellpadding="2" border="0" align="center">
<tr> 
  <td><center><b>Gestion de l'ordre</b></center></td>
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