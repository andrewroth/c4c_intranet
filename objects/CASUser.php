<?php

class CASUser 
{
	function setup()
	{
phpCAS::setDebug();
		//Set up as a proxy, doesn't consume any tickets this way
		phpCAS::proxy(SITE_CAS_VERSION, SITE_CAS_HOSTNAME, SITE_CAS_PORT, SITE_CAS_PATH, SITE_CAS_SESSION);
		
		//Not worried about the validity of the SSL cert
		phpCAS::setNoCasServerValidation();
	}
	
	function login($ticket = null)
	{
		CASUser::setup();

		if(empty($ticket))
		{
			CASUser::forceAuth();
		}
		else
		{
			/* If a ticket was sent to us, use it */
			/* Note: This will find a GUID based on a ticket without causing the ticket to expire */
			global $PHPCAS_CLIENT;
			
			/* Validate proxy ticket */
			if($PHPCAS_CLIENT->validatePT($lnk, $txt, $tree))
			{
				$return = CASUser::extractInfo($txt);
				$return['ticket'] = $PHPCAS_CLIENT->getPT();
			}
		}
		
		return $return;
	}
	
    function isAuthenticated()
    {
        return phpCAS::isAuthenticated();
    }

	function extractInfo($txt)
	{		
		/* XML Format, */
		$ret['guid'] = CASUser::extractInfoFromTag($txt, "ssoGuid");
		$ret['username'] = CASUser::extractInfoFromTag($txt, "cas:user");
		$ret['firstname'] = CASUser::extractInfoFromTag($txt, "firstName");
		$ret['lastname'] = CASUser::extractInfoFromTag($txt, "lastName");
		return $ret;
	}
	
	function extractInfoFromTag($txt, $tagname)
	{
		$taglen = strlen($tagname) + 2;
		$begin = strpos($txt, "<$tagname>") + $taglen;
		$length = strpos($txt, "</$tagname>") - $begin;
		return substr($txt, $begin, $length);
	}
	
	function forceAuth()
	{
		if(!phpCAS::isAuthenticated())
		{
			phpCAS::forceAuthentication();
			return false;
		}
		
		return true;
	}
	
	function logout() 
	{
		CASUser::setup();
		
		phpCAS::logout();
		exit();
	}
}

?>
