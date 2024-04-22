<?php
session_start();
require 'vendor/autoload.php';
require_once('commons/connection.php');


error_reporting(E_ALL);
ini_set('display_errors', '1');

use GuzzleHttp\Client;
header('content-type: application/json');
$clientID = 'IKIA72C65D005F93F30E573EFEAC04FA6DD9E4D344B1';
$secretKey = 'YZMqZezsltpSPNb4+49PGeP7lYkzKn1a5SaVSyzKOiI=';

$check_user = $conn->prepare("SELECT email, phone FROM users WHERE id = ?");
$check_user->bind_param("s", $_SESSION['user_id']);
$check_user->execute();
$result = $check_user->get_result();
$user_exist = $result->fetch_object();

$_SESSION['email'] = $user_exist->email;
$_SESSION['phone'] = $user_exist->phone;

function getAccessToken($clientID, $secretKey)
{
    $client = new Client();
    $apiUrl = 'https://apps.qa.interswitchng.com/passport/oauth/token';

    $credentials = base64_encode("$clientID:$secretKey");

    $headers = [
        'Authorization' => 'Basic ' . $credentials,
        'Content-Type' => 'application/x-www-form-urlencoded',
    ];

    $body = [
        'grant_type' => 'client_credentials',
    ];

    try {
        $response = $client->post($apiUrl, [
            'headers' => $headers,
            'form_params' => $body,
        ]);

        $responseData = $response->getBody()->getContents();
        $decodedResponse = json_decode($responseData, true);

        return $decodedResponse['access_token'] ?? null;

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return null;
    }
}

function getBillers($accessToken)
{
    $client = new Client();
    $apiUrl = 'https://qa.interswitchng.com/quicktellerservice/api/v5/services';
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $accessToken,
        'TerminalID' => '3pbl0001',
    ];

    try {
        $response = $client->get($apiUrl, [
            'headers' => $headers,
        ]);

        $responseData = $response->getBody()->getContents();
        $decodedResponse = json_decode($responseData, true);
        return $decodedResponse;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}

function getBillersByCategory($accessToken, $categoryId)
{
    $client = new Client();
    $apiUrl = "https://qa.interswitchng.com/quicktellerservice/api/v5/services?categoryId=$categoryId";

    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $accessToken,
        'TerminalID' => '3pbl0001',
    ];

    try {
        $response = $client->get($apiUrl, [
            'headers' => $headers,
        ]);

        $responseData = $response->getBody()->getContents();
        $decodedResponse = json_decode($responseData, true);
        return $decodedResponse;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}

function getBillerPaymentItems($accessToken, $billerId)
{
    $client = new Client();
    $apiUrl = "https://qa.interswitchng.com/quicktellerservice/api/v5/services/options?serviceid=$billerId";

    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $accessToken,
        'TerminalID' => '3pbl0001',
    ];

    try {
        $response = $client->get($apiUrl, [
            'headers' => $headers,
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
        'amount' => "1000",
        'paymentCode' => '10801',
        'requestReference' => "122200898163"
    ];

    try {
        $response = $client->post($apiUrl, [
            'headers' => $headers,
            'json' => $body,
        ]);

        $statusCode = $response->getStatusCode();
        $responseData = $response->getBody()->getContents();
        $decodedResponse = json_decode($responseData, true);
        
        echo "Status Code: $statusCode\n";
        return $decodedResponse;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}


$accessToken = getAccessToken($clientID, $secretKey);
$response = getBillers($accessToken);


$matchingBillers = [];
if (isset($response['BillerList']['Category'])) {
    foreach ($response['BillerList']['Category'] as $category) {
        $billers = $category['Billers'];

        foreach ($billers as $biller) {
            if (isset($biller['CategoryId']) && $biller['CategoryId'] == '4') {
                $matchingBillers[] = $biller;
            }
        }
    }
}
//echo json_encode($matchingBillers);
//exit();

$CategoryId = 4;
$responseById = getBillersByCategory($accessToken, $CategoryId);
//echo json_encode($responseById);
//exit();

$billerId = 402;
$billerPay = getBillerPaymentItems($accessToken, $billerId);
//echo json_encode($billerPay);
//exit();

//$customerValidateResponse = customerValidate($accessToken, $phone = null);
//echo json_encode($customerValidateResponse);
//exit();

$billAdviceResponse = billAdvice($accessToken);
echo json_encode($billAdviceResponse);
exit();
?>
