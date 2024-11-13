<?php
session_start();
include './DB/connect.php';

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("location: ./registration/sign_in_up.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT user_account.firstName, user_account.lastName, user_account.email, user_details.age, user_details.height, user_details.short_description, 
                 user_details.mother_tongue, user_details.religious_details, user_details.professional_details, 
                 user_details.country, user_details.state, user_details.city, user_details.phone, 
                 user_details.profile_image
          FROM user_account
          LEFT JOIN user_details ON user_account.id = user_details.user_id
          WHERE user_account.id = $user_id";

$result = $conn->query($query);
$user = $result->fetch_assoc();

if (!$user) {
    echo "User profile not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <style>
        .profile-page {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            font-family: Arial, sans-serif;
            color: #444;
        }

        .profile-container {
            width: 90%;
            max-width: 700px;
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-container h2 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 1em;
            color: #333;
        }

        .profile-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .profile-group label {
            font-weight: bold;
            color: #555;
            min-width: 120px;
            text-align: left;
        }

        .profile-group span {
            color: #666;
            max-width: 400px;
            word-wrap: break-word;
        }

        .profile-image-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        .update_btn{
            text-decoration: none;
            background-color: #007bff;
            padding: 1em;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>

<div class="profile-page">
    <div class="profile-container">
        <h2>My Profile</h2>
        <?php if (!empty($user['profile_image'])): ?>
            <div class="profile-image-container">
                <img src="uploads/profile_images/<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" class="profile-image">
            </div>
        <?php endif; ?>
        <div class="profile-group">
            <label>First Name:</label><span><?php echo htmlspecialchars($user['firstName']); ?></span>
        </div>
        <div class="profile-group">
            <label>Last Name:</label><span><?php echo htmlspecialchars($user['lastName']); ?></span>
        </div>
        <div class="profile-group">
            <label>Email:</label><span><?php echo htmlspecialchars($user['email']); ?></span>
        </div>
        <div class="profile-group">
            <label>Age:</label><span><?php echo htmlspecialchars($user['age'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group">
            <label>Height:</label><span><?php echo htmlspecialchars($user['height'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group">
            <label>Short Description:</label><span><?php echo htmlspecialchars($user['short_description'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group">
            <label>Mother Tongue:</label><span><?php echo htmlspecialchars($user['mother_tongue'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group">
            <label>Religion:</label><span><?php echo htmlspecialchars($user['religious_details'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group">
            <label>Profession:</label><span><?php echo htmlspecialchars($user['professional_details'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group">
            <label>Country:</label><span><?php echo htmlspecialchars($user['country'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group">
            <label>State:</label><span><?php echo htmlspecialchars($user['state'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group">
            <label>City:</label><span><?php echo htmlspecialchars($user['city'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group">
            <label>Phone:</label><span><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></span>
        </div>
        <div class="profile-group ">
            <a href="./complete_profile_details.php" class="update_btn">Update Profile</a>
        </div>
        
    </div>
</div>

</body>
</html>
