<?php
session_start();
include './DB/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("location: ./registration/sign_in_up.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$height = $_POST['height'];
$short_description = $_POST['short_description'];
$mother_tongue = $_POST['mother_tongue'];
$religious_details = $_POST['religious_details'];
$professional_details = $_POST['professional_details'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$phone = $_POST['phone'];

// Profile image upload logic
if (isset($_FILES['image_profile']) && $_FILES['image_profile']['error'] == 0) {
    $profile_image = basename($_FILES['image_profile']['name']);
    $target_directory = "uploads/profile_images/";
    $target_file = $target_directory . $profile_image;

    // Create directory if it doesn't exist
    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true);
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['image_profile']['tmp_name'], $target_file)) {
        // Save the profile image path to the database
        $query = "UPDATE user_details SET profile_image = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $target_file, $user_id);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error uploading file.";
        exit();
    }
} else {
    // Retrieve existing profile image from the database if available
    $query = "SELECT profile_image FROM user_details WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing_user = $result->fetch_assoc();
    $profile_image = $existing_user['profile_image'] ?? ''; // Default to an empty string if no image exists
    $stmt->close();
}

// Additional photos upload
if (isset($_FILES['user_photos']) && !empty($_FILES['user_photos']['name'][0])) {
    $target_directory = "uploads/user_photos/";
    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true);
    }

    foreach ($_FILES['user_photos']['name'] as $key => $photoName) {
        $targetFilePath = $target_directory . basename($photoName);
        
        // Check for upload errors
        if ($_FILES['user_photos']['error'][$key] !== UPLOAD_ERR_OK) {
            echo "Error uploading photo: " . htmlspecialchars($photoName) . " - Error code: " . $_FILES['user_photos']['error'][$key];
            continue;
        }
        
        if (move_uploaded_file($_FILES['user_photos']['tmp_name'][$key], $targetFilePath)) {
            // Insert each photo into the user_photos table
            $photoQuery = "INSERT INTO user_photos (user_id, photo_path) VALUES (?, ?)";
            $photoStmt = $conn->prepare($photoQuery);
            $photoStmt->bind_param("is", $user_id, $targetFilePath);

            if (!$photoStmt->execute()) {
                echo "Error inserting photo to database: " . $photoStmt->error;
            }

            $photoStmt->close();
        } else {
            echo "Error moving photo to target directory: " . htmlspecialchars($photoName);
        }
    }
} else {
    echo "No files uploaded or file selection empty.";
}

// Check if user details already exist
$query = "SELECT user_id FROM user_details WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing record
    $query = "UPDATE user_details SET age = ?, gender = ?, height = ?, short_description = ?, mother_tongue = ?, 
              religious_details = ?, professional_details = ?, country = ?, state = ?, city = ?, phone = ?, profile_image = ?
              WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isdsssssssssi", $age, $gender, $height, $short_description, $mother_tongue, $religious_details, 
    $professional_details, $country, $state, $city, $phone, $profile_image, $user_id);
} else {
    // Insert new record
    $query = "INSERT INTO user_details (user_id, age, gender, height, short_description, mother_tongue, 
    religious_details, professional_details, country, state, city, phone, profile_image)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisdsssssssss", $user_id, $age, $gender, $height, $short_description, $mother_tongue, $religious_details, 
    $professional_details, $country, $state, $city, $phone, $profile_image);
}

if ($stmt->execute()) {
    echo "<script>alert('Profile updated successfully.');
    window.location.href = 'home.php';
    </script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
