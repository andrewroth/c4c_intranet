<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text"/>

<xsl:template match="Report">
  <xsl:apply-templates select="WEEKLY_FOR_SEMESTER"/>
</xsl:template>

<xsl:template match="IndividualWeek">
  <xsl:for-each select="*">
   <xsl:value-of select="."/>
   <xsl:if test="position() != last()">
    <xsl:value-of select="','"/>
   </xsl:if>
  </xsl:for-each>
</xsl:template>

</xsl:stylesheet>