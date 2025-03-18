<?php
    libxml_use_internal_errors(true);

    $game_id = $_GET['id'] ?? null;
    if ($game_id === null) {
        //echo "Error: Article ID not found.";
        exit(); 
    }
    if($game_id == 6){
        //echo "YAY!";
        $databaseFile = 'games.db';
        try{
            $pdo = new PDO('sqlite:' . $databaseFile);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //AUTO_INCREMENT ?
            // echo "helo";
            // $table = "CREATE TABLE IF NOT EXISTS games ( 
            //     title TEXT NOT NULL, 
            //     group1 TEXT NOT NULL,
            //     items1 TEXT NOT NULL,
            //     group2 TEXT NOT NULL,
            //     items2 TEXT NOT NULL,
            //     group3 TEXT NOT NULL,
            //     items3 TEXT NOT NULL,
            //     group4 TEXT NOT NULL,
            //     items4 TEXT NOT NULL
                
            // )";
           
            $sql = "SELECT * FROM games"; //get all games created
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
    
            $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $game1 = $games[0];
        
            // echo $game1["group1"] . "\n";
            // echo $game1["items1"] . "\n";

            // echo $game1["group2"] . "\n";
            // echo $game1["items2"] . "\n";

            // echo $game1["group3"] . "\n";
            // echo $game1["items3"] . "\n";

            // echo $game1["group4"] . "\n";
            // echo $game1["items4"] . "\n";

            
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $filename = 'fullGame.html';
        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);

        // insert title
        $title = $dom->getElementById('title');
        $title->nodeValue = $game1['title'];

        //merge all groups into one array
        
        $group1 = $game1['group1'];
        $group2 = $game1['group2'];
        $group3 = $game1['group3'];
        $group4 = $game1['group4'];
        

        //insert the groupNames for when a connection is successful
        $success = $dom->getElementById('success1');
        $success->textContent = $game1['group1'];
        $success->setAttribute('data-name',$game1['group1']);
        
        $success = $dom->getElementById('success2');
        $success->textContent = $game1['group2'];
        $success->setAttribute('data-name',$game1['group2']);

        $success = $dom->getElementById('success3');
        $success->textContent = $game1['group3'];
        $success->setAttribute('data-name',$game1['group3']);

        $success = $dom->getElementById('success4');
        $success->textContent = $game1['group4'];
        $success->setAttribute('data-name',$game1['group4']);


        $items1 = explode(",", $game1['items1']);
        $items2 = explode(",", $game1['items2']);
        $items3 = explode(",", $game1['items3']);
        $items4 = explode(",", $game1['items4']);

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
                $buttonEl->setAttribute('data-group-name', $game1['group1']);
            }
            elseif (in_array($card, $items2)) {
                $buttonEl->setAttribute('data-group-id', '2');
                $buttonEl->setAttribute('data-group-name', $game1['group2']);
            }
            elseif (in_array($card, $items3)) {
                $buttonEl->setAttribute('data-group-id', '3');
                $buttonEl->setAttribute('data-group-name', $game1['group3']);
            }
            elseif (in_array($card, $items4)) {
                $buttonEl->setAttribute('data-group-id', '4');
                $buttonEl->setAttribute('data-group-name', $game1['group4']);
            }

            $cardContainer->appendChild($buttonEl);
        }

    }else{

    
        //echo("WHYY?");
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

        // retreive one of our games.
        $game = null;
        foreach ($data as $item) {
            if (isset($item['id']) && $item['id'] == $game_id) {
                $game = $item;
                break;
            }
        }

        $filename = 'fullGame.html';
        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);

        // insert title
        $title = $dom->getElementById('title');
        $title->nodeValue = $game['title'];

        //merge all groups into one array
        
        $group1 = $game['group1'];
        $group2 = $game['group2'];
        $group3 = $game['group3'];
        $group4 = $game['group4'];
        

        //insert the groupNames for when a connection is successful
        $success = $dom->getElementById('success1');
        $success->textContent = $game['group1'];
        $success->setAttribute('data-name',$game['group1']);
        
        $success = $dom->getElementById('success2');
        $success->textContent = $game['group2'];
        $success->setAttribute('data-name',$game['group2']);

        $success = $dom->getElementById('success3');
        $success->textContent = $game['group3'];
        $success->setAttribute('data-name',$game['group3']);

        $success = $dom->getElementById('success4');
        $success->textContent = $game['group4'];
        $success->setAttribute('data-name',$game['group4']);

        $cardArray = array_merge($game['items1'], $game['items2'], $game['items3'], $game['items4']);
        shuffle($cardArray);

        // insert the cards in a randomized order
        $cardContainer = $dom->getElementById('cardContainer');
        foreach($cardArray as $card) {
            $buttonEl = $dom->createElement('button',$card);
            $buttonEl->setAttribute('type','button');
            $buttonEl->setAttribute('class', 'box');
            
            if (in_array($card, $game['items1'])) {
                $buttonEl->setAttribute('data-group-id', '1');
                $buttonEl->setAttribute('data-group-name', $game['group1']);
            }
            elseif (in_array($card, $game['items2'])) {
                $buttonEl->setAttribute('data-group-id', '2');
                $buttonEl->setAttribute('data-group-name', $game['group2']);
            }
            elseif (in_array($card, $game['items3'])) {
                $buttonEl->setAttribute('data-group-id', '3');
                $buttonEl->setAttribute('data-group-name', $game['group3']);
            }
            elseif (in_array($card, $game['items4'])) {
                $buttonEl->setAttribute('data-group-id', '4');
                $buttonEl->setAttribute('data-group-name', $game['group4']);
            }

            $cardContainer->appendChild($buttonEl);
        }
    }
    
    // send html file
    header('Content-Type: text/html');
    echo $dom->saveHTML();
?>