<?php

function connect_to_db()
{
    $host = 'localhost';
    $db_name = 'xlazik00';
    $username = 'xlazik00';
    $password = 'imojbo9n';
    $port = '/var/run/mysql/mysql.sock';

    $dsn = "mysql:host=$host;dbname=$db_name;port=$port;charset=utf8mb4";
    // PDO options, these are optional but recommended for various reasons
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // If there's an error, throw an exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // When fetching data, return it as an associative array
        PDO::ATTR_EMULATE_PREPARES => false,
        // Use real prepared statements for security
    ];
    try {
        $pdo = new PDO($dsn, $username, $password, $options);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

// pretty much the same as fetch_valid_column_values, but can't query by descriptions.. TODO?
function fetch_valid_column_filters($table)
{
    switch ($table){
       case "Account":
            return $allowed_filters_for_Account = [
                'id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'email' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                },
                'first_name' => function ($value) {
                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                },
                'last_name' => function ($value) {
                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                },
                'nick' => function ($value) {
                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                },
                'account_type' => function ($value) {
                    // Assuming account types are predefined, you might check against a list of valid types.
                    $validAccountTypes = ['user', 'moderator', 'administrator'];
                    return in_array($value, $validAccountTypes, true);
                },
                'status' => function ($value) {
                    $validStatuses = ['active', 'inactive', 'banned']; // TODO add statuses
                    return in_array($value, $validStatuses, true);
                },
            ];
        case "Category":
            return $allowed_filters_for_Category = [
                'category_name' => function ($value) {
                    // Assuming category names can contain letters, numbers, and spaces
                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                },
                'time_of_creation' => function ($value) {
                    // Ensure the input is a valid datetime string
                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                },
                'status' => function ($value) {
                    // If statuses are predefined, validate against a list of valid statuses.
                    $validStatuses = ['active', 'inactive', 'pending'];
                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                },
                'super_category' => function ($value) {
                    // Assuming super category names follow the same pattern as category names.
                    if ($value)
                        return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                    return true; // if category is of the highest order

                },
                'account_id' => function ($value) {
                    // Ensure the account_id is a positive integer.
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
            ];
        case "Event":
            return $allowed_filters_for_Event = [
                'id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'event_name' => function ($value) {
                    // Assuming event names can contain letters, numbers, spaces, and some special characters
                    return preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $value) && strlen($value) <= 128;
                },
                'rating' => function ($value) {
                    // Ensure the rating is a valid float number, you might want to add range validation here
                    return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
                },
                'time_of_creation' => function ($value) {
                    // Ensure the input is a valid datetime string
                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                },
                'time_of_last_edit' => function ($value) {
                    // Ensure the input is a valid datetime string
                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                },
                'status' => function ($value) {
                    // If statuses are predefined, validate against a list of valid statuses.
                    $validStatuses = ['active', 'inactive', 'pending'];
                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                },
                'category_name' => function ($value) {
                    // Assuming category names can contain letters, numbers, and spaces
                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                },
                'owner_id' => function ($value) {
                    // Ensure the owner_id is a positive integer.
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
            ];
        case "Address":
            return $allowed_filters_for_Address = [
                'id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'Country' => function ($value) {
                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                },
                'zip' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                },
                'city' => function ($value) {
                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                },
                'street' => function ($value) {
                    return preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $value) && strlen($value) <= 128;
                },
                'street_number' => function ($value) {
                    return preg_match('/^[a-zA-Z0-9\s\/\-\_]+$/', $value) && strlen($value) <= 128;
                },
                'state' => function ($value) {
                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                },
                'date_of_creation' => function ($value) {
                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                },
                'status' => function ($value) {
                    $validStatuses = ['active', 'inactive', 'pending'];
                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                },
                'account_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
            ];
        case "Event_Instance":
            return $allowed_filters_for_EventInstance = [
                'id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'event_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'address_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'time_from' => function ($value) {
                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                },
                'time_to' => function ($value) {
                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                },
            ];
        case "Entrace_fee":
            return $allowed_filters_for_EntranceFee = [
                'instance_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'name' => function ($value) {
                    return is_string($value) && strlen($value) <= 128;
                },
                'shopping_method' => function ($value) {
                    $validStatuses = ['online', 'cash', 'card'];// make up some status names
                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                },
                'cost' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value >= 0;
                },
                'max_tickets' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                },
                'sold_tickets' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                },
            ];
        case "Registration":
            $allowed_filters_for_Registration = [
                'id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'owner_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'instance_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'time_of_confirmation' => function ($value) {
                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                },
                'fee_name' => function ($value) {
                    return is_string($value) && strlen($value) <= 128;
                },
            ];
        case "Photos":
            $allowed_filters_for_Photos = [
                'id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'event_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'address_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
            ];
        case "Comment":
            $allowed_filters_for_Comment = [
                'id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'time_of_posting' => function ($value) {
                    return DateTime::createFromFormat('Y-m-d H:i:s', $value);
                },
                'author_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'super_comment' => function ($value) {
                    // Optional, as a comment may not have a parent comment.
                    return $value === null || (filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0);
                },
                'event_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
            ];
        default:
            sendResponse(500, "Back-End Fail, fetch_valid filters function failed.\n");
            exit;
    }
}

