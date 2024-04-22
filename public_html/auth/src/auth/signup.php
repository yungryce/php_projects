<?php
session_start();
require_once(__DIR__ . '/../commons/connection.php');
include 'user_functions.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');


$first_name = $last_name = $email = $phone = $dial_code = $password = "";
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

    //Name handler
    if (empty(trim($_POST["first_name"])) || empty(trim($_POST["last_name"])))
        $responseMessage = "Name is required";
    elseif (strlen(trim($_POST["first_name"])) < 3 || strlen(trim($_POST["last_name"])) < 3)
        $responseMessage = "Name must be at least 3 characters long";
    elseif (strlen(trim($_POST["first_name"])) > 20 || strlen(trim($_POST["last_name"])) > 20)
        $responseMessage = "Name too long";
    elseif (!ctype_alpha(trim($_POST["first_name"])) || !ctype_alpha(trim($_POST["last_name"])))
        $responseMessage = "Only letters allowed";
    else
    {
        $first_name = repopulateField('first_name');
        $last_name = repopulateField('last_name');
        $username = generate_username($first_name, $last_name);
    }

    // Email handler
    if (empty(trim($_POST["email"])))
        $responseMessage = "Email is required";
    elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        $responseMessage = "Please enter a valid email address";
    else
        $email = repopulateField('email');
    

    //Phone handler
    if (empty(trim($_POST["phone"])) || empty(trim($_POST["dial_code"])))
        $responseMessage = "Please enter a valid Phone number";
    else
    {
        $dial_code = htmlspecialchars(trim($_POST["dial_code"]));
        $short_phone = preg_replace('/^0+/', '', htmlspecialchars(trim($_POST["phone"])));
        $phone_join = $dial_code . $short_phone;
        if (strlen($phone_join) > 16 || strlen($phone_join) < 11)
            $responseMessage = "Invalid phone format";
        else
            $phone = preg_replace('/[^0-9]/', '', $phone_join);
    }

    //Password handler
    if (empty(trim($_POST["password"])))
        $responseMessage = "Password is required";
    elseif (empty(trim($_POST["repeat_password"])))
        $responseMessage = "Both Passwords is required";
    elseif ($_POST["password"] !== $_POST["repeat_password"])
        $responseMessage = "Passwords do not match";
    else
    {
        $password = strongPassword($_POST["password"]);
        if (!$password)
            $responseMessage = "Password must include atleast one Uppercase, Lowercase, Number and a Special character";
        else
            $password = password_hash($password, PASSWORD_BCRYPT);
    }

    if (existingUser($conn, $email, $phone))
    {
        $responseMessage = "User already exists";
    }
}


// database Insertion
if ($first_name && $last_name && $email && $phone && $password && (!existingUser($conn, $email, $phone)))
{
    //Generate verification code
    $verification_code = bin2hex(random_bytes(16));
    $conn->begin_transaction();
    $link = 'auth';

    //Insert user into database
    try 
    {
        $activated = 0;
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, phone, password, verification_code, activated) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssi", $first_name, $last_name, $username, $email, $phone, $password, $verification_code, $activated);

        $email_sent = send_activation_email($email, $verification_code, $username, $link);

        if (!$email_sent)
            throw new Exception("Failed to send activation email");
 
        $stmt->execute();
        $conn->commit();
        // header("refresh: 3, url=login.php");
        header("refresh: 3; url=login.php?message=" . urlencode("Please check your email to activate your account"));
        exit;
    }
    catch (Exception $e) 
    {
        // Handle any exceptions that may occur during the transaction
        $conn->rollback();
        $responseMessage = "Email Exception: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
    <title>Signup</title>
</head>

<body class="min-h-screen container mx-auto flex flex-col justify-center items-center bg-custom-gradient space-y-8 my-4 lg:my-8">

    <?php if (isset($_GET['message']) && !empty($_GET['message'])) : ?>
        <div id="responseMessage" class="text-center text-white bg-pink-400 p-4 rounded-md mt-8">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($responseMessage) && !empty($responseMessage)) : ?>
        <div id="responseMessage" class="text-center text-white bg-pink-400 p-4 rounded-md mt-8">
            <?php echo htmlspecialchars($responseMessage); ?>
        </div>
        <?php $responseMessage = ''; ?>
    <?php endif; ?>

    <h1 class="text-white text-3xl">Signup</h1>

    <div class="min-w-2/3 md:w-1/2 lg:w-1/3 flex flex-col justify-center bg-slate-200 shadow-md shadow-yellow-600 p-4 mx-4">
        <form method="post" action="">

            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium text-gray-600">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo repopulateField('first_name'); ?>" required class="mt-1 p-2 w-full border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium text-gray-600">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required value="<?php echo repopulateField('last_name'); ?>" class="mt-1 p-2 w-full border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email:</label>
                <input type="email" id="email" name="email" required value="<?php echo repopulateField('email'); ?>" class="mt-1 p-2 w-full border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-600">Phone:</label>
                <div class="flex justify-between items-center w-full space-x-2">
                    <select id="country_code" name="country_code" class="w-1/3 mt-1 p-2 border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
                        <!-- You can dynamically populate the options using JavaScript -->
                    </select>
                    <input type="hidden" id="dial_code" name="dial_code">
                    <input type="tel" id="phone" name="phone" required class="mt-1 p-2 border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Password:</label>
                <input type="password" id="password" name="password" required class="mt-1 p-2 w-full border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Password:</label>
                <input type="password" id="repeat_password" name="repeat_password" required class="mt-1 p-2 w-full border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Submit</button>

            <p class="text-center mt-4 text-gray-600">Already have an account? <a href="login.php" class="hover:opacity-75 text-pink-800">Login</a>.</p>
        </form>
    </div>

    <script src="../assets/js/forms.js"></script>

</body>
</html>
