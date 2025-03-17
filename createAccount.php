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

        $stmt->bindValue(':userName', $user['userName']);
        $stmt->bindValue(':email', $user['email']);
        $stmt->bindValue(':userPassword', $user['userPassword']);
        $stmt->execute();
       

        echo "Account created successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
