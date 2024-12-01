<?php
    include("config/config.php"); 
    session_start();

    // confirmation
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Destroy the session
        session_destroy();
        
        header('location:index.php');
        exit();
    } else {
        echo "<script>
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = '?confirm=yes';
            } else {
                window.history.back();
            }
        </script>";
    }
?>
