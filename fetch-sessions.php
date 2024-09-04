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

// Fetch live sessions from the database
$query = "SELECT * FROM live_sessions"; // Adjust table name if needed
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="session">';
        echo '<h4>' . htmlspecialchars($row['title']) . '</h4>';
        echo '<p>' . htmlspecialchars($row['content']) . '</p>';
        echo '<p class="date">Created at: ' . htmlspecialchars($row['created_at']) . '</p>';
        echo '</div>';
    }
} else {
    echo '<p>No live sessions available.</p>';
}

// Close the connection
mysqli_close($conn);
?>
