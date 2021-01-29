<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){

include_once 'connection.php';
include_once 'user.php';

$database = new DB();
$db = $database->getConnection();

//Set ID property of user to be deleted these values can be passed using any device
$name = isset($_POST['name']) ? $_POST['name'] : die();
$from = isset($_POST['email']) ? $_POST['email'] : die();
$message = isset($_POST['description']) ? $_POST['description'] : die();

$to = 'maryjane@email.com';
$subject = 'Contact Us';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message
$message = '<html><body>';
$message .= '<h1 style="color:#f40;">Hi Jane!</h1>';
$message .= '<p style="color:#080;font-size:18px;">Will you marry me?</p>';
$message .= '</body></html>';
 
// Sending email
if(mail($to, $subject, $message, $headers)){
    echo 'Your mail has been sent successfully.';
} else{
    echo 'Unable to send email. Please try again.';
}
}
?>
