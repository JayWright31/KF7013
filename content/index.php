<?php
/**
 * This script creates the homepage. 
 */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); //set session folder location
    session_start(); //start a new session
    require_once('scripts/functions.php'); //link to the functions.php script file
    echo makePageHead("Villa La Nice | Home"); //create the html header and start the body. The page title is passed as an argument
    echo makeNavMenu(); //create the navigation menu

    /**
     * Each method makes a different section of the page. The first argument is the title of the section and the next two are the content for the left and right sides respetively
     */
    echo makeSplash("Your Mediterranean Paradise","
    <p>
        Located in the heard of the city, our villa is the perfect place for you and your family to take a well earned break. Take in the sights and explore the very best of French culture. Whether this is your first time in the city or you're a regular, there is plenty to do. Our villa is generously appointed with all the mod cons needed to make your stay divine.
    </p>
    <p>
        We look forward to welcoming you to our villa. To see the fantastic villas we offer, please click <a href='accommodation.php'>here.</a>
    </p>", "<img src='../assets/images/beach-night.jpg' alt='The Nice beach front at night' class='head-image'>"
    );
    
    echo sectionDark("Freedom and Flexibility", "
    <img src='../assets/images/villa-front.jpg' alt='Exterior of villa as seen from the pool'>", "
    <p>
        A villa holiday has something to suit every type of holdiay maker. Are you a lounge at the pool all day person or do you like to get out and explore? Maybe you're the type who likes to lie in until miday. Whatever you holidaying style, a villa hoiday is perfect for you.
    </p>
    <p>
        Enjoy the freedom to set your own itinerary. Do what you want when you want. With a villa holiday everything is in your hands. Sculpt the perfect relaxing holiday for your family.
    </p>
    ");

    echo sectionLight("Just Like Home", "
    <p>
        Hotels are corporate and generic. A villa feels like home because it is. It's your home away from home. Beautifully decorated 
    </p>
    <p>
        Why wake up at 8am to get the last of the scraps from breakfast when you can have breakfast whenever you want. Do you ever find that you can't eat anything off the menu? maybe you have a dietry requirement or just have fussy kids. With a self-catered villa you choose the menu.
    </p>", "
    <img src='../assets/images/villa-seating.jpg' alt='Ratton furniture in the shade over looking the pool'>
    ");

    echo startDarkSection();
    echo "
    <h3 class='ext-centre'>
        Pricing and Offers
    </h3>
    <p>
        A villa holiday doesn't have to break the bank. Our villa is competitivley priced to offer the best value experience for you and your family. Check out our autumn deals for a last minute getaway or maybe you want to get away next spring.
    </p>
    <div class='flex'>
        <div>
            <h3 class='text-centre'>
                Spring 2022, Summer 2022
            </h3>
            <p class='text-centre'>
                Prices start from £150 per person per night.
            </p>
        </div>
        <div>
            <h3 class='text-centre'>
                Family Discount
            </h3>
            <p class='text-centre'>
                Enjoy a 25% discount off your total cost when you book as a family on all our villas (2 adults and 2 children)
            </p>
        </div>
    </div>";
    echo endSection();

    echo startLightSection();
    echo "
    <h3 class='text-centre'>
        Reviews
    </h3>
    <div class='flex'>
        <div>
            <p>
                \"What a beautiful villa. We had such a great time. The amenites are top notch and the attention to detail really shows. We can't wait to come again next year.\"
            </p>
            <p>
                - Helen Williams
            </p>
        </div>
        <div>
            <p>
                \"We always wanted to visit Nice. We spent a lot of time looking for the perfect place to stay and kept coming back to Villa La Nice. The best thing is definitely the location. Being able to walk to the beach in just 5 minutes was great.\"
            </p>
            <p>
                - Frank Barnes
            </p>
        </div>
        <div>
            <p>
                \"Nothing short of perfect. The optional grocery package is definitely worth the money. Coming home from a day out to a fully stocked fridge doesn't seem like a big thing but having been caught out in the past it was well worth it.\"
            </p>
            <p>
                - Gillian Pearson
            </p>
        </div>
    </div>";
    echo endSection();
    echo makeFooter(); //create the footer
?>