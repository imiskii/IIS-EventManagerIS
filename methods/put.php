<?php
    // $json_data = '{"id":"6","email":"new@email.com"}';

    $id_array = extract_id($data, $table);
    $id_string = get_id_string($id_array); // our WHERE clause for db queries

    if(item_exists($db, $table, $id_string, $id_array)) {
        $query = "UPDATE $table SET ";
        $params = [];
        foreach($data as $key => $value) {
            $query .= "$key = :$key, ";
            $params[":$key"] = $value;
        }
        $query = rtrim($query, ", ");

        $query .= " WHERE $id_string"; // => " WHERE id = :id" etc.

        $stmt = $db->prepare($query);
        foreach ($id_array as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        foreach ($params as $placeholder => $value) {
            $stmt->bindValue($placeholder, $value);
        }

        if ($stmt->execute()) {
            sendResponse(200, "successfull update on table: $table.\n");
        } else {
            sendResponse(500, "Server Error: Failed to update item on table: $table.\n");
        }
    }
    else {
        sendResponse(400, "Item to be updated doesn't exist.\n");
    }
?>