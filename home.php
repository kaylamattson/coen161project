<?php
        libxml_use_internal_errors(true);
        error_reporting(E_ALL & ~E_NOTICE);
        
        session_start();
        $_SESSION["userName"] = "guess";
        $_SESSION["userEmail"] = "NULL";
        $_SESSION["userGamesPlayed"] = 0;
        $_SESSION["userScore"] = 0;
        $_SESSION["login"] = false;

        
        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);
       
        
        //send html file
        header('Content-Type: text/html');
        echo $dom->saveHTML();



    ?>


