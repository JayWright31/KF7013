<?php
/**
 * This script creates the individual details pages. The structure of the pages is the same for each villa with only the name, location, and villa ID number being passed as arguments
 */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); //set session folder location
    session_start(); //start a new session
    require_once('scripts/detailsFunction.php');//load the custom script that contains the structure of the pages
    
    echo makePageHead("Details"); //create the html header and start the body. The page title is passed as an argument
    echo makeNavMenu(); //create the navigation menu

    if (isset($_GET["villa"])) {
        if($_GET["villa"] == "1") {
            echo makePageContent("Belle Villa - Saint Maurice", "1");
        } else if($_GET["villa"] == "2") {
            echo makePageContent("Maison de Plage - Old Nice", "2");
        } else if($_GET["villa"] == "3") {
            echo makePageContent("Centre Ville - Vernier", "3");
        } else if($_GET["villa"] == "4") {
            echo makePageContent("Flanc de Cotaue - La Conque", "4");
        } else if($_GET["villa"] == "5") {
            echo makePageContent("Appartamento Alto - Gambetta", "5");
        } else { //the villa= was wrong so redirect to accommodation page
            header("location: accommodation.php");
            exit(); //stop script
        }
    } else { //no accommodation was selcted so return to accommodation page
        header("location: accommodation.php");
        exit(); //stop script
    }

    echo makeFooter(); //make the footer
?>