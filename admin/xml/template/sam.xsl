<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="root/result">
    <table border="1" cellpadding="2" cellspacing="1">   
        <tr>
            <td width="20%">
            	Nom : 
            </td>
        </tr>
    <xsl:for-each select="row">
        <tr>
            <td width="80%">
            	<xsl:value-of select="style_name" />
            </td>
        </tr>
    </xsl:for-each>
    </table>
</xsl:template>
</xsl:stylesheet>