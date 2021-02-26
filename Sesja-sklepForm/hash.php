<?php
    if(isset($_POST['pass'])){
        $pass = $_POST['pass'];
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        echo "Zrobione: ".$hash;

    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Do hashowania hasel</title>
</head>
<body>
    <form action="hash.php" method = "post">
        <label>Hasło<input type = "text" name = "pass"></label>
        <input type = "submit" value = "hashuj">
    </form>
</body>
</html>