<?php
// Assuming you already have a database connection set up
//include('db_connection.php');
$databaseFile = 'connection.db';
echo "hi";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "hi1";
    // Collect and sanitize input
    $userName = htmlspecialchars($_POST['userName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
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

        // Prepare SQL statement to insert user data into database
        $sql = "INSERT INTO users (userName, email, userPassword) VALUES (:userName, :email, :userPassword)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':userName', $userName);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':userPassword', $hashedPassword);
        $stmt->execute();
       

        echo "Account created successfully!";


        $query = "SELECT * FROM users";
        $stmt = $pdo->prepare($query);
        // $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
}
?>
