<xsl:stylesheet
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
                <xsl:value-of select="body" disable-output-escaping="yes">
            </td>
        </tr>
    </table>
</xsl:template>
</xsl:stylesheet>