<?php
require_once './fuggvenyek.php';


$resources = ["email", "name", "passwd", "birth"];
if (get_res($resources) > 1 && array_key_exists('email', $_GET)) {
    $email = $_GET['email'];

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



    if (in_array('passwd', $given_res)) {
        $passwd = $_GET['passwd'];
        if (strlen($passwd) > 100 || !password_correct_format($passwd)) {
            echo "A jelszó nem megfelelő!";
            exit();
        }
    }

    if (in_array('name', $given_res)) {
        $name = $_GET['name'];
        if (strlen($name) > 100) {
            echo "A név túl hosszú!";
            exit();
        }
    }


    $update_command = "update felhasznalok set ";

    for ($i = 0; $i < count($given_res); $i++) {
        if ($given_res[$i] != "email") {
            $update_command = $update_command . $given_res[$i] . "=" . "'" . $given_res_values[$i] . "'";
            if ($i != count($given_res) - 1)
                $update_command = $update_command . ", ";
        }
    }
    $update_command = $update_command . " where email='" . $email . "';";






} else {
    http_response_code(404);
}


$select_data = [];

execute_command($update_command, $select_data);
