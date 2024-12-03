<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karaoke Sign Up</title>
</head>
<body>
    <?php
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

    // Fetch songs for the dropdown
    $songsQuery = "SELECT song_id, title FROM Song ORDER BY title ASC";
    $songsStmt = $pdo->query($songsQuery);
    $songs = $songsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $songId = $_POST['song'];
        $queueType = $_POST['queue_type'];

        if (!empty($username) && !empty($email) && !empty($songId) && !empty($queueType)) {
            // Insert user into the database if they don't already exist
            $userQuery = "INSERT INTO User (name, email) VALUES (:name, :email) ON DUPLICATE KEY UPDATE email = :email";
            $userStmt = $pdo->prepare($userQuery);
            $userStmt->execute([':name' => $username, ':email' => $email]);

            // Get the user ID
            $userIdQuery = "SELECT user_id FROM User WHERE email = :email";
            $userIdStmt = $pdo->prepare($userIdQuery);
            $userIdStmt->execute([':email' => $email]);
            $userId = $userIdStmt->fetchColumn();

            // Insert into Queue
            $queueQuery = "INSERT INTO Queue (q_type, user_id, song_id) VALUES (:queue_type, :user_id, :song_id)";
            $queueStmt = $pdo->prepare($queueQuery);
            $queueStmt->execute([
                ':queue_type' => $queueType,
                ':user_id' => $userId,
                ':song_id' => $songId
            ]);

            echo "<p>Successfully signed up for karaoke!</p>";
        } else {
            echo "<p>Please fill in all fields.</p>";
        }
    }
    ?>
 <h1>Karaoke Sign-Up Form</h1>
    <form method="POST" action="">
        <label for="username">Enter your Name: </label>
        <input type="text" name="username" id="username" required>
        <br><br>

        <label for="email">Enter your Email: </label>
        <input type="email" name="email" id="email" required>
        <br><br>

        <label for="song">Choose your Song: </label>
        <select name="song" id="song" required>
            <option value="">--Select a Song--</option>
            <?php foreach ($songs as $song): ?>
                <option value="<?= htmlspecialchars($song['song_id']); ?>"><?= htmlspecialchars($song['title']); ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="queue_type">Queue Type: </label>
        <select name="queue_type" id="queue_type" required>
            <option value="1">Free Queue</option>
            <option value="2">Priority Queue</option>
        </select>
        <br><br>

        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
