<?
require "../library_local/lib_global.inc.php";
require "../library/fonction.inc.php";
require "/usr/local/lib/php/XML/sql2xml.php";
connection();

$str_listid = "SELECT xsl_tpl FROM "._CONST_BO_CODE_NAME."xsl_tpl WHERE id_"._CONST_BO_CODE_NAME."xsl_tpl=".$xsl_id;
$rst_listid = mysql_query($str_listid);
$xslstring = mysql_result($rst_listid,0,0);

$str_connect = "mysql://".$UserName.":".$UserPass."@".$Host."/".$BaseName;
$sql2xmlclass = new xml_sql2xml($str_connect);
$xmlstring = $sql2xmlclass->getxml($strsql);

$xh = xslt_create();
$arguments = array('/_xml' => $xmlstring,'/_xsl' => $xslstring);
$preview = xslt_process($xh,'arg:/_xml','arg:/_xsl',NULL,$arguments);
if ($preview){
	echo $preview;
}else{
	echo "Une erreur est survenue durant le traitement XSL...<br>";
    echo "Erreur numéro : " . xslt_errno() . "<br>";
    echo "Message d'erreur : " . xslt_error() . "<br>";
    exit;
}

xslt_free($xh);
?>