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

// Retrieve form data
$graduationYear = $_POST['graduation_year'];
$fieldOfStudy = $_POST['field_of_study'];
$currentPosition = $_POST['current_position'];
$yearOfExperience = $_POST['yearOfExperience'];
$jobRole = $_POST['jobRole'];

// Validate user input data
$graduationYear = filter_var($graduationYear, FILTER_SANITIZE_STRING);
$fieldOfStudy = filter_var($fieldOfStudy, FILTER_SANITIZE_STRING);
$currentPosition = filter_var($currentPosition, FILTER_SANITIZE_STRING);
$yearOfExperience = filter_var($yearOfExperience, FILTER_SANITIZE_NUMBER_INT);
$jobRole = filter_var($jobRole, FILTER_SANITIZE_STRING);

// Prepare SQL query
$stmt = $conn->prepare("INSERT INTO alumni_details (graduation_year, field_of_study, current_position, year_of_experience, job_role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $graduationYear, $fieldOfStudy, $currentPosition, $yearOfExperience, $jobRole);

try {
    // Execute query
    if ($stmt->execute()) {
        // Redirect to alumni dashboard
        header('Location: alumni-dashboard.html');
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