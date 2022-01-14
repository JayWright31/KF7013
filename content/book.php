<?php
    /**
     * This page allows users who are logged in to book thier stay. If they are not logged in they will be redirected to the login page. This page uses the superglobal $_GET to check if the user got to this page by clicking on a booking link. If not they are redirected to the Accommodation page
     */

     /*Sets the session folder location and starts a new session */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); 
    session_start();
    require_once('scripts/functions.php'); //link to the functions.php script file

    /**
     * First check if the user is logged in. The user should not be able to visit this page if they are logged out
     */
    if(isset($_SESSION['logged-in']) && $_SESSION['logged-in']) { //the user is logged in
        //$villaNumber = 0;

        /**
         * Next check that the user got to this page by clicking on the reservation button on an accommodation details page
         */
        if (isset($_GET["villa"])) {
            $villaNumber = $_GET["villa"];

            /*Get the villa name from the database by passing the $villaNumber to the database*/
            $conn = getConnection();
            $sql = "SELECT * FROM `accommodation` WHERE `accommodationID` = $villaNumber";
            $queryResult = mysqli_query($conn, $sql);
            
            /*Check that a result was returned and then assign the retrieved villa name to $name */
            if($queryResult) {
                //echo mysqli_fetch_assoc($queryResult);
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

            //save the current date
            $today = date("d F Y");

            /**
            * Once all validation has passed the webpage is rendered
            */
            echo makePageHead("Book Your Stay");
            echo makeNavMenu();

            echo "
            <section class='form-section background-light'>
                <div class='flex'>
                    <div class='form-container'>
                        <h2 class='text-centre'>Book your stay with us!</h2>
                        <form action='bookingConfirm.php?villa=$villaNumber' method=\"POST\" id='book-form'>
                            <hr>
                            <label>Villa: $name</label>
                            <label>Location: $location</label>
                            <label>£$price per night</label>
                            <hr>             

                            <label for='startDate'>Check In</label>
                            <input id='startDate' name='startDate' type='date'>

                            <label for='endDate'>Check Out</label>
                            <input id='endDate' name='endDate' type='date'>
                            <hr>

                            <label for='numAdult'>Number of Adults (18+)</label>
                            <select id='numAdult' name='numAdult'>
                                <option value='1'>1</option>
                                <option value='2'>2</option>
                                <option value='3'>3</option>
                                <option value='4'>4</option>
                            </select>
                            <hr>

                            <label for='numChild'>Number of Children (17 and under)</label>
                            <select id='numChild' name='numChild'>
                                <option value='0'>0</option>
                                <option value='1'>1</option>
                                <option value='2'>2</option>
                                <option value='3'>3</option>
                            </select>

                            <hr>
                            <h4 class='centre-text'>Extras</h4>
                            <div class='flex'>
                                <label for='extraFridge'>Fully Stocked Fridge</label>
                                <input id='extraFridge' name='extra[]' type='checkbox' value='fridge'>
                            
                                <label for='extraHouseKeeping'>House Keeping</label>
                                <input id='extraHouseKeeping' name='extra[]' type='checkbox' value='houseKeeping'>

                                <label for='extraCancellation'>Cancellation Protection</label>
                                <input id='extraCancellation' name='extra[]' type='checkbox' value='cancel'>

                                <label for='extraChef'>Chef</label>
                                <input id='extraChef' name='extra[]' type='checkbox' value='chef'>
                            </div>

                            <hr>
                            <button id='get-quote-button' type='submit' name='submit'>Get Quote</button>
                        </form>";

            /* Displays the error messages from the error handling methods by using the $_GET superglobal to retrieve custom error messages */
            if(isset($_GET["error"])) {
                if($_GET["error"] == "date") {
                    echo "<p class='text-centre error-message'>Checkin and Checkout dates must be filled in!</p>";
                }
                else if($_GET["error"] == "startDate") {
                    echo "<p class='text-centre error-message'>Check In must after $today!</p>";
                }
                else if($_GET["error"] == "endDate") {
                    echo "<p class='text-centre error-message'>Check Out cannot be before Check In!</p>";
                }
                else if($_GET["error"] == "minNights") {
                    echo "<p class='text-centre error-message'>You must stay for at least 1 night!</p>";
                }
                else if($_GET["error"] == "maxNights") {
                    echo "<p class='text-centre error-message'>Sorry but you cannot stay for more than 10 nights!</p>";
                }
                else if($_GET["error"] == "guest") {
                    echo "<p class='text-centre error-message'>Sorry but we only have space for 4 people to stay!</p>";
                } else if($_GET["error"] == "alreadyBooked") {
                    echo "<p class='text-centre error-message'>You've already been to this villa. Why not chose another one?</p>";
                }
                else if($_GET["error"] == "doubleBooked") {
                    echo "<p class='text-centre error-message'>Sorry but this villa is already booked during those dates!</p>";
                } else if($_GET["error"] == "error") {
                    echo "<p class='text-centre error-message'>An error occured, please try again!</p>";
                }
            } //end of error message handling
 
            echo"        
                    </div>
                </div> 
            </section>";

            echo makeFooter();

        } else { //the user did not get to this page correctly and they are sent to the accommodation listing page
            header("location: accommodation.php");
            exit();
        }
    } else { //if the user is not logged in they are redirected to the login page
        header("location: login.php?error=booking");
        exit();
    }
?>