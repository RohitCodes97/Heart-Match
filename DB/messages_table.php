<?php
include "./connect.php";

$q1 = "CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    recipient_id INT NOT NULL,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES user_account(id),
    FOREIGN KEY (recipient_id) REFERENCES user_account(id)
);
";

if($conn->query($q1)){
    echo "Table created successfully!!!";
}else{
    echo "Error creating the table: ".$conn->error;
}

?>