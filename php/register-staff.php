<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../config/config.php");

 //Still finding on how to work on js, this for meanwhile
    $inputFirstName = trim($_POST['inputFirstName']);
    $inputLastName = trim($_POST['inputLastName']);
    $inputEmail = trim($_POST['inputEmail']) . '@adzu.edu.ph';
    $inputPassword = $_POST['inputPassword'];
    $inputPasswordConfirm = $_POST['inputPasswordConfirm'];
    $inputType = $_POST['inputType'];

    //verify passwords match
    if ($inputPassword !== $inputPasswordConfirm) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        exit();
    }

    
    $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

    
    $name = $inputLastName . ', ' . $inputFirstName;
    

 
    $stmt = $conn->prepare("INSERT INTO Staff (S_Name, S_Email, S_Password, S_Type) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Database error during preparation: ' . $conn->error]);
        exit();
    }

    
    $stmt->bind_param("ssss", $name, $inputEmail, $hashedPassword, $inputType);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Account created successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating account: ' . $stmt->error]);
    }

    
    $stmt->close();
    $conn->close();
}
?>
