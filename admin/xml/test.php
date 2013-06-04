<?php
$xslData = '<xsl:stylesheet
  version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="article">
    <table border="1" cellpadding="2" cellspacing="1">
        <tr>
            <td width="20%">
             
            </td>
            <td width="80%">
                <h2><xsl:value-of select="title"></h2>
                <h3><xsl:value-of select="author"></h3>
                <br>
                <xsl:value-of select="body">
            </td>
        </tr>
    </table>
</xsl:template>
</xsl:stylesheet>';
$xmlData = '
<?xml version="1.0"?>
<article>
    <title>Learning German</title>
    <author>Sterling Hughes</author>
    <body>
      Essential phrases:
      <br>
      <br>
      Knnen Sie mir sagen, wo die Toilette ist?<br>
      Ein grosses Bier, bitte!<br>
      Noch eins, bitte.<br>
    </body>
</article>';
$xh = xslt_create();
$arguments = array('/_xml' => $xmlData,'/_xsl' => $xslData);
$result = xslt_process($xh,'arg:/_xml','arg:/_xsl',NULL,$arguments);
if ($result)
{
    echo "Voici un brillant article sur l'apprentissage du ";
    echo " français: ";
    echo "<br>\n<br>";
    echo $result;
}
else
{
    echo "Une erreur est survenue durant le traitement XSL...\n";
    echo "\tErreur numéro : " . xslt_errno() . "\n";
    echo "\tMessage d'erreur : " . xslt_error() . "\n";
    exit;
}
?>
