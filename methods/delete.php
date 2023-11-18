<?php
    $id_array = extract_id($data, $table);
    $id_string = get_id_string($id_array); // our WHERE clause for db queries

    if ($account_type == "user") { // user is only allowed to delete items they OWN
        if (!check_user_ownership($db, $table, $id_array, $id_string)) {
            sendResponse(401, "Tried to delete an item that doesn't exist/belong to you!\n");
            exit;
        }
    }

    if(item_exists($db, $table, $id_string, $id_array)) {
        $query = "DELETE FROM $table WHERE $id_string";

        $stmt = $db->prepare($query);
        foreach ($id_array as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            sendResponse(200, "successfull delete on table: $table.\n");
        } else {
            sendResponse(500, "Server Error: Failed to delete item on table: $table.\n");
        }

    }
    else {
        sendResponse(400, "Item to be updated doesn't exist.\n");
    }
?>