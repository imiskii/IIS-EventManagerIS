<?php

//TODO: move script
require 'config/common.php';

session_start();
$db = connect_to_db();

$path = $_SERVER['PATH_INFO'] ?? '';
$method = $_SERVER['REQUEST_METHOD']; // GET/POST/PUT/DELETE




// TESTING START
// $method = 'POST'; // Login
// $json_data = '{"email":"jan.novak@email.cz","password":"hashed_password"}';

// $method = 'PUT'; // Modify
// $json_data = '{"id":"6","email":"new_new@email.com"}';

// $method = 'POST'; // Logout
//$json_data = file_get_contents('php://input');

// $method = 'DELETE'; // Delete
// $json_data = '{"id":"7"}';

// $method = 'POST'; // Add
// $json_data = '{"event_name":"TEST_event","description":"Just testing"}';
// TESTING END


// 1. Parse the URL
$parsedUrl = parse_url($path);

// 2. Explode the Path
$pathParts = explode('/', $parsedUrl['path'], 2);
if ($pathParts[0] != "") // only valid path is "/database_table" so after explode: [0] = "" && [1] = db_table
{
    sendResponse(400, "Invalid path in request. Correct path assignment is: \"/database_table...\"");
    exit;
}
$table = $pathParts[1] ?? ''; // with path "/db_table" - we want to use index 1 after explode

$account_type = $_SESSION['USER']['account_type'] ?? "not_logged_in";
$accessible_db_tables = fetch_method_tables_for_account_type($account_type, $method);
if (!in_array($table, $accessible_db_tables, true))
{
    sendResponse(400, 'Bad Request: request is invalid or unauthorized');
    exit;
}

// 3. Handle Query String
$filters = $_GET; // Directly assign the $_GET array to $filters ($_GET gets URL params. for any method)
if ($method != 'GET' && !empty($filters)) //if method is not GET has to be empty
{
    sendResponse(400, 'Bad Request: query parameters are only allowed for the GET Method. Send JSON instead.');
    exit;
}

// 4. Decode received data from JSON
$json_data = json_encode($_POST);
var_dump($json_data);
//$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
if (!$data && $method != 'GET' && $table != 'Logout') {// json_decode can return null if an error occured + if GET data has to be null
    sendResponse(400, "Error in decoding JSON.\n");
    exit;
}
else{
    if (!validate_data($table, $data, $method, $account_type)) {
        sendResponse(400, "PUT Method Failed To Validate Data.");
        exit;
    }
}
add_missing_data($account_type, $method, $table, $data); // set creation time, init status/account_type etc..

switch ($method) {
    case 'GET':
        include 'methods/get.php';
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
        sendResponse(405, "Unknown Method.");
        break;
}
?>