function fetch_method_tables_for_account_type($account_type, $method)
{
    switch ($account_type) {
        case "administrator":
            switch ($method){
                case "GET":
                    return ["Account", "Category", "Event", "Address", "Event_Instance", "Entrance_fee", "Registration", "Photos", "Comment"];
                case "POST":
                    return ["Account", "Category", "Event", "Address", "Event_Instance", "Entrance_fee", "Registration", "Photos", "Comment", "Logout"];
                case"PUT":
                    return ["Account", "Category", "Event", "Address", "Registration"];
                case "DELETE":
                    return ["Account", "Category", "Event", "Address", "Event_Instance", "Photos", "Comment"];
                default:
                    return [];
            }
        case "moderator":
            switch ($method){
                case "GET":
                    return ["Account", "Category", "Event", "Address", "Event_Instance", "Entrance_fee", "Registration", "Photos", "Comment"];
                case "POST":
                    return ["Logout"];
                case "PUT" :
                    return ["Account", "Category", "Event", "Address"];
                case "DELETE":
                    return ["Category", "Event", "Event_Instance", "Address", "Comment"]; // Event_Instance is questionable
                default:
                    return [];
            }
        case "user":
            switch ($method){
                case "GET":
                    return ["Account", "Category", "Event", "Address", "Event_Instance", "Entrance_fee", "Registration", "Photos", "Comment"];
                case "POST":
                    return ["Category", "Event", "Address", "Event_Instance", "Entrance_fee", "Registration", "Photos", "Comment", "Logout"];
                case "PUT":
                    return ["Account", "Registration"];
                case "DELETE":
                    return ["Event", "Event_Instance", "Entrance_fee", "Registration", "Photos", "Comment"];
                default:
                    return [];
            }
        case "not_logged_in":
            switch ($method){
                case "GET":
                    return ["Account", "Event", "Event_Instance", "Entrance_fee", "Photos", "Comment"];
                case "POST" :
                    return ["Account", "Login"]; // registracia + login
                case "PUT":
                    return [];
                case "DELETE":
                    return [];
                default:
                    return [];
            }
    }
}

function fetch_gettable_columns_for_table($table)
{
    switch ($table){
        case "Account":
            return 'id, email, first_name, last_name, nick, account_type, photo, status';
        default:
            return '*';
    }

}

