<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
header('content-type: application/json');
$client = new Client();
$apiUrl = 'https://apidojo-yahoo-finance-v1.p.rapidapi.com/news/v2/list?region=US&snippetCount=28';

//data,main,stream,for each(content(title, clickThroughUrl(url))
$response = $client->request('POST', $apiUrl, [
	'headers' => [
		'body' => '',
		'X-RapidAPI-Host' => 'apidojo-yahoo-finance-v1.p.rapidapi.com',
		'X-RapidAPI-Key' => '9b65e8f469msh160cda53b7fa2e5p171f21jsn67f2d1c36e15',
		'content-type' => 'text/plain',
	],
]);

echo $response->getBody();