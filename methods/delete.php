<?php
    switch ($database_table) { // first URL parameter defines what table we will use
        case 'empty':
            break;
        // ... other DELETE endpoints ...
        default:
            sendResponse(404, "DELETE: Not Found");
            break;
    }
?>