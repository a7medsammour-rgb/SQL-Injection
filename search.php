<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "security_db");

if ($conn->connect_error) {
    die("Connection failed");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search User</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            width: 400px;
            margin: 100px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px #ccc;
            text-align: center;
        }

        input[type="text"] {
            width: 90%;
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 8px 15px;
            cursor: pointer;
        }

        .result {
            margin-top: 15px;
            text-align: left;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Search User</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Enter username" required>
        <br>
        <input type="submit" name="search" value="Search">
    </form>

    <div class="result">
        <?php
        if (isset($_POST['search'])) {

            $username = $_POST['username'];

            
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p><strong>Username:</strong> " . htmlspecialchars($row['username']) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                }
            } else {
                echo "<p><strong>No user found</strong></p>";
            }

            $stmt->close();
        }

        $conn->close();
        ?>
    </div>
</div>

</body>
</html>
