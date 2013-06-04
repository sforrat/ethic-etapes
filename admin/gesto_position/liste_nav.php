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

$glob_lib_bt_valider = "Valider les modifications";

$mynav = 1;
if ($_REQUEST['id_nav']!="") {
	$mynav = $_REQUEST['id_nav'];
}
?>

<script language="JavaScript">
var idChoisi="" ;
var frChoisi="" ;
var posChoisi="" ;
var etatvalide="0";
var etatmodife="0";

function out(pos) {
	if (pos!=posChoisi)
		changeClasseLigne(pos,"td_out");
}
function over(pos) {
	if (pos!=posChoisi)
		changeClasseLigne(pos,"td_over");
}
function changeClasseLigne(pos,classe) {
	document.all("lgne"+pos).className = classe ;
}
function declic() {
	changeClasseLigne(posChoisi,"td_out");
}

function clic(pos,objectid) {

	if (posChoisi!="" && posChoisi!=" ")
	{ declic(); }
	posChoisi=pos;
	temp = document.formulaire.elements["frm"+posChoisi].value;
	changeClasseLigne(pos,"td_clic");
	/*
	if (objectid!=1)
	{ window.open("rubrique.cfm?idetape="+objectid,"rubrique");
	  window.open("vide.cfm","sousrubrique"); }
	*/
}
function up() {
  if (etatvalide==0)
  { //document.all("valideur").innerHTML='<input type="Button" value="     <?=$glob_lib_bt_valider;?>    " onclick="envoie()" alt="Valider le nouvel ordre">';
	document.all("valider_table").innerHTML = '<table border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="23"><img src="titre1.gif" width="23" height="19"></td><td align="center" bgcolor="#074B88"><b><font color="#FFFFFF"><a href="javascript:envoie();" class="lienbouton">&nbsp;&nbsp;<?=$glob_lib_bt_valider;?></a></font></b></td><td width="8"><img src="titre2.gif" width="8" height="19"></td></tr></table>';
  	etatvalide=1; }
  var posavant,temp ;
  var tempid;
  posavant=(posChoisi - 1);
  temp = document.all("lgne"+posavant).innerHTML;
  tempid = document.formulaire.elements["frm"+posavant].value;
  document.formulaire.elements["frm"+posavant].value = document.formulaire.elements["frm"+posChoisi].value;
  document.all("lgne"+posavant).innerHTML = document.all("lgne"+posChoisi).innerHTML;
  document.formulaire.elements["frm"+posChoisi].value = tempid;
  document.all("lgne"+posChoisi).innerHTML = temp;
  clic(posavant,1);
}
function down() {
  if (etatvalide==0)
  { //document.all("valideur").innerHTML='<input type="Button" value="     <?=$glob_lib_bt_valider;?>    " onclick="envoie()" alt="Valider le nouvel ordre">';
	document.all("valider_table").innerHTML = '<table border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="23"><img src="titre1.gif" width="23" height="19"></td><td align="center" bgcolor="#074B88"><b><font color="#FFFFFF"><a href="javascript:envoie();" class="lienbouton">&nbsp;&nbsp;<?=$glob_lib_bt_valider;?></a></font></b></td><td width="8"><img src="titre2.gif" width="8" height="19"></td></tr></table>';
  	etatvalide=1; }
  var posapres,temp ;
  var tempid;
  posChoisi=parseInt(posChoisi);
  posapres=(posChoisi + 1);
  temp = document.all("lgne"+posapres).innerHTML;
  tempid = document.formulaire.elements["frm"+posapres].value;
  document.formulaire.elements["frm"+posapres].value = document.formulaire.elements["frm"+posChoisi].value;
  document.all("lgne"+posapres).innerHTML = document.all("lgne"+posChoisi).innerHTML;
  document.formulaire.elements["frm"+posChoisi].value = tempid;
  document.all("lgne"+posChoisi).innerHTML = temp;
  clic(posapres,1);
}
function cliqueur(pos) {
 if (etatmodife==0) { etatmodife=1; }
 var temp;
 temp = document.formulaire.elements["frm"+pos].value;
 clic(pos,temp);
}
</script>

