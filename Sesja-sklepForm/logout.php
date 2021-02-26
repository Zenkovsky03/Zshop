<?php
    session_start();
    //! zabezpiecznie czy jestem zalogowany
    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == True){
        // unset($_SESSION['zalogowany']);//! dla bezpieczeństwa jeszcze unset
        // unset($_SESSION['login']);
        //$_SESSION['error'] = "Zostałeś wylogowany";
        session_destroy();
        header('Location: form-log.php');

    }
    else{
        $_SESSION['error'] = "Proszę się zalogować";
        header('Location: form-log.php');
    }
?>