<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Sessions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .session {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .session h4 {
            margin: 0 0 10px;
            color: #333;
        }

        .session p {
            margin: 0 0 10px;
            color: #666;
        }

        .session .date {
            font-size: 0.9rem;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="navbar">
       
        <a href="student-dashboard.php">Back to Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h1>Live Sessions</h1>
        <div id="sessions">
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

            // Retrieve live sessions from the database
            $query = "SELECT * FROM live_sessions"; // Ensure the table name matches your database
            $result = mysqli_query($conn, $query);

            // Display live sessions
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='session'>";
                    echo "<h4>" . htmlspecialchars($row['username']) . "</h4>";
                    echo "<p>" . htmlspecialchars($row['content']) . "</p>";
                    echo "<p class='date'>Created at: " . htmlspecialchars($row['created_at']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No live sessions available.</p>";
            }

            // Close the connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>
