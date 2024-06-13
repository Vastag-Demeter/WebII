<?php

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        require_once './querry.php';
        break;
    case 'POST':
        require_once './new_user.php';
        break;
    case 'DELETE':
        break;
    case 'PUT':
        break;
    default:
        http_response_code(405);
        exit();
}


