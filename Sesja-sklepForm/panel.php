<?php
    session_start();
    //! sprawdzenie czy uzytkownik jest zalogowany
    if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']) == True){
        // echo "witaj";
        // echo '<p>'.$_SESSION["login"].'</p>';
        //echo "<a href = 'logout.php'>Wyloguj się</a><br>";
        require("db-connect.php");//! Implementacja parametrów połączenia z bazą
        require("CRUD-class.php");//! Implementacja klasy CRUD z innego pliku
        $myCRUD2 = new CRUD();//! Tworzenie obiektu myCRUD
        echo $myCRUD2->polacz($host,$user,$pass,$db);//! Test funkcji wyswietlajacej stan polaczenia
    ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel uzytkownika</title>
    <link rel="stylesheet" href="panelUser.css">
</head>
<body>
    <div id = 'main'>
    <header>
        <h1>Panel urzytkownika</h1>
    </header>
    <div id = 'table'>
        <div id = 'user'>
            <h3>Poprawnie zalogowales sie do serwisu</h3><br>
            <h3>Witaj na naszej stronie:  <?php echo $_SESSION["login"]; ?> </h3>
        </div>
        <?php echo $myCRUD2->czytajUser();?>
        <div id = 'wyloguj'>
            <?php echo "<a href = 'logout.php'>Wyloguj się</a><br>";?>
        </div>
    </div>
    <footer>
        <p>Sprawdź co mamy!</p>
    </footer>
    </div>
</body>
</html>
<?php
    }
    else{
        $_SESSION['error'] = "Proszę się zalogować";
        header('Location: form-log.php');
    }
?>