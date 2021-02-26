<?php
    session_start();
    //!sprawdzenie czy przeszliśmy przez formularz
    if(isset($_POST['login']) && isset($_POST['pass'])){
        //! sprawdzanie czy login i haslo sa rozne od zera
        if(strlen($_POST['login']) < 4 || strlen($_POST['pass']) < 4){
            $_SESSION['error'] = "Wprowadzane dane są zbyt krotkie";
            header('Location: form-log.php');
        }
        else{
            //! zapisanie danych do zmiennych
            //! zabezpieczenie loginu przed polskim badz niedozwolonymi znakami
            $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
            $pass = $_POST['pass'];
            //! połączenie sie z baza danych - wylapywanie wyjątków - zabezpieczenia
            try{
                $db = new mysqli("localhost","root","","zshopcrud");
                if($db->connect_errno !=0){
                    throw new Exception(mysqli_connect_errno());//!sprawdzenie wyjątku
                }
                else{
                    //! wysłanie zapytania do bazy danych
                    if($row = $db->query('SELECT * FROM users WHERE login ="'.$login.'"')){
                        //! sprawdzanie czy taki user istnieje
                        if($row->num_rows >0){
                            
                            $row2 = $row->fetch_assoc(); //! wsyzstkie dane z wiersza zapisujemy do zmiennej row2
                            //! sprawdzenie czy zgadza się hasło
                            if(password_verify($pass,$row2['pass']) && $row2['login'] == $login){
                                //! jeśli haslo sie zgadza to zamykamy polaczenie i przenosimy do innej strony
                                //! w zaleznosci od uprawnien 1- admin 0- user dostajemy sie na odpowiednie strony
                                //!uprawnienia usera
                                if($row2['uprawnienia'] ==2){
                                    $_SESSION['zalogowany'] = True; //! zmienna mowiac nam czy jestem zalogowany
                                    $_SESSION['login'] = $row2['login']; //!zmienna przechowująca login
                                    $db ->close();
                                    header('Location: panel.php');
                                    exit();
                                }//!uprawnienia admina
                                else if($row2['uprawnienia'] ==1){
                                    $_SESSION['zalogowany'] = True; //! zmienna mowiac nam czy jestem zalogowany
                                    $_SESSION['login'] = $row2['login']; //!zmienna przechowująca login
                                    $_SESSION['admin'] = True;
                                    $db ->close();
                                    header('Location: admin_panel.php');
                                }
                                else{
                                    //! zabezpieczenie gdyby w bazie przypadkiem byloby uprawnienie >2
                                    $_SESSION['error'] = "Jak tu się dostaleś gościu ?";
                                    header('Location: form-log.php');
                                }
                            }
                            else{
                                //! niepoprawne hasło
                                $_SESSION['error'] = "Wprowadziłeś niepoprawne dane";
                                header('Location: form-log.php');
                            }
                        }
                        else{
                            //! niepoprawna nazwa urzytkownika
                            $_SESSION['error'] = "Wprowadziłeś niepoprawne dane";
                            header('Location: form-log.php');
                        }
                    }else{
                        //! złe zapytanie w  if($row = mysqli_query($db,"SELECT * FROM users WHERE login = '$login'")){
                        $_SESSION['error'] = "Błąd zapytania bazy danych";
                        header('Location: form-log.php');
                    }
                }
            }
            catch(Exception $exce){
                //!zle wprowadzone dane w $db = new mysqli("localhost","root","","sesjalog");
                $_SESSION['error'] = "Błąd bazy danych";
                header('Location: form-log.php');
            }
        }
    }
    else{
        //! zabezpieczenie gdyby ktos chcial wejsc odrazu na panel.php lub admin_panel.php
        $_SESSION['error'] = "Proszę wprowadzić dane";
        header('Location: form-log.php');
    }
?>