<?php

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

if ($message) {
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    echo "$message<br/>";
}
?>
