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

     // Check if the staff being updated is an admin
     $checkAdminQuery = "SELECT is_admin FROM staff WHERE Staff_ID = ?";
     $checkAdminStmt = $conn->prepare($checkAdminQuery);
     $checkAdminStmt->bind_param("s", $staffID);
     $checkAdminStmt->execute();
     $checkAdminResult = $checkAdminStmt->get_result();
     $isAdmin = $checkAdminResult->fetch_assoc()['is_admin'];
 
     // If the staff is an admin, don't allow changing the type
     if ($isAdmin == 1) {
         $staffType = 'Admin';  // Force the type to remain 'Admin'
     }
 

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
