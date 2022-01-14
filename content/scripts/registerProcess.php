<?php
/**
* This script takes the user inputs from the register form and processes it using prepared statements to protect against SQL injection attacks. Once the data is processed the user is shown a success message and shown a link to take them to the login page.
*/

    /*Checks that the script was called by the submit button and not the user typing the script address into the URL bar */
    if (isset($_POST["submit"])) {
        /*Get connection to database from the functions.php file */
        require_once('functions.php');
        $conn = getConnection();
        //require_once('registerFunctions.php');

        //get the user data from the form
        $firstname = array_key_exists('firstname', $_REQUEST)? $_REQUEST['firstname']: null;
        $surname = array_key_exists('surname', $_REQUEST)? $_REQUEST['surname']: null;
        $username = array_key_exists('username', $_REQUEST)? $_REQUEST['username']: null;
        $password = array_key_exists('password', $_REQUEST)? $_REQUEST['password']: null;
        $confirmPassword = array_key_exists('confirmPassword', $_REQUEST)? $_REQUEST['confirmPassword']: null;

        //trim whitespace from entries
        $firstname = trim($firstname);
        $surname = trim($surname);
        $username = trim($username);
        $password = trim($password);
        $confirmPassword = trim($confirmPassword);

        /*Calls to error handling functions to verify the validity of the data entered by the user */
        //checks that all the fields have been filled out
        if (blankField($firstname, $surname, $username, $password, $confirmPassword) !== false) {
            header("location: ../register.php?error=blankfield"); //return to register with error set to blankfield
            exit(); //stop script
        }
        //checks that the firstname, surname, and username only contain valid characters
        if (nameCharacterError($firstname, $surname, $username) !== false) {
            header("location: ../register.php?error=namecharerror"); //return to register with error set to username
            exit(); //stop script
        }
        //checks that the username hasn't already been taken
        if (usernameTaken($conn, $username) !== false) {
            header("location: ../register.php?error=usernametaken"); //return to register with error set to username
            exit(); //stop script
        }
        //checks that the passwords entered match
        if (passwordsMatch($password, $confirmPassword) !== false) {
            header("location: ../register.php?error=password"); //return to register with error set to password
            exit(); //stop script
        }

        /*If no errors were thrown then the user can be registered */
        createNewUser($conn, $firstname, $surname, $username, $password);
        
    }

    /*If the user reached the script incorrectly, they are redirected to the sign up page */
    else {
        header("location: ../register.php");
        exit(); //stop script
    }

/**
* These are the methods used for registering a new user
*/

    /*Function for checking all of the fileds have been filled out by using inbuild PHP empty() method */
    function blankField($firstname, $surname, $username, $password, $confirmPassword) {
        $isError;
        if(empty($firstname) || empty($surname) || empty($username) || empty($password) || empty($confirmPassword)) {
            $isError = true;
        } else {
            $isError = false;
        }
        return $isError;
    }

    /*Function for checking that the firstname and surname only contain the letters a-z and A-Z */
    function nameCharacterError($firstname, $surname, $username) {
        $isError;
        if(!preg_match("/^[a-zA-Z]*$/", $firstname) || !preg_match("/^[a-zA-Z]*$/", $surname) || !preg_match("/^[a-zA-Z0-9]*$/", $username)) { //uses preg_match to check through all characters
            $isError = true;
        } else {
            $isError = false;
        }
        return $isError;
    }

    /*Function for checking the passwords entered match */
    function passwordsMatch($password, $confirmPassword) {
        $isError;
        if($password !== $confirmPassword) {
            $isError = true;
        } else {
            $isError = false;
        }
        return $isError;
    }

    /*Function for checking whether the entered username has been taken already using a prepared statement to protect against SQL injection attacks */
    function usernameTaken($conn, $username) {
        $query = "SELECT * FROM users WHERE username = ?;"; //statement ready for prepared statement
        $statement = mysqli_stmt_init($conn); //initialise new prepared statement

        if(!mysqli_stmt_prepare($statement, $query)) { //checks for errors in the SQL statement
            header("location: ../register.php?error=error");
            exit(); //stop script
        }

        mysqli_stmt_bind_param($statement, "s", $username); //bind username data to the statment to replace placeholder
        mysqli_stmt_execute($statement); //execute SQL query

        $getResult = mysqli_stmt_get_result($statement);

        if(mysqli_fetch_assoc($getResult)) {}
        else {
            $result = false;
            return $result;
        }

        mysqli_stmt_close($statement); //close statement
    }

    /*Function for creating a new user using the data entered with prepared statement to protect against SQL inject attacks */
    function createNewUser($conn, $firstname, $surname, $username, $password) {
        $query = "INSERT INTO users (firstname, surname, username, passwordHash) VALUES (?, ?, ?, ?);"; //statement ready for prepared statement
        $statement = mysqli_stmt_init($conn); //initialise new prepared statement

        if(!mysqli_stmt_prepare($statement, $query)) { //checks for errors in the SQL statement
            header("location: ../register.php?error=error");
            exit(); //stop script
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT); //creates a hash of the password

        mysqli_stmt_bind_param($statement, "ssss", $firstname, $surname, $username, $passwordHash); //bind username data to the statment to replace placeholder
        mysqli_stmt_execute($statement); //execute SQL query
        mysqli_stmt_close($statement); //close statement

        //return user to register page with error = success
        header("location: ../register.php?error=success");
        exit(); //stop script
    }
?>