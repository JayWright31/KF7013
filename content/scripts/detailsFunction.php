<?php
    /**
     * The scripts in this file are used to populate the accommodation details page with information about the accommodation selected from the list.
     */
    require_once('scripts/functions.php'); //link to the functions.php script file

    //creates the different sections that are used to build the page
function makePageContent($villaName, $villaNumber) {
                $splash = makeSplash("$villaName", "
                    <div>
                        <p>
                            Going on holiday can be stressful. Whether it's remembering everyone's passports or getting through security, the last thing you want on your holiday is to be stressed. You're here to unwind after all! So our villa comes with all the things you need to make your getaway as relaxing, stress-free as possible.
                        </p>
                    </div>
                    <div>
                        <p>
                            By staying with us you're getting access to over 20 years of hospitality experience. We've tried to include as much as possible in the price but understand that some people need that little extra help. Scroll down to view the fantastic facilities we have on offer and to see what extras we can do for you. Of course, if there's anything else you need don't hesitate to get in touch and we'll do our best to help you.
                        </p>
                        <p>
                            <a href='book.php?villa=$villaNumber'>Click here to see availability</a>
                        </p>
                    </div>", "<img alt='The Nice port with yachts floating in the water' class='head-image' src='../assets/images/villa$villaNumber.jpg'>");

                    
            
                    $sectionOne = sectionLight("The Master Suite", "
                        <p>
                            Each villa comes with a generous master suite. Each master suite comes with a kingsize bed and its own en suite. Luxury bed linen is included and will be freshly made ready for your arrival.
                        </p>", "<img src='../assets/images/villa-bedroom.jpg' alt='Beautiful master bedroom with kingsize bed'>");
            
                    $sectionTwo = sectionDark("The Twin Room", "<img src='../assets/images/villa-twin.jpg' alt='Spacious twin bedroom with beds pushed together'>", "
                        <p>
                            All our villas have two bedrooms, perfect for families or groups of friends. The second bedroom features two twin beds perfect for anyone who doesn't want to share! The room is finished to the same level of detail and quality as the master so no one feels short changed. There's space for an additional cot for any little guests that are staying with you.
                        </p>");
                    
                    $sectionThree = sectionLight("The Lounge and Kitchen", "
                        <p>
                            Part of going on holiday is spending time together as a family. We know you'll love spending those cosy nights in the beautiful lounge, perhaps with a drink or two. Each villa has a huge TV with a high speed internet connection so you can stream all your favourite films and TV shows in the highest quality.
                        </p>
                        <p>
                            When you're on holiday you don't want to be worrying about the washing up, or running out of clean socks. Our villa comes with all the comforts of home, including a dishwasher and laundry facilities.
                        </p>", "<img src='../assets/images/villa-kitchen.jpg' alt='Modern kitchen in villa'>");
            
                    $sectionFour = sectionDark("The Pool", "<img src='../assets/images/villa-pool.jpg' alt='Villa pool on beautiful sunny day'>", "
                        <p>
                            Cool down on those hot days with a dip in your very own private pool. No need to reserve your sun bed with a towel either. Some of our villas even have an infinity pool!
                        </p>");
            
                    $content = $splash.$sectionOne.$sectionTwo.$sectionThree.$sectionFour;
                    return $content;
            }




?>