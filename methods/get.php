<?php
    $gettable_columns = fetch_gettable_columns_for_table($table); // bit overkill, but handles that we do not want to send password in Account

    if (empty($filters)) {
        $query = "SELECT $gettable_columns FROM $table";

        $stmt = $db->prepare($query);
    }
    else {
        if (!validate_filters($table, $filters)) {
            sendResponse(400, "Invalid filters have been provided for GET.\n");
        }
        $query = "SELECT $gettable_columns FROM $table WHERE";

        // apply filters to our query
        $params = [];
        foreach ($filters as $key => $value) {
            $operation = fetch_filter_operation($key);
            $query .= " $key $operation :$key AND"; // :$key is a placeholder -> supposedly guards against SQL injections
            $params[":$key"] = $value;
        }

        $query = rtrim($query, " AND"); // above leaves us with " AND" at the end of our query..

        $stmt = $db->prepare($query);

        // replace placeholders in our query with actual values
        foreach ($params as $placeholder => $value) { 
            $stmt->bindValue($placeholder, $value);
        }
    }

    // print("$query\n");
    $stmt->execute();
    try {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            header('Content-Type: application/json');
            sendResponse(200, $result);
        } else {
            sendResponse(404, "No results found.");
        }
    } catch (Exception $e) {
        sendResponse(500, "Internal Server Error (get.php): " . $e->getMessage());
    }
?>