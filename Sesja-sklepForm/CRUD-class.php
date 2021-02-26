<?php
    //!CRUD - Create Read Update Delete/Destroy
    class CRUD extends mysqli{
        public $db;//! zmienna przechowująca połączenie z bazą danych
        //! FUNKCJA sprawdzająca połączenie
        public function polacz($host, $user ,$pass ,$db){
            $this->db=new mysqli($host,$user,$pass,$db);
            if($this->db->connect_errno){
                return "Błąd połączenia,"."<br>"."Nr. błędu: ".$this->db->connect_errno.",<br>Opis błędu: ".$this->db->connec_error;
            }else{
                //return "Połączenie z Bazą danych się udało.";
                return null;
            }
        }
        //! FUNCKJA wyświetlająca tabelę urzytkowników dla adminu
        public function czytajLog(){
            $zapytanie = "SELECT users.id, users.login, uprawnienia.nazwa FROM users, uprawnienia WHERE users.uprawnienia = uprawnienia.id;";
            $q = $this->db->query($zapytanie);
            $wynik = "<div id = 'czyt_form'><form action = 'admin-panel2.php' method = 'POST'><table>";
            $wynik .= "<tr><th>Edit</th><th>ID</th><th>Login</th><th>Uprawnienie</th></tr>";
            while($row = $q->fetch_assoc()){
                $wynik .= "<tr>
                <td><input type='submit' name='UpdateLog' value=".$row['id']."></td>
                <td>".$row['id']."</td>
                <td>".$row['login']. "</td>
                <td>".$row['nazwa']."</td>
                </tr>";
            }
            $wynik .= "</table></form></div>";
            return $wynik;
        }
        //! FUNCKJA wyświetljąca formularz do usuwania urzytkowników dla admina
        public function del_formLog(){
            $wynik = "<div id = 'del_form'><form action = 'admin-panel2.php' method = 'POST'";
            $wynik .= "<label>Podaj ID: <input name = 'id' value = '0' type = 'number'</label><br>
            <input name = 'action' value = 'KasujLog' type = 'Submit'>
            </form></div>";
            return $wynik;
        }
        //! FUNCKJA wyświetlająca tabelę urzytkowników dla admina
        public function upd_formLog($pom){
            $row2['login'] = null;
            $row2['nazwa'] = null;
            $row2['id'] = null;
            if(isset($pom['UpdateLog'])){
                $zapytanie2 = $this->db->query("SELECT users.id, users.login, uprawnienia.nazwa FROM users, uprawnienia WHERE users.uprawnienia = uprawnienia.id AND users.id = ".$pom['UpdateLog']."");
                $row2 = $zapytanie2->fetch_assoc();
            }
            $zapytanie = "SELECT * FROM uprawnienia WHERE 1";
            $q = $this->db->query($zapytanie);
            $wynik = "<div id = 'add_form'><form action = 'admin-panel2.php' method = 'POST'>";
            $wynik .= "<input type = 'hidden' name = 'id' value ='".$row2['id']."'>";
            $wynik .= "<label>Login: <input name = 'login' value ='".$row2['login']."' type = ''></label><br>
            uprawnienia: <select name = 'upr_id'>";
            while($row = $q->fetch_assoc()){
                $wynik.= '<option value="'.$row['id'].'">'.$row['nazwa'].'</option>';
            }
            $wynik .= "</select><br>";
            
            $wynik .= "<input name = 'action' value = 'EdytujLog' type = 'submit'>
            </form></div>";
            return $wynik;
        }
        //  <label>Uprawnienie: <input name = 'uprawnienie' value = '".$row2['nazwa']."' type = 'text'></label><br>";
        //! FUNCKJA wyświetlająca tabelę
        public function czytaj(){
            $zapytanie = "SELECT towar.id, towar.nazwa, towar.cena, miary.miara FROM towar, miary WHERE towar.miara = miary.id";
            $q = $this->db->query($zapytanie);
            $wynik = "<div id = 'czyt_form'><form action = 'admin_panel.php' method = 'POST'><table>";
            $wynik .= "<tr><th>Edit</th><th>ID</th><th>Nazwa</th><th>Cena</th><th>Miara</th></tr>";
            while($row = $q->fetch_assoc()){
                $wynik .= "<tr>
                <td><input type='submit' name='Update' value=".$row['id']."></td>
                <td>".$row['id']."</td><td>".$row['nazwa'] . "</td>
                <td>".$row['cena']. "</td>
                <td>".$row['miara']."</td>
                </tr>";
            }
            $wynik .= "</table></form></div>";
            return $wynik;
        }
        //! FUNCKJA wyświetlająca tabelę dal usera
        public function czytajUser(){
            $zapytanie = "SELECT towar.id, towar.nazwa, towar.cena, miary.miara FROM towar, miary WHERE towar.miara = miary.id";
            $q = $this->db->query($zapytanie);
            $wynik = "<div id = 'czyt_form'><form action = 'admin_panel.php' method = 'POST'><table>";
            $wynik .= "<tr><th>ID</th><th>Nazwa</th><th>Cena</th><th>Miara</th></tr>";
            while($row = $q->fetch_assoc()){
                $wynik .= "<tr>
                <td>".$row['id']."</td><td>".$row['nazwa'] . "</td>
                <td>".$row['cena']. "</td>
                <td>".$row['miara']."</td>
                </tr>";
            }
            $wynik .= "</table></form></div>";
            return $wynik;
        }
        //! FUNCKJA wyświetlająca formularz dodający
        public function add_form(){
            $zapytanie = "SELECT * FROM miary WHERE 1";
            $q = $this->db->query($zapytanie);
            $wynik = "<div id = 'add_form'><form action = 'admin_panel.php' method = 'POST'>";
            $wynik .= "<label>Nazwa: <input name = 'nazwa' value = '' type = ''></label><br>
            <label>Cena: <input name = 'cena' value = '' type = 'number'></label><br>
            Miara: <select name = 'miara_id'>";
            while($row = $q->fetch_assoc()){
                $wynik.= '<option value="'.$row['id'].'">'.$row['miara'].'</option>';
            }
            $wynik .= "</select><br>
            <input name = 'action' value = 'Dodaj' type = 'submit'>
            </form></div>";
            return $wynik;
        }
        //! FUNKCJA wyświetlająca formularz usuwający
        public function del_form(){
            $wynik = "<div id = 'del_form'><form action = 'admin_panel.php' method = 'POST'";
            $wynik .= "<label>Podaj ID: <input name = 'id' value = '0' type = 'number'</label><br>
            <input name = 'action' value = 'Kasuj' type = 'Submit'>
            </form></div>";
            return $wynik;
        }
        //! FUNKCJA wyświetlająca formularz edutujący
        public function upd_form($pom){
            // $zapytanie2 = $this->db->query("SELECT towar.id, towar.nazwa, towar.cena, miary.miara FROM towar, miary WHERE towar.miara = miary.id AND towar.id = ".$pom['Edytuj']."");
            // $row1 = $zapytanie2->fetch_assoc();
            // if(!isset($row1)){
            //     $row1['nazwa'] = null;
            //     $row1['cena'] = null;
            // }
            $row2['nazwa'] = null;
            $row2['cena'] = null;
            $row2['id'] = null;
            //$row2['miara'] = null;
            //$row2['miara'] = null;
            if(isset($pom['Update'])){
                $zapytanie2 = $this->db->query("SELECT towar.id, towar.nazwa, towar.cena, miary.miara FROM towar, miary WHERE towar.miara = miary.id AND towar.id = ".$pom['Update']."");
                $row2 = $zapytanie2->fetch_assoc();
            }
            $zapytanie = "SELECT * FROM miary WHERE 1";
            $q = $this->db->query($zapytanie);
            $wynik = "<div id = 'add_form'><form action = 'admin_panel.php' method = 'POST'>";
            $wynik .= "<input type = 'hidden' name = 'id' value ='".$row2['id']."'>";
            $wynik .= "<label>Nazwa: <input name = 'nazwa' value ='".$row2['nazwa']."' type = ''></label><br>
            <label>Cena: <input name = 'cena' value = '".$row2['cena']."' type = 'number'></label><br>
            Miara: <select name = 'miara_id'>";
            // if($row['miara'] ==$row2['miara']){
            //     $row['miara'] ==$row2['miara'];
            // }
            while($row = $q->fetch_assoc()){
                $wynik.= '<option value="'.$row['id'].'">'.$row['miara'].'</option>';
            }
            $wynik .= "</select><br>
            <input name = 'action' value = 'Edytuj' type = 'submit'>
            </form></div>";
            return $wynik;
        }
        //! CHRONIONA FUNKCJA obsługi formularza dodawania
        protected function add($new){
            $zapytanie = "INSERT INTO towar (id, nazwa, miara, cena) VALUES (NULL,'".$new['nazwa']."','".$new['miara_id']."','".$new['cena']."')";
            $q = $this->db->query($zapytanie);
            //header('mycrud.php');
        }
        //! CHRONIONA FUNKCJA obsługi formularza usuwania
        protected function del($new){
            $zapytanie = "DELETE FROM towar WHERE towar.id = '".$new['id']."'";
            $q = $this->db->query($zapytanie);
            //header('mycrud.php');
        }
        //! CHRONIONA FUNKCJA obsługi formularza edytującego
        protected function upd($new){
            $zapytanie = "UPDATE towar SET nazwa = '".$new['nazwa']."',cena = '".$new['cena']."',miara = '".$new['miara_id']."' WHERE id = '".$new['id']."'";
            $q = $this->db->query($zapytanie);
           // header('mycrud.php');
        }
        //! CHRONIONA FUNKCJA obsługi formularza usuwania urzytkowników
        protected function delLog($new){
            $zapytanie = "DELETE FROM users WHERE users.id = '".$new['id']."'";
            $q = $this->db->query($zapytanie);
            //header('mycrud.php');
        }
         //! CHRONIONA FUNKCJA obsługi formularza update'u urzytkownikow
        protected function updLog($new){
            $zapytanie = "UPDATE users SET uprawnienia = '".$new['upr_id']."',login = '".$new['login']."'WHERE id = '".$new['id']."'";
            $q = $this->db->query($zapytanie);
        }
        //! FUNKCJA obsługi formularzy/rozdzielenia/dispacher
        public function dispacher($sesja){
            if(isset($sesja['action'])){
                switch($sesja['action']){
                    case "Dodaj":
                        $this->add($sesja);
                        break;
                    case "Kasuj":
                        $this->del($sesja);
                        break;
                    case "Edytuj":
                        $this->upd($sesja);
                        break;
                    case "KasujLog":
                        $this->delLog($sesja);
                        break;
                    case "EdytujLog":
                        $this->updLog($sesja);
                        break;
                }
            }
        }
    }
?>