<?php


class  Email {
// 
//  DESCRIPTION:
//		This is a class for sending Email.  Some of the pop3 routines initially 
//		developed by Viper_SB (viper_sb@hotmail.com).  The routines were rewritten 
//		for use in a Class.
//
//	CONSTANTS:

//
//	VARIABLES:
	protected $smtp_server;	// SMTP server to connect to : ex "smtp.server.com"
	protected $smtp_port;		// Set port: Common port is 25
	protected $smtp_fp;		// The Socket/File Pointer for referencing our communications
	
	protected $email_from;	// Who it is from : ex "me@me.com"		
	protected $email_to;		// Who it is to : ex "you@you.com"
	protected $email_cc;
	protected $email_bcc;	
						// NOTE: The above email address fields can be Single Entry or a list of entries.
						//
						// 		 When adding an Entry it can be a single email address ( eg "me@me.com" ) or 
						//		 it can be a Name <email@address> pair (eg "John Smith <me@me.com>" )  
						//		 (email address is set apart by the "<" & ">" ).
						//
						// 		 If you are sending a list of eMail addresses, seperate that list with ; 
						//			eg,  "John Smith <me@me.com>; myself@me.com; I < i@me.com >"
						
	protected $email_rcptlist;	// An internal variable that compiles all the email addresses for use in sending
							// the SMTP Envelope.
													
	protected $email_subject;	// Subject of the message		

	protected $email_messages;	// Array of Messages.  The Content of the Email.  Must be of Class Email_Message.
	protected $email_attachments;	// Array of Attachments to be included.  Must be of Class Email_Attachment.
		
	protected $email_boundry_message;		// The SMTP boundry string to distinguish multiple alternate messages.
	protected $email_boundry_parts;		// The SMTP boundry string for different parts of an Email message.
									// (this is inbetween the message and attachments )
										
	protected $pop3_authenticate;	// Boolean to indicates if we need to first authenticate with POP before sending.
	
	protected $pop3_user;		// POP3 User name
	protected $pop3_pass; 	// POP3 password
	protected $pop3_server;	// POP3 server to connect to : ex "pop.server.com"
	protected $pop3_port;		// Set port: Common port is 110
	
	protected $socket_timeout;	// The Timeout for establishing socket connections with the servers.
	
