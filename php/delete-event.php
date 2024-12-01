<?php
// delete-event.php

include "../config/config.php";  // Include your DB connection

// Check if ID is provided via GET
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Delete from new_events table
        $queryDeleteNewEvents = "DELETE FROM new_events WHERE Event_ID = '$eventId'";
        if (!$conn->query($queryDeleteNewEvents)) {
            throw new Exception('Error deleting from new_events: ' . $conn->error);
        }

        // Delete from event table
        $queryDeleteEvent = "DELETE FROM event WHERE Event_ID = '$eventId'";
        if (!$conn->query($queryDeleteEvent)) {
            throw new Exception('Error deleting from event: ' . $conn->error);
        }

        // Commit transaction
        $conn->commit();

        // Respond with success
        echo json_encode(['status' => 'success', 'message' => 'Event and related data deleted successfully.']);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();

        // Respond with an error
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    // If no ID is provided
    echo json_encode(['status' => 'error', 'message' => 'No ID provided.']);
}
?>
