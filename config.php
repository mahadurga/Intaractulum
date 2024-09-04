<?php
session_start(); // Ensure session is started once here

// Database connection settings (can also be moved here if preferred)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentalumni";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
