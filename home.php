<?php
        libxml_use_internal_errors(true);
        error_reporting(E_ALL & ~E_NOTICE);
        
        session_start();
        $_SESSION["userName"] = "guess";
        $_SESSION["userEmail"] = "NULL";
        $_SESSION["userGamesPlayed"] = 0;
        $_SESSION["userScore"] = 0;
        $_SESSION["login"] = false;
        

        //change below
        try {
            
            // $pdo = new PDO('sqlite:articles.db');
           
            // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $id  = "1";
            // $query = "SELECT * FROM articles WHERE id = :id";
            // $stmt = $pdo->prepare($query);
            // $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // $stmt->execute();
        
            // $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // $lastestArticle = $articles[0];
            // $tagsArray = explode(",", $lastestArticle['tags']);

            // if($lastestArticle == null){
            //     echo "article was NOT found!";
            //     exit;
            // }


            
        

        } catch (Exception $e) {
            echo $e->getMessage();
            
        }


       
        // $filename = "index.html";
        // if(!(file_exists($filename))){
        //     echo "FILE: $filename does NOT exists";
        //     exit;
        // };

        
        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);
       
       
        
        
    
        // $fragment = $dom->createDocumentFragment();
        // $substringTxt = substr(strip_tags($lastestArticle["content"]), 0, 500) . '...';
        // $fragment->appendXML($substringTxt);
       
        // $articleContent->appendChild($fragment);

        
        //send html file
        header('Content-Type: text/html');
        echo $dom->saveHTML();



    ?>


