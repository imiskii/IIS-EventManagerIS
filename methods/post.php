<?php
    // $json_data = '{"email":"sample@il.com","last_name":"Doeringo","nick":"johndoe123","password":"sample_password","account_type":"user","photo":null,"status":"active"}';
    $json_data = '{"email":"sample@il.com","password":"sample_password"}';
    // $json_data = '{}';

    // $table = 'Login';
    

    // real code starts here
    // Decode received data from JSON
    $data = json_decode($json_data); 
    if (!$data) // json_decode can return null if an error occured
        sendResponse(400, "Error in decoding JSON.\n");
    if (!validate_data($table, $data)){
        sendResponse(400, "POST Method Failed To Validate Data.");
        exit;
    }

    // branch POST into query table or login/logout
    if ($table == 'Login' || $table == 'Logout'){ // POST - login/logout
        session_handler($db, $table, $data);
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

    // replace placeholders in our query with actual values
    foreach ($params as $placeholder => $value) { 
        $stmt->bindValue($placeholder, $value);
    }

    if ($stmt->execute()) {
        sendResponse(200, "$table has been successfully added.");
    } else {
        sendResponse(400, "Server Error: Failed to add $table.");
    }
?>