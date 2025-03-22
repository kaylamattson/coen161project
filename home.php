<?php
        libxml_use_internal_errors(true);
        error_reporting(E_ALL & ~E_NOTICE);
        //change below
        try {
    
        } catch (Exception $e) {
            echo $e->getMessage();
            
        }
        
        $dom = new DOMDocument();
        $dom->loadHTMLFile($filename);

        //send html file
        header('Content-Type: text/html');
        echo $dom->saveHTML();

    ?>


