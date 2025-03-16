<?php
    libxml_use_internal_errors(true);

    $game_id = $_GET['id'] ?? null;
    if ($game_id === null) {
        echo "Error: Article ID not found.";
        exit(); 
    }
    
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
    foreach ($data['ourGames'] as $item) {
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
    $group1 = $game['group1']['items'];
    $group2 = $game['group2']['items'];
    $group3 = $game['group3']['items'];
    $group4 = $game['group4']['items'];

    //insert the groupNames for when a connection is successful
    $success = $dom->getElementById('success1');
    $success->textContent = $game['group1']['group'];
    $success->setAttribute('data-name',$game['group1']['group']);
    
    $success = $dom->getElementById('success2');
    $success->textContent = $game['group2']['group'];
    $success->setAttribute('data-name',$game['group2']['group']);

    $success = $dom->getElementById('success3');
    $success->textContent = $game['group3']['group'];
    $success->setAttribute('data-name',$game['group3']['group']);

    $success = $dom->getElementById('success4');
    $success->textContent = $game['group4']['group'];
    $success->setAttribute('data-name',$game['group4']['group']);

    $cardArray = array_merge($group1, $group2, $group3, $group4);
    shuffle($cardArray);

    // insert the cards in a randomized order
    $cardContainer = $dom->getElementById('cardContainer');
    foreach($cardArray as $card) {
        $buttonEl = $dom->createElement('button',$card);
        $buttonEl->setAttribute('type','button');
        $buttonEl->setAttribute('class', 'box');
        
        if (in_array($card, $group1)) {
            $buttonEl->setAttribute('data-group-id', '1');
            $buttonEl->setAttribute('data-group-name', $game['group1']['group']);
        }
        elseif (in_array($card, $group2)) {
            $buttonEl->setAttribute('data-group-id', '2');
            $buttonEl->setAttribute('data-group-name', $game['group2']['group']);
        }
        elseif (in_array($card, $group3)) {
            $buttonEl->setAttribute('data-group-id', '3');
            $buttonEl->setAttribute('data-group-name', $game['group3']['group']);
        }
        elseif (in_array($card, $group4)) {
            $buttonEl->setAttribute('data-group-id', '4');
            $buttonEl->setAttribute('data-group-name', $game['group4']['group']);
        }

        $cardContainer->appendChild($buttonEl);
    }
    
    // send html file
    header('Content-Type: text/html');
    echo $dom->saveHTML();
?>