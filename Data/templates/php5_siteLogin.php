<?

$pathToRootKey =  XMLObject_PageContent::ELEMENT_PATH_ROOT;
$pathToRoot = (string) $page->$pathToRootKey;


/*
 *  Start by echo'ing the standard XHTML compliant xml opening tag...
 *     NOTE: we need to echo it since the '<?' and '?>' parts of the tag will
 *           cause our PHP Template System to fault.
 */
echo '<?xml version="1.0" encoding="iso-8859-1"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<script>
    // The following variable is used in the milonic menu scripts to properly
    // find the path to the other menu scripts to include.
    aiPathToRoot='<?=$pathToRoot;?>';
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?

		/*
		 *  Insert CSS Styles and JavaScript links ...
		 */
        $styleListKey = XMLObject_PageContent::NODE_CSS;
        $styleKey =  XMLObject_PageContent::ELEMENT_CSS;
        foreach ($page->$styleListKey->$styleKey as $style) {
            echo '<link href="'.$pathToRoot.$style.'" rel="stylesheet" type="text/css">'."\n";
        }
        
        $scriptListKey = XMLObject_PageContent::NODE_SCRIPT;
        $scriptKey =  XMLObject_PageContent::ELEMENT_SCRIPT;
        foreach ($page->$scriptListKey->$scriptKey as $script) {
            echo '<script language="JavaScript" src="'.$pathToRoot.$script.'" type="text/javascript"></script>'."\n";
        }
	?>
</head>

<body>
<? 

echo $page->content;

?>
</body>
</html>
