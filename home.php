<?php 
session_start();
include "./DB/connect.php";

// if(!isset($_SESSION['email'])){
//     header("location: ./registration/sign_up_in.php");
//     exit();
// }

//* this thing is  for changing text in link for updating and completing profile.
if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];
}

$query = "SELECT user_id FROM `user_details` WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $profile_link_text = "Update profile details";
}else{
    $profile_link_text = "Complete your profile details";
}

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Home Page</title>
    <link rel="stylesheet" href="Components/homePage.css">
    <link rel="stylesheet" href="Components/navbarStyle.css">
    <link rel="stylesheet" href="Components/footerStyle.css">
</head>
<body>
    <?php include("./Components/navbar.php"); ?>
    <div class="main-container">
        <!-- hero section -->
        <main class="main-section">
    <div class="container">
        <!-- Top Banner -->
        <div class="banner">
            <span class="banner-text">
            Welcome to Heart Match
            </span>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h1 class="main-heading">
            Your journey to find meaningful connections starts here.
            </h1>
            <p class="subtext">
            Join a community where love and compatibility come together to help you meet the right match.
            </p>
        </div>
    </div>
</main>

        <!-- Carousel Section -->
        <div class="carousel-wrapper">
            <div class="carousel-container">
                <div class="carousel-track" id="carousel">
                    <div class="carousel-card">
                        <img src="https://images.pexels.com/photos/19376436/pexels-photo-19376436/free-photo-of-bride-and-groom-in-traditional-clothing-standing-on-the-background-of-lights-and-smiling.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="couple shot">
                    </div>
                    <div class="carousel-card">
                        <img src="https://images.pexels.com/photos/1587042/pexels-photo-1587042.jpeg" alt="couple">
                    </div>
                    <div class="carousel-card">
                        <img src="https://images.pexels.com/photos/3352398/pexels-photo-3352398.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Outdoor couple">
                    </div>
                    <div class="carousel-card">
                        <img src="https://images.pexels.com/photos/20015006/pexels-photo-20015006/free-photo-of-woman-and-man-in-traditional-clothing-standing-together.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="marriage picture">
                    </div>
                    <div class="carousel-card">
                        <img src="https://images.pexels.com/photos/3014857/pexels-photo-3014857.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="couple bond">
                    </div>
                    <div class="carousel-card">
                        <img src="https://images.pexels.com/photos/14077142/pexels-photo-14077142.png?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Lifestyle">
                    </div>
                </div>
            </div>
        </div>

    </main>
    
</div>
<div class="btn_start">
<a class="btn_getStarted" href="<?php echo isset($_SESSION['user_id']) ? './complete_profile_details.php' : './registration/sign_up_in.php'; ?>">
        Get Started
</a>
</div>
    <br>

    <!-- How to get started -->
    <div class="get-started-section">
    <h1>How to Get Started</h1>
    <div class="steps">
        <div class="step">
            <i class="fas fa-user-plus step-icon"></i>
            <h2>Step 1. Create an account</h2>
            <p>Sign up with your email to get started on your journey of finding the perfect match.</p>
        </div>


        <div class="step">
            <i class="fas fa-user-edit step-icon"></i>
            <h2>Step 2. Complete your profile</h2>
            <p>Fill out your profile with all the necessary details to increase your visibility.</p>
        </div>


        <div class="step">
            <i class="fas fa-search-location step-icon"></i>
            <h2>Step 3. Search matches by location</h2>
            <p>Find matches nearby or explore connections from other regions.</p>
        </div>


        <div class="step">
            <i class="fas fa-heart step-icon"></i>
            <h2>Step 4. Send Requests</h2>
            <p>Send connection requests to people you are interested in getting to know.</p>
        </div>

        <div class="step">
            <i class="fas fa-users step-icon"></i>
            <h2>Step 5. View Matches & Contact</h2>
            <p>Check your matches, view their profiles, and contact them to learn more.</p>
        </div>
    </div>
</div>

<!-- About Section -->

<div class="about-section">
    <div class="about-content">
        <div class="about-image">
            <img src="https://images.pexels.com/photos/19376436/pexels-photo-19376436/free-photo-of-bride-and-groom-in-traditional-clothing-standing-on-the-background-of-lights-and-smiling.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="About Us Image">
        </div>
        <div class="about-text">
            <h2>About Heart Match</h2>
            <p>Heart Match is dedicated to helping people find meaningful connections in a safe and user-friendly environment. Our platform is designed to bring people together based on compatibility and shared values, ensuring a comfortable experience for everyone involved.</p>
            <p>Our team is committed to creating a trustworthy, engaging, and fun community where you can meet people who are just right for you. Start your journey with us, and let’s help you find that special someone.</p>
            <!-- <a href="about_us.html" class="btn-learn-more">Learn More</a> -->
        </div>
    </div>
</div>

<script src="./Components/homeScript.js"></script>
<?php include('./Components/footer.php'); ?>
    </body>
    </html>
