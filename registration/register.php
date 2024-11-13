<?php
include '../DB/connect.php';

if(isset($_POST['signUp'])){
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($_POST['password']);

    $checkEmail = "SELECT * FROM `user_account` WHERE email = '$email'";

    $result = $conn->query($checkEmail);

    if($result ->num_rows > 0){
        echo "<script>alert('Email already exists!');
            </script>";
    }else{
        $insertQuery = "INSERT INTO user_account(firstName, lastName, email, password) VALUES('$firstName', '$lastName', '$email','$password')";

        if($conn->query($insertQuery)){
            header("location: sign_up_in.php");
        }else{
            echo "Error: ".$conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM `user_account` WHERE email = '$email' and password='$password'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();

        $_SESSION['email'] = $row['email'];
        $_SESSION['user_id'] = $row['id'];
            echo "<script> alert('Successfully logged in);
            </script>";
            header("location: ../home.php");
            exit();
        }else{
            echo "<script>alert('Incorrect password');
             window.location='sign_up_in.php';</script>";          
    }
}
?>