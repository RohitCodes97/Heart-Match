<?php
session_start();
include './DB/connect.php';
if (!isset($_SESSION['user_id'])) {
    header("location: ./registration/sign_up_in.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$location = isset($_GET['location']) ? $_GET['location'] : '';

$gender = isset($_GET['gender']) ? $_GET['gender'] : '';

$query = "SELECT user_details.*, user_account.id AS accountOwnerId, user_account.firstName, user_account.lastName FROM user_details JOIN user_account ON user_details.user_id = user_account.id WHERE (user_details.city = ? OR user_details.state = ? OR user_details.country = ?)";

//* Modifying the query filter by gender if it's selected
if(!empty($gender)){
    $query .= " AND user_details.gender = ?";
}

$stmt = $conn->prepare($query);

//*Binding the parameters based on location and gender
if(!empty($gender)){
    $stmt->bind_param("ssss", $location, $location, $location, $gender);
}else{
    $stmt->bind_param("sss", $location, $location, $location);
}
 
$stmt->execute();
$result = $stmt->get_result();
?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search and View Profiles</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="Components/navbarStyle.css">
        <link rel="stylesheet" href="Components/footerStyle.css">
        <style>
              @import url('https://fonts.googleapis.com/css2?family=Anton+SC&family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&display=swap');

            *{
                box-sizing: border-box;
                padding: 0;
                margin: 0;
            }

            h2{
            font-family: 'anton sc', 'serif';  
            padding-bottom: 0.8em;   
            color: #333;       
            }

            .btn{
                padding: 0.8em;
                border: none;
                border-radius: 8px;
                margin-top: 1.5em;
                background-color: palevioletred;
                color: #fff;
                text-decoration: none;
            }

            .main-container{
                max-width: 1200px;
                margin: 8em auto;
                padding: 1.2em;
                font-size: 1rem;
            }
        
            .profile-grid { 
                display: grid; 
                grid-template-columns: repeat(3,1fr);
                gap: 2em; 
                max-width: 1200px;
            }

            .profile-card { 
                border: 1px solid #ddd; 
                border-radius: 8px; 
                padding: 1rem; 
                text-align: center;
                 background-color: #f9f9f9; 
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }
            

            .profile-card img { 
                width: 50%; 
                height: 40%; 
                border-radius: 50%;
                object-fit: cover; 
            }


        </style>
    </head>
    <body>
        <?php include("./Components/navbar.php"); ?>
        
    <div class="main-container">
        <?php
            echo "<h2>Search Result:</h2>";
            if ($result->num_rows > 0) {
                echo '<div class="profile-grid">';
                while ($user = $result->fetch_assoc()) {
                    $accountOwnerId = $user['accountOwnerId'];

                    $checkRequestQuery = "SELECT status FROM profile_requests WHERE sender_id = ? AND recipient_id = ?";
                    $checkStmt = $conn->prepare($checkRequestQuery);
                    $checkStmt->bind_param("ii", $user_id, $accountOwnerId);
                    $checkStmt->execute();

                    $checkStmt->store_result();
                    $checkStmt->bind_result($status);
                    $checkStmt->fetch();


                    echo '<div class="profile-card">';
                    echo '<img class="profile_pic" src="uploads/profile_images/' . htmlspecialchars($user['profile_image']) . '" alt="Profile Image">';
                    echo '<h2>' . htmlspecialchars($user['firstName']) . ' ' . htmlspecialchars($user['lastName']) . '</h2>';
                    echo '<p>' . htmlspecialchars($user['short_description']) . '</p>';
                    echo '<p>Age: ' . htmlspecialchars($user['age']) . '</p>';
                    echo '<p>Country: ' . htmlspecialchars($user['country']) . '</p>';
                    echo '<p>City: ' . htmlspecialchars($user['city']) . '</p>';
                    echo '<br>';
    
                    if ($user_id != $accountOwnerId) {
                        if ($checkStmt->num_rows > 0) {
                            // Request exists, display based on status
                            if ($status == 'Accepted') {
                                echo '<button class="btn" disabled>Request Accepted</button>';
                            } elseif ($status == 'Pending') {
                                echo '<button class="btn" disabled>Request Sent</button>';
                            } elseif ($status == 'Rejected') {
                                echo '<a class="btn" href="request_handle.php?recipient_id=' . urlencode($accountOwnerId) . '&sender_id=' . urlencode($user_id) . '&action=send_request">Send Request Again</a>';
                            }
                        } else {
                            // No request exists, show the Send Request button
                            echo '<a class="btn" href="request_handle.php?recipient_id=' . urlencode($accountOwnerId) . '&sender_id=' . urlencode($user_id) . '&action=send_request">Send Request</a>';
                        }
                    }
                    echo '</div>';
                    $checkStmt->close();
                }
                echo '</div>';
            } else {
                echo '<p>No profiles found for this location.</p>';
            }
            $stmt->close();
            $conn->close();
            ?>
    </div>
         <?php include('./Components/footer.php'); ?>
</body>
</html>