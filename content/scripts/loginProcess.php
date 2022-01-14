<?php 
/**
 * This script takes the user inputs from the login form and processes it using prepared statements to protect against SQL injection attacks. Once the data is processed the user is redirected back to the home page if logged in successfully or the login page to try again.
 */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData");

    //connect to database
    require_once('functions.php');
    $conn = getConnection();

    /*Gets the username and password from the login form */
    $username = array_key_exists('username', $_REQUEST)? $_REQUEST['username']: null;
    $password = array_key_exists('password', $_REQUEST)? $_REQUEST['password']: null;

    

    //get password hash from database for entered username
    $query = "SELECT passwordHash FROM users WHERE username = ?";

    $statement = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($statement, "s", $username);

    //execute
    mysqli_stmt_execute($statement);

    $queryResult = mysqli_stmt_get_result($statement);
    //turn result into assoc array
    $userRow = mysqli_fetch_assoc($queryResult);

    if ($userRow) {
        $passwordHash = $userRow['passwordHash'];
        if (password_verify($password, $passwordHash)) {
            session_start();
            $_SESSION['logged-in'] = true;
            $_SESSION['user'] = $username;
            header("location: ../index.php"); //redirect user to the homepage
            exit(); //stop script
        } 
        else {
            header("location: ../login.php?error=login"); //return to login page with error = login
            exit(); //stop script
        }
    }
    else {
        header("location: ../login.php?error=login"); //return to login page with error = login
        exit(); //stop script
    }
?>