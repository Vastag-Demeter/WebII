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

    if (!birth_date_is_correct($birth)) {
        echo "A születési dátum hibás!";
    }
    if (!user_is_adult($birth)) {
        echo "Nem töltötte be a 18-at!";
    }
    require_once './connection.php';
    $query = 'insert into felhasznalok (email, name, passwd, birth) values (:e, :n, :p, :b);';
    $select_data = [
        'e' => $email,
        'n' => $name,
        'p' => $passwd,
        'b' => $birth
    ];

    $statement = $connection->prepare($query);
    $success = $statement->execute($select_data);
    if ($success)
        echo "Futtatva";
    else
        echo "A futtasás sikertelen";



} else {
    echo "Szükség van mind a 4 adatra!";
    exit();
}