<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Series</title>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body>
<h1>Edit Series:</h1>
<form action="<? echo $formAction; ?>" method="post">
Series Name: <input name="title" type="text" value="<?php echo $title; ?>" /><br />
<?
 if ($titleError != '' ) {
    echo '<span class="style1">'.$titleError.'</span><br>';
 }
?><input name="submit" type="submit" />
</form>
</body>
</html>