<?php
include "./connect.php";

$q1 = "CREATE TABLE user_details (
    user_id INT PRIMARY KEY,  -- Matches with the id from user_account
    age INT,
    height DECIMAL(5, 2),
    short_description TEXT,
    mother_tongue VARCHAR(50),
    religious_details VARCHAR(100),
    professional_details VARCHAR(100),
    country VARCHAR(50),
    state VARCHAR(50),
    city VARCHAR(50),
    phone VARCHAR(15),
    FOREIGN KEY (user_id) REFERENCES user_account(id)
);";

// $q2 = "ALTER TABLE `user_details` ADD `profile_image` VARCHAR(255)";

$q3 = "ALTER TABLE `user_details` ADD `gender` ENUM('male', 'female') NOT NULL";

if($conn->query($q3)){
    echo "gender column in `user_details` created successfully"."<br>";
}else{
    echo "Error creating table: ".$conn->error;
}
