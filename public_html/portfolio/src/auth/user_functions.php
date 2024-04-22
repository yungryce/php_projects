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


function send_activation_email($email, $verification_code, $username, $link)
{
    $verification_code_url = "http://chxgbx.cloud/auth/$link.php?email=$email&code=$verification_code";

    // set email subject & body
    $subject = "Account Verification";
    $message = "
        Hi $username,
        Please click the following link to activate your account:
        <a href=\"$verification_code_url\">$verification_code</a>
    ";
    $headers = "From: juk@chxgbx.cloud\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    try {
        // Send the email using the mail function
        mail($email, $subject, $message, $headers);

        return true;
    } catch (Exception $e) {
        error_log("Error sending email to $email: $e");
        return false;
    }
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
?>