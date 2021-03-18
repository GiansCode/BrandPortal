<?php

$secret = " ";
$address = " ";
$from_address = " ";

if( isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["company"]) && isset($_POST["affiliation"]) && isset($_POST["message"]) && isset($_POST["response"]) ) {
	$data = [
		"secret" => $secret,
		"response" => $_POST["g-recaptcha-response"],
		"remoteip" => $_SERVER["REMOTE_ADDR"]
	];

	$options = [
		"http" => [
			"header" => "Content-type: application/x-www-form-urlencoded\r\n",
			"method" => "POST",
			"content" => http_build_query($data) 
		]
	];

	$result = file_get_contents( "https://www.google.com/recaptcha/api/siteverify", false, stream_context_create($options) );
	
	if(json_decode($result)->success) {
		$subject = $_POST["name"] . " from " . $_POST["company"];
		$message = "Name: " . $_POST["name"] . "\nEmail: " . $_POST["email"] . "\nCompany: " . $_POST["company"] . "\nAffiliation: " . $_POST["affiliation"] . "\nMessage: " . $_POST["message"];
		$headers = "From: " . $from_address;
		
		mail($address, $subject, $message, $headers);
		
		http_response_code(200);
		
		$response = [
			"success" => true,
			"message" => "message sent"
		];
	} else {
		http_response_code(400);
		
		$response = [
			"success" => false,
			"message" => "bad captcha"
		];
	}
} else {
	http_response_code(400);
	
	$response = [
		"success" => false,
		"message" => "missing parameters"
	];
}

die( json_encode($response) );