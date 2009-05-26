<?php

class CASUser
{
    function setup()
    {
        //Only setup if we haven't already
        global $PHPCAS_CLIENT;
        if ( !is_object($PHPCAS_CLIENT))
        {
            phpCAS::setDebug();

            //Set up as a proxy, doesn't consume any tickets this way
            if(!isset($_REQUEST['ticket']))
            {
                phpCAS::client(SITE_CAS_VERSION, SITE_CAS_HOSTNAME, SITE_CAS_PORT, SITE_CAS_PATH, SITE_CAS_SESSION);

/*                phpCAS::setPGTStorageFile('xml', '/var/www/campus/dev.intranet.campusforchrist.org/');
                $PHPCAS_CLIENT->setPGT($PHPCAS_CLIENT->getURL());*/
            }
            else
            {
               phpCAS::client(SITE_CAS_VERSION, SITE_CAS_HOSTNAME, SITE_CAS_PORT, SITE_CAS_PATH, SITE_CAS_SESSION);

/*phpCAS::setPGTStorageFile('xml', '/var/www/campus/dev.intranet.campusforchrist.org/');
                $PHPCAS_CLIENT->setPGT($PHPCAS_CLIENT->getURL());*/
            }
            //Not worried about the validity of the SSL cert
            phpCAS::setNoCasServerValidation();
        }
    }
	
    function getLoginInfo($ticket = null)
    {
        CASUser::setup();
        $return = false;
        if(!empty($ticket))
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

    function login_link()
    {
        CASUser::setup();
        return phpCAS::getServerLoginURL();
    }
	
    function isAuthenticated()
    {
        CASUser::setup();
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
		if(!CASUser::isAuthenticated())
		{
			phpCAS::forceAuthentication();
			return false;
		}
		
		return true;
	}

    function checkAuth()
    {
        CASUser::setup();
        return phpCAS::checkAuthentication();
        /*if(CASUser::isAuthenticated())
        {
            return true;
        }
        elseif(empty($_SESSION['CAS']['GatewayCheck']))
        {
            $_SESSION['CAS']['GatewayCheck'] = true;
            phpCAS::forceAuthentication(true);
        }

        unset($_SESSION['CAS']['GatewayCheck']);

        return false;*/
    }
	
	function logout() 
	{
		CASUser::setup();
		
		phpCAS::logout();
	}
}

?>
