<?php
require_once(__DIR__ . '/../commons/connection.php');
include 'user_functions.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$responseMessage = '';

try {
    if (isset($_GET['code'], $_GET['email'])) {
        $reset_token = $_GET['code'];
        $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);

        $check_stmt = $conn->prepare("SELECT email, verification_code, activated FROM users WHERE email = ?");
        if (!$check_stmt) {
            throw new Exception("Database error: " . $conn->error);
        }

        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if (!$check_stmt->num_rows > 0) {
            $check_stmt->close();
            header("refresh: 3, url=signup.php?message=" . urlencode("Email does not exist"));
            exit;
        }

        $check_stmt->bind_result($email, $verification_code, $activated);
        $check_stmt->fetch();

        if ($reset_token !== $verification_code) {
            $check_stmt->close();
            header("refresh: 3, url=signup.php?message=" . urlencode("Invalid verification link"));
            exit;
        }

        if ($activated == 1 && $verification_code == NULL) {
            $check_stmt->close();
            header("refresh: 3, url=login.php?message=" . urlencode("Account is already activated. Please, log in"));
            exit;
        }

        $check_stmt->close();

    } else {
        throw new Exception("Invalid parameters in the URL");
    }

} catch (Exception $e) {
    header("location: /error.php?message=" . urlencode($e->getMessage()));
    exit;
}


if ($activated == 0 && $reset_token == $verification_code) {
    $activated = 1;
    
    try {
        $conn->begin_transaction();

        $update_stmt = $conn->prepare("UPDATE users SET activated = ?, verification_code = NULL WHERE email = ? AND verification_code = ?");
        if ($update_stmt) {
            $update_stmt->bind_param("iss", $activated, $email, $verification_code);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                $conn->commit();
                header("refresh: 3, url=login.php?message=" . urlencode("Account activated successfully. Please, log in"));
                exit();
            } else {
                throw new Exception("Failed to activate the account. Please try again.");
            }
        } else {
            throw new Exception("Failed to activate the account. Please try again.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        header("refresh: 3, url=/error.php?message=" . urlencode($e->getMessage()));
        exit();
    }
}

?>
