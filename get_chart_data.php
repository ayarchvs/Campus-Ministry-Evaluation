<?php
include "config/config.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$course = isset($_GET['course']) ? $_GET['course'] : '';

$columns = ['L1', 'L2', 'L3', 'L4', 'L5', 'L6'];

function getChartData($conn, $id, $columns, $course = '') {
    $data = [];
    foreach ($columns as $column) {
        $courseFilter = $course ? "AND course = '" . $conn->real_escape_string($course) . "'" : "";
        $query = "
            SELECT 
                COUNT(CASE WHEN $column = 1 THEN 1 END) AS voted_1,
                COUNT(CASE WHEN $column = 2 THEN 1 END) AS voted_2,
                COUNT(CASE WHEN $column = 3 THEN 1 END) AS voted_3,
                COUNT(CASE WHEN $column = 4 THEN 1 END) AS voted_4,
                COUNT(CASE WHEN $column = 5 THEN 1 END) AS voted_5
            FROM new_events 
            WHERE event_id = $id $courseFilter
        ";

        $result = $conn->query($query);

        if ($result) {
            $data[] = $result->fetch_assoc();
        } else {
            $data[] = null;
        }
    }
    return $data;
}

$chartData = getChartData($conn, $id, $columns, $course);
echo json_encode($chartData);