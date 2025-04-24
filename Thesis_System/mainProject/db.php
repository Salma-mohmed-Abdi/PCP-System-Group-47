<?php
$host = "localhost";
$user = "root"; // corrected variable name from $users to $user
$pass = "123";
$dbname = "pancreatic_cancer";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "";
}

?>

