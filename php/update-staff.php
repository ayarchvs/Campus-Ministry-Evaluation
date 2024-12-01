<?php

include "../config/config.php";  // Include DB connection

if (isset($_POST['staffId'], $_POST['staffFirstName'], $_POST['staffLastName'], $_POST['staffType'], $_POST['staffEmail'])) {    
    // Retrieve posted data
    $staffID = $_POST['staffId'];
    $staffFirstName = $_POST['staffFirstName'];
    $staffLastName = $_POST['staffLastName'];
    $staffType = $_POST['staffType'];
    $staffEmail = $_POST['staffEmail'];

    $Name = $staffLastName . ", " . $staffFirstName;  // Concatenate names

    // SQL query to update staff data
    $query = "UPDATE staff SET S_Name = '$Name', S_Type = '$staffType', S_Email = '$staffEmail' WHERE Staff_ID = '$staffID'";

    // if not empty staffPassword, then update query to include password
    if (isset($_POST['staffPassword']) && !empty($_POST['staffPassword'])) {
        $staffPassword = $_POST['staffPassword'];

        // Hash the password using bcrypt
        $hashedPassword = password_hash($staffPassword, PASSWORD_DEFAULT);

        // Add password update to the query
        $query = "UPDATE staff SET S_Name = '$Name', S_Type = '$staffType', S_Password = '$hashedPassword', S_Email = '$staffEmail' WHERE Staff_ID = '$staffID'";
    }

    $result = $conn->query($query);

    if (!$result) {
        // If query fails, return the error message in JSON
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    } else {
        echo json_encode(['status' => 'success']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete data provided.']);
}
?>
