<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text"/>

<xsl:template match="PRC_FOR_SEMESTER">
  <xsl:apply-templates select="IndividualPRC"/>
</xsl:template>

<xsl:template match="IndividualPRC">
  <xsl:for-each select="*">
   <xsl:value-of select="."/>
   <xsl:if test="position() != last()">
    <xsl:value-of select="','"/>
   </xsl:if>
  </xsl:for-each>
  <xsl:text>&#10;</xsl:text>
</xsl:template>

</xsl:stylesheet>