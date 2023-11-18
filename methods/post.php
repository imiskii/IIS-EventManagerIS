<?php
    // branch POST into query table or login/logout
    if ($table == 'Login' || $table == 'Logout') { // POST - login/logout
        session_handler($db, $table, $data, $account_type);
        exit;
    }

    // POST - insert into database
    $query = "INSERT INTO $table ";

    $params = [];
    $param_string = "(";
    $value_string = "(";
    foreach($data as $key => $value) {
        $params[":$key"] = $value;
        $param_string .= "$key, ";
        $value_string .= ":$key, ";
    }
    $param_string = rtrim($param_string, ", "); // above leaves us with ", " at the end of our query..
    $value_string = rtrim($value_string, ", "); // above leaves us with ", " at the end of our query..
    $param_string .= ")";
    $value_string .= ")";

    $query .= "$param_string VALUES $value_string";
    // print("\n$query\n");

    $stmt = $db->prepare($query);

    foreach ($params as $placeholder => $value) { 
        $stmt->bindValue($placeholder, $value);
    }

    if ($stmt->execute()) {
        sendResponse(200, "$table has been successfully added.");
    } else {
        sendResponse(500, "Server Error: Failed to add $table.");
    }
?>