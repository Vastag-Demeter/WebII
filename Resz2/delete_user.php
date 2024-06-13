<?php

require_once './connection.php';
require_once './fuggvenyek.php';
if (array_key_exists('email', $_GET)) {
    $email = $_GET['email'];


    $delete_command = "delete from felhasznalok where email='" . $email . "';";
    $select_data = [];



    $user_exist = get_one_user($email);

    if ($user_exist != "") {
        $statement = $connection->prepare($delete_command);
        $success = $statement->execute($select_data);
        if ($success)
            echo "Futtatva";
        else
            echo "A futtasás sikertelen";


    } else {
        echo "Nem található ilyen felhasználó az adatbázisban, amit törölni lehetne!";
        exit();
    }



} else {
    http_response_code(404);
}