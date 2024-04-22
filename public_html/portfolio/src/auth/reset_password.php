<?php
require_once(__DIR__ . '/../commons/connection.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

$responseMessage = '';
$password = $repeat_password = '';


try {
    if (isset($_GET['code'], $_GET['email'])) {
        $reset_token = $_GET['code'];
        $user_email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);

        $check_stmt = $conn->prepare("SELECT email, password, verification_code, activated FROM users WHERE email = ?");
        if (!$check_stmt) {
            throw new Exception("Database error: " . $conn->error);
        }

        $check_stmt->bind_param("s", $user_email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if (!$check_stmt->num_rows > 0) {
            $check_stmt->close();
            throw new Exception("Email does not exist.");
        }

        $check_stmt->bind_result($email, $old_password, $verification_code, $activated);
        $check_stmt->fetch();

        if ($reset_token !== $verification_code) {
            $check_stmt->close();
            throw new Exception("Invalid verification link");
        }

        $check_stmt->close();
    } else {
        throw new Exception("Invalid verification link");
    }
} catch (Exception $e) {
    $responseMessage = $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty(trim($_POST["password"])))
        $responseMessage = "Password is required";
    elseif (empty(trim($_POST["repeat_password"])))
        $responseMessage = "Both Passwords is required";
    elseif ($_POST["password"] !== $_POST["repeat_password"])
        $responseMessage = "Passwords do not match";
    elseif (password_verify($_POST["password"], $old_password))
        $responseMessage = "New password cannot be same with old password";
    else
    {
        $password = strongPassword($_POST["password"]);
        if (!$password)
            $responseMessage = "Password must include atleast one Uppercase, Lowercase, Number and a Special character";
    }
}


if ($password && $reset_token == $verification_code && $activated == 0)
{
    try {
        $activated = 1;
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $update_stmt = $conn->prepare("UPDATE users SET password = ?, activated = ?, verification_code = NULL WHERE email = ? AND verification_code = ?");
        
        if ($update_stmt) {
            $update_stmt->bind_param("siss", $hashed_password, $activated, $email, $verification_code);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                header("refresh: 3, url=login.php?message=" . urlencode("Password reset successfully. Please, log in"));
                exit();
            } else {
                throw new Exception("Error with verification. Please try again");
            }

            $update_stmt->close();
        } else {
            throw new Exception("Error with verification. Please try again");
        }
    } catch (Exception $e) {
        $conn->rollback();
        $responseMessage = $e->getMessage();
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../assets/css/styles.css">
	<title>Password reset</title>

</head>

<body class="min-h-screen container mx-auto flex flex-col items-center bg-custom-gradient space-y-8 mt-24">

    <?php if (isset($responseMessage) && !empty($responseMessage)) : ?>
        <div id="responseMessage" class="text-center text-white bg-pink-400 p-4 rounded-md mt-8">
            <?php echo $responseMessage; ?>
        </div>
        <?php $responseMessage = ''; ?>
    <?php endif; ?>

    <div class="min-w-2/3 md:w-1/2 lg:w-1/3 flex flex-col justify-center bg-slate-200 shadow-md shadow-yellow-600 p-4">

        <form method="post" action="" autocomplete="off">

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600 mb-2">New Password:</label>
                <input type="password" id="password" name="password" required class="mt-1 p-2 w-full border border-yellow-200 rounded-md focus:border-blue-500 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-sm font-medium text-gray-600 mb-2">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required class="mt-1 p-2 w-full border border-yellow-200 rounded-md focus:border-blue-500 focus:outline-none">
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Submit</button>
        </form>
    </div>

    <script src="../assets/js/forms.js"></script>
</body>
</html>