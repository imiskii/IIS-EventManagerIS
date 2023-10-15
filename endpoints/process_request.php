<?php

function process_request($pdo, $method, $path)
{
    switch ($method) {
        case 'GET':
            handleGET($pdo, $path);
            break;
        case 'POST':
            handlePOST($pdo, $path);
            break;
        case 'PUT':
            handlePUT($pdo, $path);
            break;
        case 'DELETE':
            handleDELETE($pdo, $path);
            break;
        default:
            sendResponse(405, "Method Not Allowed");
            break;
    }
}

// Define your handler functions
function handleGET($pdo, $path)
{
    switch ($path) {
        case 'articles':
            // Fetch and return articles
            break;
        // ... other GET endpoints ...
        default:
            sendResponse(404, "Not Found");
            break;
    }
}

function handlePOST($pdo, $path)
{
    switch ($path) {
        case 'article':
            // Create a new article
            break;
        // ... other POST endpoints ...
        default:
            sendResponse(404, "Not Found");
            break;
    }
}

function handlePUT($pdo, $path)
{
    switch ($path) {
        case 'articles':
            // Modify an existing article
            break;
        // ... other PUT endpoints ...
        default:
            sendResponse(404, "Not Found");
            break;
    }
}

function handleDELETE($pdo, $path)
{
    switch ($path) {
        case 'articles':
            // Modify an existing article
            break;
        // ... other DELETE endpoints ...
        default:
            sendResponse(404, "Not Found");
            break;
    }
}

// Utility function to send JSON responses
function sendResponse($statusCode, $message)
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode(['status' => $statusCode, 'message' => $message]);
}
?>