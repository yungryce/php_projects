<?php
require_once('commons/connection.php');
include 'auth/user_functions.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

$responseMessage = '';
$first_name = $last_name = $email = $phone = $message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["first_name"])) || empty(trim($_POST["last_name"])))
        $responseMessage = "Name is required";
    elseif (strlen(trim($_POST["first_name"])) < 3 || strlen(trim($_POST["last_name"])) < 3)
        $responseMessage = "Name must be at least 4 characters";
    elseif (strlen(trim($_POST["first_name"])) > 20 || strlen(trim($_POST["last_name"])) > 20)
        $responseMessage = "Name too long";
    elseif (!ctype_alpha(trim($_POST["first_name"])) || !ctype_alpha(trim($_POST["last_name"])))
        $responseMessage = "Only letters allowed";
    else
    {
        $first_name = repopulateField('first_name');
        $last_name = repopulateField('last_name');
    }

    // Email handler
    if (empty(trim($_POST["email"])))
        $responseMessage = "Email is required";
    elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        $responseMessage = "Please enter a valid email address";
    else
        $email = repopulateField('email');

    if (empty(trim($_POST["phone"])))
        $responseMessage = "Please enter a valid Phone number";
    else 
    {
        $phone = repopulateField('phone');
        $phone = handlePhone($phone);
        if (!$phone)
            $responseMessage = "Invalid phone format";
    }
    

    if (empty(trim($_POST["message"])))
    {
        $responseMessage = "Message is required";
    }
    else
    {
        $message = repopulateField('message');;
    }

    $to = "juk@chxgbx.cloud";
    $subject = "New Contact Form Submission";
    $headers = "From: $email\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    // Email body
    $body = "Name: $first_name $last_name<br>";
    $body .= "Email: $email<br>";
    $body .= "Message: $message";

    if ($first_name && $last_name && $email && $phone && $message)
    {
        if (!mail($to, $subject, $body, $headers))
        {
            $responseMessage = "Error sending the message. Please try again later.";
        }
        else
        {
            $conn->begin_transaction();
            try 
            {
                $stmt = $conn->prepare("INSERT INTO contacts (first_name, last_name, email, phone, message) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $message);
                $stmt->execute();
                $conn->commit();
                $responseMessage = "Thank you for your feedback.";
            }
            catch (Exception $e) 
            {
                // Handle any exceptions that may occur during the transaction
                $conn->rollback();
                $responseMessage = "Error sending the message. Please try again later.";
            }
        }
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
    <title>Contact Form</title>
</head>

<body class="min-h-screen container mx-auto flex flex-col justify-center items-center bg-custom-gradient space-y-8 mb-8">

    <?php include ('menu.php'); ?>

    <?php if (isset($responseMessage) && !empty($responseMessage)) : ?>
        <div id="responseMessage" class="text-center text-white bg-pink-400 p-4 rounded-md mt-8">
            <?php echo htmlspecialchars($responseMessage); ?>
            <?php $responseMessage = ''; ?>
        </div>
    <?php endif; ?>
    <h1 class="text-white text-2xl">Please, get in touch ...</h1>

    <div class="min-w-2/3 md:w-1/2 lg:w-1/3 flex flex-col justify-center bg-slate-200 shadow-2xl p-4">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                <input type="tel" id="phone" name="phone" required value="<?php echo repopulateField('phone'); ?>" class="mt-1 p-2 w-full border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-600">Message:</label>
                <textarea id="message" name="message" rows="4" required class="mt-1 p-2 w-full border rounded-md border-yellow-200 focus:border-blue-500 focus:outline-none"></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Submit</button>
        </form>
    </div>

    <script src="assets/js/menu.js"></script>
    <script src="assets/js/forms.js"></script>
</body>
</html>
