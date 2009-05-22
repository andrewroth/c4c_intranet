<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text"/>

<xsl:template match="Report">
  <xsl:apply-templates select="CAMPUS_REPORT"/>
</xsl:template>

<xsl:template match="Activity">
  <xsl:for-each select="*">
   <xsl:text>"</xsl:text><xsl:value-of select='.'/><xsl:text>"</xsl:text>
   <xsl:if test="position() != last()">
    <xsl:value-of select="','"/>
   </xsl:if>
  </xsl:for-each>
</xsl:template>

</xsl:stylesheet>