<?php
    libxml_use_internal_errors(true);

    $filename = 'madeGames.json';

    if (!file_exists($filename)) {
        echo "Error: File not found";
        exit;
    }

    $json = file_get_contents($filename);
    $data = json_decode($json, true);

    if ($data == null) {
        echo "Error: Decoding failed";
        exit;
    }

    // retreive one of our games
    $game = null;
    $filename = 'ourGames.html';
    $dom = new DOMDocument();
    $dom->loadHTMLFile($filename);

    if (isset($data)) {
        $gameContainer = $dom->getElementById('gameList');
        // Loop through the 'ourGames' array
        foreach ($data as $game) {
            // insert the games into the buttons in the html page
            $buttonEl = $dom->createElement('button');
            $buttonEl->setAttribute('type','button');
            $buttonEl->setAttribute('class', 'game-item');

            $pEl = $dom->createElement('p');
            $title = str_replace("'", "'", htmlspecialchars($game['title'], ENT_NOQUOTES, 'UTF-8'));// Convert special characters to HTML entities
            $textNode = $dom->createTextNode($title);
            $pEl->appendChild($textNode);
            $pEl->setAttribute('class', 'game-description');
            
            // Append the paragraph to the button
            $buttonEl->appendChild($pEl);
            
            // Set the 'onclick' attribute for the button with dynamic URL
            $buttonEl->setAttribute('onclick', "window.location.href='fullGame.php?id=" . $game['id'] . "';");
            
            // Append the button to the desired parent element (e.g., 'game-list')
            $gameContainer->appendChild($buttonEl);
        }

    }
   // $gameContainer = $dom->getElementById('gameList');
   try {
        $pdo = new PDO('sqlite:games.db');        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM games";
        $stmt2 = $pdo->prepare($query);
        $stmt2->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
        
    }
    
    // $query1 = "SELECT count(*) FROM games";
    // $stmt1 = $pdo->prepare($query1);
    // $stmt->execute();
    $games = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    foreach ($games as $game) {
        // insert the games into the buttons in the html page
        $buttonEl = $dom->createElement('button');
        $buttonEl->setAttribute('type','button');
        $buttonEl->setAttribute('class', 'game-item');

        $pEl = $dom->createElement('p');
        $title = str_replace("'", "'", htmlspecialchars($game['title'], ENT_NOQUOTES, 'UTF-8'));// Convert special characters to HTML entities
        $textNode = $dom->createTextNode($title);
        $pEl->appendChild($textNode);
        $pEl->setAttribute('class', 'game-description');
        
        // Append the paragraph to the button
        $buttonEl->appendChild($pEl);
       // echo "hello!";
        // Set the 'onclick' attribute for the button with dynamic URL
        $buttonEl->setAttribute('onclick', "window.location.href='fullGame.php?id=6'");
        
        // Append the button to the desired parent element (e.g., 'game-list')
        $gameContainer->appendChild($buttonEl);
    }
    // send html file
    header('Content-Type: text/html');
    echo $dom->saveHTML();
?>