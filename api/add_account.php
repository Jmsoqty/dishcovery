<?php 
include 'dbconfig.php';
session_start();

$response = array();

if (!empty($_POST['username']) && !empty($_POST['email'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error'] = "Invalid email format";
    } else {
        $sql = "SELECT * FROM tbl_users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            return;
        } else {
            $insert_sql = "INSERT INTO tbl_users (name, username, email, password) VALUES ('$username', '$username', '$email', '')";
            if ($conn->query($insert_sql) === TRUE) {
                $response['success'] = "User registered successfully";
            } else {
                $response['error'] = "Error: " . $insert_sql . "<br>" . $conn->error;
            }
        }
    }
} else {
    $response['error'] = "All fields are required.";
}

$conn->close();

echo json_encode($response);
?>
