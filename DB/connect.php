<?php
// $c = mysqli_connect("localhost", "root", "");

// $q = "CREATE DATABASE MatrimonyWebsite";
// if(mysqli_query($c, $q)){
//     echo "Database created successfully";
// }else{
//     echo "Not avail to create database!";
// }

$host = "localhost";
$user = "root";
$pass = "";
$db = "MatrimonyWebsite";

$conn = new mysqli($host, $user, $pass, $db) or die("Connection was not established");

?>