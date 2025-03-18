<?php
// Assuming you already have a database connection set up
//include('db_connection.php');

// $filename = "home.html";
// if(!(file_exists($filename))){
//     echo "FILE: $filename does NOT exists";
//     exit;
// };

// $dom = new DOMDocument();
// $dom->loadHTMLFile($filename);
    
// header('Content-Type: text/html');
// echo $dom->saveHTML();
$databaseFile = 'connection.db';
// echo "hi";
$loginBool = false;

//got to make sure passwords are the same
//use sessions?
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo "hi1";
    // Collect and sanitize input
    //$userName = htmlspecialchars($_POST['userName']);
    
    //NOTE: assuming to login, only need email and pass
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = strtolower($email);
    
    $userPassword = $_POST['password'];
    // $confirmPassword = $_POST['confirm-password'];

    //var_dump($name, $email, $password, $confirmPassword);

    // Check if passwords match
    // if ($userPassword !== $confirmPassword) {
    //     echo "Passwords do not match!";
    //     exit();
    // }

    // Hash the password for security
    // $hashedPassword = password_hash($userPassword, PASSWORD_BCRYPT);

    try {
        $pdo = new PDO('sqlite:' . $databaseFile);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to insert user data into database
        // $sql = "INSERT INTO users (userName, email, userPassword, gamesPlayed, score) VALUES (:userName, :email, :userPassword, :gamesPlayed, :score)";
        // $stmt = $pdo->prepare($sql);

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
        
        
        // $sql = "SELECT count(*) FROM users WHERE email = :email";
        // $stmt = $pdo->prepare($sql);

        // $query = "SELECT * FROM users";
        // $stmt = $pdo->prepare($query);
        // $stmt->execute();
    
        // $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // echo sizeof($users);
        //foreach($users as $user){
        //     echo $user["name"];
        //     echo $user["email"];
        //     // $id = $article['id'];
        
        if(sizeof($users) === 0){
            echo("User with email: " . $email . " was not found in our database <br>");
            // echo ($email);

        }else{
            $user = $users[0];
            $hashedPass = $user["userPassword"];
            if(!password_verify($userPassword, $hashedPass)){
               // echo("Login failed!");
               $loginBool = false;



            }else{
                $loginBool = true;
                session_start();
                $_SESSION["userName"] = $user["userName"];
                $_SESSION["userEmail"] = $email;
                $_SESSION["userGamesPlayed"] = $user["gamesPlayed"];
                $_SESSION["userScore"] = $user["score"];
                // echo("You have sucessufully logged in, " . $user["userName"] . "<br>");
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
        // echo("You have sucessufully logged in, " . $user["userName"] . "<br>");
        $userGreeting = $dom->createElement("h3", "You have sucessufully logged in, " . $user["userName"] . "");
        //$userGreeting->setAttribute("class", "errorTxt");
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

        // $errorTxt->nodeValue = "";
        $header->appendChild($errorTxt);

        //$heading->nodeValue = $article_saved["title"];
    
        header('Content-Type: text/html');
        echo $dom->saveHTML();
    }
}
?>
