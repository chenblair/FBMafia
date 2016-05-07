<?php
$access_token = "EAAH9ZB08zbAwBAPv86uoe8TZBKyMxr8ZANzUlDs9ujKWdIJpHZAktTun7A7UZA8Mqq3b21a9ZA1ZC3Nb5XWzZBfvNw1pgWfyvbNIxlYuhnrQoBLl4NbhWxxwa2N2EwOPqdocyxB0HZBP9Wddfn9JW1rYOQ0dYwNB8ulkJNVcJdZCquOAZDZD";
$verify_token = "my_access_code";
$hub_verify_token = null;

function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
} 

//database calls
/*$dbHost = 'ec2-54-243-243-135.compute-1.amazonaws.com';
$dbUsername = 'd5gei6idamag9h';
$dbPassword = 'y9AcZwkmoyyM6L41Bzk9pebGYD';
$dbName = 'd5gei6idamag9h';
$myPDO = new PDO('pgsql:host='+$dbHost+';dbname='+$dbName, $dbUsername, $dbName);*/
$counter='hi';

# This function reads your DATABASE_URL configuration automatically set by Heroku
# the return value is a string that will work with pg_connect
function pg_connection_string() {
  return "dbname=d270g74n5lg3ni host=ec2-50-16-218-45.compute-1.amazonaws.com port=5432 user=iuyrqoboxxpsri password=KuNsezJCq0rW4MeF2d2AyWKjE8 sslmode=require";
}
 
# Establish db connection
$db = pg_connect(pg_connection_string());
if (!$db) {
    echo "Database connection error.";
    exit;
}
$query= pg_query($db, "SELECT * FROM players;");
$row=pg_fetch_assoc($query);
$counter=$row['userid'];

$input = json_decode(file_get_contents('php://input'), true);
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$message_to_reply = '';
/**
 * Some Basic rules to validate incoming messages
 */
if(preg_match('[start game]', strtolower($message))) {
	$gameID='mafia'.generateRandomString();
	pg_query($db, "INSERT INTO players (userid,gameid,ishost) VALUES ('$sender','$gameID',TRUE);");
	$message_to_reply = $gameID;
} else if (preg_match('[mafia]', strtolower($message))) {
	$query= pg_query($db, "SELECT * FROM players WHERE gameid='$message' AND host=TRUE;");
	if (pg_num_rows($query)<1) {
		$message_to_reply='invalid code!';
	} else {
		$row=pg_fetch_assoc($query);
		$game=$row['gameid'];
		$hoster=$row['userid'];
		pg_query($db, "INSERT INTO players (userid,gameid,ishost) VALUES ('$sender','$game',FALSE);");
		$message_to_reply='You have been successfully added to game '.$game.' hosted by '.$hoster.'!';
	}
} else {
	$message_to_reply = 'Mafia incoming! Stay tuned!';
}
//API Url
$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
//Initiate cURL.
$ch = curl_init($url);
//The JSON data.

$jsonData = '{
	"recipient":{
		"id":"'.$sender.'"
	},
	"message":{
		"text":"'.$message_to_reply.'"
	}
}';
//Encode the array into JSON.
$jsonDataEncoded = $jsonData;
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
//Execute the request
if(!empty($input['entry'][0]['messaging'][0]['message'])){
	$result = curl_exec($ch);
}

