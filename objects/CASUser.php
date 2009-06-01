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

            phpCAS::proxy(SITE_CAS_VERSION, SITE_CAS_HOSTNAME, SITE_CAS_PORT, SITE_CAS_PATH, SITE_CAS_SESSION);

            //No SSL
            phpCAS::setNoCasServerValidation();

            phpCAS::setPGTStorageFile('xml',session_save_path());
        }
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
        CASUser::setup();
        return phpCAS::checkAuthentication();
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
      phpCAS::setFixedCallbackURL('http://dev.intranet.campusforchrist.org/index.php');

      $service = 'https://www.mygcx.org/global/module/omnibar/omnibar'; 
      phpCAS::serviceWeb($service,$err_code,$output); 
print_r($output);
print("<pre>");
print_r($_SESSION['phpCAS']);
print("</pre>");
flush();
      return "";
      $xml = simplexml_load_string($output);
      $result = $xml->xpath('/reportoutput/reportdata');
      return html_entity_decode($result[0]->asXML());

/*      $gcxConnexionBar = "GCX ConneXion Bar will go here... RM2 isAuth = true";
      $service = 'https://www.mygcx.org/Public/module/omnibar/omnibar'; 
      phpCAS::serviceWeb($service,$err_code,$output); 
      preg_match('/<reportdata>(.*)<\\/reportdata>/', $output, $matches); 
      $gcxConnexionBar = $matches[1]; 

  flush();
  if ( phpCAS::serviceWeb($cnxbar,$err_code,$output) ) {
    $xml = simplexml_load_string($output);
    $result = $xml->xpath('/reportoutput/reportdata');
    echo html_entity_decode($result[0]->asXML());
  }
  else {
    echo "Error Loading";
  }*/

    }
    else
    {
      return "NOT authenticated";
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
