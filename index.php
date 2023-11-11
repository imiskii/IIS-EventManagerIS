<?php
require 'config/common.php';

session_start();

/* TODO list
differentiate query operations for authorization levels
*/

$db = connect_to_db(); // connect to database -> returns pdo that allows us to work with the db

$path = $_SERVER['PATH_INFO'] ?? null;
$method = $_SERVER['REQUEST_METHOD']; // GET/POST/PUT/DELETE
// $method = 'POST'; // TEST

// 1. Parse the URL
$parsedUrl = parse_url($path);

// 2. Explode the Path
$pathParts = explode('/', $parsedUrl['path'], 2);
if ($pathParts[0] != "") // only valid path is "/database_table" so after explode: [0] = "" && [1] = db_table
{
    sendResponse(400, "Invalid path in request. Correct path assignment is: \"/database_table...\"");
    exit;
}
$table = $pathParts[1] ?? null; // with path "/db_table" - we want to use index 1 after explode

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

// print("\nIde sa na to!\n");
// print_r($table); // Outputs: Account etc..
// print("\n");
// print_r($filters); // Outputs: Array ( [first_name] => John [last_name] => Doe )
// print("\n");

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
        sendResponse(405, "Unknown Method.");
        break;
}
?>
