<?php
include 'dbconfig.php';
session_start();

$email = $_POST['email'];
$response = array();
$topup = "TOP-UP";

$sql = "SELECT *, CONCAT(amount, ' $') AS amount_php FROM tbl_history_of_donations 
        WHERE (sent_by = ?  AND sent_to = ?) OR sent_to = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sss", $topup, $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Format the date
                $row['date_sent'] = date("F d, Y \a\\t g:i a", strtotime($row['date_sent']));
                $response[] = $row;
            }
            $result->close();
            $response['status'] = 'success';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No History found';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error fetching histories: ' . $stmt->error;
    }
    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error preparing statement: ' . $conn->error;
}

$conn->close();
echo json_encode($response);
?>
