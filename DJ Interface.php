<!DOCTYPE html>
<html>
<head><title>Karaoke Disc Jockey</title><head>
<style>
        body {
            background-color:  gray;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #ff6347;
            font-size: 70px;
            text-align: center;
            font: 15px Arial;
        }
        form {
            background-color: #bf5b49;
            padding: 5px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 200px;
            margin: 10px;
        }
        input[type="submit"] {
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            background-color:#ff6347;
        }
        input[type="submit"]:hover {
            opacity: 0.5;
        }
        table {
            border-collapse: none;
            width: 100%;
            background-color:  dark gray;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        }
        th, td {
            border: 5px solid black;
            padding: 5px;
            color: black;
        }
        th {
            background-color: #ff6347;
        }
        td {
            text-align: center;
        }
        table, th, td {
            border: 1px solid;
            background-color: #bf5b49;
            padding: 4px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
            margin: auto;
            margin-top: 15px;
            font-size: 18px;
        }
        .error {
            color: #ff6347;
            margin-top: 10px;
            text-align: center;
        }
        .success {
            color: green;
            margin-top: 10px;
            text-align: center;
        }
        .play {
            width: 60px;
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
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo 'Connection failed: ' . $e->getMessage();
}
        static $signUpPage = "./karaokeSignUp.php"; // the link to the sign up page
        static $queueColumns = 8; // columns of a standard queue. add one to priority queues

        echo "<br><br>\n";
        echo "<body>\n";
        echo "<h1>Karaoke DJ Interface</h1>\n";

        // a button to send you to the sign up page
        echo '<form action="' . $signUpPage . '">';
        echo '<input type="Submit" value="To the Sign Up Page" /></form>';

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
                            echo "<p class='error'>Invalid option, did you refresh the page?</p>";
                        }
                        else // deletes it :)
                        {
                                $result = $pdo->prepare("DELETE FROM " . $table . " WHERE " . $id . " = :id");
                                $result->execute(array('id' => $_POST["ID"]));
                                // bye bye :)
                                echo "<p class='success'>Song is now playing. Removed from queue</p>";
                        }
                }
                echo "</p>";
        }
        // gathers the data for the priority queue
        $result = $pdo->query('SELECT PriorityQueue.pq_id AS "ID", User.name AS "Name", User.email AS "Email", '
                . 'Song.title AS "Song Title", Song.genre AS "Genre", Artist.artist_name AS "Artist", '
                . 'PriorityQueue.money AS "Money", Song.karaoke_file AS "File" FROM PriorityQueue '
                . 'LEFT JOIN User ON PriorityQueue.user_id = User.user_id '
                . 'LEFT JOIN Song ON PriorityQueue.song_id = Song.song_id '
                . 'LEFT JOIN Artist ON Song.artist_id = Artist.artist_id '
                . 'ORDER BY money DESC');
        $priorityQueue = $result->fetchall(PDO::FETCH_ASSOC);
        // gathers the data for the standard queue
        $result = $pdo->query('SELECT Queue.q_id AS "ID", User.name AS "Name", User.email AS "Email", '
                . 'Song.title AS "Title", Song.genre AS "Genre", Artist.artist_name AS "Artist", '
                . 'Song.karaoke_file AS "File" FROM Queue '
                . 'LEFT JOIN User ON Queue.user_id = User.user_id '
                . 'LEFT JOIN Song ON Queue.song_id = Song.song_id '
                . 'LEFT JOIN Artist ON Song.artist_id = Artist.artist_id');
        $standardQueue = $result->fetchall(PDO::FETCH_ASSOC);
        // prints the two queues
        printTable($priorityQueue, "Priority Queue", $queueColumns + 1, 1);
        printTable($standardQueue, "Standard Queue", $queueColumns, 0);

        // prints a table
        function printTable(array &$data, $title, $totalCols, $priority)
        {
                if (!empty($data))
                {
                        echo "<p>\n<table border=2>\n";
                        // there's definitely a way to get the column count with just the data but whatever
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
                                echo '<td><form method="POST" class="play">';
                                echo '<input type="hidden" name="ID" value="' . $row["ID"]. '">'; // sends the id
                                echo '<input type="Hidden" name="priority" value="' . $priority . '">'; // sends whether it's priority
                                echo '<input type="Submit" value="Play"></td></form>';
                                echo "</tr>\n";
                        }
                        echo "</tr>\n</table>\n</p>";
                }
                else
                {
                        echo "<p>" . $title . " is empty</p>";
                }
        }

        ?>

</body>
</html>
