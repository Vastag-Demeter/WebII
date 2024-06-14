<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <nav>
        <p><a href="login.php">Bejelentkezés</a></p>
        <p><a href="registration.php">Regisztráció</a></p>
        <p><a href="modify_password.php">Jelszó módosítása</a></p>
    </nav>
    <form action="" method="post">
        <h1>Regisztráció</h1>
        <input type="email" name="email" placeholder="Email" class="user_input">
        <input type="text" name="name" placeholder="Felhasználónév" class="user_input">
        <input type="password" name="password" placeholder="Jelszó" class="user_input">
        <label>Születési Dátum</label><input type="date" name="birth_date" class="user_input">
        <div class="gender_div">
            <label>Nem</label> <br>
            <p> <label>Férfi</label><input type="radio" name="gender" value="Ferfi"></p>
            <p> <label>Nő</label><input type="radio" name="gender" value="No"></p>


        </div>
        <button type="submit">Regisztráció</button>
        <link rel="stylesheet" href="style.css">
    </form>



</body>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require './fuggvenyek.php';


    //Email, nem lehet üres
    $email_errors = check_data("email|required");
    if ($email_errors) {
        $email = clear($_POST["email"]);
    } else {
        $error[] = "Az email megadása kötelező! <br>";

    }

    //Név, nem lehet üres
    $name_errors = check_data("name|required");
    if ($name_errors) {
        $name = clear($_POST["name"]);
    } else {
        $error[] = "A név megadása kötelező! <br>";

    }

    //Jelszó, nem lehet üres és a megfelelő formátumban kell lennie ([A-Za-z0-9])
    $password_errors = check_data("password|required,password_correct_format");
    if ($password_errors) {
        $password = clear($_POST["password"]);
    } else {
        $error[] = "A jelszó nem lehet üres és csak az Angol ABC nagy- és kisbetűit tartalmazhatja, valamint számjegyeket!<br>";

    }

    //Születési idő, nem lehet üres, az év alapján számolt életkor nem lehet kisebb,
    //mint 18
    $birth_errors = check_data("birth_date|required,adult");
    if ($birth_errors) {
        $birth = clear($_POST["birth_date"]);
    } else {
        $error[] = "A születési dátum megadása kötelező, valamint el kell múljon 18! <br>";

    }

    $gender_errors = check_data("gender|required|is_null");
    if ($gender_errors) {
        $gender = clear($_POST["gender"]);
    } else
        $error[] = "A nem megadása kötelező";


    //Ha minden adatra a visszatérési érték megfelel ("OK"), akkor elmenthetem őket a fájlba
    if ($email_errors && $name_errors && $password_errors && $birth_errors && $gender_errors) {
        //Az írás metódusa, "w", ha a fájl nem létezik,
        // "ra", ha a fájl lézezik
        $method = "";
        //Ez a sor, amivel kiegészítem a fájlt
        $line = PHP_EOL . $email . ";" . $name . ";" . $password . ";" . $birth . ";" . $gender;
        //Ha nem létezik a fájl, akkor nem olvasok semmit, hanem 
        //létrehozom és beleírom az adatot.
        //Ha létezik, akkor megnézem, szerepel-e már benne ilyen
        //email és ha nem, akkor egészítem csak ki.
        if (file_exists("data.csv"))
            $method = "ra+";
        else
            $method = "w";

        $file = fopen("./data.csv", $method);

        if (!$file) {
            echo "A fájlt nem lehet megnyitni!";
        }

        if ($method == "ra+") {
            //Ebbe mentem el, ha az email létezik
            $existing_email = false;
            while (!feof($file)) {
                //Beolvasok egy sort
                $row = fgets($file);
                //Kiszedem a whitespace-t
                $row = trim($row);
                //Felbontom a beolvasott sort email;nev;jelszo;szulido
                $fields = explode(';', $row);
                //Csak az emailt kell ellenőriznem
                $field_email = $fields[0];
                if ($field_email == $email) {
                    $existing_email = true;
                    break;
                }
            }


            //Ha nincs benne az email, akkkor 
            //a fájl végét bővítem a megadott adatokkal
            //Ha benne van, akkor tájékoztatom a felhasználót
            if (!$existing_email) {
                fputs($file, $line);
            } else {
                echo "A megadott email cím már szerepel!";
            }
        } else {
            fwrite($file, $line);
            echo "Írok a fájlba";
        }

        //Lezárom a fájlt
        fclose($file);
    }

}

?>


<?php if (isset($error)): ?>
    <div class="server_error_message">
        <?php for ($i = 0; $i < count($error); $i++): ?>
            <p><?= $error[$i] ?></p>
        <?php endfor; ?>
    </div>


<?php endif; ?>

</html>