<?php
    switch ($path) {
        case 'empty':
            break;
        // ... other PUT endpoints ...
        default:
            sendResponse(404, "PUT: Not Found");
            break;
    }
?>