<?php
/**
 * The methods below create different page elements when called as well as houses some utility methods
 */

 //creates the html <head> tag and uses the $pageTitle argument to set the <title> text
function makePageHead($pageTitle) {
    $headContent = <<<HEADSTART
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/stylesheets/stylesheet.css?v=11">
        <link href="https://fonts.googleapis.com/css2?family=Italianno&family=Lato:wght@300&family=Noto+Serif&display=swap" rel="stylesheet">
        <title>$pageTitle</title>
    </head>
    <body>
HEADSTART;
    $headContent .="\n";
    return $headContent;
}

//creates the navigation menu 
function makeNavMenu() {
    $navContent = "
    <header class='background-light text-centre'>
       <div class='heading'>
           <div>
                <h1>
                    Villa La Nice
                </h1>
                <p>Luxury French Villas</p>
            </div>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href='index.php'>Home</a></li>
            <li><a href='accommodation.php'>Accommodation</a></li>
            ";
    //checks to see if there is a current session, if so then the user is logged in so the Logout and Book links can be shown
    if(isset($_SESSION['user'])) {
        $navContent .= "
            <li><a href='scripts/logout.php'>Logout</a></li>";
    } else { //if the user is not logged in then they are shown links to either register for a new account or login to an existing account
        $navContent .= "
            <li><a href='register.php'>Register</a></li>
            <li><a href='login.php'>Login</a></li>";
    }
    $navContent .= "
        </ul>
    </nav>
    <main>";
    $navContent .= "\n";
    return $navContent;
}

//creates the full width splash image with heading, paragraph text, and image link passed as the respective arguments
function makeSplash($splashHeadText, $splashPara, $splashImage) {
    $content = <<<SPLASH
    <section>
        <div class="main-splash">
            $splashImage
            <h2 class="text-centre">
                $splashHeadText
            </h2>
        </div>

        <div class="container">
            <div class="flex">
                <div>
                    $splashPara
                </div>
            </div>
        </div>
    </section>
SPLASH;
    $content .="\n";
    return $content;
}

//creates a stand alone dark section with the header, left content, and right content passed as the respective arguments. Useful for simple two column sections
function sectionDark ($headText, $leftContent, $rightContent) {
    $content = <<<MAINCONTENT
    <section class="background-dark">
            <div class="container">
                <h3 class="text-centre">
                    $headText
                </h3>
                <div class="flex">
                    <div>
                        $leftContent
                    </div>
                    <div>
                        $rightContent
                    </div>
                </div>
            </div>
        </section>
MAINCONTENT;
    $content .="\n";
    return $content;
}

//creates a stand alone light section with the header, left content, and right content passed as the respective arguments. Useful for simple two column sections
function sectionLight($headText, $leftContent, $rightContent) {
    $content = <<<MAINCONTENT
    <section class="background-light">
            <div class="container">
                <h3 class="text-centre">
                    $headText
                </h3>
                <div class="flex">
                    <div>
                        $leftContent
                    </div>
                    <div>
                        $rightContent
                    </div>
                </div>
            </div>
        </section>
MAINCONTENT;
    $content .="\n";
    return $content;
}

//creates a stand alone section for the accommodation lists
function makeListSection($idNumber, $villaName, $villaDescription, $location, $price) {
    $content = <<<MAINCONTENT
    <section class="list-section">
        <div class="list-container">
            <div class="flex">
                <div>
                    <img src='../assets/images/villa$idNumber.jpg' alt='Villa header image'/>
                </div>
                <div>
                    <h3 class="text-centre">$villaName - $location</h3>
                    <p>£$price per night
                    <p>$villaDescription</p>
                    <a href= "details.php?villa=$idNumber" class="list-link">Click here for more details</a>
                </div>
            </div>
        </div>
    </section>

MAINCONTENT;
    $content .="\n";
    return $content;
}

//creates the footer
function makeFooter() {
    $content = <<<MAKEFOOTER
    </main>
    <footer>
        <div class="container flex">
            <div>
                <h3 class="text-centre">EXPLORE</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="accommodation.php">Accommodation</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="credits.php">Credits</a></li>
                    <li><a href="security.php">Security Report</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-centre">VISIT</h3>
                <ul>
                    <li>123 Le Street</li>
                    <li>Nice</li>
                    <li>France</li>
                    <li>AB12 3CD</li>
                </ul>
            </div>
            <div>
                <h3 class="text-centre">CONTACT</h3>
                <ul>
                    <li>Tel: 01234 56789</li>
                    <li>email: info@villanice.com</li>
                </ul>
            </div>
        </div>
        <p class="copyright text-centre">
            Copyright 2021. This website has been created as part of a University assignment. This is not a real holiday villa.
        </p>
    </footer>
MAKEFOOTER;
    $content .= "\n";
    return $content;
}

//starts an empty dark section where HTML can be placed after the call to this method to create more complex section layouts
function startDarkSection() {
    $content = <<<SECTION
    <section class="background-dark">
            <div class="container">
SECTION;
    $content .="\n";
    return $content;
}

//starts an empty light section where HTML can be placed after the call to this method to create more complex section layouts
function startLightSection() {
    $content = <<<SECTION
    <section class="background-light">
            <div class="container">
SECTION;
    $content .="\n";
    return $content;
}

//closes a section
function endSection() {
    $content = <<<SECTION
    </div>
        </section>
SECTION;
    $content .="\n";
    return $content;
}

//connects to the database and saves the msqli command as $conn which can be used on any page to establish a connection to the database
function getConnection() {
    define('DB_NAME', 'unn_w19031546');
    define('DB_USER', 'unn_w19031546');
    define('DB_PASSWORD', 'webdev123');
    define('DB_HOST', 'localhost');
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or
    die("Could not connect to database");
    return $conn;
}

//checks that the user login credentials are correct
function checkLogin() {
    if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
        return true;
    } else {
        return false;
    }
}
?>
