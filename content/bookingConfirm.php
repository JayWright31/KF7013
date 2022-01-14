<?php
    /**
     * This page allows users who are logged in to book thier stay. If they are not logged in they will be redirected to the login page. This page uses the superglobal $_GET to check if the user got to this page by clicking on a booking link. If not they are redirected to the Accommodation page
     */

     /*Sets the session folder location and starts a new session */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); 
    session_start();
    require_once('scripts/functions.php'); //link to the functions.php script file

    /**
     * First check if the user has logged in. The user should not be able to visit this page if they have logged out
     */
    if(isset($_SESSION['logged-in']) && $_SESSION['logged-in']) { //user is logged in

        //gets the logged in users username from the session file
        $userName = $_SESSION['user'];

        /**
         * Next check that the user got to this page by pressing the submit button on the reservation form on book.php
         */
        if (isset($_POST["submit"])) { //user did press submit
            
            $villaNumber= $_GET["villa"];//get the villa ID number from the url

            /*Get the villa information by passing $villaNumber to the database*/
            $conn = getConnection();
            $sqlAccommodation = "SELECT * FROM `accommodation` WHERE `accommodationID` = $villaNumber";
            $queryResult = mysqli_query($conn, $sqlAccommodation);
    
            /*Check that a result was returned and then assign the retrieved data to appropriate variables */
            if($queryResult) {
                while ($currentRow = mysqli_fetch_assoc($queryResult)) {
                    $name = $currentRow['accommodation_name'];
                    $location = $currentRow['location'];
                    $price = $currentRow['price'];

                    //sanitise results
                    $name = filter_var($name, FILTER_SANITIZE_STRING);
                    $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $location = filter_var($location, FILTER_SANITIZE_STRING);
                }
            }

            /*Get the customer's information from the database*/
            $sqlUser = "SELECT * FROM `users` WHERE `username` = '$userName'";
            $queryResult = mysqli_query($conn, $sqlUser);
    
            /*Check that a result was returned and then assign the retrieved data to appropriate variables */
            if($queryResult) {
                while ($currentRow = mysqli_fetch_assoc($queryResult)) {
                    $firstname = $currentRow['firstname'];
                    $surname = $currentRow['surname'];
                    $userID = $currentRow['userID'];
                    //sanitise results
                    $userID = filter_var($userID, FILTER_SANITIZE_NUMBER_INT);
                    $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
                    $surname = filter_var($surname, FILTER_SANITIZE_STRING);
                }
            }
            
            //get the data from the form
            $startDate = array_key_exists('startDate', $_REQUEST)? $_REQUEST['startDate']: null;
            $endDate = array_key_exists('endDate', $_REQUEST)? $_REQUEST['endDate']: null;
            $numAdult = array_key_exists('numAdult', $_REQUEST)? $_REQUEST['numAdult']: null;
            $numChild = array_key_exists('numChild', $_REQUEST)? $_REQUEST['numChild']: null;
            $extraFridge = array_key_exists('extraFrige', $_REQUEST)? $_REQUEST['extraFridge']: null;
            $extraHouseKeeping = array_key_exists('extraHouseKeeping', $_REQUEST)? $_REQUEST['extraHouseKeeping']: null;
            $extraCancellation = array_key_exists('extraCancellation', $_REQUEST)? $_REQUEST['extraCancellation']: null;
            $extraChef = array_key_exists('extraChef', $_REQUEST)? $_REQUEST['extraChef']: null;

            //Date conversion and number of nights calculation
            $checkin = date("d F Y", strtotime($startDate)); //converts the format of the checkin date for display on the webpage
            $checkout = date("d F Y", strtotime($endDate)); //converts the format of the checkout date for display on the webpage
            $numNights = $checkout - $checkin; //calculates the number of nights
            $secondsStart = date("U", strtotime($startDate)); //converts the checkin date to UNIX seconds
            $secondsEnd = date("U", strtotime($endDate)); //converts the checkout date to unix seconds

            /**
             * Price Calculations
             */
            $numGuests = $numAdult + $numChild;
            $pricePerNight = $numGuests * $price;
            $fridgePrice = 100.00;
            $houseKeepingPrice = 50.00;
            $chefPrice = 75.00;
            $cancellationPrice = 150.00;
            $extraCost = 0;
            $discount = 0;

            /*Checks any extras and adds their cost */
            if(extras('extra', 'fridge')) {
                $extraCost += $fridgePrice;
            } 
            if(extras('extra', 'houseKeeping')) {
                $extraCost += $houseKeepingPrice;
            } 
            if(extras('extra', 'chef')) {
                $extraCost += $chefPrice;
            } 
            if(extras('extra', 'cancel')) {
                $extraCost += $cancellationPrice;
            }
            
            //calculates the cost before extras added
            $totalPrice = $pricePerNight * $numNights;

            //calculates the subtotal before discounts are applied
            $subtotal = $totalPrice + $extraCost;

            /**
             * Calls to error handling and validation functions to verify the validity of the data entered by the user 
             */

            //checks that a start and end date have been selected
            if (blankDate($startDate, $endDate) !== false) {
                header("location: book.php?villa=$villaNumber&error=date");
                exit();
            }
            //checks the checkin date is valid
            if (checkinValid($secondsStart) !== false) {
                header("location: book.php?villa=$villaNumber&error=startDate");
                exit();
            }
            //checks the checkout date is valid
            if (checkoutValid($checkin, $checkout) !== false) {
                header("location: book.php?villa=$villaNumber&error=endDate");
                exit();
            }
            //checks that the minimum stay duration is at least 1 day
            if (minNightsValid($checkin, $checkout) !== false) {
                header("location: book.php?villa=$villaNumber&error=minNights");
                exit();
            }
            //checks the number of nights does not exceed 10
            if (maxNightsValid($checkin, $checkout) !== false) {
                header("location: book.php?villa=$villaNumber&error=maxNights");
                exit();
            }
            //checks that there are not more than the permitted number of guests
            if (guestNumber($numAdult, $numChild) !== false) {
                header("location: book.php?villa=$villaNumber&error=guest");
                exit();
            }
            //checks if the reservation qualifies for a family discount
            if (familyDiscount($numAdult, $numChild) !== false) {
                $discount = ($totalPrice + $extraCost) * 0.25;
                $totalPrice = ($totalPrice + $extraCost) * 0.75;
            }

            //checks if the customer has already got a booking for this villa regardless of whether the dates are available
            alreadyVisited($conn, $villaNumber, $userID);

            //checks whether the villa has already been booked on the selected dates
            doubleBooked($conn, $villaNumber, $startDate, $endDate);

            /**
             * Once all validation has been passed the webpage is rendered
             */

            echo makePageHead("Confirm Your Booking");
            echo makeNavMenu();

            echo "
            <section class='form-section background-light'>
                <div class='flex'>
                    <div class='form-container'>
                        <h1 class='text-centre'>Your Quote</h1>
                        <p class='text-centre'>Please check the details and if you're happy press confirm</p>
                        <form action='scripts/bookProcess.php' method='POST' id='book-form'>
                        <hr>
                        <label>Customer Name: $firstname $surname</label>
                        <label>Villa Name: $name</label>          
                        <label>Location: $location</label>
                        <label>£$price per night</label>
                        
                        <hr>
                        <label>Check In: $checkin</label>
                        <label>Check Out: $checkout</label>
                        <label>Number of Nights: $numNights</label>

                        <hr>
                        <label>Number of Adults: $numAdult</label>
                        <label>Number of Children: $numChild</label>
                        
                        <hr>
                        <label>Cost of Extras: £$extraCost</label>

                        <hr>
                        <label>Subtotal: £$subtotal</label>
                        <label>Discounts: £$discount</label>
                        <label>Total: £$totalPrice</label>
                        <hr>
                        <input type='hidden' name='accommodationID' value='$villaNumber'>
                        <input type='hidden' name='customerID' value='$userID'>
                        <input type='hidden' name='startDate' value='$startDate'>
                        <input type='hidden' name='endDate' value='$endDate'>
                        <input type='hidden' name='numGuests' value='$numGuests'>
                        <button id='booking-confirm' type='submit' name='submit'>Confirm Booking!</button>

                        </form>
                    </div>
                </div> 
            </section>";

            echo makeFooter();
            
        

        } else { //if the user did not get to this page by clicking submit they are redirected to the accommodation listing page to select a villa
            header("location: accommodation.php");
            exit();
        }
    } else { //if the user is not logged in they are redirected to the login page
        header("location: login.php?error=booking");
        exit();
    }

    /**
     * Error handling functions are called to validate that all data entered by the user is correct
     */
    //funcion for verifying a start date and end date have been chosen          
     function blankDate($startDate, $endDate) {
         $isError;
         if (empty($startDate) || empty($endDate)) {
             $isError = true;
         } else {
             $isError = false;
         }
        return $isError;
     }

     //function for verifying the number of guests does not exceed the maximum allowed of 4
     function guestNumber($numAdult, $numChild) {
         $isError;
         $totalGuest = $numAdult + $numChild;
         if ($totalGuest >= 5) {
            $isError = true;
        } else {
            $isError = false;
        }
        return $isError;
     }

     //function to check if the booking is eligiable for a family discount
     function familyDiscount($numAdult, $numChild) {
         $familyDiscount;
         if ($numAdult == 2 && $numChild == 2) {
             $familyDiscount = true;
         } else {
             $familyDiscount = false;
         }
        return $familyDiscount;
     }

     //function to check which extras have been selected
     function extras($extra, $value) {
         if (!empty($_POST[$extra])) {
             foreach($_POST[$extra] as $checkValue) {
                 if ($checkValue == $value) {
                     return true;
                 }
             }
         }
         return false;
     }

     //function for checking the check in date is in the future
     function checkinValid($startDate) {
         $isError;
        $now = date("U");
        if($startDate <= $now){
            $isError = true;
        } else {
            $isError = false;
        }
        return $isError;
     }

     //function for checking the checkout date is after the checkin date
     function checkoutValid($checkin, $checkout) {
        $isError;
        $days = $checkout - $checkin;
        if($days <0){
           $isError = true;
        } else {
           $isError = false;
        }
        return $isError;
    }

     //function for checking that the duration of the stay is at least 1 night
     function minNightsValid($checkin, $checkout) {
        $isError;
        $days = $checkout - $checkin;
        if($days == 0){
           $isError = true;
        } else {
           $isError = false;
        }
        return $isError;
    }

    //function for checking that the duration of the stay does not exceed 10 nights
    function maxNightsValid($checkin, $checkout) {
        $isError;
        $days = $checkout - $checkin;
        if($days >= 11){
           $isError = true;
        } else {
           $isError = false;
        }
        return $isError;
    }

    //function for checking if the customer has already stayed in the villa regardless of dates chosen
    function alreadyVisited($conn, $villaNumber, $userID) {
        $query = "SELECT * FROM reservations WHERE customerID = ?;"; //statement for prepared statement
        $statement = mysqli_stmt_init($conn); //initialise new prepared statement

        if(!mysqli_stmt_prepare($statement, $query)) { //checks for errors in the SQL statement
            header("location: book.php?villa=$villaNumber&error=error");
            exit(); //stop script
        }     
        
        mysqli_stmt_bind_param($statement, "i", $userID); //bind data to the statement to replace placeholder
        mysqli_stmt_execute($statement); //execute SQL query

        $getResult = mysqli_stmt_get_result($statement); //gets the result of the SQL query
        $rowCount = mysqli_num_rows($getResult); //gets the number of rows in the query, usesd for checking if anything was returned

        if($getResult && $rowCount !=0) { //if the result exists and the number of rows is not 0
            while($currentRow = mysqli_fetch_assoc($getResult)) { //loops through each row of the associative array and assignes the data acordingly
                $bookedAccommodation = $currentRow['accommodationID'];
            }
            if ($bookedAccommodation == $villaNumber) { //checks any of the villas that the user has already booked are the same as the villa they are currently trying to book
                header("location: book.php?villa=$villaNumber&error=alreadyBooked");
            }
        }

        mysqli_stmt_close($statement); //close statement
    }

    //function for checking if the villa has already been booked during the chosen dates
    function doubleBooked($conn, $villaNumber, $startDate, $endDate) {
        $query = "SELECT * FROM reservations WHERE accommodationID = ?;"; //statement ready for prepared statement
        $statement = mysqli_stmt_init($conn); //initialise new prepared statement

        if(!mysqli_stmt_prepare($statement, $query)) { //checks for errors in the SQL statement
            header("location: book.php?villa=$villaNumber&error=error");
            exit(); //stop script
        }

        mysqli_stmt_bind_param($statement, "i", $villaNumber); //bind data to the statment to replace placeholder
        mysqli_stmt_execute($statement); //execute SQL query

        $getResult = mysqli_stmt_get_result($statement); //gets the result of the SQL query
        $rowCount = mysqli_num_rows($getResult); //gets the number of rows in the query, usesd for checking if anything was returned

        if($getResult && $rowCount !=0) { //if the result exists and the number of rows is not 0
            while ($currentRow = mysqli_fetch_assoc($getResult)) { //loops through each row of the associative array and assignes the data acordingly
                $bookedStart = $currentRow['start_date'];
                $bookedEnd = $currentRow['end_date'];
            }
            if(($endDate >= $bookedStart) && ($endDate <= $bookedEnd)) { //checks whether the booking request overlaps with any existing bookings in the database
                header("location: book.php?villa=$villaNumber&error=doubleBooked");
                exit(); //stop script
            }
            if(($bookedEnd >= $startDate) && ($bookedEnd <= $endDate)) { //checks whether the booking request overlaps with any existing bookings in the database
                header("location: book.php?villa=$villaNumber&error=doubleBooked");
                exit(); //stop script
            }
        }

        mysqli_stmt_close($statement); //close statement
    }
     
?>