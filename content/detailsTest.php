<?php
    require_once('scripts/detailsFunction.php');
    echo makePageHead("Villa La Nice | Home"); 
    echo makeNavMenu();

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

    echo makeFooter();
?>