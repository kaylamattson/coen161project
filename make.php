<?php
        libxml_use_internal_errors(true);
        error_reporting(E_ALL & ~E_NOTICE);
        
        // session_start();
        // $_SESSION["userName"] = "guess";
        // $_SESSION["userEmail"] = "NULL";
        // $_SESSION["userGamesPlayed"] = 0;
        // $_SESSION["userScore"] = 0;


        $filename = "make.html";
        if(!(file_exists($filename))){
            echo "FILE: $filename does NOT exists";
            exit;
        };

        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);
       
       
        $title = $dom->getElementById('titleContainer');

        $cat1 = $dom->getElementById('categoryButton1');
        //$words1 = $dom->getElementById('wordsContainer1'); //array

        $cat2 = $dom->getElementById('categoryButton2');
        //$words2 = $dom->getElementById('wordsContainer2'); //array

        $cat3 = $dom->getElementById('categoryButton3');
        //$words3 = $dom->getElementById('wordsContainer3'); //array

        $cat4 = $dom->getElementById('categoryButton4');
        //$words4 = $dom->getElementById('wordsContainer4'); //array

        $items1 = $dom.getElementById("0");
        $items2 = $dom.getElementById("1");
        $items3 = $dom.getElementById("2");
        $items4 = $dom.getElementById("3");
        

        //change below
        try {
            
            $pdo = new PDO('sqlite:games.db');
           
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $id  = "1";



           
            $insertQuery = "INSERT INTO games (title, group1, items1, group2, items2, group3, items3, group4, items4 ) VALUES (:title, :group1, :items1, :group2, :items2, :group3, :items3, :group4, :items4)";
            $stmt = $pdo->prepare($insertQuery);

            
            $stmt->bindParam(':title', $title);//which one???
            $stmt->bindValue(':group1', $cat1);
            $stmt->bindValue(':items1', $items1);
            $stmt->bindValue(':group2', $cat2);
            $stmt->bindValue(':items2', $items2);
            $stmt->bindValue(':group3', $cat3);
            $stmt->bindValue(':items3', $items3);
            $stmt->bindValue(':group4', $cat4);
            $stmt->bindValue(':items4', $items4);


            $stmt->execute();

            
        

        } catch (Exception $e) {
            echo $e->getMessage();
            
        }


       
        $filename = "game.html";//idk man maybe do a new page then press continue and send to somewhere else
        if(!(file_exists($filename))){
            echo "FILE: $filename does NOT exists";
            exit;
        };

        
        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);
       
       
        
        
    

        
        //send html file
        header('Content-Type: text/html');
        echo $dom->saveHTML();



    ?>


