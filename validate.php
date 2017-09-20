<?php
    session_start();
    
    // If "Retry" button is pressed
    if(isset($_POST['retry'])){
        sleep(10); // delay page load by 10 seconds
        unset($_SESSION['userAuth']); // unset userAuth variable to load clean page
        header('Location:index.php');
    }
    
    // If "Logout" button is pressed
    if(isset($_POST['logout'])){
        // Unset/destroy session data
        session_unset();
        session_destroy();
        header('Location:index.php'); // redirect back to login page
    }
    
    // Check if form POST variables are set
    if(isset($_POST['username'])){
        if(isset($_POST['password'])){
            $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            // Ensure $_POST variables are reset with each page load
            unset($_POST['username']);
            unset($_POST['password']);
        }
    }
    
    // Authentication function
    function authenticate($user, $pass){
        $auth = false; // sets/resets $auth variable
        $validUsers = array("admin", "greg"); // valid usernames
        $validPass = array("qwerty", "admin"); // valid passwords, aligned with usernames
        for($i = 0; $i < count($validUsers); $i++){
            if($user == $validUsers[$i]){ // if valid username used
                $j = $i;
                if($pass == $validPass[$j]){ // if valid user/pass combo used
                    $auth = true;
                }
            }
        }
        return $auth;
    }    
    
        // Authenticate user/pass combo
    if(isset($user)){
        if(isset($pass)){
            $isValid = authenticate($user, $pass); // auth function call
            if($isValid == true){ // if user is authenticated
                $_SESSION['userAuth'] = 'valid';
                $_SESSION['user'] = $user;
            } else { // if user is not authenticated
                /*
                 * The following portion maintains a counter that persists
                 * across sessions, iterating one higher with each pass. If,
                 * after 4 unsuccessful login attempts, the user selects to 
                 * retry once more, the userAuth variable is reset, but the
                 * counter variable is not, meaning the delay will continually
                 * get longer and longer and each attempt after #4 will require
                 * the user to select "Retry" which itself comes with a 10
                 * second delay.
                */
                $iterate = 1;
                if(!isset($_SESSION['counter'])){
                    $_SESSION['counter'] = 1;
                } else {
                    $_SESSION['counter'] += $iterate;
                }
                if($_SESSION['counter'] >= 4){
                    $_SESSION['userAuth'] = 'kill';
                } else {
                    $_SESSION['userAuth'] = 'invalid';
                }
                // delay program execution based on number of attempts
                $delay = $_SESSION['counter'];
                sleep($delay);
                header('Location:index.php');
            }
        }
    }
    
    // Check if Captcha is Entered Correctly
    if(isset($_POST["captcha"]) && $_POST["captcha"] != "" 
            && $_SESSION["code"] == $_POST["captcha"] 
            && $_SESSION['userAuth'] == 'valid'){
        $_SESSION['validSession'] = true;
        header('Location:index.php');
    } else {
        $_SESSION['validSession'] = false;
        if ($_SESSION['userAuth'] != 'kill'){
            $_SESSION['userAuth'] = 'invalid';
        } else {
            $_SESSION['userAuth'] = 'kill';
        }
        header('Location:index.php');
    }
?>