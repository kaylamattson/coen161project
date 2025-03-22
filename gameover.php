<?php
   $data = json_decode(file_get_contents('php://input'), true);
   
   $numWins = $data['numwin'] ?? 'undefined';

   session_start();

    if(isset($_SESSION['userEmail'])) {
        echo "Welcome, " . htmlspecialchars($_SESSION['userName']) . "! <br>";
        echo "Email: " . htmlspecialchars($_SESSION['userEmail']) . "<br>";
        echo "Score: " . (int)$_SESSION['userScore'] . "<br>";
        echo "Games Played: " . (int)$_SESSION['userGamesPlayed'] . "<br>";
    } else {
        echo "User not logged in!";
    }

    
    $userName = $_SESSION["userName"];
    $userEmail = $_SESSION["userEmail"];
    $numGamesPlayed = $_SESSION["userGamesPlayed"];
    $userScore = $_SESSION["userScore"];
    echo $numGamesPlayed . " try";
    $numGamesPlayed++;

    if($numWins == 4){
        $userScore++;
    }
    try {

        $pdo = new PDO('sqlite:connection.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $updateQuery = "UPDATE users SET 
                    gamesPlayed = :gamesPlayed,
                    score = :score
                WHERE email = :email";

    
        $stmt = $pdo->prepare($updateQuery);

        // Bind values
        $stmt->bindValue(':gamesPlayed', $numGamesPlayed, PDO::PARAM_INT);
        $stmt->bindValue(':score', $userScore, PDO::PARAM_INT);
        $stmt->bindValue(':email', $userEmail);

        // Execute the update
        $stmt->execute();

        echo "Number of games '$numGamesPlayed' is now updated! <br>";
        echo "score '$userScore' is now updated! <br>";

   

        if ($stmt->rowCount() > 0) {
            echo "User with email '$userEmail' updated successfully! <br>";
        } else {
            echo "No user found with email '$userEmail', or no changes were made. <br>";
        }
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt1 = $pdo->prepare($sql);
            $stmt1->bindParam(':email', $userEmail);
            $stmt1->execute();
        
            $users = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            $user = $users[0];
            echo $userName;
            echo $userEmail;
            echo "in DATABASE RN: games played = " . $user['gamesPlayed'] ." <br>";
            echo "in DATABASE RN:score =  " . $user['score'] ." <br>";

        echo $numGamesPlayed . " try2";
        $_SESSION["userGamesPlayed"] = $numGamesPlayed;
        $_SESSION["userScore"] = $userScore;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } 

?>