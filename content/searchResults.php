<?php
/**
 * This script processes the search request and shows the results. The layout of this page is identical to the accommodation listing page but with only the matching villas shown
 */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); //set session folder location
    session_start(); //start a new session
    require_once('scripts/functions.php'); //link to the functions.php script file
    $conn = getConnection(); //establish a connection with the database and save as $conn

    //gets the data from the search form and saves as variables for use in the processing script
    if(isset($_POST['searchSubmit'])) {
        $searchQuery = $_POST['searchBar'];
        $priceSearch = $_POST['priceSearch'];
        $priceValue = $_POST['priceValue'];
    }

    //functions called for the reletive searches
    isSearch($searchQuery, $priceSearch);
    priceIsNumber($priceSearch);



    echo makePageHead("Accommodation"); //creates the html header and passes a <title> as an argument
    echo makeNavMenu(); //creates the navigation menu
    
    echo "
        <section class='background-dark'>
            <div class='container'>
                <h2 class='text-centre'>Luxury Made Easy</h2>
            </div>
            <div class='container'>
                <p>
                    Going on holiday can be stressful. Whether it's remembering everyone's passports or getting through security, the last thing you want on your holiday is to be stressed. You're here to unwind after all! So our villa comes with all the things you need to make your getaway as relaxing, stress-free as possible.
                </p>
                <p>
                    Explore our beautiful villas below. You can also use the search options to find the best place for you.
                </p>
            </div>
        </section>
    ";

    //the function for the search which will echo out the list of search results
    echo search($conn, $searchQuery, $priceSearch, $priceValue);
    
    echo "<section>
        <div class='container'>
            <h2 class='text-centre'>
                Extras
            </h2>
            <p>
                We also offer a fantastic selection of add-ons that you can select to make your stay even more comfortable. Let us know if you'd like to add any of our fantastic extras onto your reservation.
            </p>
            <div class='flex'>
                <div class='square'>
                    <h3 class='text-centre'>
                        Fully Stocked Fridge
                    </h3>
                    <p>
                        Don't feel like shopping for milk and bread? We can make sure your fridge is fully stocked before you arrive and keep it stocked during your stay. 
                    </p>
                    <p>
                        - £100
                    </p>
                </div>
                <div class='square'>
                    <h3 class='text-centre'>
                        House Keeping
                    </h3>
                    <p>
                        Make your stay even more relaxing by choosing our house keeping service. If you don't feel like making your bed we can take care of that for you. 
                    </p>
                    <p>
                        - £50
                    </p>
                </div>
            </div>
            <div class='flex'>
                <div class='square'>
                    <h3 class='text-centre'>
                        Chef
                    </h3>
                    <p>
                        While one of the great benefits to a villa holiday is privacy and doing things your own way, sometimes you don't feel like cooking. We've partnered with some great local chefs who will happily cook a gorgeous 3 course meal for you on one of your nights. So whether you want a romantic dinner for two, or just don't want to cook on that first night, we've got you covered.
                    </p>
                    <p>
                        - £75
                    </p>
                </div>
                <div class='square'>
                    <h3 class='text-centre'>
                        Last Minute Cancellation Protection
                    </h3>
                    <p>
                        We understand that sometimes plans have to change. With our cancellation protection you can cancel up to 24 hours in advance and get a full refund (minus the cost of cancellation protection).
                    </p>
                    <p>
                        - £150
                    </p>
                </div>
            </div>
        </div>
    </section>";

    echo makeFooter(); //creates the footer

    /**
     * Functions for processing the search requests
     */

     //function for checking that a search query has been entered
     function isSearch($searchQuery, $priceSearch) {
         if (empty($searchQuery) && empty($priceSearch)) {
             header ("location: accommodation.php?error=noSearch");
             exit(); //stop script
         }
     }

     //function to validate if the user entered numbers or letters into the price search box. Is only called if data is entered
     function priceIsNumber($priceSearch) {
        if (!empty($priceSearch)) {
           if (!is_numeric($priceSearch)) {
               header ("location: accommodation.php?error=pricenNotNumber");
               exit(); //stop script
           }
       }
    }

     /**
      * Function for searching the database based on the queries entered by the user. IF ELSE statements produce different SQL query statements based on which configuration of search paramaters is used
      */
     function search($conn, $searchQuery, $priceSearch, $priceValue) {

        /**
         * If user is searching by text and price at the same time
         */
        if (!empty($searchQuery) && !empty($priceSearch)) {

            //if the price is less than
            if($priceValue == 0) {
                $query = "SELECT * FROM `accommodation` WHERE (`accommodation_name` LIKE concat('%', ?, '%') or `description` LIKE concat('%', ?, '%') OR `price` LIKE concat('%', ?, '%') OR `location` LIKE concat('%', ?, '%')) AND (`price` <= ?)"; //statement ready for prepared statement
            } 
            
            //if the price is more than
            else if($priceValue == 1) {
                $query = "SELECT * FROM `accommodation` WHERE (`accommodation_name` LIKE concat('%', ?, '%') or `description` LIKE concat('%', ?, '%') OR `price` LIKE concat('%', ?, '%') OR `location` LIKE concat('%', ?, '%')) AND (`price` >= ?)"; //statement ready for prepared statement
            }

            $statement = mysqli_stmt_init($conn); //initialise new prepared statement

           if(!mysqli_stmt_prepare($statement, $query)) { //checks for errors in the SQL statement
               header("location: index.php"); //if an error occured the user is redirected to the homepage
               exit(); //stop script
           }

           mysqli_stmt_bind_param($statement, "ssssi", $searchQuery, $searchQuery, $searchQuery, $searchQuery, $priceSearch); //bind search query to placeholders
        } //end of dual search
        
        /**
         * If only searching based on price
         */
        else if (empty($searchQuery) && !empty($priceSearch)) {

            //if price is less than
            if($priceValue == 0) {
                $query = "SELECT * FROM `accommodation` WHERE `price` <= ?"; //statement ready for prepared statement
            } 
            
            //if price is more than
            else if($priceValue == 1) {
                $query = "SELECT * FROM `accommodation` WHERE `price` >= ?"; //statement ready for prepared statement
            }

            $statement = mysqli_stmt_init($conn); //initialise new prepared statement

            if(!mysqli_stmt_prepare($statement, $query)) { //checks for errors in the SQL statement
            echo "statement issue";
            exit(); //stop script
            }

            mysqli_stmt_bind_param($statement, "i", $priceSearch); //bind search query to placeholders

        } //end of price search

        /**
         * If only searching by text
         */
        else if (!empty($searchQuery) && empty($priceSearch)) {
            $query = "SELECT * FROM `accommodation` WHERE `accommodation_name` LIKE concat('%', ?, '%') or `description` LIKE concat('%', ?, '%') OR `price` LIKE concat('%', ?, '%') OR `location` LIKE concat('%', ?, '%')"; //statement ready for prepared statement

            $statement = mysqli_stmt_init($conn); //initialise new prepared statement

            if(!mysqli_stmt_prepare($statement, $query)) { //checks for errors in the SQL statement
                echo "statement issue";
                exit(); //stop script
            }

            mysqli_stmt_bind_param($statement, "ssss", $searchQuery, $searchQuery, $searchQuery, $searchQuery); //bind search query to placeholders
        } //end of text search

           mysqli_stmt_execute($statement); //execute SQL query

           $getResult = mysqli_stmt_get_result($statement);
           $rowCount = mysqli_num_rows($getResult);

           if($getResult && $rowCount !=0) {
               while ($currentRow = mysqli_fetch_assoc($getResult)) {
                   $idNumber = $currentRow['accommodationID'];
                   $name = $currentRow['accommodation_name'];
                   $description = $currentRow['description'];
                   $price = $currentRow['price'];
                   $location = $currentRow['location'];
                   //sanitise results
                    $idNumber = filter_var($idNumber, FILTER_SANITIZE_NUMBER_INT);
                    $name = filter_var($name, FILTER_SANITIZE_STRING);
                    $description = filter_var($description, FILTER_SANITIZE_STRING);
                    $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $location = filter_var($location, FILTER_SANITIZE_STRING);
                   echo makeListSection($idNumber, $name, $description, $location, $price);
               }
           } else {
               header ("location: accommodation.php?error=noResults");
               exit();
           }
    }

?>