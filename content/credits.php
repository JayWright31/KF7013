<?php
/**
 * This script creates a credits page where all the images used on this website are credited to their original creators. Only images are propery of 3rd parties. All code, scripts, and web content are original to me
 */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); //set session folder location
    session_start(); //start a new session
    require_once('scripts/functions.php'); //link to the functions.php script file
    echo makePageHead("Credits"); //creates the html header and passes a <title> as an argument
    echo makeNavMenu(); //creates the navigation menu
    echo startLightSection();
    ?>
        <h2 class="text-centre">Credits</h2>
        
        <div class="flex">
            <div>
                <img src="../assets/images/beach-night.jpg" alt="Image of the Nice beach at night">
                <p>Blache, P., 2019. Nice beach at night [image] Available at: https://pixabay.com/photos/nice-france-sea-mediterranean-4519328. [image].></p>
            </div>
            <div>
            <img src="../assets/images/villa-front.jpg" alt="Exterior of villa as seen from the pool">
                <p>Vetsikas, D., 2017. Villa overlooking pool [image] Available at: https://pixabay.com/photos/villa-architecture-house-design-2375137</p>
            </div>
        </div>

        <div class="flex">
            <div>
                <img src="../assets/images/villa-seating.jpg" alt="Ratton furniture in the shade over looking the pool">
                <p>panoramicvillacosta., 2017. Furniture by pool [image] Available at: https://pixabay.com/photos/villa-backyard-holiday-villa-2366293</p>
            </div>
            <div>
            <img src='../assets/images/port.jpg' alt='The Nice port with yachts floating in the water'>
                <p>Blache, P., 2020. Yachts on the water. [image] Available at: https://pixabay.com/photos/nice-france-boats-sea-5333868</p>
            </div>
        </div>

        <div class="flex">
            <div>
            <img src='../assets/images/villa-twin.jpg' alt='Spacious twin bedroom with beds pushed together'>
                <p>Lachmann-Anke, P. and Lachmann-Anke, M., 2019. Kingsize double room [image] Available at: https://pixabay.com/photos/inner-space-hotel-rendering-102644</p>
            </div>
            <div>
            <img src='../assets/images/port.jpg' alt='The Nice port with yachts floating in the water'>
                <p>Erotokritou, S., 2016. Twin bedroom. [image] Available at: https://pixabay.com/photos/bedroom-hotel-interior-1737167.</p>
            </div>
        </div>

        <div class="flex">
            <div>
            <img src='../assets/images/villa-kitchen.jpg' alt='Modern kitchen in villa'>
                <p>n.d. Modern kitchen. [image] Available at: https://pxhere.com/en/photo/1273590</p>
            </div>
            <div>
            <img src='../assets/images/villa-pool.jpg' alt='Villa pool on beautiful sunny day'>
                <p>Hou, D., 2018. Pool with plants in front of camera. [image] Available at: https://pixabay.com/photos/swimming-pool-summer-holiday-relax-3652690</p>
            </div>
        </div>

<?php
    echo endSection(); //close the opened section
    echo makeFooter(); //create the footer
?>