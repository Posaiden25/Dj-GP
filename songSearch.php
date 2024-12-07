<!DOCTYPE html>
<html>
<head><title>Search for Songs</title><head>
<style>
        /* General page styling */
        body {
            background-color: #787777; (GRAY)
            color: #f0f0f0;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            image:url("https://static1.squarespace.com/static/5df0d26ebbdf986d02a31efe/t/65f78a582b861022932ec9c7/1710721624630/2024.03.05_LittleStreetStudio_MARCH24_Photo-23814_FINALEdit_LR.jpg?format=1500w");
        }
        h1, h3 {
            color: #ff6347; /* Tomato color for headers */
        }
        form {
            background-color: #bf5b49;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
            width: 300px;
            margin: auto;
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
        table, th, td {
            border: 1px solid;
            background-color: #bf5b49;
            padding: 4px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
            margin: auto;
            margin-top: 15px;
        }
        .error {
            color: #ff4500;
            margin-top: 10px;
        }
</style>
<?php
// Database connection setup
$host = 'courses';
$dbname = 'z1930639';
$username = 'z1930639';
$password = '2003Jan31';

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
<body>
<div>
        <form>
                <input type="submit" value="Submit a Song" formaction="./karaokeSignUp.php">
                <input type="submit" value="To the DJ Interface" formaction="./djView.php">
        </form>

        <h1>Search for Songs</h1>

        <form method="POST">
                <label for="search">Enter search terms below:</label>
                <input type="text" name="search" id="search">
                <input type="submit" value="Search">
        </form>
<?php
        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
                // searches the database :)
                $searchString = '%' . $_POST['search'] . '%'; // used to search the database
                $result = $pdo->prepare('SELECT Song.song_id, Song.title, Song.genre, Artist.artist_name, Song.karaoke_file '
                        . 'FROM Song JOIN Artist '
                        . 'ON Song.artist_id = Artist.artist_id '
                        . 'WHERE title LIKE :search '
                        . 'OR genre LIKE :search '
                        . 'OR artist_name LIKE :search ');
                $result->execute(array('search' => $searchString));
                $data = $result->fetchall(PDO::FETCH_ASSOC);
                if (!empty($data))
                {
                        printTable($data); // print what was found
                }
                else
                {
                        echo "<p class='error'>No songs in the database match your search query</p>";
                }
        }

        // prints a table
        function printTable(array &$data)
        {
?>
                <div>
                <table>
                        <tr>
                                <th>ID</th>
                                <th>Song Title</th>
                                <th>Genre</th>
                                <th>Artist</th>
                                <th>File Name</th>
                        </tr>
<?php
                foreach($data as $song) // loops through each song
                {
                        echo "<tr>\n";
                        foreach ($song as $att) // loops through each attribute of the song
                        {
                                echo "<td>$att</td>\n";
                        }
                        echo "</tr>\n";
                }
                echo "</table>\n</div>";
        }
?>
</div>
</body>
</html>

