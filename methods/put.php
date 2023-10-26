<?php
    switch ($database_table) { // first URL parameter defines what table we will use
        case 'empty':
            break;
        // ... other PUT endpoints ...
        default:
            sendResponse(404, "PUT: Not Found");
            break;
    }
?>