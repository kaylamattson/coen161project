<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$databaseFile = 'connection.db';
try{
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $table = "CREATE TABLE IF NOT EXISTS users ( 
        userName TEXT NOT NULL, 
        email TEXT NOT NULL,
        userPassword TEXT NOT NULL
    )";
    // changed userName and userPassword
    $pdo->exec($table);
    echo "Database created successfully.";

    $insertQuery = "INSERT INTO users (userName, email, userPassword) VALUES (:userName, :email, :userPassword)";
    $stmt = $pdo->prepare($insertQuery);

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
