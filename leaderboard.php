<?php
$databaseFile = 'connection.db';

try {
    // Connect to SQLite database
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch leaderboard data sorted by score (highest first)
    $query = "SELECT userName, score FROM users ORDER BY score DESC LIMIT 10";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all rows as associative array
    $leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($leaderboard);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>

