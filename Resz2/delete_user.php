<?php


require_once './fuggvenyek.php';
$resources = ["email", "name", "passwd", "birth"];

if (get_res($resources) == 1) {
    if (array_key_exists('email', $_GET)) {
        $email = $_GET['email'];

        $delete_command = "delete from felhasznalok where email='" . $email . "';";

    } else {
        http_response_code(404);
    }
} else if (get_res($resources) > 1 && get_res($resources) < 5) {
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


    $given_res_values = [];
    foreach ($given_res as $res) {
        $given_res_values[] = $_GET[$res];
    }

    $delete_command = "delete from felhasznalok where ";

    for ($i = 0; $i < count($given_res); $i++) {
        $delete_command = $delete_command . $given_res[$i] . "=" . "'" . $given_res_values[$i] . "'";
        if ($i != count($given_res) - 1)
            $delete_command = $delete_command . " and ";
    }
    $delete_command = $delete_command . ";";




} else {
    http_response_code(404);
}
$data = [];
execute_command($delete_command, $data);