<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$databaseFile = 'games.db';
try{
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //AUTO_INCREMENT ?
    //echo "helo";

    $idCounter = 0;

    $table = "CREATE TABLE IF NOT EXISTS games ( 
        id INT NOT NULL,
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
   // echo "ELLO";
    $pdo->exec($table);
    echo "Database created successfully. <br> <br>";

    $jsonData = file_get_contents('madeGames.json');
    $games = json_decode($jsonData, true);

          
    if (!$games || !is_array($games)) {
        throw new Exception("Invalid or empty JSON data.");
    }

           
    $insertQuery = "INSERT INTO games (id, title, group1, items1, group2, items2, group3, items3, group4, items4 ) VALUES (:id, :title, :group1, :items1, :group2, :items2, :group3, :items3, :group4, :items4)";
    $stmt = $pdo->prepare($insertQuery);

            // $items1 = $item11 . ", " . $item12 . ", " . $item13 . ", " . $item14;
            // $items2 = $item21 . ", " . $item22 . ", " . $item23 . ", " . $item24;
            // $items3 = $item31 . ", " . $item32 . ", " . $item33 . ", " . $item34;
            // $items4 = $item41 . ", " . $item42 . ", " . $item43 . ", " . $item44;
            // $stmt->bindValue(':title', $title);
            // $stmt->bindValue(':group1', $cat1);
            // $stmt->bindValue(':items1', $items1);
            // $stmt->bindValue(':group2', $cat2);
            // $stmt->bindValue(':items2', $items2);
            // $stmt->bindValue(':group3', $cat3);
            // $stmt->bindValue(':items3', $items3);
            // $stmt->bindValue(':group4', $cat4);
            // $stmt->bindValue(':items4', $items4);


            // $stmt->execute();

    $countQuery = "SELECT count(*) FROM games WHERE title = :title";
    $countStmt = $pdo->prepare($countQuery);
           
    foreach($games as $game) {

              
        $title = $game['title'];
        $countStmt->bindParam(':title', $title);
        $countStmt->execute();
        $count = $countStmt->fetchColumn();
        
        if($count == 1){
            echo("ERROR: Game with title: " . $title . " is already a game implemented in our database! <br>");

        }else{
            $id = $idCounter;
            $idCounter++;
            //$title = $article['title'];
            $group1 = $game['group1'];
            $items1 = implode(",", $game['items1']);

            $group2 = $game['group2'];
            $items2 = implode(",", $game['items2']);

            $group3 = $game['group3'];
            $items3 = implode(",", $game['items3']);

            $group4 = $game['group4'];
            $items4 = implode(",", $game['items4']);


            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':group1', $group1);
            $stmt->bindValue(':items1', $items1);
            $stmt->bindValue(':group2', $group2);
            $stmt->bindValue(':items2', $items2);
            $stmt->bindValue(':group3', $group3);
            $stmt->bindValue(':items3', $items3);
            $stmt->bindValue(':group4', $group4);
            $stmt->bindValue(':items4', $items4);
                    
            //$tags = is_array($article['tags']) ? implode(",", $article['tags']) : $article['tags'];
            $stmt->execute();
        

            echo "Game with title '$title' & '$id' was inserted successfully! <br>";
        }      


                
    }
    echo "<br> pre-made games in JSON file were loaded into database! <br>";
    //echo sizeof($games);
    
}catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
