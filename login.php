<?php
require 'config.php'; // Ensure this file includes database connection setup and session_start()

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $loginType = $_POST['loginType'];// To differentiate between student and alumni login

    if ($loginType == 'alumni') {
        // Check if the user is an alumni
        $stmt = $conn->prepare("SELECT * FROM alumnisignup WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $alumni = $stmt->get_result()->fetch_assoc();

        if ($alumni && password_verify($password, $alumni['password'])) {
            // Set session variables for alumni and redirect to alumni dashboard
            $_SESSION['user_id'] = $alumni['id'];
            $_SESSION['role'] = 'alumni';
            header('Location: alumni-dashboard.php');
            exit();
        } else {
            echo "<script>alert('Error: Invalid email or password for alumni login.'); window.location.href = 'login.php';</script>";
            exit();
        }
    } elseif ($loginType == 'student') {
        // Check if the user is a student
        $stmt = $conn->prepare("SELECT * FROM studentsignup WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $student = $stmt->get_result()->fetch_assoc();

        if ($student && password_verify($password, $student['password'])) {
            // Set session variables for student and redirect to student dashboard
            $_SESSION['user_id'] = $student['id'];
            $_SESSION['role'] = 'student';
            header('Location: student-dashboard.php');
            exit();
        } else {
            echo "<script>alert('Error: Invalid email or password for student login.'); window.location.href = 'login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Error: Invalid login type.'); window.location.href = 'login.php';</script>";
        exit();
    }
}
?>
