<?
$xh = xslt_create();

$result = xslt_process($xh, "xml/dump_xml/sam.xml", "xml/template/sam.xsl");
if ($result){
	echo $result;
}else{
	echo "Une erreur est survenue durant le traitement XSL...<br>";
    echo "Erreur numéro : " . xslt_errno() . "<br>";
    echo "Message d'erreur : " . xslt_error() . "<br>";
    exit;

}

xslt_free($xh);
?>