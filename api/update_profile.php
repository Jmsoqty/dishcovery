<?php
include 'dbconfig.php';
session_start();

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];
    $fullname = $_POST['fullname'];

    // Check if profile image is uploaded
    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] === 0) {
        $imageData = file_get_contents($_FILES["profile_image"]["tmp_name"]);
    } else {
        $imageData = null;
    }

    if (empty($newUsername) && empty($newPassword) && empty($fullname) && empty($imageData)) {
        $response['success'] = false;
        $response['message'] = "No changes to update!";
    } else {
        $updateSql = "UPDATE tbl_users SET";
        $params = array();

        if (!empty($newUsername)) {
            $updateSql .= " username = ?";
            $params[] = $newUsername;
        }

        if (!empty($newPassword)) {
            $hashedPassword = md5($newPassword);
            $updateSql .= empty($params) ? "" : ",";
            $updateSql .= " password = ?";
            $params[] = $hashedPassword;
        }

        if (!empty($fullname)) {
            $updateSql .= empty($params) ? "" : ",";
            $updateSql .= " name = ?";
            $params[] = $fullname;
        }

        if (!empty($imageData)) {
            $updateSql .= empty($params) ? "" : ",";
            $updateSql .= " prof_pic = ?";
            $params[] = $imageData;
        }

        $updateSql .= " WHERE email = ?";
        $params[] = $email;

        $stmt = $conn->prepare($updateSql);
        if ($stmt) {
            $types = str_repeat("s", count($params));
            $stmt->bind_param($types, ...$params);

            $result = $stmt->execute();

            if ($result) {
                $response['success'] = true;
                $response['message'] = "User details updated successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Failed to update user details!";
            }

            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = "Error preparing statement!";
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method!";
}

echo json_encode($response);
?>
