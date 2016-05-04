<?php

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'my_token_code') {
echo $challenge;
}

$access_token='EAAH9ZB08zbAwBABRz7DxBQmGJOdvdhlOqurYBe3PcFaeCNVJ6ZC6WTZCx6olTkDPW3n192p36heKEriSkYGC58ZAotSBPQDZB0QbLRhnJ0OaIZBjBKn9C1B98jOKP4JHXdJtS53vcgMs4GDO02rQXIWeisNFVk50nxY1WwwIpU0gZDZD';

$url='https://graph.facebook.com/v2.6/me/subscribed_apps?access_token='+access_token;
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
    )
));
$result = file_get_contents($url, false, NULL);
if ($result === FALSE) 
{ 
	die('Error');
}

// Decode the response
$responseData = json_decode($response, TRUE);

// Print the date from the response
echo $responseData;

/*$user_id=10206390442655882;
$url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAH9ZB08zbAwBABRz7DxBQmGJOdvdhlOqurYBe3PcFaeCNVJ6ZC6WTZCx6olTkDPW3n192p36heKEriSkYGC58ZAotSBPQDZB0QbLRhnJ0OaIZBjBKn9C1B98jOKP4JHXdJtS53vcgMs4GDO02rQXIWeisNFVk50nxY1WwwIpU0gZDZD';

// use key 'http' even if you send the request to https://...
$postData = array(
    'recipient' => array('id' => $user_id),
    'message' => array('text' => 'hello, world!')
);
$context = stream_context_create(array(
    'http' => array(
        // http://www.php.net/manual/en/context.http.php
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
));
$result = file_get_contents($url, false, $context);
if ($result === FALSE) 
{ 
	die('Error');
}

// Decode the response
$responseData = json_decode($response, TRUE);

// Print the date from the response
echo $responseData;*/