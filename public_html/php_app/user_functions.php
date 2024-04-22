<?php

function repopulateField($fieldName)
{
    return isset($_POST[$fieldName]) ? htmlspecialchars(trim($_POST[$fieldName])) : '';
}

function existingUser($conn, $email, $phone)
{
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $email, $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $user_exist = $result->fetch_object();

    if (!empty($user_exist))
    {
        if ($user_exist->email == $email)
        {
            $_SESSION['message'] =  "Email already exist!!!";
            return true;
        }
        elseif ($user_exist->phone == $phone)
        {
            $_SESSION['message'] =  "Phone number already exists!!!";
            return true;
        }
        else
            return false;
    }
    return false;
}

function generate_username($first_name, $last_name)
{
    if ($first_name && $last_name)
        $username = $last_name[0] . $first_name;

        return $username;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function send_activation_email($email, $verification_code, $username)
{
    $verification_code_url = "http://localhost/auth.php?email=$email&code=$verification_code";

    // set email subject & body
    $subject = "Account Verification";
    $message = <<<MESSAGE
            Hi $username,
            Please click the following link to activate your account:
            <a href="$verification_code_url">$verification_code</a>
    MESSAGE;

    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $phpmailer = new PHPMailer(true);

    try {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'ee2183a0166d42';
        $phpmailer->Password = '6af7e14c48bb68';

        // Set email content
        $phpmailer->setFrom('no-reply@email.com', 'Your Name');
        $phpmailer->addAddress($email, $username);
        $phpmailer->Subject = $subject;
        $phpmailer->isHTML(true);
        $phpmailer->Body = $message;

        // Send the message
        $phpmailer->send();

        return true;
    } catch (Exception $e) {
        error_log("Error sending email to $email: " . $phpmailer->ErrorInfo);
        $_SESSION['message'] = "Failed to send activation code";
        return false;
    }
}

function handlePhone($phone)
{
    $numericString = '';

    for ($i = 0; $i < strlen($phone); $i++)
    {
        $char = $phone[$i];
        if (is_numeric($char))
            $numericString .= $char;
    }
    $numericLength = strlen($numericString);

    if ($numericLength >= 10)
    {
        if ($numericString[0] === '0' && $numericLength === 11)
            return $numericString;
        elseif ($numericLength === 10)
            return '0' . $numericString;
        elseif ($numericLength > 11)
        {
            $numericString = substr($numericString, -10);
            return '0' . $numericString;
        }
    }
    return null;
}

function strongPassword($password)
{
    $hasUppercase = false;
    $hasLowercase = false;
    $hasNumber = false;
    $hasSpecialChar = false;

    if (strlen($password) < 8)
    return null;

    for ($i = 0; $i < strlen($password); $i++)
    {
        $char = $password[$i];

        if (ctype_upper($char))
            $hasUppercase = true;
        elseif (ctype_lower($char))
            $hasLowercase = true;
        elseif (ctype_digit($char))
            $hasNumber = true;
        elseif (!ctype_alnum($char))
            $hasSpecialChar = true;
    }

    if ($hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar)
        return $password;
    else
        return null;
}



function isAccountActivated($conn, $email)
{
    $activated = 0;

	$stmt = $conn->prepare("SELECT activated FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
	if ($stmt->fetch())
    	$stmt->bind_result($activated);
    
    $stmt->close();

    // Check if the account is activated
    return $activated == 1;
}


function activateAccount($conn, $email, $verification_code)
{
    $stmt = $conn->prepare("UPDATE users SET activated = 1 WHERE email = ? AND verification_code = ?");
    $stmt->bind_param("ss", $email, $verification_code);

	$result = $stmt->execute();

    $stmt->close();

	return $result;
}