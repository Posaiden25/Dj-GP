<?php
require 'connection.php';
function executeFile(PDO $pdo, $filePath) {
    $sql = file_get_contents($filePath);

         if ($sql === false) {
             throw new Exception("No file: $filePath");
        }       

        $pdo->exec($sql);
        echo "worked";
}   
try{
    executeFile($pdo, 'dj.sql');
    executeFile($pdo, 'insert.sql');
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
?>
