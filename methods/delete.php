<?php
    switch ($path) {
        case 'empty':
            break;
        // ... other DELETE endpoints ...
        default:
            sendResponse(404, "DELETE: Not Found");
            break;
    }
?>