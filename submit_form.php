<?php
//this pages isn't being used rn, but we can implement it if we want
//i was trying to make it so that the email would automatically send, and a thank you message would come up





/*$filename = 'contact.html';
if(!file_exists($filename)){
    echo "Error: File not found";
    exit;
}
$dom = new DOMDocument();
$dom->loadHTMLFile($filename);

$thanks = $dom->getElementById('success-message');
$thanks->nodeValue = '';

$thanks->appendChild($dom->createTextNode("Success"));
*/



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Set email parameters
    $to = "kmattson@scu.edu"; 
    $subject = "New Contact Form Submission from $name";
    $messageBody = "Name: $name\n
                    Email: $email\n
                    Message: $message";

    // Send email
    mail($to, $subject, $messageBody);
}
//header('Content-Type: text/html');
    //echo $dom->saveHTML();
?>
