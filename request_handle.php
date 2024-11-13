<?php
session_start();
include './DB/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("location: ./registration/sign_up_in.php");
    exit();
}

// Check for GET parameters and validate input
if (isset($_GET['action']) && $_GET['action'] === 'send_request' && isset($_GET['recipient_id']) && isset($_GET['sender_id'])) {
    $senderId = intval($_GET['sender_id']);
    $recipientId = intval($_GET['recipient_id']);

    // Check if request already exists to prevent duplicate entries
    $checkQuery = "SELECT * FROM `profile_requests` WHERE `sender_id` = ? AND `recipient_id` = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ii", $senderId, $recipientId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Request already sent.'); 
        window.location='home.php';</script>";
    } else {
        // Insert new request with status 'Pending'
        $insertQuery = "INSERT INTO `profile_requests` (`sender_id`, `recipient_id`, `status`) VALUES (?, ?, 'Pending')";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $senderId, $recipientId);

        if ($insertStmt->execute()) {
            echo "<script>alert('Request sent successfully.');
            // ! choose page carefully 
            window.location='home.php';</script>";
        } else {
            echo "<script>alert('Failed to send request.');
             window.history.back();</script>";
        }

        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); 
    window.history.back();</script>";
    exit();
}
?>
