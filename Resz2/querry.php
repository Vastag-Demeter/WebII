<?php

require_once './connection.php';


//Ezeket az erőforrásokat fogadhatom el
$resources = ["email", "name", "passwd", "birth"];
require_once './fuggvenyek.php';

//Ha nem található meg az elfogadható erőforrások közül egy sem, akkor
//csak kilistázom az adatbázisban található rekordokat
if (get_res($resources) == 0) {
    $query = "select * from felhasznalok";


    //Valamennyi elfogadtható erőforrás bennevan
    // a $_GET tömbben
} else if (get_res($resources) != 0) {
    //Ebbe a tömbbe fogom belerakni az erőforrásokat
    $given_res = [];

    foreach ($resources as $res) {
        if (array_key_exists($res, $_GET)) {
            if (!empty($_GET[$res])) {
                $given_res[] = $res;
            } else {
                http_response_code(404);
                exit();
            }
        }
    }

    //Ebben tárolom el az erőforrások értékeit
    $given_res_values = [];
    foreach ($given_res as $res) {
        $given_res_values[] = $_GET[$res];
    }

    $query = "select * from felhasznalok where ";

    for ($i = 0; $i < count($given_res); $i++) {
        $query = $query . $given_res[$i] . "=" . "'" . $given_res_values[$i] . "'";
        if ($i != count($given_res) - 1)
            $query = $query . " and ";
    }
    $query = $query . ";";






} else {
    http_response_code(404);
}
$data = [];
$statement = $connection->prepare($query);
$success = $statement->execute($data);
$users = [];
if ($success) {
    echo "Az olvasás sikeres!";
    $users = $statement->fetchAll();
    $users_json_string = json_encode($users);

    header('Content-Type: application/json;charset=utf-8');
    echo $users_json_string;

} else {
    echo "Az olvasás sikertelen!";
}

$connection = null;