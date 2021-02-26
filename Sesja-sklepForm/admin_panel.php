<?php
    session_start();
    //! sprawdzenie czy uzytkownik jest zalogowany
    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == True && $_SESSION['admin'] == True ){
        // echo "witaj<br>";
        // echo "Adminie<br>";
        // echo "<a href = 'admin-logout.php'>Wyloguj się</a><br>";
        require("db-connect.php");//! Implementacja parametrów połączenia z bazą
        require("CRUD-class.php");//! Implementacja klasy CRUD z innego pliku
        $myCRUD = new CRUD();//! Tworzenie obiektu myCRUD
        echo $myCRUD->polacz($host,$user,$pass,$db);//! Test funkcji wyswietlajacej stan polaczenia
        $myCRUD->dispacher($_POST);//! Obsługa formularzy
    ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny</title>
    <link rel="stylesheet" href="styleADM.css">
</head>
<body>
    <div id = "main-page">
        <div id = "side-bar">
            <div id = "logo">
                <h1>ZShop</h1>
            </div>
            <div id = "options">
                <a href = 'admin-logout.php'>Wyloguj się</a><br><br>
                <a href = 'admin-panel2.php'>Użytkownicy</a><br>
            </div>
        </div>
        <header>
            <div id = "name">
                <h1>Panel Administracyjny</h1>
            </div>
            <div id = "info">
                <?php
                    echo "Login: ".'<p>'.$_SESSION["login"].'</p';
                ?>
            </div>
        </header>
        <div id = "content">
            <div id = "functions">
                <div id = "table">
                    <?php echo $myCRUD->czytaj();?>
                </div>
                <div id = "addP">
                    <?php echo $myCRUD->add_form();?>
                </div>
                
                <div id = "editP">
                    <?php echo $myCRUD->upd_form($_POST);?>
                </div>
                <div id = "removP">
                    <?php echo $myCRUD->del_form();?>
                </div>
            </div>
        </div>
    </div>

    <!-- <div id = 'main'>
    <header>
        <h1>Panel Administracyjny</h1>
    </header>
    <div id = 'table'>
        <?php //echo $myCRUD->czytaj();?>
    </div>
    <div id = 'triple-dragon'>
        <?php
           // echo $myCRUD->add_form();
           // echo $myCRUD->del_form();
           // echo $myCRUD->upd_form($_POST);
           // echo $myCRUD->czytajLog();
           // echo $myCRUD->del_formLog();
           // echo $myCRUD->upd_formLog($_POST);
        ?>
    </div>
    <p>Dostęp dla admina tylko i wyłącznie</p>
</div> -->
</body>
</html>
<?php
    }
    else{
        $_SESSION['error'] = "Proszę się zalogować";
        header('Location: form-log.php');
    }
?>