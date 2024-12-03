<!DOCTYPE html>
<html>
<head><title>Karaoke Sign Up</title><head>
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
}
?>
<br><br>
<body>
        <form method="POST">
                <label for="username">Enter your Name: </label>
                <input / type="Text" name="username" id="username">
                <br>
                <label for="email">Enter your Email: </label>
                <input / type="Text" name="email" id="email">
                <br>
                <label for="song">Choose your Song: </label>
<?php

?>
        </form>
</body>
