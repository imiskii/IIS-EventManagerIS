<?php
    switch ($path) {
        case 'empty':
            break;
        // ... other POST endpoints ...
        default:
            sendResponse(404, "POST: Not Found");
            break;
    }
?>