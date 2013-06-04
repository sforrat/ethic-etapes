<? error_reporting(0); ?>
<html>
<head>
<script language="javascript">
// *** centrage de la popup
	var x,y;
	x=(screen.width/3.5);
	y=(screen.height/6);
	window.moveTo(x,y);
</script>
</head>

<FRAMESET ROWS="60,*" frameborder=0 border=0>
	<FRAME NAME="haut" SRC="boutons.php" SCROLLING=NO NORESIZE FRAMESPACING=0 TOPMARGIN=0>
	<FRAME NAME="main" SRC="liste.php?selection=<?=$_REQUEST['selection']?>&tbl_selection=<?=$_REQUEST['tbl_selection']?>&tableName=<?=$_REQUEST['tableName']?>&idItem=<?=$_REQUEST['idItem']?>" SCROLLING=YES NORESIZE FRAMESPACING=0 TOPMARGIN=0>
</FRAMESET>
</html>
