<?php
include '../config/config.php';
include '../access_control.php';  // Include the access control file
session_start();

require '../phpspreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the user is logged in and Staff_ID is available
    if (!isset($_SESSION['Staff_ID'])) {
        echo "You must be logged in to add an event.";
        exit;
    }

    // Get logged-in Staff_ID from session
    $staff_id = $_SESSION['Staff_ID'];

    // Get and sanitize form data
    $eventType = filter_input(INPUT_POST, 'eventType', FILTER_SANITIZE_STRING);
    $eventStartDate = filter_input(INPUT_POST, 'eventStartDate', FILTER_SANITIZE_STRING);
    $eventEndDate = filter_input(INPUT_POST, 'eventEndDate', FILTER_SANITIZE_STRING);

    // $eventMonth = filter_input(INPUT_POST, 'eventMonth', FILTER_VALIDATE_INT);
    // $eventDay = filter_input(INPUT_POST, 'eventDay', FILTER_VALIDATE_INT);
    // $eventYear = filter_input(INPUT_POST, 'eventYear', FILTER_VALIDATE_INT);
    $eventCourse = filter_input(INPUT_POST, 'eventCourse', FILTER_SANITIZE_STRING);
    $religion = filter_input(INPUT_POST, 'religion', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'eventLocation', FILTER_SANITIZE_STRING);

    // Check if the user has permission to add this event type
    if (!can_manage_event($eventType)) {
        echo "You do not have permission to add this type of event.";
        exit;
    }

    // Handle file upload
    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == 0) {
        $file = $_FILES['excelFile']['tmp_name'];
        $fileType = strtolower(pathinfo($_FILES['excelFile']['name'], PATHINFO_EXTENSION));

        // Determine file processing method based on file type
        if ($fileType == 'xlsx') {
            // Process Excel (XLSX) file
            $reader = new Xlsx();
        } elseif ($fileType == 'csv') {
            // Process CSV file
            $reader = IOFactory::createReader('Csv');
        } else {
            echo "Invalid file type. Only .xlsx and .csv files are allowed.";
            exit;
        }

        $sql = "INSERT INTO event (Staff_ID, E_Type, E_StartDate, E_EndDate, E_Course, E_Religion, E_Location) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssss", $staff_id, $eventType, $eventStartDate, $eventEndDate, $eventCourse, $religion, $location);

        if ($stmt->execute()) {
            echo "success";
            $event_id = $conn->insert_id;

            // Read the file and insert data
            try {
                $spreadsheet = $reader->load($file);
                $worksheet = $spreadsheet->getActiveSheet();
                $worksheet_arr = $worksheet->toArray();
                
                unset($worksheet_arr[0]); // Remove header row

                foreach ($worksheet_arr as $row) {
                    $lastName = $row[2]; 
                    $firstName = $row[3];  
                    $studentID = $row[4]; 
                    $course = $row[6]; 
                    $venue = $row[7]; 
                    $gender = $row[8]; 
                    $L1 = $row[11];
                    $L2 = $row[13];
                    $L3 = $row[15];
                    $L4 = $row[17];
                    $L5 = $row[19];
                    $L6 = $row[21];
                    $C1 = $row[23];
                    $C2 = $row[25];
                    $C3 = $row[27];
                    $C4 = $row[29];
                    $C5 = $row[31];
                    $C6 = $row[33];
                    $C7 = $row[35];
                    $C8 = $row[37];

                    $sql = "INSERT INTO new_events 
                    (
                    lastname,
                    firstname,
                    student_id,
                    course,
                    venue,  
                    gender, 
                    Event_ID,
                    L1, L2, L3, L4, L5, L6,
                    C1, C2, C3, C4, C5, C6, C7, C8
                    ) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param(
                        "ssisssiiiiiiiiiiiiiii", 
                        $lastName, 
                        $firstName,
                        $studentID, 
                        $course, 
                        $venue, 
                        $gender,
                        $event_id,
                        $L1, $L2, $L3, $L4, $L5, $L6,
                        $C1, $C2, $C3, $C4, $C5, $C6, $C7, $C8
                    );
                    $stmt->execute();
                }
            } catch (Exception $e) {
                echo 'Error reading file: ',  $e->getMessage();
                exit;
            }
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "No file uploaded or file upload error.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
