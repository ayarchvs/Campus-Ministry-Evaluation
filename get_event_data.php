<?php
include "config/config.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$course = isset($_GET['course']) ? $_GET['course'] : '';

$sql = "SELECT * FROM new_events WHERE Event_ID = ?";
$params = [$id];

if (!empty($course)) {
    $sql .= " AND course = ?";
    $params[] = $course;
}

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>