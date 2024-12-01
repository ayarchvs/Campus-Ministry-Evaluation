<?php
// fetch_event_details.php

include "../config/config.php";  // Include your DB connection

// Check if ID is set
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Your database query logic here
    $query = "SELECT * FROM event WHERE Event_ID = '$eventId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $eventData = $result->fetch_assoc();

        // Send back a JSON response
        echo json_encode([
            'status' => 'success',
            'eventData' => $eventData
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Event not found.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No ID provided.'
    ]);
}

?>
