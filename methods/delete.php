<?php
    $json_data = '{"id":"3"}';

    $data = json_decode($json_data); 
    if (!$data) // json_decode can return null if an error occured
        sendResponse(400, "Error in decoding JSON.\n");
    if (!validate_data($table, $data, $method)) {
        sendResponse(400, "PUT Method Failed To Validate Data.");
        exit;
    }

    if(item_exists($db, $table, $data->id)) {
        $query = "DELETE FROM $table WHERE id = :id";

        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $data->id);

        if ($stmt->execute()) {
            sendResponse(200, "successfull delete on table: $table for item with id: $data->id.\n");
        } else {
            sendResponse(500, "Server Error: Failed to delete item with id: $data->id on table: $table.\n");
        }

    }
    else {
        sendResponse(400, "Item to be updated doesn't exist.\n");
    }
?>