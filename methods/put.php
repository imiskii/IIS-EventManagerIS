<?php
    $json_data = '{"id":"6","email":"new@email.com"}';

    $data = json_decode($json_data); 
    if (!$data) // json_decode can return null if an error occured
        sendResponse(400, "Error in decoding JSON.\n");
    if (!validate_data($table, $data, $method)) {
        sendResponse(400, "PUT Method Failed To Validate Data.");
        exit;
    }

    if(item_exists($db, $table, $data->id)) {
        $query = "UPDATE $table SET ";
        $params = [];
        foreach($data as $key => $value) {
            if ($key != 'id') { // Skip the 'id' key
                $query .= "$key = :$key, ";
                $params[":$key"] = $value;
            }
        }
        $query = rtrim($query, ", ");
        $query .= " WHERE id = :id"; // or whatever your primary key is
        $params[':id'] = $data->id; // make sure 'id' is provided

        $stmt = $db->prepare($query);
        foreach ($params as $placeholder => $value) {
            $stmt->bindValue($placeholder, $value);
        }

        if ($stmt->execute()) {
            sendResponse(200, "successfull update on table: $table for item with id: $data->id.\n");
        } else {
            sendResponse(500, "Server Error: Failed to update item with id: $data->id on table: $table.\n");
        }
    }
    else {
        sendResponse(400, "Item to be updated doesn't exist.\n");
    }
?>