<?php
require("General/gen_Includes.php");

CASUser::setup("/var/www/campus/dev.intranet.campusforchrist.org/callback.log");
CASUser::checkAuth();

?>
