<?php
    $host = 'localhost';
    $dbname = 'KaraokeDB';
    $username = 'your_username';
    $password = 'your_password';
    
    $pdo = new PDO("mysql:host=$host;dbname=$db",$user,$password);
    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
?>
