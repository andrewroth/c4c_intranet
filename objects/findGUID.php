<?php

# get/post data to a webpage
function webRequest($url, $method, $pvars=null, $header=0)
{
	$curl = curl_init();
	$curl_header = ($method == "get") ? (int)$header : 0;
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
	curl_setopt($curl, CURLOPT_HEADER, $curl_header);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	if ($method == "post")
	{
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($pvars));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
	}
	$response	= curl_exec($curl);
	$error		= curl_error($curl);
	$result		= array('header'		=> '', 
						'body'			=> '', 
						'curl_error'	=> '', 
						'http_code'		=> '',
						'last_url'		=> '');
	if ($error)
	{
		$result['curl_error'] = $error;
		return $result;
	}
	
	$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
	$result['header'] = substr($response, 0, $header_size);
	$result['body'] = substr($response, $header_size);
	$result['http_code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	$result['last_url'] = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
	curl_close($curl);
	return $result;
}


# Find GUID from user email and password
function findUserGUID($email, $password, $url='https://www.mygcx.org/screen/Public/home')
{
	$params = array('service'	=> $url,
					'username'	=> $email,
					'password'	=> $password);
	$p = webRequest('https://signin.mygcx.org/cas/login', 'post', $params);
	
	# capture header and find service ticket
	$h = $p['header'];
	$begin = strpos($h, "ST-");
	if (!$begin) return null;
	$end = strpos(substr($h, $begin), '"');
	$ticket = substr($h, $begin, $end);
	
	# Get service ticket response from CAS
	$wr = webRequest("https://signin.mygcx.org/cas/proxyValidate?service=" . $url . "&ticket=" . $ticket, 'get');
	$str = $wr['header'];
	$begin = strpos($str, "<ssoGuid>");
	$end = strpos(substr($str, $begin + 9), '<');
	$guid = substr($str, $begin + 9, $end);
	
	return $guid;
}

/*
$guid = findUserGUID("","");
echo $guid;
*/

/*

# PHP code goes here
$service = (isset($_REQUEST['service'])) ? $_REQUEST['service'] : 'https://www.mygcx.org/screen/Public/home';
$guid = findUserGUID($_REQUEST['email'], $_REQUEST['password'], $service);


if ($guid)
{
	# redirect user after login
	if (isset($_REQUEST['service'])) header("location: " . $_REQUEST['service']);
	else echo 'my guid is: ' . $guid;
}
else echo 'invalid username or password';
*/

?>