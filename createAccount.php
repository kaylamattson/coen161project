<?php
// Assuming you already have a database connection set up
//include('db_connection.php');
$databaseFile = 'connection.db';
// echo "hi";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo "hi1";
    // Collect and sanitize input
    $userName = htmlspecialchars($_POST['userName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = strtolower($email);
    
    $userPassword = $_POST['userPassword'];
    $confirmPassword = $_POST['confirm-password'];

    //var_dump($name, $email, $password, $confirmPassword);

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

        // $query = "SELECT * FROM users";
        // $stmt2 = $pdo->prepare($query);
        // $stmt2->execute();
    
        // $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        // echo sizeof($users);
        // foreach($users as $user){
        //     echo $user["name"];
        //     echo $user["email"];
        //     // $id = $article['id'];
        $countStmt->bindParam(':email', $email);
        $countStmt->execute();
        $count = $countStmt->fetchColumn();
        // echo $count;
        if($count == 1){
            echo("User with email: " . $email . " already has an account! <br>");
            // echo ($email);

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
               
        
           // echo "Account created successfully!";
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
        //$userGreeting->setAttribute("class", "errorTxt");

        // $errorTxt->nodeValue = "";
        $nav->appendChild($userGreeting);

        //$heading->nodeValue = $article_saved["title"];
    
        header('Content-Type: text/html');
        echo $dom->saveHTML();

        // $query = "SELECT * FROM users";
        // $stmt = $pdo->prepare($query);
        
        // $stmt->execute();
    
        // $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // foreach ($users as $user) {
        //     // Bind values to the placeholders in the SQL query
        //     echo (':userName' . $user['userName'] . "\n");
        //     echo (':email' . $user['email'] . "\n");
        //     echo (':userPassword' . $user['userPassword'] . "\n");

           
        //     echo("print 1 \n");
        // }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // foreach($users as $user){
    //     if($email === $user['email']){
    //         break;
    //     }
    // }
}
?>