function fetch_required_columns($table, $method)
{
    switch ($method){
        case "POST":
            switch ($table){
                case "Account": // email is our unofficial id for Account + account_type is used by sessions to validate access -> they are required
                    return $required_columns = ['email', 'account_type'];
                case "Category":
                    return $required_columns = ['category_name'];
                case "Event":
                    return $required_columns = [];
                case "Address":
                    return $required_columns = [];
                case "Event_Instance":
                    return $required_columns = ['event_id', 'address_id'];
                case "Entrance_fee":
                    return $required_columns = ['instance_id'];
                case "Registration":
                    return $required_columns = ['instance_id'];
                case "Photos":
                    return $required_columns = ['event_id', 'address_id'];
                case "Comment":
                    return $required_columns = ['event_id'];
                case "Login":
                    return $required_columns = ['email', 'password'];
                case "Logout":
                    return $required_columns = [];
            }
        case "GET":
            return [];
        default:
            switch ($table){
                case "Account": // email is our unofficial id for Account + account_type is used by sessions to validate access -> they are required
                    return $required_columns = ['id'];
                case "Category":
                    return $required_columns = ['category_name'];
                case "Event":
                    return $required_columns = ['id'];
                case "Address":
                    return $required_columns = ['id'];
                case "Event_Instance":
                    return $required_columns = ['id'];
                case "Entrance_fee":
                    return $required_columns = ['instance_id', 'name'];
                case "Registration":
                    return $required_columns = ['id'];
                case "Photos":
                    return $required_columns = ['id'];
                case "Comment":
                    return $required_columns = ['id'];
            }
    }
}

function fetch_filter_operation($filter)
{
    switch ($filter) {
        case "time_from":
            return ">=";
        case "time_to":
            return "<=";
        default:
            return "=";
    }
}


function validate_filters($table, $filters)
{
    $isValid = true;
    $valid_filter_check = fetch_valid_column_filters($table);

    foreach ($filters as $key => $value) {
        // Check if the filter is allowed and valid
        if (isset($valid_filter_check[$key]) && is_callable($valid_filter_check[$key])) {
            if (!$valid_filter_check[$key]($value)) {
                $isValid = false;
                // print("Invalid filter: $key with value: $value\n");
                break;
            }
        } else {
            $isValid = false;
            // print("Invalid filter: $key with value: $value\n");
            break;
        }
    }

    return $isValid;
}

