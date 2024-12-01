<?php
// delete-staff.php

include "../config/config.php";  // Include your DB connection

// Check if ID is provided via GET
if (isset($_GET['id'])) {
    $staffId = $_GET['id'];

    // Check if the staff member is associated with any events
    $checkEventQuery = "SELECT COUNT(*) AS count FROM event WHERE Staff_ID = '$staffId'";
    $result = $conn->query($checkEventQuery);
    $data = $result->fetch_assoc();

    // If there are events associated with the staff member
    if ($data['count'] > 0) {
        // Respond with an error message
        echo json_encode(['status' => 'error', 'message' => 'This staff member is assigned to an event and cannot be deleted.']);
        exit;  // Stop the script execution
    }

    // SQL query to delete the staff from the database
    $query = "DELETE FROM staff WHERE Staff_ID = '$staffId'";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Respond with success
        echo json_encode(['status' => 'success', 'message' => 'Staff deleted successfully.']);
    } else {
        // Respond with an error if deletion fails
        echo json_encode(['status' => 'error', 'message' => 'Error deleting Staff: ' . $conn->error]);
    }
} else {
    // If no ID is provided
    echo json_encode(['status' => 'error', 'message' => 'No ID provided.']);
}
?>