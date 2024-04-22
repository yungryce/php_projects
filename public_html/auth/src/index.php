<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/styles.css">
        <title>Auth</title>

</head>
<body>
    <header class="bg-blue-500 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex justify-start items-center space-x-2 w-1/6">
                <a href="index.php"><i class="fa-brands fa-squarespace text-white text-4xl"></i></a>
            </div>

            <nav class="flex justify-center space-x-12 w-2/3">
                <a href="#" class="">Home</a>
                <a href="#" class="">ABOUT US</a>
                <a href="#" class="">HELP</a>
                <a href="#" class="">CONTACT</a>
            </nav>

            <ul class="flex space-x-4 justify-end w-1/6">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['login_successful'] === true) : ?>
                    <!-- User is logged in, show logout link -->
                    <li><a href="auth/logout.php">Logout</a></li>
                <?php else : ?>
                    <!-- User is not logged in, show signup and login links -->
                    <li><a href="auth/signup.php">Signup</a></li>
                    <li><a href="auth/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>
    
</body>
</html>