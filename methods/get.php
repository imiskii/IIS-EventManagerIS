<?php
    switch ($path) {
        case 'empty':
            break;
        // ... other GET endpoints ...
        default:
            sendResponse(404, "GET: Not Found");
            break;
    }
?>