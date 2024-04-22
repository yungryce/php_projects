<?php
session_start();
require_once(__DIR__ . '/../commons/connection.php');
include 'user_functions.php';


ini_set('display_errors', 1);
error_reporting(E_ALL);


$email = $username = "";
$responseMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_SESSION['user_id']) && $_SESSION['login_successful'] === true)
    {
        header("location: /");
        exit;
    } else {
        session_destroy();
    }

    if (!empty(trim($_POST["email"]))) {
        $user_email = htmlspecialchars(trim($_POST['email']));

        try {
            $conn->begin_transaction();

            $check_stmt = $conn->prepare("SELECT email, username FROM users WHERE email = ?");
            if ($check_stmt) {
                $check_stmt->bind_param("s", $user_email);
                $check_stmt->execute();
                $check_stmt->store_result();
                if (!$check_stmt->num_rows > 0) {
                    $check_stmt->close();
                    throw new Exception("as email does not exist.");
                }
                $check_stmt->bind_result($email, $username);
                $check_stmt->fetch();
                $check_stmt->close();
            }

            $activated = 0;
            $verification_code = bin2hex(random_bytes(16));
            $link = 'reset_password';

            $update_stmt = $conn->prepare("UPDATE users SET verification_code = ?, activated = ? WHERE email = ?");
            if ($update_stmt) {
                $update_stmt->bind_param("sis", $verification_code, $activated, $email);
                $update_stmt->execute();

                if ($update_stmt->affected_rows > 0) {
                    if (send_activation_email($email, $verification_code, $username, $link)) {
                        $responseMessage = "Please check your email for verification link";
                    } else {
                        throw new Exception("sending email. Please try again");
                    }
                } else {
                    throw new Exception("with verification. Please try again");
                }
                $update_stmt->close();
            }
            
            $conn->commit();

        } catch (Exception $e) {
            $conn->rollback();
            $responseMessage = "Error occured " . $e->getMessage();
        }
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
    <?php endif; ?>

    <p class="text-center text-white text-xl p-4">Please, enter your email. You would receive a link to reset your password</p>

    <div class="min-w-2/3 md:w-1/2 lg:w-1/3 flex flex-col justify-center bg-slate-200 shadow-md shadow-yellow-600 p-4">

        <form method="post" action="" autocomplete="off">

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600 mb-2">Email:</label>
                <input type="email" id="email" name="email" required class="mt-1 p-2 w-full border border-yellow-200 rounded-md focus:border-blue-500 focus:outline-none">
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Submit</button>

            <p class="text-center mt-4 text-gray-600">Go back to <a href="login.php" class="hover:opacity-75 text-pink-800">Login</a>.</p>
        </form>
    </div>

    <script src="../assets/js/forms.js"></script>
</body>
</html>

