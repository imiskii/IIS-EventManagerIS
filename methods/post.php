<?php
    switch ($database_table) { // first URL parameter defines what table we will use
        case 'empty':
            break;
        // ... other POST endpoints ...
        default:
            sendResponse(404, "POST: Not Found");
            break;
    }
?>