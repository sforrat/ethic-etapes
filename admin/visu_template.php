<?
require "library_local/lib_global.inc.php";
require "library/fonction.inc.php";
?>
<link rel="STYLESHEET" href="css/style.php" type="text/css">
<script language="javascript">
	var x,y;
	x=(screen.width/3);
	y=(screen.height/5.5);
	window.moveTo(x,y);
	
	temp = opener.document.form_update_template.template.value;
	debut = 0;
	
	while (temp.indexOf("<?=Template_left_delimiter?>TAG_",debut)!=-1)
	{
		 pos1 = temp.indexOf("<?=Template_left_delimiter?>TAG_",debut);
		 pos2 = temp.indexOf("<?=Template_right_delimiter?>",pos1+1);
		 
		 tag = temp.substring(pos1,pos2+1);
		 lib_tag = temp.substring(pos1+5,pos2);
		 temp = temp.replace(tag,"<b><?=htmlentities(Template_left_delimiter)?>TAG_" + lib_tag + "<?=htmlentities(Template_right_delimiter)?></b>");
		 debut = pos2;
	}
	
	
	if (temp=="")
	{ temp = "<center>Votre template est vide.</center>"; }
	document.write(temp);
</script>



<br><br>
<center><a href="javascript:window.close();">close</a></center>