<?php
require 'config.php';

// User authentication system
if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE username = ? AND password = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ss", $username, $password);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $user_data['id'];
  } else {
    echo "<p style='color: red;'>Invalid username or password</p>";
  }
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Store a new note
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title']) && isset($_POST['content'])) {
  $title = $_POST['title'];
  $content = $_POST['content'];

  $query = "INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "iss", $user_id, $title, $content);
  mysqli_stmt_execute($stmt);
}

// Retrieve notes for the user
$query = "SELECT * FROM notes WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-container h3 {

            font-size: 1.8rem;
            margin-bottom: 20px;
            color:  #fa538d;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
            color: #666;
        }

        .form-container input,
        .form-container textarea {
            width: calc(100% - 22px); /* Adjust width to account for padding */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            padding: 10px 20px;
            color: white;
            background: linear-gradient(to right, #ff966d, #fa538d, #89379c);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background 0.3s;
        }

        .form-container button:hover {
            background: linear-gradient(to right, #fa538d, #89379c, #ff966d);
        }

        .form-container p {
            margin-top: 15px;
            text-align: center;
        }

        .form-container a {
            color: #fa538d;
            text-decoration: none;
        }

        .note-list {
            list-style: none;
            padding: 0;
        }

        .note-list li {
            background: #fff;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 5px;
        }

        .note-list h4 {
            margin: 0 0 10px;
        }

        .note-list p {
            margin: 0;
            color: #666;
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
            margin: 0 15px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="student-dashboard.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="form-container">
        <h3>Your Notes</h3>

        <ul class="note-list">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <li>
                    <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    <p>Created at: <?php echo htmlspecialchars($row['created_at']); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>

        <h3>Add a new note</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br><br>
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="5" required></textarea><br><br>
            <button type="submit">Add Note</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the connection
mysqli_close($conn);
?>
