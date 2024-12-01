<?php
// fetch_staff_details.php

include "../config/config.php";  // Include your DB connection

// Check if ID is set
if (isset($_GET['id'])) {
    $staffID = $_GET['id'];

    // Your database query logic here
    $query = "SELECT * FROM staff WHERE Staff_ID = '$staffID'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $staffData = $result->fetch_assoc();

        // Send back a JSON response
        echo json_encode([
            'status' => 'success',
            'staffData' => $staffData
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Staff not found.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No ID provided.'
    ]);
}

?>
