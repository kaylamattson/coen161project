<?php
        libxml_use_internal_errors(true);
        error_reporting(E_ALL & ~E_NOTICE);
        
        // session_start();
        // $_SESSION["userName"] = "guess";
        // $_SESSION["userEmail"] = "NULL";
        // $_SESSION["userGamesPlayed"] = 0;
        // $_SESSION["userScore"] = 0;


        // $filename = "make.html";
        // if(!(file_exists($filename))){
        //     echo "FILE: $filename does NOT exists";
        //     exit;
        // };

        // $dom = new DOMDocument();
        // $dom->loadHTMLFile($filename);
       
       
        // $title = $dom->getElementById('titleContainer');
        // $title = $title->nodeValue;

        // $cat1 = $dom->getElementById('categoryButton1');
        // $cat1 = $cat1->nodeValue;
        // //$words1 = $dom->getElementById('wordsContainer1'); //array

        // $cat2 = $dom->getElementById('categoryButton2');
        // $cat2 = $cat2->nodeValue;
        // //$words2 = $dom->getElementById('wordsContainer2'); //array

        // $cat3 = $dom->getElementById('categoryButton3');
        // $cat3 = $cat3->nodeValue;
        // //$words3 = $dom->getElementById('wordsContainer3'); //array

        // $cat4 = $dom->getElementById('categoryButton4');
        // $cat4 = $cat4->textContent;
        // echo($cat4);
        //$words4 = $dom->getElementById('wordsContainer4'); //array

        // $items1 = $dom->getElementById("0");
        // $items1 = $items1->nodeValue;
        // echo($items1);

        // $items2 = $dom->getElementById("1");
        // $items2 = $items2->nodeValue;

        // $items3 = $dom->getElementById("2");
        // $items3 = $items3->nodeValue;

        // $items4 = $dom->getElementById("3");
        // $items4 = $items4->nodeValue;
        
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //change below
        try {
            //change!!

            $title = $_POST['title'];
            $cat1 = $_POST['cat1'];
            $item11 = $_POST['c1item1'];
            $item12 = $_POST['c1item2'];
            $item13 = $_POST['c1item3'];
            $item14 = $_POST['c1item4'];

            $cat1 = $_POST['cat1'];
            $item11 = $_POST['c1item1'];
            $item12 = $_POST['c1item2'];
            $item13 = $_POST['c1item3'];
            $item14 = $_POST['c1item4'];

            $cat2 = $_POST['cat2'];
            $item21 = $_POST['c2item1'];
            $item22 = $_POST['c2item2'];
            $item23 = $_POST['c2item3'];
            $item24 = $_POST['c2item4'];

            $cat3 = $_POST['cat3'];
            $item31 = $_POST['c3item1'];
            $item32 = $_POST['c3item2'];
            $item33 = $_POST['c3item3'];
            $item34 = $_POST['c3item4'];

            $cat4 = $_POST['cat4'];
            $item41 = $_POST['c4item1'];
            $item42 = $_POST['c4item2'];
            $item43 = $_POST['c4item3'];
            $item44 = $_POST['c4item4'];

           
    
            
            $pdo = new PDO('sqlite:games.db');
           
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $id  = "1";

            $query = "SELECT * FROM games";
            $stmt2 = $pdo->prepare($query);
            $stmt2->execute();
        
            
            $countQuery = "SELECT count(*) FROM games";
            $stmtCount = $pdo->prepare($countQuery);
            $stmtCount->execute();
            $IDindex = $stmtCount->fetchColumn();
            //$newID = $IDindex 
            echo($IDindex);
        

           
            $insertQuery = "INSERT INTO games (id, title, group1, items1, group2, items2, group3, items3, group4, items4 ) VALUES (:id, :title, :group1, :items1, :group2, :items2, :group3, :items3, :group4, :items4)";
            $stmt = $pdo->prepare($insertQuery);

            $items1 = $item11 . ", " . $item12 . ", " . $item13 . ", " . $item14;
            $items2 = $item21 . ", " . $item22 . ", " . $item23 . ", " . $item24;
            $items3 = $item31 . ", " . $item32 . ", " . $item33 . ", " . $item34;
            $items4 = $item41 . ", " . $item42 . ", " . $item43 . ", " . $item44;
    
            

        
            $stmt->bindValue(':id', $IDindex);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':group1', $cat1);
            $stmt->bindValue(':items1', $items1);
            $stmt->bindValue(':group2', $cat2);
            $stmt->bindValue(':items2', $items2);
            $stmt->bindValue(':group3', $cat3);
            $stmt->bindValue(':items3', $items3);
            $stmt->bindValue(':group4', $cat4);
            $stmt->bindValue(':items4', $items4);


            $stmt->execute();

            //$query = "SELECT * FROM games";
            //$stmt2 = $pdo->prepare($query);
            //$stmt2->execute();
        
            
            // $query1 = "SELECT count(*) FROM games";
            // $stmt1 = $pdo->prepare($query1);
            // $stmt->execute();
            //$games = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            //echo sizeof($users);
            // foreach($games as $game){
            //     echo $game["title"];
            //     echo $game["items1"];
            //     // $id = $article['id'];
            // }
        

        } catch (Exception $e) {
            echo $e->getMessage();
            
        }



        
        //echo $game['id']
        
       
        $filename = "newGame.html";//idk man maybe do a new page then press continue and send to somewhere else
        if(!(file_exists($filename))){
            echo "FILE: $filename does NOT exists";
            exit;
        };

        
        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);
       
       
        // foreach($games as $game){
        //     echo("1");
        //     echo $game["title"];
        //     echo $game["items1"];
        //     // $id = $article['id'];
        // }
        // echo "HI?";
        $buttonContainer = $dom->getElementById("playButton");
        $buttonEl = $dom->createElement('button');
        $buttonEl->setAttribute('type','button');
        $buttonEl->setAttribute('class', 'game-item');
        $buttonEl->setAttribute('onclick', "window.location.href='fullGame.php?id=" . $IDindex . "'");
        $buttonContainer->appendChild($buttonEl);
    

        
        //send html file
        header('Content-Type: text/html');
        echo $dom->saveHTML();

    }
    
?>


