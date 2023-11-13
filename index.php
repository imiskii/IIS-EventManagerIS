<?php
require 'config/common.php';

session_start();

/* TODO list
differentiate query operations for authorization levels
*/

$db = connect_to_db(); // connect to database -> returns pdo that allows us to work with the db

$path = $_SERVER['PATH_INFO'] ?? '';
$method = $_SERVER['REQUEST_METHOD']; // GET/POST/PUT/DELETE
// $method = 'PUT'; // TEST

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

$db_tables = ["Account", "Category", "Event", "Address", "Event_Instance", "Entrance_fee", "Registration", "Photos", "Comment"];
if (!in_array($table, $db_tables, true) && ($method != 'POST' || $table != 'Login') && ($method != 'POST' || $table != 'Logout'))
{ 
    sendResponse(400, 'Bad Request: request is not querying a table, or a login/logout attempt');
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
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true); 
if (!$data && $method != 'GET' && $table != 'Logout') {// json_decode can return null if an error occured + if GET data has to be null
    sendResponse(400, "Error in decoding JSON.\n");
    exit;
}
else{
    if (!validate_data($table, $data, $method)) {
        sendResponse(400, "PUT Method Failed To Validate Data.");
        exit;
    }
}

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