<?php 
session_start();
include "./DB/connect.php";

if(!isset($_SESSION['user_id'])){
    header("location: ./registration/sign_up_in.php");
    exit();
}

// Check if ID is provided
if(isset($_GET['id'])){
    $user_id = $_GET['id'];

    // Fetch user details
    $query = "SELECT u.firstName, u.lastName, d.city, d.state, d.country, d.profile_image, d.age, d.professional_details, d.religious_details, d.mother_tongue, d.height, d.short_description, d.phone, d.gender 
              FROM user_account u 
              JOIN user_details d ON u.id = d.user_id 
              WHERE u.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }

    // Fetch user photos
    $photoQuery = "SELECT photo_path FROM user_photos WHERE user_id = ?";
    $photoStmt = $conn->prepare($photoQuery);
    $photoStmt->bind_param("i", $user_id); // here $user_id is the ID from the user_account
    $photoStmt->execute();
    $photoResult = $photoStmt->get_result();

    $photos = [];
    while($row = $photoResult->fetch_assoc()) {
        $photos[] = $row['photo_path'];
    }
} else {
    echo "No user specified.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile of <?php echo htmlspecialchars($user['firstName'] . " " . $user['lastName']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
    <link rel="stylesheet" href="Components/navbarStyle.css">
    <link rel="stylesheet" href="Components/footerStyle.css">
    <style>
         @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .main-container{
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 8em 1em;
            font-size: 1rem;
        }

        h2{
            font-family: "Inter", -apple-system, BlinkMacSystemFont, sans-serif;
            color: #333;
        }

        .profile-container {
            width: 80%;
            max-width: 1200px;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        .profile-header {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            align-items: center;
        }
        .profile-header img {
            width: 200px;
            height: 250px;
            border-radius: 10px;
            object-fit: cover;
        }
        .profile-info {
            flex-grow: 1;
        }
        .profile-info h2 {
            margin: 0;
            color: #333;
        }
        .profile-info p {
            margin: 5px 0;
            color: #555;
        }
        .profile-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 20px;
        }
        .profile-gallery img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: palevioletred;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            opacity: 0.8;
        }

        /* Modal functionality */
        .thumnail{
            width: 100px;
            height: auto;
            margin: 10px;
            cursor: pointer;
        }

        /* modal background */
        .modal{
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        /* modal content */
        .modal-content{
            margin: auto;
            display: block;
            width: 80%;
            height: auto;
        }

        /* close button */
        .close{
            position: absolute;
            top: 2.5em;
            right: 1em;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus{
            color: #f1f1f1;
            text-decoration: none;
            cursor: pointer;
        }
        

    </style>
</head>
<body>
<?php include("./Components/navbar.php"); ?>
<div class="main-container">
    <div class="profile-container">
        <div class="profile-header">
            <img src="uploads/profile_images/<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" class ='thumbnail'>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($user['firstName'] . " " . $user['lastName']); ?></h2>
                <p><strong><?php echo htmlspecialchars($user['short_description']); ?></strong></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
                <p><strong>Occupation:</strong> <?php echo htmlspecialchars($user['professional_details']); ?></p>
                <p><strong>Religion:</strong> <?php echo htmlspecialchars($user['religious_details']); ?></p>
                <p><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
                <p><strong>State:</strong> <?php echo htmlspecialchars($user['state']); ?></p>
                <p><strong>Country:</strong> <?php echo htmlspecialchars($user['country']); ?></p>
                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            </div>
        </div>
    
        <!-- User Photos Gallery -->
        <h2>Photos</h2>
        <div class="profile-gallery">
            <?php
    
            if (count($photos) > 0) {
                foreach ($photos as $photo) {
                    echo "<img src='".htmlspecialchars($photo)."' alt='User Photo' class ='thumbnail'>";
                }
            } else {
                echo "<p>No photos available.</p>";
            }
            ?>
        </div>
        <!-- Fullscreen Modal -->
        <div id="imageModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>
    
        <a href="connections.php" class="back-button">Back</a>
        <script src="modalScript.js"></script>
    </div>
</div>
<?php include "./Components/footer.php"; ?>
</body>
</html>
<?php    
    $stmt->close();
    $photoStmt->close();
    $conn->close();
    ?>
