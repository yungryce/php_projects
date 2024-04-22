<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

use GuzzleHttp\Client;

require_once('getAuthData.php');
require_once('oauth.php');
require_once('vendor/autoload.php');
require_once('commons/connection.php');

header('content-type: application/json');

$check_user = $conn->prepare("SELECT email, phone FROM users WHERE id = ?");
$check_user->bind_param("s", $_SESSION['user_id']);
$check_user->execute();
$result = $check_user->get_result();
$user_exist = $result->fetch_object();

$_SESSION['email'] = $user_exist->email;
$_SESSION['phone'] = $user_exist->phone;

$pan = "6280511000000095";
$expiryDate = "5004";
$cvv = "111";
$pin = "1111";
echo getAuthData(
    $pan,
    $expiryDate,
    $cvv,
    $pin
);


$accessToken = getAccessToken($clientID, $secretKey);
$authData = getAuthData($pan, $expDate, $cvv, $pin, $publicModulus = null, $publicExponent = null);

if (isset($_SESSION['user_id']) && $_SESSION['login_successful'] === true)
{
        function cardPayment($accessToken, $authData)
        {
                $client = new Client();
                $apiUrl = 'https://qa.interswitchng.com/api/v3/purchases';
                
                $headers = [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken,
                    'TerminalID' => '3pbl0001',
                ];

                $body = [
                        'customerId' => $_SESSION['phone'],
                        'amount' => '10000',
                        'transactionRef' => '123456789',
                        'currency' => 'NGN',
                        'authData' => $authData,
                    ];
        }
}

?>

