<?php

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        require_once './get_user.php';
        break;
    case 'POST':
        require_once './new_user.php';
        break;
    case 'DELETE':
        require_once './delete_user.php';
        break;
    case 'PUT':
        require_once './update_user.php';
        break;
    default:
        http_response_code(405);
        exit();
}


