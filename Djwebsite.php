<!DOCTYPE html>
<html>
<head><title>Karaoke Sign Up</title><head>
<?php
// Database connection setup
$host = 'localhost';
$dbname = 'KaraokeDB';
$username = 'your_username';
$password = 'your_password';

try
{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo 'Connection failed: ' . $e->getMessage();
}
?>
<br><br>
<body>
        <h1>Welcome To Karaoke!</h1>
        <h3>To request a song, fill out the form below</h3>
        <form method="POST">
                <label for="name">Enter your Name: </label>
                <input / type="Text" name="name" id="name">
                <br>
                <label for="email">Enter your Email: </label>
                <input / type="Text" name="email" id="email">
                <br>
                <label for="song">Choose your Song: </label>
                <select name="song" id="song">
                <option value="" disabled selected>Select a Song</option> // dummy option
                <?php
                // gathers all the songs and puts them in a dropdown list
                $result = $pdo->query('SELECT song_id,title,band FROM Song');
                $songs = $result->fetchAll(PDO::FETCH_ASSOC);
                foreach($songs as $song) // loops through each song + band combo
                {
                        // adds each song as an option in the dropdown list
                        // currently shows N/A for every band since none was added in the database
                        echo "<option value=\"" . $song['song_id'] . "\">" . $song['title'] . " by " . $song['band'] . "</option>";
                }
                ?>
                </select>
                <br>
                <label for="priority">Priority queue: </label>
                <input / type="Radio" name="priority" id="priority">
                <br>
                <input / type="Submit">
        </form>
<?php
        // processes the data after submitting
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
                // checks if any of the inputs are invalid
                if ($_POST['name'] == "" || $_POST['email'] == "" || $_POST['song'] == "")
                {
                        echo "Please fill out the form";
                }
                else
                {
                        // checks if the user is being put in the priority queue
                        if ($_POST['priority'] == 'on')
                        {
                                $queue = "PriorityQueue";
                                echo "Entering Priority Queue...<br>";
                        }
                        else
                        {
                                $queue = "Queue";
                                echo "Entering Queue...<br>";
                        }
                }
                // checks if the user already exists
                $result = $pdo->prepare("SELECT user_id IN User WHERE name = :name AND email = :email");
                $result->execute(array('name' => $_POST['name'], 'email' => $_POST['email']));
                $data = $result->fetch();
                if (empty($data)) // user does not yet exist...
                {
                        // ... so we add them!
                        $result = $pdo->prepare("INSERT INTO User(name, email) VALUES (:name, :email) ");
                        $result->execute(array('name' => $_POST['name'], 'email' => $_POST['email']));
                        // TODO: get the new user's ID
                        echo "Welcome new user!";
                }
                else // user does exist
                {

                }
        }
?>

</body>
</html>






