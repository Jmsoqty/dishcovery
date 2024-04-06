<?php

include 'dbconfig.php';
session_start();

if (isset($_POST['payment']) && isset($_SESSION['email'])) {
    $ewallet_value = $_POST['payment'];
    $email = $_SESSION['email'];

    $update_sql = "UPDATE tbl_users SET ewallet_value = ewallet_value + ? WHERE email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ds", $ewallet_value, $email);

    if ($update_stmt->execute()) {
        $transaction_id = $_POST['transaction_id'];

        $sent_from = "TOP-UP";
        $sent_to = $email;

        $insert_sql = "INSERT INTO tbl_history_of_donations (transaction_id, amount, sent_by, sent_to)
                       VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        // Concatenate the string and variable properly
        $amount_string = "+" . $ewallet_value;
        $insert_stmt->bind_param("ssss", $transaction_id, $amount_string, $sent_from, $sent_to);

        if ($insert_stmt->execute()) {
            echo json_encode(array("message" => "Payment value updated successfully and transaction recorded"));
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Error recording transaction"));
        }
    } else {
        http_response_code(500);
        echo json_encode(array("error" => "Error updating payment value"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("error" => "Invalid request"));
}

?>
