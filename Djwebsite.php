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
                // gathers all the songs and puts them in a dropdown list
                $result = $pdo->query('SELECT song_id,title,band FROM Song');
                $songs = $result->fetchAll(PDO::FETCH_ASSOC);
                foreach($songs as $song) // loops through each song + band combo
                {
                        // this should properly add each song as an option but i couldn't get the database to work on m>
                        // ill try again later if someone doesn't confirm this works
                        echo "<option value=\"" . song[0] . "\">" . song[1] . " by " . song[2] . "</option>";
                }
?>
        </form>
</body>
