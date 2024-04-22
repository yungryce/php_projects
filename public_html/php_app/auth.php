<?php
session_start();
require_once('commons/connection.php');
include 'user_functions.php';


$email = filter_var($_GET['email'] ?? null, FILTER_VALIDATE_EMAIL);
$verification_code = $_GET['code'] ?? null;

if ($email && $verification_code)
{
	if (isAccountActivated($conn, $email))
        $_SESSION['message'] = "Account is already activated. You can log in now.";
    else
	{
        if (activateAccount($conn, $email, $verification_code))
            $_SESSION['message'] = "Account activated successfully. You can log in now.";
        else
            $_SESSION['message'] = "Failed to activate the account. Please try again.";
    }
    header("location: login.php");
    exit;
}
else
{
	$_SESSION['message'] = "Invalid activation link";
	header("location: login.php");
    exit;
}

?>
