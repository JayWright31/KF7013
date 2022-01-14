<?php
/**
 * This script creates a registration page where new users can register for an account. The page also uses custom error handlers to display useful information to the user
 */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); //set session folder location
    session_start(); //start a new session
    require_once('scripts/functions.php'); //link to the functions.php script file
    echo makePageHead("Sign Up"); //create the html header and start the body. The page title is passed as an argument
    echo makeNavMenu();//create the navigation menu
 ?>
    
        <section class="form-section background-dark">
            <div class="flex">
                <div class="form-container">
                    <h2 class="text-centre">Register For A New Account</h2>
                    <form action="scripts/registerProcess.php" method="POST" id="register-form">
                        <label for="firstname">First Name</label>
                        <input id="firstname" type="text" name="firstname" placeholder="First Name">

                        <label for="surname">Surname</label>
                        <input id="surname" type="text" name="surname" placeholder="Surname">

                        <label for="username">Username</label>
                        <input id="username" type="text" name="username" placeholder="Username">

                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Password">

                        <label for="confirmPassword">Confirm Password</label>
                        <input id="confirmPassword" type="password" name="confirmPassword" placeholder="Confirm Password">

                        <button id="submit-button" type="submit" name="submit">Register!</button>
                    </form>

                    <?php
                        /* Displays the error messages from the error handling methods by using the $_GET superglobal to retrieve custom error messages */
                        if(isset($_GET["error"])) {
                            if($_GET["error"] == "blankfield") {
                                echo "<p class='text-centre error-message'>All boxes must be filled in!</p>";
                            }
                            else if($_GET["error"] == "namecharerror") {
                                echo "<p class='text-centre error-message'>Firstname and Surname should contain only letters, Username can have numbers!</p>";
                            }
                            else if($_GET["error"] == "usernametaken") {
                                echo "<p class='text-centre error-message'>This username is already taken, please choose another one!</p>";
                            }
                            else if($_GET["error"] == "password") {
                                echo "<p class='text-centre error-message'>Passwords do not match!</p>";
                            }
                            else if($_GET["error"] == "error") {
                                echo "<p class='text-centre error-message'>An error occured, please try again!</p>";
                            }
                            else if($_GET["error"] == "success") {
                                echo "<p class='text-centre error-message'>Thank you for registering. Click <a href= 'login.php'>HERE</a> to login!</p>";
                            }
                        }
                    ?>
                </div>
            </div> 
        </section>

 <?php
    echo makeFooter();
?>