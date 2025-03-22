<?php
$databaseFile = 'connection.db';
$loginBool = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = strtolower($email);
    
    $userPassword = $_POST['password'];

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

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(sizeof($users) === 0){
            echo("User with email: " . $email . " was not found in our database <br>");

        }else{
            $user = $users[0];
            $hashedPass = $user["userPassword"];
            if(!password_verify($userPassword, $hashedPass)){
               $loginBool = false;

            }else{
                $loginBool = true;
                session_start();
                $_SESSION["userName"] = $user["userName"];
                $_SESSION["userEmail"] = $email;
                $_SESSION["userGamesPlayed"] = $user["gamesPlayed"];
                $_SESSION["userScore"] = $user["score"];
            }
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

   

    if($loginBool){
        $filename = "home.html";
        if(!(file_exists($filename))){
            echo "FILE: $filename does NOT exists";
            exit;
        };

        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);

        $nav = $dom->getElementById("userGreeting");
        $userGreeting = $dom->createElement("h3", "You have sucessufully logged in, " . $user["userName"] . "");
        $nav->appendChild($userGreeting);
    
    
        header('Content-Type: text/html');
        echo $dom->saveHTML();
    }
    else{
        $filename = "login.html";
        if(!(file_exists($filename))){
            echo "FILE: $filename does NOT exists";
            exit;
        };

        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);
    
        $header = $dom->getElementById("loginHeader");
        $errorTxt = $dom->createElement("h4", "Error: User email is not in our records or password is incorrect, try again.");
        $errorTxt->setAttribute("class", "errorTxt");

        $header->appendChild($errorTxt);
    
        header('Content-Type: text/html');
        echo $dom->saveHTML();
    }
}
?>
