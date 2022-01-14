<?php
/**
 * This script creates a login page that allows registered users to log in to the website. Custom error handlers are used to relay information about unsuccessful logins to the user
 */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData");
    session_start(); //start a new session
    require_once('scripts/functions.php'); //link to the functions.php script file
    echo makePageHead("Login | Register"); //create the html header and start the body. The page title is passed as an argument
    echo makeNavMenu(); //create the navigation menu

?>
    <section class="form-section background-dark">
        <div class="flex">
            <div class="form-container">
                <h2 class="text-centre">Login</h2>
                <form action="scripts/loginProcess.php" method="POST">
                    <label for="loginUsername">Username</label>
                    <input id="loginUsername" type="text" name="username">
                    
                    <label for="loginPassword">Password</label>
                    <input id="loginPassword" type="password" name="password">
                    
                    <input type="submit" value="Logon">
                </form>

                <?php
                /**
                 * Displays the error messages from the error handling methods by using the $_GET superglobal to retrieve custom error messages
                 */
                if(isset($_GET["error"])) {
                    if($_GET["error"] == "login") {
                        echo "<p class='text-centre error-message'>Username or Password Incorrect!</p>";
                    } else if($_GET["error"] == "booking") {
                        echo "<p class='text-centre error-message'>Please first login or register for an account to book with us.</p>";
                    }
                }             
                ?>
                
                <p class="text-centre">If you don't already have an account click <a href="register.php">HERE</a> to create one.</p>
            </div>
        </div>

        
    </section>
<?php
    echo makeFooter();
?>
