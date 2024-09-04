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
} // <--- Add this closing curly brace

// Retrieve form data
$collegeName = $_POST['collegeName'];
$registerNumber = $_POST['registerNumber'];
$yearOfCollege = $_POST['yearOfCollege'];
$department = $_POST['department'];
$fieldOfStudy = $_POST['fieldOfStudy'];

// Validate user input data
$collegeName = filter_var($collegeName, FILTER_SANITIZE_STRING);
$registerNumber = filter_var($registerNumber, FILTER_SANITIZE_STRING);
$yearOfCollege = filter_var($yearOfCollege, FILTER_SANITIZE_STRING);
$department = filter_var($department, FILTER_SANITIZE_STRING);
$fieldOfStudy = filter_var($fieldOfStudy, FILTER_SANITIZE_STRING);

// Prepare SQL query
$stmt = $conn->prepare("INSERT INTO student_details (college_name, register_number, year_of_college, department, field_of_study) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $collegeName, $registerNumber, $yearOfCollege, $department, $fieldOfStudy);

try {
    // Execute query
    if ($stmt->execute()) {
        // Redirect to student dashboard
        header('Location: student-dashboard.html');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close statement and connection
$stmt->close();
$conn->close();
?>