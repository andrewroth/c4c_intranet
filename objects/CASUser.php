<?php

//Relevant settings.  Declared globally in gen_Defines.php

/*define( 'SITE_CAS_HOSTNAME',"signin.mygcx.org" );
define( 'SITE_CAS_PORT',443 );
define( 'SITE_CAS_PATH','/cas' );
define("SITE_CAS_SESSION", 0);
define("SITE_CAS_VERSION", CAS_VERSION_2_0);
define("SITE_CAS_CONNEXIONBAR_URL", "https://www.mygcx.org/public/module/omnibar/omnibar");
define("SITE_CAS_CALLBACK", "http://dev.intranet.campusforchrist.org/callback.php");
define("SITE_CAS_PGT_STORE", "/var/www/campus/dev.intranet.campusforchrist.org/pgt");*/


class CASUser
{
    function setup()
    {
        //Only setup if we haven't already
        global $PHPCAS_CLIENT;
        if ( !is_object($PHPCAS_CLIENT))
        {
            phpCAS::setDebug("/var/www/campus/dev.intranet.campusforchrist.org/cas.log");

            phpCAS::proxy(SITE_CAS_VERSION, SITE_CAS_HOSTNAME, SITE_CAS_PORT, SITE_CAS_PATH, SITE_CAS_SESSION);

	    phpCAS::setFixedCallbackURL(SITE_CAS_CALLBACK);

            //No SSL
            phpCAS::setNoCasServerValidation();

            phpCAS::setPGTStorageFile('xml', SITE_CAS_PGT_STORE);//session_save_path());

	    return true;
        }
	return false;
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


	
	function forceAuth()
	{
		if(!CASUser::isAuthenticated())
		{
			phpCAS::forceAuthentication();
			return false;
		}
		
		return true;
	}

    // Doesn't force a login, uses gateway auth
    function checkAuth()
    {
        if(CASUser::setup())
	{
	//Allow it to be called multiple times, and return the auth info
	//Normally it will force a login if this isn't done
	        return phpCAS::checkAuthentication();
	}
	else
	{
		return CASUser::isAuthenticated();
	}
    }
	
	function logout() 
	{
		CASUser::setup();
		
		phpCAS::logout();
	}

  function getConnexionBar()
  {
    if ( CASUser::checkAuth() )
    {
      $service = SITE_CAS_CONNEXIONBAR_URL; 
      phpCAS::serviceWeb($service,$err_code,$output); 
      $xml = simplexml_load_string($output);
      $result = $xml->xpath('/reportoutput/reportdata');
      return str_replace("https://signin.mygcx.org/cas/logout", "https://intranet.campusforchrist.org/index.php?p_Mod=Logout", html_entity_decode($result[0]->asXML()));
  }
    else
    {
      return "";
    }
  }



/* Retired Code */

    /* For use with Proxy only */
    /*function getLoginInfo($ticket = null)
    {
        CASUser::setup();
        $return = false;
        if(!empty($ticket))
        {
            // If a ticket was sent to us, use it 
            // Note: This will find a GUID based on a ticket without causing the ticket to expire 
            global $PHPCAS_CLIENT;
            
            // Validate proxy ticket 
            if($PHPCAS_CLIENT->validatePT($lnk, $txt, $tree))
            {
                $return = CASUser::extractInfo($txt);
                $return['ticket'] = $PHPCAS_CLIENT->getPT();
            }
        }

        return $return;
    }*/

  /*function extractInfo($txt)
  {   
    // XML Format
    $ret['guid'] = CASUser::extractInfoFromTag($txt, "ssoGuid");
    $ret['username'] = CASUser::extractInfoFromTag($txt, "cas:user");
    $ret['firstname'] = CASUser::extractInfoFromTag($txt, "firstName");
    $ret['lastname'] = CASUser::extractInfoFromTag($txt, "lastName");
    return $ret;
  }*/
  
  /*function extractInfoFromTag($txt, $tagname)
  {
    $taglen = strlen($tagname) + 2;
    $begin = strpos($txt, "<$tagname>") + $taglen;
    $length = strpos($txt, "</$tagname>") - $begin;
    return substr($txt, $begin, $length);
  }*/

}

?>
