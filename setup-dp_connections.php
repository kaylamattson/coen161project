<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$databaseFile = 'games.db';
try{
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //AUTO_INCREMENT ?
    echo "helo";
    $table = "CREATE TABLE IF NOT EXISTS games ( 
        title TEXT NOT NULL, 
        group1 TEXT NOT NULL,
        items1 TEXT NOT NULL,
        group2 TEXT NOT NULL,
        items2 TEXT NOT NULL,
        group3 TEXT NOT NULL,
        items3 TEXT NOT NULL,
        group4 TEXT NOT NULL,
        items4 TEXT NOT NULL
        
    )";
    // changed userName and userPassword
    echo "ELLO";
    $pdo->exec($table);
    echo "Database created successfully.";

   // $insertQuery = "INSERT INTO games (id, title, group1, items1, group2, items2, group3, items3, group4, items4 ) VALUES (:id, :title, :group1, :items1, :group2, :items2, :group3, :items3, :group4, :items4)";
    //$stmt = $pdo->prepare($insertQuery);
    
}catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
