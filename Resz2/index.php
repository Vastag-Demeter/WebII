<?php

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        require_once './ql.php';
        break;
    case 'POST':
        break;
    case 'DELETE':
        break;
    case 'PUT':
        break;
    default:
        http_response_code(405);
        exit();
}


