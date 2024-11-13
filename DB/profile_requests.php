<?php 
include "./connect.php";

$q1 = "CREATE TABLE profile_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    recipient_id INT NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES user_account(id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES user_account(id) ON DELETE CASCADE
)";
 
 if($conn->query($q1)){
    echo "Table created successfully!";
 }else{
    echo "Error creating table: ". $conn->error;
 }
?>