function item_exists($db, $table, $id_string, $id_array)
{
    // $query = "SELECT COUNT(*) FROM $table WHERE id = :id";
    $query = "SELECT COUNT(*) FROM $table WHERE $id_string";

    $stmt = $db->prepare($query);
    foreach ($id_array as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    // $stmt->bindParam(':id', $id);
    $stmt->execute();

    return $stmt->fetchColumn() > 0;
}

function fetch_valid_columns($account_type, $method, $table)
{
    switch ($account_type) {
        case "administrator":
            switch ($method) {
                case "POST":
                    switch ($table){
                        case "Account":
                            return $allowed_filters_for_Account = [
                                'email' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                                },
                                'first_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'last_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'nick' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'password' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'photo' => function ($value){
                                    return true;
                                },
                            ];
                        case "Category":
                            return $allowed_filters_for_Category = [
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'super_category' => function ($value) {
                                    if ($value)
                                        return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                    return true; // if category is of the highest order

                                },
                            ];
                        case "Event":
                            return $allowed_filters_for_Event = [
                                'event_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $value) && strlen($value) <= 128;
                                },
                                'description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'icon' => function ($value){
                                    return true;
                                },
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                            ];
                        case "Address":
                            return $allowed_filters_for_Address = [
                                'Country' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'zip' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                                },
                                'city' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'street' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $value) && strlen($value) <= 128;
                                },
                                'street_number' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s\/\-\_]+$/', $value) && strlen($value) <= 128;
                                },
                                'state' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                            ];
                        case "Event_Instance":
                            return $allowed_filters_for_EventInstance = [
                                'event_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'address_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'time_from' => function ($value) {
                                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                                },
                                'time_to' => function ($value) {
                                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                                },
                            ];
                        case "Entrace_fee":
                            return $allowed_filters_for_EntranceFee = [
                                'instance_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'name' => function ($value) {
                                    return is_string($value) && strlen($value) <= 128;
                                },
                                'shopping_method' => function ($value) {
                                    $validStatuses = ['online', 'cash', 'card'];// make up some status names
                                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                                },
                                'cost' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value >= 0;
                                },
                                'max_tickets' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                                },
                                // 'sold_tickets' => function ($value) {
                                //     return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                                // },
                            ];
                        case "Registration":
                            return $allowed_filters_for_Registration = [
                                'instance_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'fee_name' => function ($value) {
                                    return is_string($value) && strlen($value) <= 128;
                                },
                            ];
                        case "Photos":
                            return $allowed_filters_for_Photos = [
                                'photo' => function ($value) {
                                    return !empty($value) && is_string($value);
                                },
                                'event_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'address_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Comment":
                            return $allowed_filters_for_Comment = [
                                'comment_text' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'super_comment' => function ($value) {
                                    return $value === null || (filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0);
                                },
                                'event_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Logout":
                            return [];
                        default:
                            sendResponse(500, "Back-End Fail, fetch_valid function failed.\n");
                            exit;
                    }
                case "PUT":
                    switch ($table){
                        case "Account":
                            return $allowed_filters_for_Account = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'email' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                                },
                                'first_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'last_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'nick' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'password' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'account_type' => function ($value) {
                                    $validAccountTypes = ['user', 'moderator', 'administrator'];
                                    return in_array($value, $validAccountTypes, true);
                                },
                                'photo' => function ($value){
                                    return true;
                                },
                                'status' => function ($value) {
                                    $validStatuses = ['active', 'inactive', 'banned']; // TODO add statuses
                                    return in_array($value, $validStatuses, true);
                                },
                            ];
                        case "Category":
                            return $allowed_filters_for_Category = [
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'status' => function ($value) {
                                    $validStatuses = ['active', 'inactive', 'pending'];
                                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                                },
                            ];
                        case "Event":
                            return $allowed_filters_for_Event = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'event_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $value) && strlen($value) <= 128;
                                },
                                'description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'icon' => function ($value) {
                                    return !empty($value) && is_string($value);
                                },
                                'rating' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
                                },
                                'status' => function ($value) {
                                    $validStatuses = ['active', 'inactive', 'pending'];
                                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                                },
                            ];
                        case "Address":
                            return $allowed_filters_for_Address = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'Country' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'zip' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                                },
                                'city' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'street' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $value) && strlen($value) <= 128;
                                },
                                'street_number' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s\/\-\_]+$/', $value) && strlen($value) <= 128;
                                },
                                'state' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'status' => function ($value) {
                                    $validStatuses = ['active', 'inactive', 'pending'];
                                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                                },
                            ];
                        case "Event_Instance":
                            return $allowed_filters_for_EventInstance = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'time_from' => function ($value) {
                                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                                },
                                'time_to' => function ($value) {
                                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                                },
                            ];
                        case "Entrance_fee": //TODO maybe add 'id' tp this db table -> otherwise requires unique handling
                            return $allowed_filters_for_EntranceFee = [
                                'instance_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'name' => function ($value) {
                                    return is_string($value) && strlen($value) <= 128;
                                },
                                'shopping_method' => function ($value) {
                                    $validStatuses = ['online', 'cash', 'card'];// make up some status names
                                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                                },
                                'cost' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value >= 0;
                                },
                                'max_tickets' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                                },
                                'sold_tickets' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                                },
                            ];
                        case "Registration":
                            return $allowed_filters_for_Registration = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Photos":
                            return $allowed_filters_for_Photos = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'photo' => function ($value) {
                                    return !empty($value) && is_string($value);
                                },
                            ];
                        case "Comment":
                            return $allowed_filters_for_Comment = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'comment_text' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                            ];
                        default:
                            sendResponse(500, "Back-End Fail, fetch_valid function failed.\n");
                            exit;
                    }
                case "DELETE":
                    switch ($table){
                        case "Account":
                            return $allowed_filters_for_Account = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Category":
                            return $allowed_filters_for_Category = [
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                            ];
                        case "Event":
                            return $allowed_filters_for_Event = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Address":
                            return $allowed_filters_for_Address = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Event_Instance":
                            return $allowed_filters_for_EventInstance = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Entrace_fee": //TODO maybe add 'id' tp this db table -> otherwise requires unique handling
                            return $allowed_filters_for_EntranceFee = [
                                'instance_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'name' => function ($value) {
                                    return is_string($value) && strlen($value) <= 128;
                                },
                            ];
                        case "Registration":
                            return $allowed_filters_for_Registration = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Photos":
                            return $allowed_filters_for_Photos = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Comment":
                            return $allowed_filters_for_Comment = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        default:
                            sendResponse(500, "Back-End Fail, fetch_valid function failed.\n");
                            exit;
                    }
                default:
                    sendResponse(500, "Back-End Fail, fetch_valid function failed on method selection.\n");
            }
        case "moderator":
            switch ($method) {
                case "PUT":
                    switch ($table){
                        case "Account":
                            return $allowed_filters_for_Account = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'email' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                                },
                                'first_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'last_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'nick' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'password' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'photo' => function ($value){
                                    return true;
                                },
                                // 'status' => function ($value) {
                                //     $validStatuses = ['active', 'inactive', 'banned']; // TODO add statuses
                                //     return in_array($value, $validStatuses, true);
                                // },
                            ];
                        case "Category":
                            return $allowed_filters_for_Category = [
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'status' => function ($value) {
                                    $validStatuses = ['active', 'inactive', 'pending'];
                                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                                },
                            ];
                        case "Event":
                            return $allowed_filters_for_Event = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'status' => function ($value) {
                                    $validStatuses = ['active', 'inactive', 'pending'];
                                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                                },
                            ];
                        case "Address":
                            return $allowed_filters_for_Address = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'status' => function ($value) {
                                    $validStatuses = ['active', 'inactive', 'pending'];
                                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                                },
                            ];
                        default:
                            sendResponse(500, "Back-End Fail, fetch_valid function failed.\n");
                            exit;
                    }
                case "DELETE":
                    switch ($table){
                        case "Category":
                            return $allowed_filters_for_Category = [
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                            ];
                        case "Event":
                            return $allowed_filters_for_Event = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Address":
                            return $allowed_filters_for_Address = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Event_Instance":
                            return $allowed_filters_for_EventInstance = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Comment":
                            return $allowed_filters_for_Comment = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        default:
                            sendResponse(500, "Back-End Fail, fetch_valid function failed.\n");
                            exit;
                    }
                default:
                    sendResponse(500, "Back-End Fail, fetch_valid function failed on method selection.\n");
            }
        case "user":
            switch ($method) {
                case "POST":
                    switch ($table){
                        case "Category":
                            return $allowed_filters_for_Category = [
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'super_category' => function ($value) {
                                    if ($value)
                                        return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                    return true; // if category is of the highest order

                                },
                            ];
                        case "Event":
                            return $allowed_filters_for_Event = [
                                'event_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $value) && strlen($value) <= 128;
                                },
                                'description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'icon' => function ($value){
                                    return true;
                                },
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                            ];
                        case "Address":
                            return $allowed_filters_for_Address = [
                                'Country' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'zip' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                                },
                                'city' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'street' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $value) && strlen($value) <= 128;
                                },
                                'street_number' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s\/\-\_]+$/', $value) && strlen($value) <= 128;
                                },
                                'state' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                            ];
                        case "Event_Instance":
                            return $allowed_filters_for_EventInstance = [
                                'event_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'address_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'time_from' => function ($value) {
                                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                                },
                                'time_to' => function ($value) {
                                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                                },
                            ];
                        case "Entrace_fee":
                            return $allowed_filters_for_EntranceFee = [
                                'instance_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'name' => function ($value) {
                                    return is_string($value) && strlen($value) <= 128;
                                },
                                'shopping_method' => function ($value) {
                                    $validStatuses = ['online', 'cash', 'card'];// make up some status names
                                    return in_array($value, $validStatuses, true) && strlen($value) <= 64;
                                },
                                'cost' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value >= 0;
                                },
                                'max_tickets' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                                },
                                // 'sold_tickets' => function ($value) {
                                //     return filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
                                // },
                            ];
                        case "Registration":
                            return $allowed_filters_for_Registration = [
                                'instance_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'fee_name' => function ($value) {
                                    return is_string($value) && strlen($value) <= 128;
                                },
                            ];
                        case "Photos":
                            return $allowed_filters_for_Photos = [
                                'photo' => function ($value) {
                                    return !empty($value) && is_string($value);
                                },
                                'event_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'address_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Comment":
                            return $allowed_filters_for_Comment = [
                                'comment_text' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'super_comment' => function ($value) {
                                    return $value === null || (filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0);
                                },
                                'event_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Logout":
                            return [];
                        default:
                            sendResponse(500, "Back-End Fail, fetch_valid function failed.\n");
                            exit;
                    }
                case "PUT":
                    switch ($table){
                        case "Account":
                            return $allowed_filters_for_Account = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'email' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                                },
                                'first_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'last_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'nick' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'password' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'photo' => function ($value){
                                    return true;
                                },
                                // 'status' => function ($value) {
                                //     $validStatuses = ['active', 'inactive', 'banned']; // TODO add statuses
                                //     return in_array($value, $validStatuses, true);
                                // },
                            ];
                        case "Registration":
                            return $allowed_filters_for_Registration = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        default:
                            sendResponse(500, "Back-End Fail, fetch_valid function failed.\n");
                            exit;
                    }
                case "DELETE":
                    switch ($table){
                        case "Event":
                            return $allowed_filters_for_Event = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Event_Instance":
                            return $allowed_filters_for_EventInstance = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Entrace_fee": //TODO maybe add 'id' tp this db table -> otherwise requires unique handling
                            return $allowed_filters_for_EntranceFee = [
                                'instance_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'name' => function ($value) {
                                    return is_string($value) && strlen($value) <= 128;
                                },
                            ];
                        case "Registration":
                            return $allowed_filters_for_Registration = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Photos":
                            return $allowed_filters_for_Photos = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        case "Comment":
                            return $allowed_filters_for_Comment = [
                                'id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                            ];
                        default:
                            sendResponse(500, "Back-End Fail, fetch_valid function failed.\n");
                            exit;
                    }
                default:
                    sendResponse(500, "Back-End Fail, fetch_valid function failed on method selection.\n");
            }
        case "not_logged_in":
            switch ($method) {
                case "POST":
                    switch ($table){
                        case "Account":
                            return $allowed_filters_for_Account = [
                                'email' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                                },
                                'first_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'last_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'nick' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'password' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                                'photo' => function ($value){
                                    return true;
                                },
                            ];
                        case "Login":
                            return $allowed_filters_for_Comment = [
                                'email' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                                },
                                'password' => function ($value) {
                                    return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
                                },
                            ];
                        default:
                            sendResponse(500, "Back-End Fail, fetch_valid function failed.\n");
                            exit;
                    }
                default:
                    sendResponse(500, "Back-End Fail, fetch_valid function failed on method selection.\n");
            }
    }
}

