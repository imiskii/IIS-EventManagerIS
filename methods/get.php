<?php
    $query = "SELECT * FROM $table WHERE";

    // apply filters to our query
    $params = [];
    foreach ($filters as $key => $value) {
        $operation = fetch_filter_operation($key);
        $query .= " $key $operation :$key AND"; // :$key is a placeholder -> supposedly guards against SQL injections
        $params[":$key"] = $value;
    }
    // Trim the trailing " AND"
    $query = rtrim($query, " AND"); // above leaves us with " AND" at the end of our query..

    // Crafting our SQL query
    $stmt = $db->prepare($query);

    // replace placeholders in our query with actual values
    foreach ($params as $placeholder => $value) { 
        $stmt->bindValue($placeholder, $value);
    }

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