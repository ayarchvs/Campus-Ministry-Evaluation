<?php
include "../config/config.php";  // Include DB connection

if (isset($_POST['eventId'], $_POST['eventYear'], $_POST['eventMonth'], $_POST['eventDay'], $_POST['eventType'], $_POST['religion'], $_POST['location'], $_POST['course'])) {
    $eventId = $_POST['eventId'];
    $year = $_POST['eventYear'];
    $month = $_POST['eventMonth'];
    $day = $_POST['eventDay'];
    $eventType = $_POST['eventType'];
    $religion = $_POST['religion'];
    $location = $_POST['location'];
    $course = $_POST['course'];

    $query = "UPDATE event SET E_Year = '$year', E_Month = '$month', E_Day = '$day', E_Type = '$eventType', E_Religion = '$religion', E_Location = '$location', E_Course = '$course' WHERE Event_ID = '$eventId'";
    $result = $conn->query($query);

    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update event.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete data provided.']);
}
?>