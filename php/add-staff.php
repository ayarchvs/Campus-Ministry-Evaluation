<?php
// add-staff.php

include "../config/config.php";
include "../access_control.php";
session_start();

// Check if the user is an admin
if (!can_add_staff()) {
    echo json_encode(['status' => 'error', 'message' => 'You do not have permission to add staff members.']);
    exit;
}

if (isset($_POST['staffFirstName'], $_POST['staffLastName'], $_POST['staffType'], $_POST['staffEmail'], $_POST['staffPassword'])) {
    // Retrieve posted data
    $staffFirstName = $_POST['staffFirstName'];
    $staffLastName = $_POST['staffLastName'];
    $staffType = $_POST['staffType'];
    $staffEmail = $_POST['staffEmail'];
    $staffPassword = $_POST['staffPassword'];

    $Name = $staffLastName . ", " . $staffFirstName;  // Concatenate names

    // Hash the password using bcrypt
    $hashedPassword = password_hash($staffPassword, PASSWORD_DEFAULT);

    // Determine if the account is an admin based on the staffType
    $isAdmin = ($staffType === 'Admin') ? 1 : 0;

    // Prepare the SQL statement
    $query = "INSERT INTO staff (S_Name, S_Type, S_Password, S_Email, is_admin) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind parameters
        $fullEmail = $staffEmail . "@adzu.edu.ph";
        $stmt->bind_param("ssssi", $Name, $staffType, $hashedPassword, $fullEmail, $isAdmin);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete data provided.']);
}

$conn->close();
?>