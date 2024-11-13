<?php
include "./connect.php";

$q1 = "CREATE TABLE user_photos (
    photo_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    photo_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user_account(id) ON DELETE CASCADE
);
";

if($conn->query($q1)){
    echo "Table created successfully!!!";
}else{
    echo "Error creating the table: ".$conn->error;
}
?>