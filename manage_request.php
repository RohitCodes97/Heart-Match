<?php
session_start();
include './DB/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("location: ./registration/sign_up_in.php");
    exit();
}

//! this file is handling the request status for matches.

if (isset($_POST['request_id']) && isset($_POST['action'])) {
    $requestId = $_POST['request_id'];
    $status = ($_POST['action'] === 'accept') ? 'Accepted' : 'Rejected';

    $query = "UPDATE `profile_requests` SET `status` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $requestId);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Request successfully updated.";
        $_SESSION['alert'] = "You have accepted the request!";
     } else {
        $_SESSION['message'] = "Failed to update request.";
    }

    $stmt->close();
    $conn->close();
    
    header("Location: connections.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Request</title>
    <style>
    
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f6f8;
        }

        /* Message styling */
        .message-box {
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .message-box p {
            font-size: 1.1rem;
            color: #333;
        }

        .message-success {
            color: #4caf50;
        }

        .message-fail {
            color: #e53935;
        }

        /* Button styling */
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="message-box">
    <?php
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $messageClass = strpos($message, 'successfully') !== false ? 'message-success' : 'message-fail';

        echo "<p class=\"$messageClass\">$message</p>";
        unset($_SESSION['message']);
    }
    ?>
    <a href="profile_requests.php" class="back-button">Back to Requests</a>
</div>

</body>
</html>
