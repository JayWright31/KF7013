<?php
/**
 * When called this script destroys the current session logging the user out
 */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); //set session folder location
    session_start(); //start a new session

    //find the session and destroy it then redirect to the homepage
    $_SESSION = array();
    session_destroy();
    header('Location: ../index.php');
?>