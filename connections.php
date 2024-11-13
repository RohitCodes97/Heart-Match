<?php
session_start();
include "./DB/connect.php";

if(!isset($_SESSION['user_id'])){
    header("location: ./registration/sign_up_in.php");
    exit();
}
$user_id = $_SESSION['user_id'];

if(isset($_SESSION['alert'])){
    echo "<script>alert('".$_SESSION['alert']."')</script>";
    unset($_SESSION['alert']); // clear the alert message after showing it
}

$currentUserId = $_SESSION['user_id'];

// Fetch accepted connections
$query = "SELECT u.id, u.firstName, u.lastName, d.city, d.city, d.state, d.country, d.profile_image FROM profile_requests r JOIN user_account u ON (r.sender_id = u.id OR r.recipient_id = u.id)
JOIN user_details d ON u.id = d.user_id
WHERE (r.sender_id = ? OR r.recipient_id = ?)
AND r.status = 'Accepted'
AND u.id != ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $currentUserId, $currentUserId, $currentUserId);
$stmt ->execute();
$result= $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Connections</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Components/navbarStyle.css">
    <link rel="stylesheet" href="Components/navbarStyle.css">
    <link rel="stylesheet" href="Components/footerStyle.css">
    <style>

@import url('https://fonts.googleapis.com/css2?family=Anton+SC&family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&display=swap');


        *{
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        .main-container{
                max-width: 1200px;
                margin: 8em auto;
                padding: 1.2em;
            }
        
         h1, h2{
            font-family: 'anton sc', 'serif';
            color: #333;
         }   

        .btn{
            background-color: palevioletred;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            padding: 0.5em;
        }

        .btn:hover{
            opacity: 0.5;
        }
             
        .connection-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2em;
            max-width: 1200px;
            margin: 2em 0;
            
        }

        .connection-card {
            border: 1px solid #ddd;
            padding: 1em;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .connection-card img {
            width: 50%;
            height: 50%;
            border-radius: 50%;
        }
    </style>
</head>
<body>
<?php include("./Components/navbar.php"); ?>
    <div class="main-container">
        <h1>Your Matches </h1>
        <?php
        echo "<div class='connection-grid'>";
        if($result->num_rows > 0){
           while($connection = $result->fetch_assoc()){
            echo "
            <div class='connection-card'>
                <img src='uploads/profile_images/".htmlspecialchars($connection['profile_image'])."'alt='profile Image'>
                <h2>".htmlspecialchars($connection['firstName'])." ".htmlspecialchars($connection['lastName'])."</h2>
                <p>City: ". htmlspecialchars($connection['city'])."</p>
                <p>State: ". htmlspecialchars($connection['country']). "</p><br>
                <a class='btn' href='view_profile.php?id=".$connection['id']."'>View Profile</a>
                </div>";
            }
           echo "</div>";
        } else{
            echo "<p>No connections found.</p>";
        }
        ?>
    </div>
</body>
</html>
<?php include('./Components/footer.php');