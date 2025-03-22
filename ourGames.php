<?php
    libxml_use_internal_errors(true);

   try {
        $pdo = new PDO('sqlite:games.db');        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM games";
        $stmt2 = $pdo->prepare($query);
        $stmt2->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
        
    }
    
    $games = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $filename = 'ourGames.html';
    $dom = new DOMDocument();
    $dom->loadHTMLFile($filename);
    $gameContainer = $dom->getElementById('gameList');

    foreach ($games as $game) {
        // insert the games into the buttons in the html page
        $buttonEl = $dom->createElement('button');
        $buttonEl->setAttribute('type','button');
        $buttonEl->setAttribute('class', 'game-item');

        $pEl = $dom->createElement('p');
        $title = str_replace("'", "'", htmlspecialchars($game['title'], ENT_NOQUOTES, 'UTF-8'));
        $textNode = $dom->createTextNode($title);
        $pEl->appendChild($textNode);
        $pEl->setAttribute('class', 'game-description');
        
        $buttonEl->appendChild($pEl);
        
        $buttonEl->setAttribute('onclick', "window.location.href='fullGame.php?id=" . $game['id'] . "'");
        
        $gameContainer->appendChild($buttonEl);
    }
    
    // send html file
    header('Content-Type: text/html');
    echo $dom->saveHTML();
?>