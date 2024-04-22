<?php
session_start();
require_once('commons/connection.php');


if (!isset($_SESSION['user_id']) || $_SESSION['login_successful'] !== true) {
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HOME</title>
</head>
<body>
        Welcome <?php echo htmlspecialchars($_SESSION["username"]); ?>
        <a href="logout.php">Logout</a>
</body>
</html>