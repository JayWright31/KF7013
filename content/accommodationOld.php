<?php
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); //set session folder location
    session_start(); //start a new session
    require_once('scripts/functions.php'); //link to the functions.php script file
    echo makePageHead("Accommodation"); //creates the html header and passes a <title> as an argument
    echo makeNavMenu(); //creates the navigation menu
    echo makeSplash("Luxury Made Easy", "
        <div>
            <p>
                Going on holiday can be stressful. Whether it's remembering everyone's passports or getting through security, the last thing you want on your holiday is to be stressed. You're here to unwind after all! So our villa comes with all the things you need to make your getaway as relaxing, stress-free as possible.
            </p>
        </div>
        <div>
            <p>
                Explore our beautiful villas below. You can also use the search options to find the best place for you.
            </p>
        </div>", "<img src='../assets/images/port.jpg' alt='The Nice port with yachts floating in the water' class='head-image'>");

    /*Get data from the database*/
    $conn = getConnection();
    $sql = "SELECT * FROM `accommodation`";
    $queryResult = mysqli_query($conn, $sql);
    
    /*Check that a result was returned and then cycle through each item in the list to build a list section */
    if($queryResult) {
        while ($currentRow = mysqli_fetch_assoc($queryResult)) {
            $idNumber = $currentRow['accommodationID'];
            $name = $currentRow['accommodation_name'];
            $description = $currentRow['description'];
            $price = $currentRow['price'];
            $location = $currentRow['location'];
            echo makeListSection($idNumber, $name, $description, $location);
        }
    }

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

?>