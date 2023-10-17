<?php
require 'config/common.php';

$db = connect_to_db(); // connect to database -> returns pdo that allows us to work with the db

$method = $_SERVER['REQUEST_METHOD']; // GET/POST/PUT/DELETE
$path = $_SERVER['PATH_INFO'] ?? ''; // get path -> if empty return empty string not null

switch ($method) {
    case 'GET':
        include 'methods/get.php'; // include emulates function calls + passes all current context
        break;
    case 'POST':
        include 'methods/post.php';
        break;
    case 'PUT':
        include 'methods/put.php';
        break;
    case 'DELETE':
        include 'methods/delete.php';
        break;
    default:
        sendResponse(405, "Method Not Allowed");
        break;
}
?>