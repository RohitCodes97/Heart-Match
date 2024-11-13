<?php
echo '<div id="navbar-container" class="navbar">';
echo '<nav>';
echo '<a href="./home.php" class="logo">
    <img src="./Components/images/BrandLogo.png" height="70" width="70">Heart Match</a>';
echo '<ul class="nav-links">';


echo '<li><a href="home.php">Home</a></li>';
// echo '<li><a href="about.php">About</a></li>';
echo '<li><a href="./connections.php">Matches</a></li>';


echo '<li class="search-container">';
echo '<form action="search_view_profiles.php" method="get" class="search-form">
        <input type="text" name="location" id="location" placeholder="Search by location">
        <select name="gender" id="genderFilter">
            <option value="">Gender</option>
            <option value="Male" ' . ((isset($_GET['gender']) && $_GET['gender'] == "Male") ? 'selected' : '') . '>Male</option>
            <option value="Female" ' . ((isset($_GET['gender']) && $_GET['gender'] == "Female") ? 'selected' : '') . '>Female</option>
            <option value="Other" ' . ((isset($_GET['gender']) && $_GET['gender'] == "Other") ? 'selected' : '') . '>Other</option>
        </select>
        <button type="submit">Search</button>
      </form>';
echo '</li>';

// User profile dropdown
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = mysqli_query($conn, "SELECT * FROM `user_account` WHERE email='$email'");

    $query2 = mysqli_query($conn, "SELECT user_id FROM `user_details` WHERE user_id='$user_id'");
    $profile_link_text = (mysqli_num_rows($query2) > 0) ? "Update Profile" : "Complete Your Profile";

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        echo '<li class="dropdown">
                <a href="#" class="user-name">' . htmlspecialchars($row['firstName']) . ' <i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="./complete_profile_details.php">' . htmlspecialchars($profile_link_text) . '</a></li>
                    <li><a href="./myProfileView.php">My Profile</a></li>
                    <li><a href="./view_request.php">View Requests</a></li>
                    <li><a href="./registration/logout.php">Logout</a></li>
                </ul>
              </li>';
    }
} else {
    echo '<li><a href="./registration/sign_up_in.php" class="sign_in">Sign In</a></li>';
}

echo '</ul>';
echo '</nav>';
echo '</div>';
?>
