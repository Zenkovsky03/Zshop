<?php
    session_start();
    //! zabezpieczenie jeśli jesteśmy zalogowani i przejdziemy do formularza do logowania to przeniesie nas do panelu gdzie mozemy sie wylogowac
    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == True ){
        header("Location: panel.php");
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Logowania</title>
    <link rel="stylesheet" href="polstyl.css">
</head>
<body>
    <!-- //!PANEL LOGOWANIA -->
    <!-- <form action="login.php" method="POST">
        <input type="text" name="login" placeholder="Login"><br>
        <input type="password" name="pass" placeholder="Hasło"><br>
        <input type="submit" name="" value="Zaloguj"><br>
    </form> -->
    <div class="login">
            <h2 class="login-header">Login panel</h2>
        <form class="login-container" action="login.php" method="POST">
            <p><input type="text" placeholder="Username" name = "login"></p>
            <p><input type="password" placeholder="Password" name = "pass"></p>
            <p><input type="submit" value="Log in"></p>
        </form>
    </div>
    <?php
        //!komunikaty o błędach i o wylogowaniu
        if(isset($_SESSION['error'])){
            echo '<p id="blad">'.$_SESSION["error"].'</p>';
            unset($_SESSION['error']);
        }
    ?>
</body>
</html>