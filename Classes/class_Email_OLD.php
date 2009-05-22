<?php


class  Email {
// 
//  DESCRIPTION:
//		This is a class for sending Email.  It uses a set of routines initially 
//		developed by Viper_SB (viper_sb@hotmail.com).  The routines were rewritten 
//		for use in a Class.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $smtp_server;	// SMTP server to connect to : ex "smtp.server.com"
	var $smtp_port;		// Set port: Common port is 25
	var $from;			// Who it is from : ex "me@me.com"		
	var $to_email;		// Who it is to : ex "you@you.com"
	var $cc;
	var $subject;		// Subject of the message		
	var $body;			// Body of message
	
	
	var $content_isHTML;	// Boolean Flag indicating that the content is an HTML message.
	
	var $attachment;	// Any file you want sent as an attachment, if not just leave blank : ex "/myfiles/myfile.zip"
	var $filename;		// This can be the same as the file name or can be another name and that is what it will show up as: ex "fileforyou.zip"; 		
	
	
	var $pop3_authenticate;	// Boolean to indicates if we need to first authenticate with POP before sending.
	
	var $pop3_user;		// POP3 User name
	var $pop3_pass; 	// POP3 password
	var $pop3_server;	// POP3 server to connect to : ex "pop.server.com"
	var $pop3_port;		// Set port: Common port is 110
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Email($from, $to_email, $subject, $body, $cc='', $pop3_user='', $attachment='', $filename='',  $smtp_server='192.168.254.10', $smtp_port='25', $pop3_pass='', $pop3_server='192.168.254.10', $pop3_port='110') {
		
		$this->smtp_server 	= $smtp_server;
		$this->smtp_port 	= $smtp_port;
		$this->from 		= $from;
		$this->to_email		= $to_email;
		$this->cc			= $cc;
		$this->subject		= $subject;
		$this->body			= $body;
		
		$this->content_isHTML = false;
		
//		$this->attachment_available = false;
		$this->attachment	= $attachment;
		$this->filename		= $filename;
		
		
		$this->pop3_authenticate = false;
		
		$this->pop3_user	= $pop3_user;
		$this->pop3_pass	= $pop3_pass;
		$this->pop3_server	= $pop3_server;
		$this->pop3_port	= $pop3_port;
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function Send() {
	
		// If we need to pop authenticate before sending, call pop3auth() 
		if ($this->pop3_authenticate == true) {
		
			$this->pop3auth($this->pop3_server, $this->pop3_user, $this->pop3_pass, $this->pop3_port); 
		}
		
		$this->send_mail();
	}
	
	
	//  *************************************************************************************************************************
	// Begin functions
	//  *************************************************************************************************************************
	function send_mail() {
		// Connect to SMTP server on port 25
		$fp = fsockopen($this->smtp_server, $this->smtp_port, &$errno, &$errstr, 20);
		socket_set_blocking($fp,-1);
		fwrite($fp, "HELO ". $this->smtp_server ."\r\n");
		// All the echo $reply below aren't needed when sending there just used for debugging (but the $reply = fgets($fp, 512) 
		// is needed) I suggest that the first time you use the script you enable all of them then you can see any problems that
		// come up
		$reply = fgets($fp, 512);
		//echo "$reply<br>";
		
		fwrite($fp, "VRFY " . $pop3_user . "\r\n"); // On some servers this line isn't necessary; to see if it is un comment the 
		// lines below and if you get 252 Cannot VRFY user; try RCPT to attempt delivery (or try finger) comment out this line
		$reply = fgets($fp, 512);
		//echo "$reply<br>";
		fwrite($fp, "MAIL FROM:<" . $this->from . ">\r\n");
		$reply = fgets($fp, 512);
		//echo "$reply<br>";
		fwrite($fp, "RCPT TO:<". $this->to_email .">\r\n");
		$reply = fgets($fp, 512);
		//echo "$reply<br>";
		fwrite($fp, "DATA\r\n");
		$reply = fgets($fp, 512);
		//echo "$reply<br>";
		
		fwrite($fp, "From: " . $this->from . "\r\n");
		fwrite($fp, "To: " . $this->to_email . "\r\n");
		fwrite($fp, "Subject: " . $this->subject . "\r\n");
		fwrite($fp, "Reply-To: " . $this->from . "\r\n");
		fwrite($fp, "Cc: " . $this->cc . "\r\n");
		fwrite($fp, "X-Mailer: WYTIWYG Interface\r\n"); // You can put what you want here right now it means
		// What you Type IS What You Get hehe 

		if ($this->attachment) {
			$attach_name = $this->filename;
			$attach_type = "application/x-zip-compressed"; // This can be changed depending on what you are sending, right now 
			// its set for zip files

			if (file_exists($this->attachment)) {
				$file = fopen($this->attachment, "r");
				set_magic_quotes_runtime(0);
				$contents = fread($file, filesize($this->attachment));
				set_magic_quotes_runtime(1);
				$encoded_attach = chunk_split(base64_encode($contents));
				fclose($file);
			}

			fwrite($fp, "MIME-version: 1.0\n");
			fwrite($fp, "Content-type: multipart/mixed; boundary=\"Message-Boundary\"\n");
			fwrite($fp, "Content-transfer-encoding: 7BIT\n");
			fwrite($fp, "X-attachments: $attach_name\n");

			fwrite($fp, "--Message-Boundary\n");
			
			if ($this->content_isHTML == false ) {
				fwrite($fp, "Content-type: text/plain; charset=US-ASCII\n");
				fwrite($fp, "Content-transfer-encoding: 7BIT\n");
				
			} else {
				fwrite($fp, " Content-Type: text/html; charset=US-ASCII\n");
				fwrite($fp, " Content-Transfer-Encoding: quoted-printable\n");
			}
			fwrite($fp, "Content-description: Mail message body\n\n");
		}

		fwrite($fp, $this->body."\r\n");

		if ($attachment) {
			fwrite($fp, "\n\n--Message-Boundary\n");
			fwrite($fp, "Content-type: $attach_type; name=\"$attach_name\"\n");
			fwrite($fp, "Content-Transfer-Encoding: BASE64\n");
			fwrite($fp, "Content-disposition: attachment; filename=\"$attach_name\"\n\n");
			fwrite($fp, "$encoded_attach\n");
			fwrite($fp, "--Message-Boundary--\n");
		}
		fwrite($fp, "\r\n.\r\n");
		
		//fwrite($fp, "SEND FROM:<". $to_email .">\r\n"); // This also might give problems and say it doesn't recognize
		// the command if so just comment out.
		//$reply = fgets($fp, 512);
		//echo "$reply<br>";
		
		fwrite($fp, "RSET\r\n");
		fwrite($fp, "NOOP\r\n");
		fwrite($fp, "QUIT");
		fclose($fp);
	}

	// These 2 functions are used by pop3auth
	function is_ok_pop3 ($cmd = ""){
		//	Return true or false on +OK or -ERR
		if(empty($cmd))					{ return false; }
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
		if ($this->pop3_server == "none"){
		} else {
			$fpop = fsockopen($this->pop3_server, $this->pop3_port); 

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

	
	
	
	
	

}






?>