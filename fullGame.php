<?php
    libxml_use_internal_errors(true);

    $game_id = $_GET['id'] ?? null;
    if ($game_id === null) {
        exit(); 
    }

        $databaseFile = 'games.db';
        try{
            $pdo = new PDO('sqlite:' . $databaseFile);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $sql = "SELECT * FROM games"; //get all games created
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
    
            $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($games as $game){
                if($game["id"] == $game_id){
                    //echo $game_id;
                    $playingGame = $game;
                    break;
                }
            }

        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $filename = 'fullGame.html';
        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);

        // insert title
        $title = $dom->getElementById('title');
        $title->nodeValue = $playingGame['title'];

        // merge all groups into one array
        
        $group1 = $playingGame['group1'];
        $group2 = $playingGame['group2'];
        $group3 = $playingGame['group3'];
        $group4 = $playingGame['group4'];
        

        // insert the groupNames for when a connection is successful
        $success = $dom->getElementById('success1');
        $success->textContent = $playingGame['group1'];
        $success->setAttribute('data-name',$playingGame['group1']);
        
        $success = $dom->getElementById('success2');
        $success->textContent = $playingGame['group2'];
        $success->setAttribute('data-name',$playingGame['group2']);

        $success = $dom->getElementById('success3');
        $success->textContent = $playingGame['group3'];
        $success->setAttribute('data-name',$playingGame['group3']);

        $success = $dom->getElementById('success4');
        $success->textContent = $playingGame['group4'];
        $success->setAttribute('data-name',$playingGame['group4']);


        $items1 = explode(",", $playingGame['items1']);
        $items2 = explode(",", $playingGame['items2']);
        $items3 = explode(",", $playingGame['items3']);
        $items4 = explode(",", $playingGame['items4']);

        $cardArray = array_merge($items1, $items2, $items3, $items4);
        shuffle($cardArray);

        // insert the cards in a randomized order
        $cardContainer = $dom->getElementById('cardContainer');
        foreach($cardArray as $card) {
            $buttonEl = $dom->createElement('button',$card);
            $buttonEl->setAttribute('type','button');
            $buttonEl->setAttribute('class', 'box');
            
            if (in_array($card, $items1)) {
                $buttonEl->setAttribute('data-group-id', '1');
                $buttonEl->setAttribute('data-group-name', $playingGame['group1']);
            }
            elseif (in_array($card, $items2)) {
                $buttonEl->setAttribute('data-group-id', '2');
                $buttonEl->setAttribute('data-group-name', $playingGame['group2']);
            }
            elseif (in_array($card, $items3)) {
                $buttonEl->setAttribute('data-group-id', '3');
                $buttonEl->setAttribute('data-group-name', $playingGame['group3']);
            }
            elseif (in_array($card, $items4)) {
                $buttonEl->setAttribute('data-group-id', '4');
                $buttonEl->setAttribute('data-group-name', $playingGame['group4']);
            }

            $cardContainer->appendChild($buttonEl);
        }
        
    // send html file
    header('Content-Type: text/html');
    echo $dom->saveHTML();
?>