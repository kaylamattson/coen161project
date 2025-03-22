<?php
// Assuming you already have a database connection set up
$databaseFile = 'connection.db';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $userName = htmlspecialchars($_POST['userName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = strtolower($email);
    
    $userPassword = $_POST['userPassword'];
    $confirmPassword = $_POST['confirm-password'];

    // Check if passwords match
    if ($userPassword !== $confirmPassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($userPassword, PASSWORD_BCRYPT);

    try {
        $pdo = new PDO('sqlite:' . $databaseFile);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $table = "CREATE TABLE IF NOT EXISTS users ( 
            userName TEXT NOT NULL, 
            email TEXT NOT NULL,
            userPassword TEXT NOT NULL,
            gamesPlayed INTEGER,
            score INTEGER
        )";

        $pdo->exec($table); 
        // Prepare SQL statement to insert user data into database
        $sql = "INSERT INTO users (userName, email, userPassword, gamesPlayed, score) VALUES (:userName, :email, :userPassword, :gamesPlayed, :score)";
        $stmt = $pdo->prepare($sql);


        $countQuery = "SELECT count(*) FROM users WHERE email = :email";
        $countStmt = $pdo->prepare($countQuery);

        $countStmt->bindParam(':email', $email);
        $countStmt->execute();
        $count = $countStmt->fetchColumn();

        if($count == 1){
            echo("User with email: " . $email . " already has an account! <br>");

        }else{

            session_start();
            $_SESSION["userName"] = $userName;
            $_SESSION["userEmail"] = $email;
            $_SESSION["userGamesPlayed"] = 0;
            $_SESSION["userScore"] = 0;

            $stmt->bindValue(':userName', $userName);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':userPassword', $hashedPassword);
            $stmt->bindValue(':gamesPlayed', 0);
            $stmt->bindValue(':score', 0);
            $stmt->execute();
        }
        
        $filename = "home.html";
        if(!(file_exists($filename))){
            echo "FILE: $filename does NOT exists";
            exit;
        };

        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);
    
        $nav = $dom->getElementById("userGreeting");
        $userGreeting = $dom->createElement("h3", "Welcome " . $userName . "!");

        $nav->appendChild($userGreeting);
    
        header('Content-Type: text/html');
        echo $dom->saveHTML();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
