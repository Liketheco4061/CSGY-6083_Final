<?php
//usernames and passwords obfuscated for security purposes 
$host = "localhost";
$dbname = "Its_A_Secret";
$username = "Thats_A_Secret_Too";
$password = "Also_A_Secret";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>