<?php
//include "../../../php/Classes/class_Email.php";

//	EMAIL INFORMATION
//
//		These values will define the SMTP & POP3 value defaults for the Email Class.
/*
define( 'EMAIL_CONNECTION_TIMEOUT', 20);
define( 'EMAIL_SMTP_SERVER', 	'192.168.216.12');
define( 'EMAIL_SMTP_PORT', 		25);
define( 'EMAIL_POP3_USER', 		'test' );
define( 'EMAIL_POP3_PASS', 		'test' );
define( 'EMAIL_POP3_SERVER', 	'192.168.216.12');
define( 'EMAIL_POP3_PORT', 		110);
*/
class Emailer
{
    protected $email;
    protected $recipients;
    protected $ccrecipients;
    protected $bccrecipients;
    protected $sender;
    protected $subject;
    protected $message;
    protected $template;
    
    function __construct()
    {
        $this->recipients = "";
        $this->ccrecipients = "";
        $this->bccrecipients = "";
        $this->sender = "legolas@lotr.net";
        $this->template = 0;
    }
    
    
    
    function addRecipients($recipients, $languageID=1, $type="normal")
    {
        switch ($type)
        {
            case "normal":
            $this->recipients = $recipients;
            break;
            case "cc":
            $this->ccrecipients = $recipients;
            break;
            case "bcc":
            $this->bccrecipients = $recipients;
            break;
            default:
            break;
        }
    }
    
    
    
    function send()
    {
        $this->setupEmail();
        $this->email->send();
    }
    
    
    
    function setMessage($message)
    {
        $this->message = $message;
    }
    
    
    
    function setSender($sender)
    {
        $this->sender = $sender;
    }
    
    function setSubject($subject)
    {
        $this->subject = $subject;
    }   
    
    function setupEmail()
    {
        $this->email = new Email($this->sender, $this->recipients, $this->ccrecipients, $this->bccrecipients, $this->subject);
        $this->email->addMessage(new Email_Message($this->message));
       
    }
    
    function getString()
    {
        $retVal = "Sender: " . $this->sender . "<br>\n";
        $retVal .= "Recipients: " . $this->recipients . "<br>\n";
        $retVal .= "CCRecipients: " . $this->ccrecipients . "<br>\n";
        $retVal .= "BCCRecipients: " . $this->bccrecipients . "<br><br>\n\n";
        $retVal .= "    Subject: " . $this->subject . "<br>\n";
        $retVal .= "<br><br>\n\nMessage: " . $this->message . "<br>\n";
        return $retVal;
    }
}
/*
$test = new Emailer();
$test->addRecipients("ruy@dodomail.net; reubenuy@gmail.com");
$test->setSubject("Urgent message");
$test->setMessage("Heal plz!!\nlegolas");
$test->send();
*/
?>