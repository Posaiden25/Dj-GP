<?php
// Database connection setup
$host = 'localhost';
$dbname = 'KaraokeDB';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karaoke Sign Up</title>
    <style>
        /* General page styling */
        body {
            background-color: #121212; (GRAY)
            color: #f0f0f0;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }
        h1, h3 {
            color: #ff6347; /* Tomato color for headers */
        }
        form {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
            width: 300px;
        }
        
      label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #333;
            border-radius: 4px;
            background-color: #2b2b2b;
            color: #f0f0f0;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #ff6347;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #ff4500; /* Slightly darker red */
        }

        .error {
            color: #ff4500;
            margin-top: 10px;
        }

        .success {
            color: #32cd32; /* Lime green */
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <div>
        <h1>Welcome To Karaoke!</h1>
        <h3>To request a song, fill out the form below</h3>

        <form method="POST">
            <label for="name">Enter your Name:</label>
            <input type="text" name="name" id="name">

            <label for="email">Enter your Email:</label>
            <input type="text" name="email" id="email">

            <label for="song">Choose your Song:</label>
            <select name="song" id="song">
                <option value="" disabled selected>Select a Song</option>
                <?php
                $result = $pdo->query('SELECT song_id, title, band FROM Song');
                foreach ($result as $song) {
                    echo "<option value=\"" . $song['song_id'] . "\">" . htmlspecialchars($song['title']) . " by " . htmlspecialchars($song['band']) . "</option>";
                }
                ?>
            </select>

            <label for="priority_yes">Priority Queue:</label>
            <input type="radio" name="priority" id="priority_yes" value="on"> Yes
            <input type="radio" name="priority" id="priority_no" value="off" checked> No

            <input type="submit" value="Submit">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['song'])) {
                echo "<p class='error'>Please fill out the form completely.</p>";
            } else {
                try {
                    $queue = ($_POST['priority'] === 'on') ? "PriorityQueue" : "Queue";
                    // Check if user exists
                    $result = $pdo->prepare("SELECT user_id FROM User WHERE name = :name AND email = :email");
                    $result->execute(['name' => $_POST['name'], 'email' => $_POST['email']]);
                    $data = $result->fetch();

                    if (!$data) {
                        // Add user
                        $stmt = $pdo->prepare("INSERT INTO User (name, email) VALUES (:name, :email)");
                        $stmt->execute(['name' => $_POST['name'], 'email' => $_POST['email']]);
                        $result->execute(['name' => $_POST['name'], 'email' => $_POST['email']]);
                        $data = $result->fetch();
                        echo "<p class='success'>Welcome new user!</p>";
                    } else {
                        echo "<p class='success'>Welcome back!</p>";
                    }

                    // Add song to queue
                    $stmt = $pdo->prepare("INSERT INTO $queue (user_id, song_id) VALUES (:user, :song)");
                    $stmt->execute(['user' => $data['user_id'], 'song' => $_POST['song']]);
                    echo "<p class='success'>Successfully added song to queue!</p>";
                } catch (PDOException $e) {
                    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
