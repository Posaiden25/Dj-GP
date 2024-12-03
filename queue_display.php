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
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

// Free Queue Query
$freeQueueQuery = "
    SELECT q.q_id, u.name AS user_name, s.title AS song_title, a.artist_name, s.karaoke_file, q.timestamp
    FROM Queue q
    JOIN User u ON q.user_id = u.user_id
    JOIN Song s ON q.song_id = s.song_id
    JOIN Artist a ON s.artist_id = a.artist_id
    WHERE q.q_type = 1
    ORDER BY q.timestamp;
";

$freeQueue = $pdo->query($freeQueueQuery)->fetchAll(PDO::FETCH_ASSOC);