// increment sold_tickets on PUT
function add_missing_data($account_type, $method, $table, &$data)
{
    switch ($account_type) {
        case "administrator":
            switch ($method) {
                case "POST":
                    switch ($table) {
                        case "Account":
                            $data['account_type'] = 'user';
                            $data['status'] = 'active'; // account status is whatever atm..
                            return;
                        case "Category":
                            $data['status'] = 'pending';
                            $data['time_of_creation'] = date("Y-m-d H:i:s");
                            $data['account_id'] = $_SESSION['id'];
                            return;
                        case "Event":
                            $data['status'] = 'pending';
                            $data['time_of_creation'] = date("Y-m-d H:i:s");
                            $data['time_of_last_edit'] = date("Y-m-d H:i:s");
                            $data['owner_id'] = $_SESSION['id'];
                            return;
                        case "Address":
                            $data['status'] = 'pending';
                            $data['date_of_creation'] = date("Y-m-d H:i:s");
                            $data['account_id'] = $_SESSION['id'];
                            return;
                        case "Entrance_fee":
                            $data['sold_tickets'] = 0; // do we want this?
                            return;
                        case "Registration":
                            $data['owner_id'] = $_SESSION['id'];
                        case "Comment":
                            $data['time_of_posting'] = date("Y-m-d H:i:s");
                            $data['author_id'] = $_SESSION['id'];
                            return;
                        default:
                            return;
                    }
                case "PUT":
                    switch ($table) {
                        case "Event":
                            $data['time_of_last_edit'] = date("Y-m-d H:i:s");
                            return;
                        case "Registration":
                            $data['time_of_confirmation'] = date("Y-m-d H-i-s");
                            return;
                        default:
                            return;

                    }
                default:
                    return;
            }
        case "moderator":
            switch ($method) {
                case "PUT":
                    switch ($table) {
                        case "Event":
                            $data['time_of_last_edit'] = date("Y-m-d H:i:s");
                            return;
                        default:
                            return;
                    }
                default:
                    return;
            }
        case "user":
            switch ($method) {
                case "POST":
                    switch ($table) {
                        case "Category":
                            $data['status'] = 'pending';
                            $data['time_of_creation'] = date("Y-m-d H:i:s");
                            $data['account_id'] = $_SESSION['id'];
                            return;
                        case "Event":
                            $data['status'] = 'pending';
                            $data['time_of_creation'] = date("Y-m-d H:i:s");
                            $data['time_of_last_edit'] = date("Y-m-d H:i:s");
                            $data['owner_id'] = $_SESSION['id'];
                            return;
                        case "Address":
                            $data['status'] = 'pending';
                            $data['date_of_creation'] = date("Y-m-d H:i:s");
                            $data['account_id'] = $_SESSION['id'];
                            return;
                        case "Entrance_fee":
                            $data['sold_tickets'] = 0; // do we want this?
                            return;
                        case "Registration":
                            $data['owner_id'] = $_SESSION['id'];
                            return;
                        case "Comment":
                            $data['time_of_posting'] = date("Y-m-d H:i:s");
                            $data['author_id'] = $_SESSION['id'];
                            return;
                        default:
                            return;
                    }
                case "PUT":
                    switch ($table) {
                        case "Registration":
                            $data['time_of_confirmation'] = date("Y-m-d H-i-s");
                            return;
                        default:
                            return;
                    }
                default:
                    return;
            }
        case "not_logged_in":
            switch ($method) {
                case "POST":
                    switch ($table) {
                        case "Account":
                            $data['account_type'] = 'user';
                            $data['status'] = 'active'; // account status is whatever atm..
                            return;
                        default:
                            return;
                    }
                default:
                    return;
            }
    }
}

