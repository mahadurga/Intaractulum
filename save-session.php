<?php
// Configuration
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "studentalumni";

// Connect to the database
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Read JSON data
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$content = $data['content'];

// Insert session into the database
$query = "INSERT INTO live_sessions (username, content) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $username, $content);
$success = mysqli_stmt_execute($stmt);

// Return success status
echo json_encode(['success' => $success]);

// Close the connection
mysqli_close($conn);
?>
