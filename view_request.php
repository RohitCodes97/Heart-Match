<?php
session_start();
include './DB/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("location: ./registration/sign_up_in.php");
    exit();
}

$currentUserId = $_SESSION['user_id'];

// Fetch Incoming Requests for the Logged-in User
$requestQuery = "SELECT pr.id AS request_id, ua.firstName, ua.lastName, pr.status
                 FROM profile_requests pr
                 JOIN user_account ua ON pr.sender_id = ua.id
                 WHERE pr.recipient_id = ?";
$stmt = $conn->prepare($requestQuery);
$stmt->bind_param("i", $currentUserId);
$stmt->execute();
$requests = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incoming Requests</title>
    <style>
          @import url('https://fonts.googleapis.com/css2?family=Anton+SC&family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&display=swap');
          
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-weight: 600;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

      
        h2 {
            color: #333;
            margin-bottom: 20px;
            font-family: 'anton sc', 'serif';
        }


        .request {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .request p {
            margin: 5px 0;
            color: #666;
        }

        /* Button styling */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            
        }

 
        button:hover {
            opacity: 0.8;
        }

    
        button[name="action"][value="reject"] {
            background-color: #e74c3c;
        }


        button[name="action"][value="reject"]:hover {
            opacity: 0.8;
        }

        p.no-requests {
            color: #888;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Incoming Requests</h2>
        <?php
        if ($requests->num_rows > 0) {
            while ($request = $requests->fetch_assoc()) {
                echo '<div class="request">';
                echo '<p>Request from: ' . htmlspecialchars($request['firstName']) . ' ' . htmlspecialchars($request['lastName']) . '</p>';
                echo '<p>Status: ' . htmlspecialchars($request['status']) . '</p>';

                if ($request['status'] === 'Pending') {
                    echo '<form method="POST" action="manage_request.php">';
                    echo '<input type="hidden" name="request_id" value="' . $request['request_id'] . '">';
                    echo '<button type="submit" name="action" value="accept">Accept</button>';
                    echo '<button type="submit" name="action" value="reject">Reject</button>';
                    echo '</form>';
                }

                echo '</div>';
            }
        } else {
            echo '<p class="no-requests">No incoming requests.</p>';
        }
        ?>
    </div>
</body>
</html>
