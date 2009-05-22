<?php
require("../General/gen_Includes.php");
require("../modules/app_cim_home/objects_pages/page_HomePage.php");
require("../modules/app_cim_home/objects_bl/obj_SideBar.php");
 require("app_aia_reg.php");

// echo PAGE_TEMPLATE."<BR>".PAGE_TEMPLATE_DEFAULT;

// get the proper page template to use in displaying the data.
// $pageTemplateRequest = XMLObject_PageContent::getQSValue( PAGE_TEMPLATE, PAGE_TEMPLATE_DEFAULT );

$page = new Page( '../Data/templates/php5_siteAIAGreyCupTemplate.php' );
$validate = false;
$page->start($validate);

?>
