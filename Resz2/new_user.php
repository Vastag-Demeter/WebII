<?php

require_once './fuggvenyek.php';
//Új felhasználó felviteléhez, szükség van, mind a 4 adatra
$resources = ["email", "name", "passwd", "birth"];

if (get_res($resources) == 4) {

    foreach ($resources as $res) {
        if (empty($_GET[$res])) {
            echo "Az adatok nem lehetnek üresek!";
            exit();
        }
    }


    //Eltárolom az adatokat
    $email = $_GET['email'];
    $name = $_GET['name'];
    $passwd = $_GET['passwd'];
    $birth = $_GET['birth'];

    if (strlen($email) > 100 || strlen($name) > 100 | strlen($passwd) > 100) {
        echo "Az email, név, jelszó, maximum 100 karakter lehet!";
        exit();
    }


    if (!email_correct_format($email)) {
        echo "Az email nem megfelelő!";
        exit();
    }

    if (!password_correct_format($passwd)) {
        echo "A jelszó formátuma nem megfelelő!";
        exit();
    }

    if (!birth_date_is_correct($birth)) {
        echo "A születési dátum hibás!";
        exit();
    }
    if (!user_is_adult($birth)) {
        echo "Nem töltötte be a 18-at!";
        exit();
    }
    require_once './connection.php';
    $post_command = 'insert into felhasznalok (email, name, passwd, birth) values (:e, :n, :p, :b);';
    $select_data = [
        'e' => $email,
        'n' => $name,
        'p' => $passwd,
        'b' => $birth
    ];

    execute_command($post_command, $select_data);

} else {
    echo "Szükség van mind a 4 adatra!";
    exit();
}