<html>
<head>
<link rel="STYLESHEET" href="style.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" link="#0000FF" alink="#0000FF" vlink="#0000FF">
<table cellspacing="0" cellpadding="2" border="1" align="center" bordercolor="#074B88">


<form method="post" action="" name="formulaire">
<? 	$max=0;

$tablename = "_nav";
		
		//$chaine = "SELECT * FROM ".$tablename." WHERE 1=1 ";
	$chaine = "SELECT * FROM _nav where id__nav_pere=".$mynav;
		//080325 - SBA - Gestion du multilingue
		
		$strTabledef='SELECT id__table_def FROM _table_def WHERE cur_table_name = \''.$tablename.'\'';
		$rsTableDef=mysql_query($strTabledef);
	
	
			//10/09/2007-MVA-gestion affichage des multilingue
			if(isMultilingue(mysql_field_name(mysql_query($chaine),1),mysql_result($rsTableDef,0,0)))
			{
				$fieldname = mysql_field_name(mysql_query($chaine),1);
				//$chaine = "SELECT * FROM _nav where id__nav_pere=".$mynav;
				$chaine = "SELECT "._CONST_BO_PREFIX_TABLE_TRAD.$tablename.".id__".$tablename." , "._CONST_BO_PREFIX_TABLE_TRAD.$tablename.".".$fieldname." ,  ".$tablename.".* FROM _nav LEFT JOIN "._CONST_BO_PREFIX_TABLE_TRAD.$tablename."  ON id__".$tablename ." = ".$tablename.".id_".$tablename." AND id__langue=".$_SESSION['ses_langue']." where id__nav_pere=".$mynav;
	
			}
				


	//$chaine = "SELECT * FROM _nav where id__nav_pere=".$mynav;
	$chaine.= " order by ordre";

	$RS = mysql_query($chaine);

	for ($j=0;$j<mysql_num_rows($RS);$j++) {
		$i = ($j+1); ?>
		<tr>
		<td class="td_out" id="lgne<?=$i;?>" onclick="cliqueur('<?=$i;?>');" onmouseout="out('<?=$i;?>');" onmouseover="over('<?=$i;?>');"><center><a href="#"><?=mysql_result($RS,$j,1)?></a></center></td>
		<input type="hidden" name="frm<?=$i?>" id="frm<?=$i?>" value="<?=mysql_result($RS,$j,0)?>">
		</tr>	
<?		$max++;
	} ?>
<input name="taille" id="taille" type="hidden" value="<?=$max;?>">

</form>


<script language="JavaScript">
function valide(x)
{ 
  if (posChoisi!="" && posChoisi!=" ")
  {
  	if (x==1)
  	{
  		if (posChoisi!=1)
  		{ up(); }
  	}else{
   		if (posChoisi!=<?=$max?>)
  		{ down(); }
  	}
  }
}

function envoie()
{
 document.formulaire.action="majliste_nav.php";
 document.formulaire.submit();
}
</script>

<? if (mysql_num_rows($RS)>0) { ?>
	<tr>
	<td valign="middle" height="40">
		<div id="valider_table">
		<table border="0" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td width="23"><img  src="titre1b.gif" width="23" height="19"></td>
				<td align="center" bgcolor="#B5C3CE"><b><font color="#FFFFFF"><div id="modifier_href">&nbsp;&nbsp;<?=$glob_lib_bt_valider;?></div></font></b></td>
				<td width="8"><img src="titre2b.gif" width="8" height="19"></td>
			</tr>
		</table>
		</div>
	</td>
	</tr>
<? }else{ ?>
	<tr><td align="center">Aucune sous rubriques</td></tr>
<? } ?>
</table>
</body>
