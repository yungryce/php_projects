<?php
session_start();
require_once('commons/connection.php');


if (isset($_SESSION['user_id']) && $_SESSION['login_successful'] === true)
{
    header("location: profile.php");
    exit;
}

$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if ((!empty(trim($_POST["email"]))) && (!empty(trim($_POST["password"]))))
    {
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        $check_user = $conn->prepare("SELECT id, username, password, activated FROM users WHERE email = ?");
        $check_user->bind_param("s", $email);
        $check_user->execute();
        $result = $check_user->get_result();
        $user_exist = $result->fetch_object();

        if (!empty($user_exist) && password_verify($password, $user_exist->password))
        {
            if ($user_exist->activated)
            {
                $_SESSION['user_id'] = $user_exist->id;
                $_SESSION['username'] = $user_exist->username;
                $_SESSION['login_successful'] = true;

                header("refresh: 5, url=index.php");
                $_SESSION['message'] = "Login successful..";
                $check_user->close();
                exit();
            }
            else
                $_SESSION['message'] = "Account not activated. Please check your email for activation instructions.";
        }
        else
            $_SESSION['message'] = "Invalid username or password";

        $conn->close();
    }
    else
        $_SESSION['message'] = "Email and Password are required";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="/assets/css/main.css">
	<title>Login</title>
</head>

<body class="min-h-screen flex justify-center items-center mx-auto mt-16 bg-custom-gradient">
    <div class="flex flex-col justify-center w-1/3 bg-slate-200 shadow-2xl p-4">

        <h1 class="text-center text-pink-700 text-3xl p-4">Login</h1>

        <form class="flex flex-col space-y-6" method="post" action="" autocomplete="off">

            <label class="flex justify-center">
                <i class="fa fa-envelope text-2xl rounded-l-lg px-4 py-3 bg-my-purple text-white" aria-hidden="true"></i>
                <input type="email" name="email" placeholder="Email" required class="border-2 border-blue-200 rounded-r-lg px-4 py-2"/>
            </label>

            <label class="flex justify-center">
                <i class="fa fa-phone text-2xl rounded-l-lg px-4 py-3 bg-my-purple text-white" aria-hidden="true"></i>
                <input type="password" name="password" placeholder="Password" required class="border-2 rounded-r-lg border-blue-200 px-4 py-2"/>
            </label>

            <!-- Include the alerts.php file to display alerts -->
            <p> <?php include('alerts.php'); ?> </p>

            <div class="flex justify-center">
                <input style="font-family: FontAwesome" value="&#xf090;" type="submit" class="w-36 bg-purple-900 text-white font-bold py-2 px-4 w-full rounded-lg transition duration-300 hover:bg-pink-500 cursor-pointer">
            </div>
            <p class="text-center mt-4 text-gray-600">Don't have an account? <a href="register.php" class="hover:opacity-75 text-pink-800">Sign up now</a>.</p>
        </form>
    </div>

</body>
</html>