	protected $debug_mode;	// Boolean Flag for indicating wether or not to save debugging info.
	protected $debug_data;	// The Debugging data that is collected.
	
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Email($from="", $to="", $cc="", $bcc="", $subject="",  $smtp_server=EMAIL_SMTP_SERVER, $smtp_port=EMAIL_SMTP_PORT, $pop3_user=EMAIL_POP3_USER, $pop3_pass=EMAIL_POP3_PASS, $pop3_server=EMAIL_POP3_SERVER, $pop3_port=EMAIL_POP3_PORT, $socket_timeout=EMAIL_CONNECTION_TIMEOUT) {
		
		$this->smtp_server 	= $smtp_server;
		$this->smtp_port 	= $smtp_port;
		$this->smtp_fp		= 0;
		
		$this->email_from 	= $from;
		$this->email_to		= $to;
		$this->email_cc		= $cc;
		$this->email_bcc	= $bcc;
		
		$this->email_rcptlist	= array();
		
		$this->email_subject	= $subject;

		$this->email_messages = array();
		$this->email_attachments = array();
		
		$this->email_boundry_message = '_-_Message-Boundry_-_';
		$this->email_boundry_parts = '_-_Message-Parts_-_';
		
		$this->pop3_authenticate = false;
		
		$this->pop3_user	= $pop3_user;
		$this->pop3_pass	= $pop3_pass;
		$this->pop3_server	= $pop3_server;
		$this->pop3_port	= $pop3_port;
		
		$this->socket_timeout = $socket_timeout;
	
		$this->debug_mode	= false;
		$this->debug_data	= '';
		
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function send() {
	
		$this->setupData();
	
		// If we need to pop authenticate before sending, call pop3auth() 
		if ($this->pop3_authenticate == true) {
		
			$this->pop3auth($this->pop3_server, $this->pop3_user, $this->pop3_pass, $this->pop3_port); 
		}
		
		if ( $this->openConnection() ) {
		
			$this->sendEnvelope();
			$this->sendHeaders();
			$this->sendMessages();
			$this->sendAttachments();
			
			$this->quitSMTP();
			$this->closeConnection();
			
		}

	}
	
	

	
	
	//************************************************************************
	function setupData() {
	//  
	//	This routine prepares the info we need to properly send this eMail.
	
	
		// Prepare the Email RCPT List
		$this->parseEmailList( $this->email_to );
		$this->parseEmailList( $this->email_cc );
		$this->parseEmailList( $this->email_bcc );
		
		if ($this->debug_mode == true) {
		
			$this->debug_data .= '<b>List Of Email Addresses:</b> <br>';
			$this->debug_data .= 'email_to = ['.$this->email_to.']<br>';
			$this->debug_data .= 'email_cc = ['.$this->email_cc.']<br>';
			$this->debug_data .= 'email_bcc = ['.$this->email_bcc.']<br><br>';
			
			// Record the RCPT TO List:
			for ($Indx=0; $Indx < count( $this->email_rcptlist ); $Indx++) {
				$this->debug_data .= 'email_rcplist['.$Indx.'] = ['. $this->email_rcptlist[$Indx].']<br>';
			}
			$this->debug_data .= '<br><br>';
		}

// Still need to add error checking here ...

	}
	
	//************************************************************************
	function parseEmailList( $List ) {
	//  
	//	This routine searches through the given List and pulls out the email address
	//	for use in the RCPT list.
	
	
		if ( $List != '') {
		
			// Prepare the Email RCPT List
			// Expand $List into an array of items
			$ListOfAddresses = explode( ';', $List );
			
			// for each item in the array ...
			for ($Indx=0; $Indx < count( $ListOfAddresses ); $Indx++) {
			
				// If it contains an '<' it must be in format "Name <email@address>"
				$CurrEmail = trim( $ListOfAddresses[ $Indx ] );
				$BegPosition = strpos( $CurrEmail, '<');
				$EndPosition = strpos( $CurrEmail, '>');
				if (($BegPosition === false) && ($EndPosition === false)) {
				
					// not found, so must be in format "email@address" ...
					$this->email_rcptlist[] = $CurrEmail;
				
				
				} else {
				
					// if only "<" or ">" was found ...
					if (($BegPosition === false) || ($EndPosition === false))  {
					
						echo 'EMAIL:parseEmailList:invalid email entry ['.$CurrEmail.']<br>';
					
					} else {
					
						// else get substring that is the email address.
						$Address = substr( $CurrEmail, $BegPosition +1, $EndPosition - $BegPosition -1);
						
						$this->email_rcptlist[] = trim( $Address );
					}
				
				}
				
			} // end for
			
		} // end if List != ''
		 

// Still need to add error checking here ...

	}
	
	
	//************************************************************************
	function openConnection() {
	//  
	//	This routine simply prepares the socket connection with the SMTP server.
	//  It stores the pointer to the connection in $this->smtp_fp variable.
	
		// Connect to SMTP server using given SMTP information ...
		$this->smtp_fp = fsockopen($this->smtp_server, $this->smtp_port, $errno, $errstr, $this->socket_timeout);
		
		if ($this->smtp_fp != false) {
	
			socket_set_blocking($this->smtp_fp,-1);
			
			if ( $this->debug_mode == true ) {
			
				$displayText = 'Socket Successfully Opened ... <br>';
				echo $displayText;
				$this->debug_data .= $displayText;
				
			}
			
			return true;

		} else {
		
		
			if ( $this->debug_mode == true ) {
			
				$displayText = 'EMAIL:openConnection:Error Opening Socket = ['.$errno.'] '.$errstr.'<br>';
				echo $displayText;
				$this->debug_data .= $displayText;
				
			}
			
			return false;
			
		}

	}
	
	
	//************************************************************************
	function sendSMTP( $DataToSend, $GetReply=true ) {
	//  
	//	This routine actually sends the data to the SMTP server.  It also tracks
	//	the debugging/logging info if enabled.
	// 
	//	By default it will wait for a reply from the server after sending the data.
	//	Setting $GetReply = false will not cause it to wait for data back after
	//	sending.
	
		fwrite($this->smtp_fp, $DataToSend );
		
		if ($GetReply == true) {
			$Reply = fgets($this->smtp_fp, 512);
		}
		
		if ( $this->debug_mode == true ) {
		
			echo '<i>'.htmlspecialchars($DataToSend).'</i><br>';
			$this->debug_data .= '<i>'.htmlspecialchars($DataToSend).'</i><br>';
			
			if ($GetReply == true) {
				echo '<strong>'.htmlspecialchars($Reply).'</strong><br>';
				$this->debug_data .= '<strong>'.htmlspecialchars($Reply).'</strong><br>';
			}
		}
		
		
	}
	
	
	//************************************************************************
	function sendEnvelope() {
	//  
	//	This routines sends the initial SMTP ENVELOPE info.
	
		$this->sendSMTP( "HELO ". $this->smtp_server ."\r\n");
		
		//$this->sendSMTP(  "VRFY " . $this->pop3_user . "\r\n"); // On some servers this line isn't necessary; to see if it is un comment the 
		// lines below and if you get 252 Cannot VRFY user; try RCPT to attempt delivery (or try finger) comment out this line

		$this->sendSMTP( "MAIL FROM:<" . $this->email_from . ">\r\n");

		// Now we add a RCPT TO: for each To, Cc, and Bcc entry:
		for ($Indx=0; $Indx < count( $this->email_rcptlist ); $Indx++) {
			$this->sendSMTP( "RCPT TO:<". $this->email_rcptlist[ $Indx ] .">\r\n");
		}
		
		$this->sendSMTP( "DATA\r\n");

	}
	
	
	//************************************************************************
	function sendHeaders() {
	//  
	//	This routines sends the message headers.  These are not REQUIRED for SMTP
	//  but are used by the mail clients to fill out the message info.
	
				
		$this->sendSMTP( "From: " . $this->email_from . "\r\n", false);
		$this->sendSMTP( "To: " . $this->email_to . "\r\n", false);
		$this->sendSMTP( "Subject: " . $this->email_subject . "\r\n", false);
		$this->sendSMTP( "Reply-To: " . $this->email_from . "\r\n", false);
		$this->sendSMTP( "Cc: " . $this->email_cc . "\r\n", false);
		$this->sendSMTP( "X-Mailer: eMailer \r\n", false); // You can put what you want here right now it means

		
		$this->sendSMTP(  "MIME-version: 1.0\n", false);
		$this->sendSMTP(  "Content-type: multipart/mixed; boundary=\"".$this->email_boundry_parts."\"\n\n", false);

		$this->sendSMTP(  "--".$this->email_boundry_parts."\n", false);

	}
	
	
	//************************************************************************
	function sendMessages() {
	//  
	//	This routine sends all the included Messages.
	
		$NumMessages = count( $this->email_messages);
		
		// if > 1 message is present
		if ( $NumMessages > 1 ) {
		
			//send Message Attachment Header
			$this->sendSMTP(  "Content-type: multipart/alternative; boundary=\"".$this->email_boundry_message."\"\n\n", false);
			
		} // end if
		
		// for each message
		for ($Indx=0; $Indx<$NumMessages; $Indx++){
		
			// if > 1 message present
			if ($NumMessages > 1 ) {
			
				// send boundry
				$this->sendSMTP(  "--".$this->email_boundry_message."\n", false);
			} // end if
			
			
			// send Message
			$this->sendSMTP( $this->email_messages[ $Indx ]->returnFormattedMessage(), false );
			
		} // Next Message
		
		// if > 1 message is present
		if ($NumMessages > 1 ) {
		
			// send ending boundry
			$this->sendSMTP(  "--".$this->email_boundry_message."--\n\n", false);
		}// end if

	}
	
	//************************************************************************
	function sendAttachments() {
	//  
	//	This routine sends all the included Messages.
	
		$NumAttachments = count( $this->email_attachments);

		
		// for each message
		for ($Indx=0; $Indx<$NumAttachments; $Indx++){
		
			// Preceed  the attachments with another part boundry.
			$this->sendSMTP(  "--".$this->email_boundry_parts."\n", false);

			// send Message
			$this->sendSMTP( $this->email_attachments[ $Indx ]->returnFormattedMessage(), false );
			
		} // Next Message

	}

	
	
	//************************************************************************
	function quitSMTP() {
	//  
	//	This routine wraps up the SMTP Envelope and closes the SMTP connection.
	
		$this->sendSMTP(  "--".$this->email_boundry_parts."--\n", false);
		
		$this->sendSMTP( "\r\n.\r\n");

		$this->sendSMTP(  "QUIT");
	}
	
	
	
	//************************************************************************
	function closeConnection() {
	//  
	//	This routine simply closes the socket connection with the SMTP server.
	
		// Close out the File/Socket ...
		fclose($this->smtp_fp);

	}
	
	

	// These 2 functions are used by pop3auth
	function is_ok_pop3 ($cmd = ""){
		//	Return true or false on +OK or -ERR
		if(empty($cmd))				{ return false; }
		if (ereg ("^\+OK", $cmd))	{ return true; }
		return false;
	}
	function is_ok_smtp ($cmd = ""){
		//	Return true or false on +OK or -ERR
		if(empty($cmd))				{ return false; }
		if (ereg ("^220", $cmd))	{ return true; }
		if (ereg ("^250", $cmd))	{ return true; }
		return false;
	}

	// Connect to POP3 server and authenticate
	function pop3auth() {
		if ($this->pop3_server == ""){
		} else {
			$fpop = fsockopen($this->pop3_server, $this->pop3_port, $errno, $errstr, $this->socket_timeout); 

			if (!$fpop) {
				echo "ERROR: Could not open socket";
				die;
			}
			$reply = fgets($fpop, 512);
			if(!$this->is_ok_pop3($reply)) {
				echo "Connection ERROR: POP3 server responded with " . $reply;
				die;
			}

			set_socket_blocking($fpop,-1);

			fwrite($fpop, "USER ". $this->pop3_user ."\r\n");		// Send USER login
			$reply = fgets($fpop, 512);
			if(!$this->is_ok_pop3($reply)) {
				// +OK name is a valid mailbox
				// -ERR never heard of mailbox name
				echo "ERROR invalid user or never heard of mailbox name:<br> Response was:" . $reply;
				fwrite($fpop, "QUIT");
				die;
			}
			fwrite($fpop, "PASS ". $this->pop3_pass ."\r\n");		// Send user PASS
			$reply = fgets($fpop, 512);
			if(!$this->is_ok_pop3($reply)) {
				 // +OK maildrop locked and ready
				 // -ERR invalid password
				 // -ERR unable to lock maildrop
				echo "POP3 AUTHENTICATION ERROR: invalid password or unable to lock maildrop<br> Response was:" . $reply;
				fwrite($fpop, "QUIT");
				die;
			}
			
			fwrite($fpop, "STAT\r\n"); // Checks mail box
			$reply = fgets($fpop, 512);
			fwrite($fpop, "QUIT"); // Quits
			fclose($fpop);
			//echo "POP3 Authentication OK<br>"; // Enable this if you want to be told that it worked fine
			
			// End POP3 Authentication
		}
	}
	//*************************************************************************************************************************
	// End functions
	//*************************************************************************************************************************

	
	
	//************************************************************************
	function setDebugOn() {
	//  
	//	This routine sets the internal Debug Mode to TRUE.
	
		$this->debug_mode = true;
		
	}
	
	
	//************************************************************************
	function addMessage( $NewMessage ) {
	//  
	//	This routine adds a message to this email.
	
		$this->email_messages[] = $NewMessage;
		
	}
	
	
	//************************************************************************
	function addAttachment( $newAttachment ) {
	//  
	//	This routine adds an attachment to this email.
	
		$this->email_attachments[] = $newAttachment;
		
	}
	
    //CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the obj_Email Object.
	 * </pre>
	 * @param $modulePath [STRING] The path from the root directory to this 
	 * module's root directory.
	 * @param $viewer [OBJECT] The viewer object 
	 * @return [STRING]
	 */
	 function addToRecipient( $newRecipient, $newName='') {
	   if((eregi("^([ 0-9a-z\.-_]*)",$newName))&&(eregi("^([0-9a-z]+)([ 0-9a-z\.-_]+)@([0-9a-z\.-_]+)\.([0-9a-z]+)",$newRecipient))) {
    	   $this->email_to	.= $newName . "<" . $newRecipient . ">;";
    	   return $this->email_to;
	   } else {
	       return false;
	   }
	 
				
	}
	
	
	

	
	
	
    //CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the obj_Email Object.
	 * </pre>
	 * @param $modulePath [STRING] The path from the root directory to this 
	 * module's root directory.
	 * @param $viewer [OBJECT] The viewer object 
	 * @return [void]
	 */
	 function setSubject( $email_subject ) {
          $this->email_subject = $email_subject;	
	}
	
	
	
    //CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the obj_Email Object.
	 * </pre>
	 * @param $modulePath [STRING] The path from the root directory to this 
	 * module's root directory.
	 * @param $viewer [OBJECT] The viewer object 
	 * @return [void]
	 */
	function addCC( $newRecipient ) {
				
	}
	
	
	
    //CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the obj_Email Object.
	 * </pre>
	 * @param $modulePath [STRING] The path from the root directory to this 
	 * module's root directory.
	 * @param $viewer [OBJECT] The viewer object 
	 * @return [void]
	 */
	 function addBCC( $newRecipient ) {
				
	}

    function getMessage()
    {
        return $this->email_messages;
    }
    
    function getSubject()
    {
        return $this->email_subject;
    }
}





class  Email_Message {
// 
//  DESCRIPTION:
//		This is a class for a message that is to be added to an Email.
//
//	CONSTANTS:

//
//	VARIABLES:
protected $message_body;		// The content of the Message.  
protected $message_type;		// The Type of a message: Plain Text or HTML

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Email_Message( $body, $type='text/plain') {
		
		$this->message_body = $body;
		$this->message_type = $type;
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function returnFormattedMessage() {
	// 
	// DESCRIPTION
	//	
	//	
	
		$Result  = "Content-Type: ".$this->message_type."; charset=US-ASCII\n";
		$Result .= "Content-transfer-encoding: 7BIT\n\n";
		$Result .= $this->message_body."\n";

		return $Result;
	
	}	
	
	
	
	function getMessage()
	{
	   return $this->message_body;
	}
	
	
	
	//************************************************************************
	function setTypePlain() {
	// 
	// This function set's the message type of this message to "Text/Plain".
	
		$this->message_type = 'text/plain';
	
	}
	
	//************************************************************************
	function setTypeHTML() {
	// 
	// This function set's the message type of this message to "Text/Plain".
	
		$this->message_type = 'text/html';
	
	}

}




class  Email_Attachment {
// 
//  DESCRIPTION:
//		This is a class for an attachment that is to be added to an Email.
//
//	CONSTANTS:

//
//	VARIABLES:
protected $attachment_path;
protected $attachment_type;
protected $attachment_name;
protected $attachment_encodedData;

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Email_Attachment( $path='' ) {
	//
	// Initialze the class variables to their starting values.  If path is provided,
	// we will attempt to load in a file as the attachment.
		
		$this->attachment_name = '';
		$this->attachment_type	= '';
		$this->attachment_encodedData	= 'no data';
		
		// If a path to a file was given, then attempt to load it.
		if ( $path != '') {
			$this->loadFile( $path );
		}
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function returnFormattedMessage() {
	// 
	// DESCRIPTION
	//	
	//	This takes the given data for the Attachment and compiles the necessary 
	//  header information and returns it as the data for the Attachment contents
	//  for sending.
	

		$Result .= "Content-transfer-encoding: base64\n";
		$Result .= "Content-Type: ".$this->attachment_type."; name=\"".$this->attachment_name."\"\n";
		$Result .= "Content-Disposition: attachment; filename=\"".$this->attachment_name."\"\n\n";
		$Result .= $this->attachment_encodedData."\n";

		return $Result;
	
	}	
	
	
	//************************************************************************
	function setTypeByExtension( $extension ) {
	// 
	// This function set's the attachment type according to the provided file extension.  
	// The extension should be given in all small caps and not include the ".".  
	//    eg:   "zip", "mp3", "jpg"  
	
		// Make sure extension is lower case
		$extension = strtolower( $extension );
		
		switch( $extension ) {
		
		
			//
			// Audio files
			//
			case 'aif':
			case 'aiff':
				$this->attachment_type = 'audio/x-aiff';
				break;
				
			case 'mpga':
			case 'mp2':
			case 'mp3':
				$this->attachment_type = 'audio/mpeg';
				break;
		
			//
			// Image Files
			//
			case 'gif':
				$this->attachment_type = 'image/gif';
				break;
				
			case 'jpg':
			case 'jpeg':
			case 'jpe':
				$this->attachment_type = 'image/jpeg';
				break;
				
			case 'png':
				$this->attachment_type = 'image/png';
				break;
				
			case 'tiff':
			case 'tif':
				$this->attachment_type = 'image/tiff';
				break;
				
			//
			// Application Related Files
			//
			case 'bin':
			case 'dms':
			case 'lha':
			case 'lzh':
			case 'exe':
			case 'class':
				$this->attachment_type = 'application/octet-stream';
				break;
			
			case 'dot':
			case 'doc':
				$this->attachment_type = 'application/msword';
				break;
			
			case 'pdf':
				$this->attachment_type = 'application/pdf';
				break;
				
			case 'sit':
				$this->attachment_type = 'application/x-stuffit';
				break;
				
			case 'swf':
				$this->attachment_type = 'application/x-shockwave-flash';
				break;
				
			case 'tar':
				$this->attachment_type = 'application/x-tar';
				break;
				
			case 'zip':
				$this->attachment_type = 'application/zip';
				break;
				
// Verify these ...				
			case 'xls':
			case 'xlt':
				$this->attachment_type = 'application/vnd.ms-excel';
				break;
				
			case 'ppt':
				$this->attachment_type = 'application/vnd.ms-powerpoint';
				break;
// end Verify 
				
			//
			// Video Related Files
			//
			case 'avi':
				$this->attachment_type = 'video/x-msvideo';
				break;
			
			case 'mov':
			case 'qt':
				$this->attachment_type = 'video/quicktime';
				break;
				
			case 'mpeg':
			case 'mpg':
			case 'mpe':
				$this->attachment_type = 'video/mpeg';
				break;
		
		}
	
	}
	
	
	//************************************************************************
	function loadFile( $path, $newName='' ) {
	// 
	// This function loads a file from disk as this attachment. You must provide the 
	// path to this file.  Remember that the path will be relative to the location
	// of the calling page.  
	//
	// Calling this function will load the data into the attachment, encode it 
	// for transmission, attempt to set it's type based on it's name, and set the 
	// final name for sending.
	//
	// $path	= The path to the file.
	// $newName	= The name you want this file to be named for the Attachment. If you 
	//			  want it to be the same as the path, just omit this parameter.
	
		
		if (file_exists($path)) {
		
			// Load & Encode the data
			$file = fopen($path, "r");
			set_magic_quotes_runtime(0);
			$contents = fread($file, filesize($path) );
			set_magic_quotes_runtime(1);
			$this->attachment_encodedData = chunk_split(base64_encode($contents));
			fclose($file);
			
			$this->setTypeFromGivenName( $path );
			
			if ( $newName == '') {
			
				$newName = $this->getNameFromPath( $path );
			}
			
			$this->attachment_name = $newName;
			
				
			return true;	
				
		} else {
		
			echo 'EMAIL_ATTACHMENT:LOADFILE: File does not exist ['.$path.']<br>';
			return false;
		} 
	}
	
	
	//************************************************************************
	function loadData( $data, $newName='' ) {
	// 
	// This function takes the provided data and encodes it for sending.  
	//
	// If you do not provide a Name, you will still need to set the name and Type
	// manually.
	
		
		$this->attachment_encodedData = chunk_split(base64_encode($data));
			
		if ($newName != '') {
			$this->attachment_name = $newName;
			$this->setTypeFromGivenName( $newName );
		} else {
			$this->attachment_name = 'unnamed.file';
		}
		return true;	

	}
	
	
	
	//************************************************************************
	function getNameFromPath( $path ) {
	//
	// This is a utility function to pull off the name from a provided path to
	// a file.
	//
	
		// 1st change any '\' to '/' 
		$path = str_replace( '\\', '/', $path);
		
		// Now get last '/' in path
		$position = strrpos( $path, '/');
		
		// If no '/' exists then Path = Name
		if ($position === false) {
		
			$name = $path;
			
		} else {
		
			// else get name from path
			$name = substr( $path, $position + 1);
		}
		
		return $name;
	
	}
	
	
	
	
	//************************************************************************
	function setTypeFromGivenName( $path ) {
	//
	// This is a utility function to pull off the extension of the provided name 
	// and set this attachment's type. 
	//
	// The name can have the full path associated with it.
	//
	
		// Now attempt to get file type from given path and set the Type
		$name = $this->getNameFromPath( $path );
		
		// Now get position of '.' in name
		$position = strrpos( $name, '.' );
		
		if ($position === false) {
			
			// Then just use the $name as $extension
			$extension = $name;
			
		} else {
		
			// Get the extension of the file from the name
			$extension = substr( $name, $position + 1);
			
		}
		
		// Now Set the Type
		$this->setTypeByExtension( $extension );
	}

}






?>