<?php
   ini_set('session.cookie_httponly', 1);
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="styles/styles.css" rel="stylesheet" type="text/css"/>
        <title>Excessive Authentication Attempts - Fixed</title>
    </head>
    <body>
        <?php
            // First Time Accessing Login Page
            if(!isset($_SESSION['userAuth'])){
                // a CAPTCHA is used to prevent automated attacks
        ?>
        <div class="login"> 
            <h2>Enter Your Login Credentials</h2>
            <form action="validate.php" method="post" name="login">
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" size="20" autocomplete="off"><br><br>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" size="20"><br><br>
                <label>Enter Numbers Shown</label><br>
                <img src="captcha.php" alt="captcha"><br>
                <input name="captcha" type="text" size="5" style="text-align: center" autocomplete="off"><br><br>
                <input type="submit" name="submit" value="Login">
            </form>
        </div>
        <?php
            // After Too Many Failed Login Attempts
            } elseif ($_SESSION['userAuth'] == 'kill'){
        ?>
        <div class="login">
            <h2>Too many login attempts. Please wait.</h2>
            <form action="validate.php" method="post" name="reset">
                <input type="submit" name="retry" value="Retry">
            </form>
        </div>
        <?php
            // After Failed Login Attempt
            } elseif ($_SESSION['userAuth'] == 'invalid'){
        ?>
        <div class="login">
            <h2>Enter Your Login Credentials</h2>
            <h3>Invalid login attempt</h3>
            <form action="validate.php" method="post" name="login">
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" size="20" autocomplete="off"><br><br>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" size="20"><br><br>
                <label>Enter Numbers Shown</label><br>
                <img src="captcha.php" alt="captcha"><br>
                <input name="captcha" type="text" size="5" style="text-align: center" autocomplete="off"><br><br>
                <input type="submit" name="submit" value="Login">
            </form>
        </div>
        <?php 
            // If User Successfully Logs In
            } elseif ($_SESSION['validSession'] == true){
        ?>
        <div class="login">
            <h2>You are currently logged in as <?php echo $_SESSION['user'];?>.</h2>
            <form action="validate.php" method="post" name="reset">
                <input type="submit" name="logout" value="Log Out">
            </form>
        </div>
        <?php
            }
        ?>
    </body>
</html>

