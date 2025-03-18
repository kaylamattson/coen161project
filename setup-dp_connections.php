<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$databaseFile = 'games.db';
try{
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //AUTO_INCREMENT ?
    $table = "CREATE TABLE IF NOT EXISTS games ( 
        id INT PRIMARY KEY,
        title TEXT NOT NULL, 
        group1 TEXT NOT NULL,
        items1 TEXT NOT NULL,
        group2 TEXT NOT NULL,
        items2 TEXT NOT NULL,
        group3 TEXT NOT NULL,
        items3 TEXT NOT NULL,
        group4 TEXT NOT NULL,
        items4 TEXT NOT NULL,
        
    )";
    // changed userName and userPassword
    $pdo->exec($table);
    echo "Database created successfully.";

    $insertQuery = "INSERT INTO games (id, title, group1, items1, group2, items2, group3, items3, group4, items4 ) VALUES (:id, :title, :group1, :items1, :group2, :items2, :group3, :items3, :group4, :items4)";
    $stmt = $pdo->prepare($insertQuery);

    if (!file_exists('madeGames.json')) {
        throw new Exception("madeGames.json file not found.");
    }
    $jsonData = file_get_contents('madeGames.json');
    $ourGames = json_decode($jsonData, true);

  
    if (!$ourGames || !is_array($ourGames)) {
        throw new Exception("Invalid or empty JSON data.");
    }


    $countQuery = "SELECT count(*) FROM ourGames WHERE id = :id";
            $countStmt = $pdo->prepare($countQuery);
           
            foreach($ourgames as $game) {

              
                $id = $game['id'];
                $countStmt->bindParam(':id', $id, PDO::PARAM_INT);
                $countStmt->execute();
                $count = $countStmt->fetchColumn();
                
                if($count == 1){
                    echo("Game with ID:" . $id . " has already been made<br>");

                }else{

                    $title = $game['title'];

                    $group1 = $game['group1'];
                    $items1 = is_array($game['items1']) ? implode(",", $game['items1']) : $game['items1'];

                    $group2 = $game['group2'];
                    $items2 = is_array($game['items2']) ? implode(",", $game['items2']) : $game['items2'];

                    $group3 = $game['group3'];
                    $items3 = is_array($game['items3']) ? implode(",", $game['items3']) : $game['items3'];

                    $group3 = $game['group4'];
                    $items3 = is_array($game['items4']) ? implode(",", $game['items4']) : $game['items4'];//stopped here


                   
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':tags', $tags);
                    $stmt->bindParam(':content', $content);
                    $stmt->execute();

                    echo "Article with title '$title' inserted successfully.<br>";
                }


                
            }



    // $sampleUsers = [
    //     ['userName' => 'Kayla Mattson', 'email' => 'john@example.com', 'userPassword' => password_hash('password123', PASSWORD_DEFAULT)],
    //     ['userName' => 'Jane Smith', 'email' => 'jane@example.com', 'userPassword' => password_hash('mypassword456', PASSWORD_DEFAULT)]
    // ];

    // foreach ($sampleUsers as $user) {
    //     // Bind values to the placeholders in the SQL query
    //     $stmt->bindValue(':userName', $user['userName']);
    //     $stmt->bindValue(':email', $user['email']);
    //     $stmt->bindValue(':userPassword', $user['userPassword']);
    //     $stmt->execute();
    //     echo "Sample user \"{$user['userName']}\" inserted.<br>";
    // }

    // $selectQuery = "SELECT * FROM users";
    // $stmt = $pdo->prepare($selectQuery);
    // $stmt->execute();        
    // $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($users);

}

catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
