<?php
/*
$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}

require ( $extension.$pathFile );
*/
//require_once("modules/app_EmailTemplates/incl_EmailTemplates.php");
//require_once("../../app_EmailTemplates/incl_EmailTemplates.php");
require_once("Emailer.php");
//require_once("../php/Classes/class_Email.php");

class EmailTemplate
{
    protected $template;
    protected $values;
    protected $manager;
    protected $key;
    protected $recipient;
    protected $subject;
    protected $bccrecipients;
    protected $ccrecipients;
    
    function __construct($values="", $recipient="", $templateKey="", $languageID=1, $appID="")
    {
        $this->template = "";
        $this->manager = new RowManager_EmailTemplateManager();
        $this->values = $values;
        $this->key = $templateKey;
        $this->recipient = $recipient;
        
        $label = $this->loadTemplateFromKey($templateKey,$appID,$languageID);
        //echo "subject - " . $this->getSubject($retVal) . "\n";
        $pos = strpos($label, "\n");
        //echo "template = " . substr($retVal, $pos) . "\n";
        $this->template = substr($label, $pos);
        $subject = $this->getSubject($label);
        $this->subject = $this->getString($subject);
        //echo $retVal;
    }
    
    function getString($input="")
    {
        if ($input == "") {
            $retVal = $this->template;
        } else {
            $retVal = $input;
        }
        //print_r($this->values);
        foreach($this->values as $key => $value)
        {
            $retVal = str_replace("[".$key."]", $value, $retVal);
            //print $retVal . "<br>";
        }
        return $retVal;
    }
    
    function getTemplate($template)
    {
        return $this->template;
    }
    
    
    function isActive()
    {
        return $this->manager->isActive();
    }
    
    
    function loadTemplateFromKey($templateKey, $appID, $languageID)
    {
        if ($this->manager->loadByKey($templateKey))
        {
            $labelKey = $this->manager->getLabelKey();
            //$this->setAppID($appID);
            $labelManager = new RowManager_MultilingualLabelManager();
            $labelManager->loadByKeyInfo("", $labelKey, $languageID);
            return $labelManager->getLabel();
        }
    }
    
    function sendEmail($send=true)
    {
        $emailer = new Emailer();
        $message = $this->getString();
        $emailer->setMessage($message);
        $emailer->setSubject($this->subject);
        $emailer->setSender("nss@dodomail.net");
        $emailer->addRecipients($this->recipient);
        $emailer->addRecipients($this->bccrecipients, 1, "bcc");
        $emailer->addRecipients($this->ccrecipients, 1, "cc");
        if ($send) {
            $emailer->send();
        } else 
        {
            $emailString = $emailer->getString();
            print $emailString;
        }
    }
    
    function setTemplate($template)
    {
        $this->template = $template;
    }   
    
    function setValues($values)
    {
        $this->values = $values;
    }
    
    function setBCCRecipients($bccrecipients)
    {
        $this->bccrecipients = $bccrecipients;
    }
    
    function setCCRecipients($ccrecipients)
    {
        $this->ccrecipients = $ccrecipients;
    }
    
    function getSubject($template)
    {
        //$template = $this->getValueByFieldName( 'template_content' );
        $subject = explode("\n", $template);
        
        //print_r($subject);
        //echo implode("\n", $subject);
        if(isset($subject[0])) {
            return $subject[0];
        } else return "";
    
    }
    
    function testSend()
    {
        $this->sendEmail(false);
    }
}
/*
$values = array();
$values['name'] = "Reuben";
//$values['amount'] = "\$100";
//$values['approved'] = 'rejected';
$test = new EmailTemplate($values, "ruy@dodomail.net", "AdjustmentApproveReject",3);
//$test->setCCRecipients("jhausman@dodomail.net");
//$test->setBCCRecipients("ric@zteam.biz");
//$test->sendEmail();
$test->testSend();
*/

/*
$test->getSubject();
$test->setTemplate("Hi [name]!  You owe $[amountowed]!\nPay back or i kill you!\n\n");
$values = array();
$values['name'] = "Walker";
$values['amountowed'] = "1000";
$test->setValues($values);
echo $test->getString();
*/
?>