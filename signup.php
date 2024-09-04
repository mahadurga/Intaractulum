<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "studentalumni");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Retrieve and sanitize POST data
$firstname = sanitize_input($_POST['firstname']);
$lastname = sanitize_input($_POST['lastname']);
$email = sanitize_input($_POST['email']);
$password = sanitize_input($_POST['password']);
$confirm_password = sanitize_input($_POST['confirm_password']);
$role = sanitize_input($_POST['role']);

// Check if passwords match
if ($password !== $confirm_password) {
    echo "Passwords do not match!";
    exit();
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL statements based on role
if ($role == 'student') {
    $table = 'studentsignup';
    $stmt = $mysqli->prepare("INSERT INTO $table (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $password_hash);
} elseif ($role == 'alumni') {
    $table = 'alumnisignup';
    $stmt = $mysqli->prepare("INSERT INTO $table (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $password_hash);
}

// Execute the statement
if ($stmt->execute()) {
    // Redirect based on role
    if ($role == 'student') {
        header("Location: student_details.html");
    } elseif ($role == 'alumni') {
        header("Location: alumni_details.html");
    }
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
?>
