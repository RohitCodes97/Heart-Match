<?php
session_start();
include './DB/connect.php'; 

if(!isset($_SESSION['email'])){
    header("location: ./registration/sign_in_up.php");
    exit();
}

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}


// Fetch user details using a JOIN
$query = "SELECT user_account.firstName, user_account.lastName, user_account.email, user_details.age, user_details.height, user_details.short_description, 
                 user_details.mother_tongue, user_details.religious_details, user_details.professional_details, 
                 user_details.country, user_details.state, user_details.city, user_details.phone, 
                 user_details.profile_image
          FROM user_account user_account
          LEFT JOIN user_details user_details ON user_account.id = user_details.user_id
          WHERE user_account.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Your Profile</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Complete Your Profile</h2>
    <form action="save_profile.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first_name" value="<?php echo htmlspecialchars($user['firstName']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last_name" value="<?php echo htmlspecialchars($user['lastName']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user['age'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label class="required">Gender:</label>
            <div class="radio-group">
                <input type="radio" name="gender" value="Male" <?php echo (!isset($user['gender']) || $user['gender'] === 'Male') ? 'checked' : ''; ?>>Male</input>
                <input type="radio" name="gender" value="Female"  <?php echo (isset($user['gender']) && $user['gender'] === 'Female') ? 'checked' : ''; ?> >Female</input>
            </div>
        </div>


        <div class="form-group">
            <label for="height">Height (in cm)</label>
            <input type="number" step="0.01" id="height" name="height" value="<?php echo htmlspecialchars($user['height'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="short-description">Short Description</label>
            <textarea id="short-description" name="short_description"><?php echo htmlspecialchars($user['short_description'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="mother-tongue">Mother Tongue</label>
            <input type="text" id="mother-tongue" name="mother_tongue" value="<?php echo htmlspecialchars($user['mother_tongue'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="religious-details">Religious Details</label>
            <input type="text" id="religious-details" name="religious_details" value="<?php echo htmlspecialchars($user['religious_details'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="professional-details">Professional Details</label>
            <input type="text" id="professional-details" name="professional_details" value="<?php echo htmlspecialchars($user['professional_details'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($user['country'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="state">State</label>
            <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($user['state'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="image_profile" class="required">Profile Image</label>
            <input type="file" id="image_profile" name="image_profile">
        </div>

        <div class="form-group">
            <label for="user_photos">Upload Additional Photos</label>
            <input type="file" id="user_photos" name="user_photos[]" multiple>
        </div>

        <div class="form-group">
            <button type="submit">Save Profile</button>
        </div>
    </form>
</div>

</body>
</html>