function validate_data($table, $data, $method, $account_type)
{
    if($method == 'GET' || $table == 'Logout') // works fine without this if, but return error codes for foreach
        return $data === null;

    $isValid = true;
    $required_columns = fetch_required_columns($table, $method);
    $valid_data_check = fetch_valid_columns($account_type, $method, $table);

    // check if all required columns are present
    foreach ($required_columns as $required_column) {
        if (!isset($data, $required_column)) {
            $isValid = false;
            break;
        }
    }

    if ($isValid) {
        foreach ($data as $key => $value) {
            // Check if the filter is allowed and valid
            if (isset($valid_data_check[$key]) && is_callable($valid_data_check[$key])) {
                if (!$valid_data_check[$key]($value)) {
                    $isValid = false;
                    print("Invalid value: $key with value: \"$value\"\n");
                    break;
                }
            } else {
                $isValid = false;
                print("invalid value: $key with value: \"$value\"\n");
                break;
            }
        }
    }

    return $isValid;
}

function get_pdo_statement($query, $id_array) {
    global $db;
    $stmt = $db->prepare($query);
    if ($id_array) {
        foreach ($id_array as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
    }
    $stmt->execute();
    return $stmt;
}

function fetch_table_column($table, $return_id, $id_array, $id_string)
{
    $query = "SELECT $return_id FROM $table WHERE $id_string";
    $stmt = get_pdo_statement($query, $id_array);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result[$return_id] : null;
}

function fetch_table_columns($query, $id_array)
{
    $stmt = get_pdo_statement($query, $id_array);

    // Extract the values of the specified column into an array
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetch_all_table_columns($table, $return_id, $id_array, $id_string, $group_by) {
    $query = "SELECT $return_id FROM $table" . ($id_string ? " WHERE $id_string" : "") . ($group_by ? " GROUP BY $group_by" : "");
    return fetch_table_columns($query, $id_array);
}

function fetch_distinct_table_columns($table, $return_id, $id_array, $id_string) {
    $query = "SELECT DISTINCT $return_id FROM $table" . ($id_string ? " WHERE $id_string" : "");
    return fetch_table_columns($query, $id_array);
}

function check_user_ownership($db, $table, $id_array, $id_string)
{
    switch ($table) {
        case "Account":
            return $id_array['id'] == $_SESSION['id'];
        case "Category":
            $account_id = fetch_table_column($table, "account_id", $id_array, $id_string);
            return $account_id == $_SESSION['id'];
        case "Event":
            $owner_id = fetch_table_column($table, "owner_id", $id_array, $id_string);
            return $owner_id == $_SESSION['id'];
        case "Address":
            $account_id = fetch_table_column($table, "account_id", $id_array, $id_string);
            return $account_id == $_SESSION['id'];
        case "Event_instance":
            $event_id = fetch_table_column($table, "event_id", $id_array, $id_string);
            if (!$event_id)
                return false;
            $account_id = fetch_table_column("Event", "account_id", ["id"=>$event_id], "id = :id");
            return $account_id == $_SESSION['id'];
        case "Entrance_fee":
            $instance_id = fetch_table_column($table, "instance_id", $id_array, $id_string);
            if (!$instance_id)
                return false;
            $event_id = fetch_table_column("Event_instance", "event_id", ["id"=>$instance_id], "id = :id");
            if (!$event_id)
                return false;
            $owner_id = fetch_table_column("Event", "owner_id", ["id"=>$event_id], "id = :id");
            return $owner_id == $_SESSION['id'];
        case "Registration":
            $owner_id = fetch_table_column($table, "owner_id", $id_array, $id_string);
            return $owner_id == $_SESSION['id'];
        case "Comment":
            $author_id = fetch_table_column($table, "author_id", $id_array, $id_string);
            return $author_id == $_SESSION['id'];
    }
}

function get_id_string($id)
{
    $id_string = "";
    foreach($id as $key => $value) {
        $id_string .= "$key = :$key AND ";
    }
    $id_string = substr($id_string, 0, -5); // removes last 5 chars -> ' AND '

    return $id_string;
}

function extract_id(&$data, $table)
{
    $primary_keys = fetch_required_columns($table, 'PUT');

    $id = [];

    foreach($primary_keys as $primary_key) {
        $id[$primary_key] = $data[$primary_key];
        unset($data[$primary_key]);
    }

    return $id;
}

function session_handler($db, $table, $data, $account_type)
{
    if ($table == "Login" && $account_type == "not_logged_in") {
        $query = "SELECT id, password, account_type FROM Account WHERE email = :email";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        $stored_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$stored_data){
            sendResponse(401, "No user with provided email exists.\n");
            return;
        }

        // if (password_verify($data['pwd'], $stored_data['pwd'])) { // right now we don't hash passwords
        if ($stored_data['password'] == $data['password']){
            $_SESSION['account_type'] = $stored_data['account_type'];
            $_SESSION['id'] = $stored_data['id'];
            sendResponse(200, "Log in successfull.\n");
        }
        else{
            sendResponse(401, "Log in failed: No email-password configuration found or valid.\n");
        }
    }
    else if ($table == 'Login' && $account_type != "not_logged_in") {
        sendResponse(200, "You are already logged in.\n");
    }
    else if ($table == 'Logout' && $account_type != "not_logged_in") {
        session_destroy();
        sendResponse(200, "Log out successfull.\n");
    }
    else {
        sendResponse(400, "Attempt to Log out error: user was never logged in.\n");
    }
}

// Utility function to send JSON responses
function sendResponse($statusCode, $message)
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode(['status' => $statusCode, 'message' => $message]);
}
?>
