<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$databaseFile = 'connection.db';
try{
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $table = "CREATE TABLE IF NOT EXISTS users ( 
        id INTEGER PRIMARY KEY,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT NOT NULL
    )";
    $pdo->exec($table);
    echo "Database created successfully.";

    $insertQuery = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $pdo->prepare($insertQuery);

    $sampleUsers = [
        ['name' => 'Kayla Mattson', 'email' => 'john@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT)],
        ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => password_hash('mypassword456', PASSWORD_DEFAULT)]
    ];

    foreach ($sampleUsers as $user) {
        // Bind values to the placeholders in the SQL query
        $stmt->bindValue(':name', $user['name']);
        $stmt->bindValue(':email', $user['email']);
        $stmt->bindValue(':password', $user['password']);
        $stmt->execute();
        echo "Sample user \"{$user['name']}\" inserted.<br>";
    }

    $selectQuery = "SELECT * FROM users";
    $stmt = $pdo->prepare($selectQuery);
    $stmt->execute();        
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($users);

}

catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
