<?php
include("config/config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT Staff_ID, S_Password, S_Name, S_Type, is_admin FROM `staff` WHERE `S_Email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['S_Password'])) {
                $_SESSION['Staff_ID'] = $user['Staff_ID'];
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $user['S_Name'];
                $_SESSION['is_admin'] = $user['is_admin'];
                $_SESSION['event_type'] = $user['S_Type'];

                header("Location: main-page.php");
                exit;
            } else {
                $_SESSION['login_error'] = "Invalid password";
            }
        } else {
            $_SESSION['login_error'] = "Account not found";
        }

        $stmt->close();
    } else {
        $_SESSION['login_error'] = "Both email and password are required.";
    }

    $_SESSION['login_email'] = $email;
    header("Location: index.php");
    exit;
}

mysqli_close($conn);
?>