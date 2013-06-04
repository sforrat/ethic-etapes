<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="root/result">
<TABLE cellSpacing="1" cellPadding="2" border="0">
<xsl:for-each select="row">
<TBODY>
<TR>
<TD width="20%"><B><xsl:value-of select="titre"/></B></TD></TR>
<TR>
<TD width="100%"><xsl:value-of select="contenu"/></TD></TR>
</TBODY>
</xsl:for-each>
</TABLE>
</xsl:template>
</xsl:stylesheet>