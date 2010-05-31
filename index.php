<?php
require("General/gen_Includes.php");

// get the proper page template to use in displaying the data.
$pageTemplateRequest = XMLObject_PageContent::getQSValue( PAGE_TEMPLATE, PAGE_TEMPLATE_DEFAULT );
$page = new Page( $pageTemplateRequest );
$page->start();

?>
