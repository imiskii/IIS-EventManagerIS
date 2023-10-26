<?php
require 'config/common.php';

$db = connect_to_db(); // connect to database -> returns pdo that allows us to work with the db

$method = $_SERVER['REQUEST_METHOD']; // GET/POST/PUT/DELETE
$path = $_SERVER['PATH_INFO'] ?? null;
// 1. Parse the URL
$parsedUrl = parse_url($path);

// 2. Explode the Path
$pathParts = explode('/', $parsedUrl['path'], 2);
if ($pathParts[0] != "") // only valid path is "/database_table" so after explode: [0] = "" && [1] = db_table
{
    sendResponse(400, "Invalid path in request. Correct path assignment is: \"/database_table\"");
    exit;
}
$table = $pathParts[1] ?? null; // with path "/db_table" - we want to use index 1 after explode

// Validate existence of queried table
$db_tables = ["Account", "Category", "Event", "Address", "Event_Instance", "Entrance_fee", "Registration", "Photos", "Comment"];
if (!in_array($table, $db_tables, true))
{
    sendResponse(400, 'Bad Request: Tried to query non existent database table');
    exit;
}

// 3. Handle Query String
$filters = $_GET; // Directly assign the $_GET array to $filters -> if method is not GET has to be empty
if ($method != 'GET' && !empty($filters))
{
    sendResponse(400, 'Bad Request: query parameters are only allowed for GET. Send JSON instead.');
    exit;
}

print("\nIde sa na to!\n");
print_r($table); // Outputs: Account etc..
print("\n");
print_r($filters); // Outputs: Array ( [first_name] => John [last_name] => Doe )
print("\n");

switch ($method) {
    case 'GET':
        include 'methods/get.php'; // include emulates function calls + passes all current context
        break;
    case 'POST':
        // json_decode(file_get_contents('php://input'), true);
        include 'methods/post.php';
        break;
    case 'PUT':
        // json_decode(file_get_contents('php://input'), true);
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