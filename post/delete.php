<?php

    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ../login.php');
        exit;
    }

    // get database connection
    include_once '../connection.php';
     
    // instantiate object
    include_once '../objects/posts.php';

    $database = new DB();
    $db = $database->getConnection();
     
    $post = new Post($db);

    $post_id = $_GET['post_id'];

    // delete
    $check = $post->delete_post($post_id);
    if($check){
        $delete =array(
        // "message"   => $check,
        "Message"    => "True"
    );
    }
     
    // if unable to delete
    else{
        $delete =array(
        // "message"   => $check,
        "Message"    => "False"
    );
    }
    echo json_encode($delete);
?>