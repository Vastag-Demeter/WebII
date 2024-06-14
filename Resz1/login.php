<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="style.css">
</head>

<?php
$email_error;
$password_error;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Függvények implementálása
    require_once 'fuggvenyek.php';

    //Email lekérése, nem lehet üres
    $email_error = check_data("email|required");
    if ($email_error) {
        $email = clear($_POST['email']);
    } else
        echo "Az email megadása kötelező!";

    //Jelszó lekérése, nem lehet üres és a megfelelő formátumban kell lennie
    $password_error = check_data("password|required,password_correct_format");
    if ($password_error) {
        $password = clear($_POST['password']);
    } else
        echo "A jelszó nem megfelelő!";


    //Ha az email és a jelszó megfelel, akkor elkezdhetem ellenőrizni,
    //hogy található-e ilyen email-jelszó páros a fájlban
    if ($email_error && $password_error) {
        //Megnyitom a fájlt olvasásra
        $file = fopen('./data.csv', 'r');
        //Ha a fájl megnyitása sikeres, elkezdek kiolvasni a fájlból
        if ($file) {
            //Ebbe mentem el, ha találtam egy felhasználót a megadott
            //email cím és jelszó párossal
            $user_found = false;
            while (!feof($file)) {
                //Egy asszociatív tömbben tárolom majd
                //az email címet és a jelszót, amit a fájl sorából
                //szedek ki
                $row = fgets($file);
                $fields = explode(';', $row);
                $field_records = [
                    'email' => $fields[0],
                    'password' => $fields[2]
                ];
                //Ha a kiolvasott sorban lévő email és jelszó szerepel, akkor kilépek a ciklusból
                //mert megtaláltam a felhasználót
                if ($field_records['email'] == $email && $field_records['password'] == $password) {
                    $user_found = true;
                    break;
                }
            }
            fclose($file);
            //Ha találtam felhasználót, ha nem, mind a kettő
            //esetről tájékoztatom a bejelentkezni próbáló felhasználót
            if ($user_found) {
                echo "A bejelentkezés sikeres!";
            } else {
                echo "Nem találtunk ilyen felhasználót a megadott email címmel és jelszóval";
            }
        } else {
            echo "A fájlt nem lehet megnyitni!";
        }
    }


}





?>





<body>
    <h1>Bejelentkezés</h1>
    <form action="" method="POST">
        <label>E-mail:</label>
        <input type="email" name="email"> <br>
        <label>Jelszó:</label>
        <input type="password" name="password"> <br>
        <button type="submit">Bejelentkezés</button>
    </form>

</body>

</html>