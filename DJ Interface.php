<!DOCTYPE html>
<html>
<head><title>Karaoke Disc Jockey</title><head>
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
<br><br>
<body>
        <h1>Karaoke DJ Interface</h1>
<?php
        // checks if a form was submitted
        if($_SERVER['REQUEST_METHOD'] = "POST")
        {
                echo "<p>";
                // checks if the data exists
                if (!empty($_POST["ID"]) || !empty($_POST["priority"]))
                {
                        // find the table to look through
                        if ($_POST["priority"] == 1)
                        {
                                $table = "PriorityQueue";
                                $id = "pq_id";
                        }
                        else
                        {
                                $table = "Queue";
                                $id = "q_id";
                        }
                        // checks to see if what we're looking for exists
                        $result = $pdo->prepare("SELECT * FROM " . $table . " WHERE " . $id . " = :id");
                        $result->execute(array('id' => $_POST["ID"]));
                        if ($result->rowCount() == 0) // if it's not there
                        {
                                echo "Invalid option";
                        }
                        else // deletes it :)
                        {
                                $result = $pdo->prepare("DELETE FROM " . $table . " WHERE " . $id . " = :id");
                                $result->execute(array('id' => $_POST["ID"]));
                                // bye bye :)
                                echo "Song is now playing. Removed from queue";
                        }
                }
                echo "</p>";
        }
        // gathers the data for the priority queue
        $result = $pdo->query('SELECT PriorityQueue.pq_id AS "ID", User.name AS "Name", User.email AS "Email", Song.title AS "Song Title", Song.genre AS "Genre", Artist.artist_name AS "Artist" FROM PriorityQueue LEFT JOIN User ON PriorityQueue.user_id = User.user_id LEFT JOIN Song ON PriorityQueue.song_id = Song.song_id LEFT JOIN Artist ON Song.artist_id = Artist.artist_id');
        $priorityQueue = $result->fetchall(PDO::FETCH_ASSOC);
        // gathers the data for the standard queue
        $result = $pdo->query('SELECT PriorityQueue.pq_id AS "ID", User.name AS "Name", User.email AS "Email", Song.title AS "Song Title", Song.genre AS "Genre", Artist.artist_name AS "Artist" FROM Queue LEFT JOIN User ON Queue.user_id = User.user_id LEFT JOIN Song ON Queue.song_id = Song.song_id LEFT JOIN Artist ON Song.artist_id = Artist.artist_id');
        $standardQueue = $result->fetchall(PDO::FETCH_ASSOC);
        // prints the two queues
        printTable($priorityQueue, "Priority Queue", 7, 1);
        printTable($standardQueue, "Standard Queue", 7, 0);

        // prints a table
        function printTable(array &$data, $title, $totalCols, $priority)
        {
                echo "<table border=2 style=\"float: left\">\n";
                // there's definitely a way to get the column count with just the data but ill worry about that later
                echo "<tr><th colspan=\"" . $totalCols . "\">" . $title . "</th></tr><tr>";
                foreach(array_keys($data[0]) as $header) // prints the attributes
                {
                        echo "<th>$header</th>\n";
                }
                echo "</tr>\n";
                foreach($data as $row) // prints the data
                {
                        echo "<tr>\n";
                        foreach($row as $col)
                        {
                                echo "<td>$col</td>\n";
                        }
                        // provides the form to allow the user to play a song
                        echo '<td><form method="POST">';
                        echo '<input type="hidden" name="ID" value="' . $row["ID"]. '">'; // sends the id
                        echo '<input type="Hidden" name="priority" value="' . $priority . '">'; // sends whether it's priority
                        echo '<input type="Submit" value="Play"></td></form>';
                        echo "</tr>\n";
                }
                echo "</tr>\n</table>\n";
        }
        ?>

</body>
</html>
