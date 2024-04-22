<?php
require 'vendor/autoload.php';


use GuzzleHttp\Client;
function customerValidate($accessToken, $phone = null)
{
    $client = new Client();
    $apiUrl = "https://qa.interswitchng.com/quicktellerservice/api/v5/Transactions/validatecustomers";

    if ($phone === null && isset($_SESSION['phone'])) {
        $phone = $_SESSION['phone'];
    }

    $headers = [
        'Authorization' => 'Bearer ' . $accessToken,
        'Content-Type' => 'application/json',
    ];

    $body = [
        'customers' => [
                'paymentCode' => '10901',
                'customerId' => $phone,
        ],
    ];

    try {
        $response = $client->post($apiUrl, [
            'headers' => $headers,
            'json' => $body,
        ]);

        $responseData = $response->getBody()->getContents();
        $decodedResponse = json_decode($responseData, true);
        return $decodedResponse;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}


function billAdvice($accessToken)
{
    $client = new Client();
    $apiUrl = "https://qa.interswitchng.com/quicktellerservice/api/v5/Transactions";

    $headers = [
        'Authorization' => 'Bearer ' . $accessToken,
        'Content-Type' => 'application/json',
        'TerminalID' => '3pbl0001',
    ];
    $body = [
        'customerId' => '00000000001',
        'customerMobile' => '2348033115478',
        'customerEmail' => 'johndoe@nomail.com',
        'amount' => 146000,
        'paymentCode' => '10801',
        'requestReference' => 1453 . '' . time()
    ];

    try {
        $response = $client->post($apiUrl, [
            'headers' => $headers,
            'json' => $body,
        ]);

        $statusCode = $response->getStatusCode();
        $responseData = $response->getBody()->getContents();
        //echo "Status Code: $statusCode\n";
        //echo "Response Body: $responseData\n";
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}