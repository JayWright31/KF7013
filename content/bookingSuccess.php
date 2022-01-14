<?php
/**
 * This script creates a Booking Successful page to tell the user that their booking request has been successful.
 */
ini_set("session.save_path", "/home/unn_w19031546/sessionData"); //set session folder location
session_start(); //start a new session
require_once('scripts/functions.php'); //link to the functions.php script file

if (isset($_GET["booking"])) { //check that the page was visited correcly
    echo makePageHead("Booking Confirmed");
    echo makeNavMenu();
    echo "
        <section class='form-section background-light'>
            <div class='flex'>
                <div class='form-container'>
                    <h1 class='text-centre'>Booking Successful!</h1>
                    <p>Thank you for choosing us to make your French getaway a holdiay to remember</p>
                    <p>You booking is confirmed and you can now close this window. Please don't press the back button in your browser just in case.</p>
                </div>
            </div>
        </section>
    ";
    echo makeFooter();
} else {
    header("location: index.php"); //if not redirect to the home page
    exit(); //stop script
}
?>