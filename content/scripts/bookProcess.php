<?php
    /**
     * This script takes the data from the booking confirm form that was passed as hidden inputs and adds it to the reservation table. If the user does not access this page correctly they are redirected to the home page
     */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); 
    session_start();
    require_once('functions.php'); //link to the functions.php script file
    $conn = getConnection();
    
    /**
     * First check that the script was accessed correctly
     */
    if (isset($_POST["submit"])) {

        //get the booking data from the form
        $accommodationID = array_key_exists('accommodationID', $_REQUEST)? $_REQUEST['accommodationID']: null;
        $customerID = array_key_exists('customerID', $_REQUEST)? $_REQUEST['customerID']: null;
        $startDate = array_key_exists('startDate', $_REQUEST)? $_REQUEST['startDate']: null;
        $endDate = array_key_exists('endDate', $_REQUEST)? $_REQUEST['endDate']: null;
        $numGuests = array_key_exists('numGuests', $_REQUEST)? $_REQUEST['numGuests']: null;

        //create the reservation
        createReservation($conn, $accommodationID, $customerID, $startDate, $endDate, $numGuests);
        //redirect to booking successful
        header("location: ../bookingSuccess.php?booking=success");
    }

    /*If the user reached this script incorrectly they are redirected to the homepage */
    else {
        header("location: .//index.php");
        exit(); //stop script
    }

    /**
     * Functions for adding the reservation
     */
    function createReservation($conn, $accommodationID, $customerID, $startDate, $endDate, $numGuests) {
        $query = "INSERT INTO reservations (accommodationID, customerID, start_date, end_date, num_guests) VALUES (?, ?, ?, ?, ?);"; //statement ready for prepared statement
        $statement = mysqli_stmt_init($conn); //initialise prepared statement

        if(!mysqli_stmt_prepare($statement, $query)) { //checks for errors in the SQL statement
            echo "statement error";
            exit();
        }

        mysqli_stmt_bind_param($statement, "iissi", $accommodationID, $customerID, $startDate, $endDate, $numGuests); //bind the reservation data to the statement to replace placeholders
        mysqli_stmt_execute($statement); //execute the SQL query
        mysqli_stmt_close($statement); //close the statement
    }
?>