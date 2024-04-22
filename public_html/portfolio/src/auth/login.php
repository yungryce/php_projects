<?php
session_start();
require_once(__DIR__ . '/../commons/connection.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');


$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_SESSION['user_id']) && $_SESSION['login_successful'] === true)
    {
        header("location: /");
        exit;
    }

    if ((!empty(trim($_POST["email"]))) && (!empty(trim($_POST["password"]))))
    {
        $email = htmlspecialchars(trim($_POST['email']));
        $password = $_POST['password'];

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

                header("refresh: 3, url=/");
                $_SESSION['message'] = "Login successful..";
                $check_user->close();
                exit();
            }
            else
                $_SESSION['message'] = "Account not activated. Please try again.";
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
	<link rel="stylesheet" href="../assets/css/styles.css">
	<title>Login</title>

</head>

<body class="min-h-screen container mx-auto flex flex-col justify-center items-center bg-custom-gradient space-y-8">

    <?php if (isset($_GET['message']) && !empty($_GET['message'])) : ?>
        <div id="responseMessage" class="text-center text-white bg-pink-400 p-4 rounded-md mt-8">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['message']) && !empty($_SESSION['message'])) : ?>
        <div id="responseMessage" class="text-center text-white bg-pink-400 p-4 rounded-md mt-8">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h1 class="text-white text-3xl">Login</h1>

    <div class="min-w-2/3 md:w-1/2 lg:w-1/3 flex flex-col justify-center bg-slate-200 shadow-md shadow-yellow-600 p-4">
        <form class="" method="post" action="" autocomplete="off">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email:</label>
                <input type="email" id="email" name="email" required class="mt-1 p-2 w-full border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Password:</label>
                <input type="password" id="password" name="password" required class="mt-1 p-2 w-full border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Submit</button>

            <p class="text-center mt-4 text-gray-600">Don't have an account? <a href="signup.php" class="hover:opacity-75 text-pink-800">Sign up now</a>.</p>

            <p class="text-center mt-2 text-gray-600"><a href="forgot_password.php" class="hover:opacity-75 text-pink-800">Forgot your password?</a></p>
        </form>
    </div>

    <script src="../assets/js/forms.js"></script>

</body>
</html>

