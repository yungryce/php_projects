<?php
session_start();
require_once('commons/connection.php');
include 'user_functions.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

$first_name = $last_name = $email = $phone = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //Name handler
    if (empty(trim($_POST["first_name"])) || empty(trim($_POST["last_name"])))
        $_SESSION['message'] = "Name is required";
    elseif (strlen(trim($_POST["first_name"])) < 4 || strlen(trim($_POST["last_name"])) < 4)
        $_SESSION['message'] = "Name must be at least 4 characters";
    elseif (strlen(trim($_POST["first_name"])) > 20 || strlen(trim($_POST["last_name"])) > 20)
        $_SESSION['message'] = "Name too long";
    elseif (!ctype_alpha(trim($_POST["first_name"])) || !ctype_alpha(trim($_POST["last_name"])))
        $_SESSION['message'] = "Only letters allowed";
    else
    {
        $first_name = repopulateField('first_name');
        $last_name = repopulateField('last_name');
        $username = generate_username($first_name, $last_name);
    }

    // Email handler
    if (empty(trim($_POST["email"])))
        $_SESSION['message'] = "Email is required";
    elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        $_SESSION['message'] = "Please enter a valid email address";
    else
        $email = repopulateField('email');
    

    //Phone handler
    if (empty(trim($_POST["phone"])))
        $_SESSION['message'] = "Please enter a valid Phone number";
    else 
    {
        $phone = repopulateField('phone');
        $phone = handlePhone($phone);
        if (!$phone)
            $_SESSION['message'] = "Invalid phone format";
    }


    //Password handler
    if (empty(trim($_POST["password"])))
        $_SESSION['message'] = "Password is required";
    elseif (empty(trim($_POST["repeat_password"])))
        $_SESSION['message'] = "Both Passwords is required";
    elseif ($_POST["password"] !== $_POST["repeat_password"])
            $_SESSION['message'] = "Passwords do not match";
    else
    {
        $password = repopulateField('password');
        $password = strongPassword($password);
        if (!$password)
            $_SESSION['message'] = "Password must include atleast one Uppercase, Lowercase, Number and a Special character";
        else
            $password = password_hash($password, PASSWORD_BCRYPT);
    }

}


// database Insertion
if ($first_name && $last_name && $email && $phone && $password && !(existingUser($conn, $email, $phone)))
{
    //Generate verification code
    $verification_code = bin2hex(random_bytes(16));
    $conn->begin_transaction();

    //Insert user into database
    try 
    {
        $activated = 0;
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, phone, password, verification_code, activated) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssi", $first_name, $last_name, $username, $email, $phone, $password, $verification_code, $activated);

        $email_sent = send_activation_email($email, $verification_code, $username);

        if (!$email_sent)
            throw new Exception("Failed to send activation email");
 
        $stmt->execute();
        $conn->commit();
        header("refresh: 5, url=auth.php");
        $_SESSION['message'] =  "Please check your email to activate your account";
        exit;
    }
    catch (Exception $e) 
    {
        // Handle any exceptions that may occur during the transaction
        $conn->rollback();
        header("Location: login.php");
        $_SESSION['message'] = "Email Exception: " . $e->getMessage();
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/main.css">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
    <title>Register</title>
</head>

<body class="min-h-screen flex justify-center items-baseline mx-auto mt-16 bg-custom-gradient">
    <div class="flex flex-col justify-center w-1/3 bg-slate-200 shadow-2xl p-4">

        <h1 class="text-center text-pink-700 text-3xl p-4">Signup</h1>

        <form class="flex flex-col space-y-6" method="post" action="">

            <label class="flex justify-center">
                <i class="fa fa-user text-2xl rounded-l-lg p-3 bg-my-purple text-white" aria-hidden="true"></i>
                <input type="text" name="first_name" placeholder="First Name" value="<?php echo repopulateField('first_name'); ?>" required class="border-2 border-blue-200 rounded-r-lg px-4 py-2"/>
            </label>

            <label class="flex justify-center">
                <i class="fa fa-user text-2xl rounded-l-lg p-3 bg-my-purple text-white" aria-hidden="true"></i>
                <input type="text" name="last_name" placeholder="Last Name" value="<?php echo repopulateField('last_name'); ?>" required class="border-2 border-blue-200 rounded-r-lg px-4 py-2"/>
            </label>

            <label class="flex justify-center">
                <i class="fa fa-envelope text-2xl rounded-l-lg p-3 bg-my-purple text-white" aria-hidden="true"></i>
                <input type="email" name="email" placeholder="Email" value="<?php echo repopulateField('email'); ?>" required class="border-2 border-blue-200 rounded-r-lg px-4 py-2"/>
            </label>

            <label class="flex justify-center">
                <i class="fa fa-phone text-2xl rounded-l-lg p-3 bg-my-purple text-white" aria-hidden="true"></i>
                <input type="tel" name="phone" placeholder="Phone" value="<?php echo repopulateField('phone'); ?>" required class="border-2 rounded-r-lg border-blue-200 px-4 py-2"/>
            </label>

            <label class="flex justify-center">
                <i class="fa fa-lock text-2xl rounded-l-lg p-3 bg-my-purple text-white" aria-hidden="true"></i>
                <input type="password" name="password" placeholder="Password" required class="border-2 rounded-r-lg border-blue-200 px-4 py-2"/>
            </label>

            <label class="flex justify-center">
                <i class="fa fa-lock text-2xl rounded-l-lg p-3 bg-my-purple text-white" aria-hidden="true"></i>
                <input type="password" name="repeat_password" placeholder="Repeat Password" required class="border-2 rounded-r-lg border-blue-200 px-4 py-2"/>
            </label>

            <!-- Include the alerts.php file to display alerts -->
            <p> <?php include('alerts.php'); ?> </p>

            <div class="flex justify-center">
                <input style="font-family: FontAwesome" value="&#xf090;" type="submit" class="w-36 bg-purple-900 text-white font-bold py-2 px-4 w-full rounded-lg transition duration-300 hover:bg-pink-500 cursor-pointer">
            </div>
            <p class="text-center mt-4 text-gray-600">Already have an account? <a href="login.php" class="hover:opacity-75 text-pink-800">Login</a>.</p>
        </form>
    </div>

</body>
</html>
