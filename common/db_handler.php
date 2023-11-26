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
                'account_id' => function ($value) {
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
                    $validAccountTypes = ['regular', 'moderator', 'administrator'];
                    return in_array($value, $validAccountTypes, true);
                },
                'account_status' => function ($value) {
                    $validStatuses = ['active', 'inactive', 'banned'];
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
                'category_status' => function ($value) {
                    $validStatuses = ['approved', 'rejected', 'pending'];
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
        case "Administrator":
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
        case "Moderator":
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
        case "Regular":
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
        case "Administrator":
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
                                'profile_icon' => function ($value){
                                    return true;
                                },
                            ];
                        case "Category":
                            return $allowed_filters_for_Category = [
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'category_description' => function ($value) {
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
                                'event_description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'event_icon' => function ($value){
                                    return true;
                                },
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                            ];
                        case "Address":
                            return $allowed_filters_for_Address = [
                                'country' => function ($value) {
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
                                'address_description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                            ];
                        case "Event_instance":
                            return $allowed_filters_for_EventInstance = [
                                'event_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'address_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'time_from' => function ($value) {
                                    return DateTime::createFromFormat('H:i:s', $value) !== false;
                                },
                                'time_to' => function ($value) {
                                    return DateTime::createFromFormat('H:i:s', $value) !== false;
                                },
                                'date_from' => function ($value) {
                                    return DateTime::createFromFormat('Y-m-d', $value) !== false;
                                },
                                'date_to' => function ($value) {
                                    return DateTime::createFromFormat('Y-m-d', $value) !== false;
                                },
                            ];
                        case "Entrace_fee":
                            return $allowed_filters_for_EntranceFee = [
                                'instance_id' => function ($value) {
                                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                                },
                                'fee_name' => function ($value) {
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
                                'photo_path' => function ($value) {
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
                                'account_id' => function ($value) {
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
                                    $validAccountTypes = ['Regular', 'Moderator', 'Administrator'];
                                    return in_array($value, $validAccountTypes, true);
                                },
                                'profile_icon' => function ($value){
                                    return true;
                                },
                                'account_status' => function ($value) {
                                    $validStatuses = ['active', 'inactive', 'banned']; // TODO add statuses
                                    return in_array($value, $validStatuses, true);
                                },
                            ];
                        case "Category":
                            return $allowed_filters_for_Category = [
                                'category_name' => function ($value) {
                                    return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'category_description' => function ($value) {
                                    return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                                },
                                'category_status' => function ($value) {
                                    $validStatuses = ['approved', 'rejected', 'pending'];
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
        case "Moderator":
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
        case "Regular":
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
                                'country' => function ($value) {
                                    return preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'zip' => function ($value) {
                                    return empty($value) || filter_var($value, FILTER_VALIDATE_INT) !== false && $value >= 0;
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
                                    return empty($value) || preg_match('/^[a-zA-Z\s]+$/', $value) && strlen($value) <= 128;
                                },
                                'address_description' => function ($value) {
                                    return empty($value) || is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
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
    return $stmt;
}

function insert_into_table($table, array &$id_array) {
    $columns_array = array_keys($id_array);
    $values_array = array_map(function ($key) {
        return ':' . $key;
    }, $columns_array);
    $values = implode(', ', $values_array);
    $columns = implode(', ', $columns_array);
    $query = "INSERT INTO $table ($columns) VALUES ($values)";
    $stmt = get_pdo_statement($query, $id_array);
    return $stmt->execute();
}

function update_table_column($table, $update_query, $id_string, $id_array) {
    $query = "UPDATE $table $update_query WHERE $id_string";
    echo $query;
    $stmt = get_pdo_statement($query, $id_array);
    return  $stmt->execute();
}

function update_table_row($table, array &$columns_to_update, $search_by_attribute, $search_by_value) {
    $update_query_parts = [];
    $id_array = [];
    foreach($columns_to_update as $attribute => $value) {
        array_push($update_query_parts, "$attribute = :$attribute");
        $id_array[$attribute] = $value;
    }
    $id_array[$search_by_attribute] = $search_by_value;
    $query = "UPDATE $table SET ".implode(', ', $update_query_parts)." WHERE $search_by_attribute = :$search_by_attribute";
    $stmt = get_pdo_statement($query, $id_array);
    return $stmt->execute();
}

function find_table_column($return_column, $table, $id_array) {
    $query_parts = [];
    foreach($id_array as $attribute => $value) {
        array_push($query_parts, "$attribute = :$attribute");
    }
    $query = "SELECT $return_column FROM $table WHERE ".implode(' AND ', $query_parts);
    $stmt = get_pdo_statement($query, $id_array);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result[$return_column] : null;
}

function delete_from_table($table, &$delete_values, $attribute) {
    $query_parts = [];
    $id_array = [];
    for ($i = 0; $i < sizeof($delete_values); $i++) {
        array_push($query_parts, "$attribute = :$attribute"."$i");
        $id_array[$attribute.$i] = $delete_values[$i];
    }
    $query = "DELETE FROM $table WHERE ".implode(' OR ', $query_parts);
    $stmt = get_pdo_statement($query, $id_array);
    return $stmt->execute();
}

function fetch_table_column($table, $return_id, $id_array = null, $id_string = null)
{
    $query = "SELECT $return_id FROM $table".($id_string ? " WHERE $id_string" : '');
    $stmt = get_pdo_statement($query, $id_array);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result[$return_id] : null;
}

function fetch_table_entry($table, $return_id, $id_array, $id_string) {
    $query = "SELECT $return_id FROM $table WHERE $id_string";
    $stmt = get_pdo_statement($query, $id_array);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function fetch_table_columns($query, $id_array)
{
    $stmt = get_pdo_statement($query, $id_array);
    $stmt->execute();
    // Extract the values of the specified column into an array
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetch_all_table_columns($table, $return_id, $id_array, $id_string, $group_by = null) {
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

function verifyMethod($method_name) {
    return $_SERVER['REQUEST_METHOD'] == $method_name;
}

function verifyToken(&$method) {
    return isset($method['token']) && isset($_SESSION['token']) && $method['token'] == $_SESSION['token'];
}

function session_handler($table, $data, $account_type)
{
    if ($table == "Login" && $account_type == "not_logged_in") {
        $account = fetch_table_entry("Account", "*", ["email" => $data['email']], "email = :email");


        if (!$account){
            sendResponse(401, "No user with provided email exists.\n");
            return;
        }

        // if (password_verify($data['pwd'], $stored_data['pwd'])) { // right now we don't hash passwords
        if ($account['password'] == $data['password']){
            $_SESSION["USER"] = [];
            foreach($account as $attribute => $value) {
                $_SESSION["USER"][$attribute] = $value;
            }
            return;
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

function redirect(string $path) {
    header('Location: ' . (isset($_SESSION['return_to']) ? $_SESSION['return_to'] : $path));
    exit;
}

function redirectForce(string $path) {
    header("Location: $path");
    exit;
}

// TODO: get - no special chars echo - htmlspecialchars
function getUserAttribute($attribute) {
    return $_SESSION['USER'][$attribute] ?? null;
}

function setUserAttribute($attribute, $value) {
    $_SESSION['USER'][$attribute] = $value;
}

function echoUserAttribute($attribute) {
    echo getUserAttribute($attribute);
}

function getUserIcon(&$user = null) {
    $default = 'user-icons/default.webp';
    if ($user) {
        return $user['profile_icon'] ?? $default;
    } else {
        return $_SESSION['USER']['profile_icon'] ?? $default;
    }
}

function getEventIcon(&$event) {
    return $event['event_icon'] ?? 'event-icons/default.jpg';
}

function getProfileAttributes($account_id) {
    return fetch_table_entry("Account", "*", ['account_id' => $account_id], "account_id = :account_id");
}

function getUserTickets($account_id) {
    $tables = 'Address a JOIN Event_instance ei ON a.address_id = ei.address_id JOIN Event e ON e.event_id = ei.event_id
    JOIN Entrance_fee ef ON ef.instance_id = ei.instance_id JOIN Registration r on r.instance_id = ef.instance_id';
    $return_id = 'e.event_name, e.event_id, ei.instance_id, ei.date_from, ei.time_from, ei.date_to, ei.time_to, a.city,
    a.street, a.street_number, a.country';
    return fetch_all_table_columns($tables, $return_id, ["account_id" => $account_id], 'r.account_id = :account_id', $return_id);
}

function getRegistrations($account_id, $instance_id, bool $confirmed) {
    $condition = $confirmed ? "IS NOT NULL" : "IS NULL";
    $tables = 'Entrance_fee ef JOIN Registration r ON ef.fee_name = r.fee_name AND ef.instance_id = r.instance_id';
    $return_id = 'ef.fee_name, SUM(r.ticket_count) as tickets_total';
    $group_by = 'ef.fee_name';
    $id_string = "r.account_id = :account_id and r.time_of_confirmation $condition and ef.instance_id = :instance_id";
    $id_array = ['account_id' => $account_id, 'instance_id' => $instance_id];
    return fetch_all_table_columns($tables, $return_id, $id_array, $id_string, $group_by);
}

function getEventLink($event_id) {
    return "event-detail.php?event_id=" . $event_id;
}

function formatAddress(array &$address) {
    return $address['country'] . ', ' . $address['city'] . ', ' . $address['street']. ' ' . $address['street_number'];
}

function formatTime(array &$time, $date_column, $time_column) {
    return $time[$date_column].' '.$time[$time_column];
}

function addInFilter(array &$id_array, array &$query_parts, array $filter_array, $filter_name, $filter_owner) {
    for($i = 0; $i < sizeof($filter_array); $i++) {
        $id_array[$filter_name.$i] = $filter_array[$i] ;
        $filter_array[$i] = ':'.$filter_name.$i;
    }
    $values = implode(', ', $filter_array);
    array_push($query_parts, "$filter_owner.$filter_name in ($values)");
}



function getAccounts() {
    $id_array = [];
    $query_parts = [];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["search-bar"])) {
            $pattern  = '%' . $_GET["search-bar"] . '%';
            $id_array['email'] = $pattern;
            $id_array['nick'] = $pattern;
            $id_array['first_name'] = $pattern;
            $id_array['last_name'] = $pattern;
            array_push($query_parts, '( nick LIKE :nick OR email LIKE :email OR first_name LIKE :first_name OR last_name LIKE :last_name )');
        }
        if (isset($_GET["account_status"]) && $_GET['account_status'] != 'all' ) {
            $id_array['status'] = $_GET["account_status"];
            array_push($query_parts, 'account_status = :status');
        }
        if (isset($_GET['account_type_filter'])) {
            $id_array['type'] = $_GET['account_type_filter'];
            array_push($query_parts, 'account_type = :type');
        }
    }

    return fetch_all_table_columns('Account', '*', $id_array, implode(' and ', $query_parts));
}

function getEventCount() {
    return fetch_table_column('Event', 'COUNT(*)');
}

function getEvents($events_allowed, $account_id = null) {
    $id_array = [];
    $query_parts = [];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["categories"])) {
            addInFilter($id_array, $query_parts, $_GET["categories"], "category_id", "e");
        }
        if (isset($_GET["locations"])) {
            addInFilter($id_array, $query_parts, $_GET["locations"], "city", "a");
        }
        if (isset($_GET["min_rating"])) {
            $id_array['min_rating'] = $_GET["min_rating"];
            array_push($query_parts, 'e.rating >= :min_rating');
        }
        if (isset($_GET["max_rating"])) {
            $id_array['max_rating'] = $_GET["max_rating"];
            array_push($query_parts, 'e.rating <= :max_rating');
        }
        if (isset($_GET["date_from"]) && $_GET["date_from"] != "") {
            $id_array['date_from'] = $_GET['date_from'];
            array_push($query_parts, 'ei.date_from >= :date_from');
        }
        if (isset($_GET["date_to"]) && $_GET["date_to"] != "") {
            $id_array['date_to'] = $_GET['date_to'];
            array_push($query_parts, 'ei.date_to <= :date_to');
        }
        if (isset($_GET['search_bar']) && !empty($_GET['search_bar'])) { // search bar on manage events page
            $search_value = $_GET['search_bar'];
            $searchbar_query = [];
            // if there is number in the search bar it can be event ID.
            if(is_numeric($search_value)) {
                $id_array['event_id'] = $search_value;
                array_push($searchbar_query, 'e.event_id = :event_id');
            }
            $id_array['event_name'] = '%'.$search_value.'%';
            array_push($searchbar_query, 'e.event_name LIKE :event_name');
            array_push($query_parts, '('.implode(' OR ', $searchbar_query).')');
        } else if(isset($_GET["events_search_bar"]) && !empty($_GET['events_search_bar'])) { // global serch bar
            $id_array['event_name'] = '%'.$_GET['events_search_bar'].'%';
            array_push($query_parts, 'e.event_name LIKE :event_name');
        }
        // event status can only be selected on manage events page, hence the argument prevents non active events to be displayed on the main page
        if ($events_allowed == 'all' && isset($_GET['event_status']) && $_GET['event_status'] != 'all') { // all in GET is just a placeholder for all statuses
            $id_array['event_status'] = $_GET['event_status'];
            array_push($query_parts, 'e.event_status = :event_status');
        }
    }

    if ($events_allowed != 'all') {
        $id_array['event_status'] = $events_allowed;
        array_push($query_parts, 'e.event_status = :event_status');
    }

    if(!is_null($account_id)) {
        $id_array['account_id'] = $account_id;
        array_push($query_parts, 'e.account_id = :account_id');
    }

    $return_id = 'e.event_id, e.event_name, e.rating, e.event_status, acc.nick, GROUP_CONCAT(DISTINCT city) AS cities, MIN(date_from) AS earliest_date, MAX(date_to) AS latest_date';
    $table = "Event_instance ei JOIN Event e ON ei.event_id = e.event_id JOIN Address a ON ei.address_id = a.address_id JOIN Account acc on e.account_id = acc.account_id";
    $group_by = "e.event_id, e.event_name, e.rating, e.event_status, acc.nick";
    return fetch_all_table_columns($table, $return_id, $id_array, implode(' and ', $query_parts), $group_by);
}

function getEventIdsByStatus(array &$event_ids, string $status) : array {
    $id_string = 'event_status = :event_status AND event_id IN ('.implode(', ',$event_ids).')';
    $table_rows = fetch_all_table_columns('Event', 'event_id', ['event_status' => $status], $id_string);
    $result_array = [];
    foreach($table_rows as $row) {
        array_push($result_array, $row['event_id']);
    }
    return $result_array;
}

function getCategoryNameByStatus(array &$category_names, string $status) : array  {
    $id_string = 'category_status = :category_status AND category_name IN ('.implode(', ',$category_names).')';
    $table_rows = fetch_all_table_columns('Category', 'category_name', ['category_status' => $status], $id_string); // TODO: rename function
    $result_array = [];
    foreach($table_rows as $row) {
        array_push($result_array, $row['category_name']);
    }
    return $result_array;
}

function getTableColumnsByValue($table, string $return_column, array &$search_selection, string $filter_key, string $filter_value) : array {
    $id_string = "$filter_key = :$filter_key AND $return_column IN ".'("'.implode('", "', $search_selection).'")';
    $table_rows = fetch_all_table_columns($table, $return_column, [$filter_key => $filter_value], $id_string); // TODO: rename function
    $result_array = [];
    foreach($table_rows as $row) {
        array_push($result_array, $row[$return_column]);
    }
    return $result_array;
}

function dateBetween($date, $date_from, $date_to, $date_format) {
    return date($date_format, strtotime($date)) >= date($date_format, strtotime($date_from))
        && date($date_format, strtotime($date)) <= date($date_format, strtotime($date_to));
}

function sortEventsByPeriods(array &$events) {
    $date = date('Y-m-d');
    $periods = array();
    foreach($events as &$event) {
        $date_from = $event['earliest_date'];
        $date_to = $event['latest_date'];
        if (dateBetween($date, $date_from, $date_to, 'Y-m-d')) {
            $event['Today'] = true;
            $periods[0] = 'Today';
        } else if (dateBetween($date, $date_from, $date_to, 'Y-W')) {
            $event['This Week'] = true;
            $periods[1] = 'This Week';
        } else if (dateBetween($date, $date_from, $date_to, 'Y-m')) {
            $event['This Month'] = true;
            $periods[2] = 'This Month';
        } else if (dateBetween($date, $date_from, $date_to, 'Y')) {
            $event['This Year'] = true;
            $periods[3] = 'This Year';
        } else {
            $event['All Events'] = true;
            $periods[4] = 'All Events';
        }
    }
    return $periods;
}

function userIsLoggedIn() {
    return isset($_SESSION['USER']);
}

function idMatchesUser() {
    return key_exists('account_id', $_GET) && userIsLoggedIn() && $_SESSION['USER']['account_id'] == $_GET['account_id'];
}

function getCities() {
    return fetch_distinct_table_columns("Address", "city", null, 'address_status = "approved"');
}

function getApprovedLocations() {
    return fetch_distinct_table_columns("Address", "country, city, street, street_number, address_id", null, "address_status = 'approved'");
}

function getLocationProposals() {
    $tables = 'Address a JOIN Account acc ON a.account_id = acc.account_id';
    $return_id = 'a.address_id, a.country, a.city, a.street, a.street_number, a.state, a.zip, acc.nick';
    return fetch_distinct_table_columns($tables, $return_id, null, "a.address_status = 'pending'");
}

function getLocations() {
    $id_array = [];
    $query_parts = [];
    if(($_SERVER["REQUEST_METHOD"] == "GET")) {
        if(isset($_GET['search-bar']) && !empty($_GET['search-bar'])) {
            $search_value = $_GET['search-bar'];
            $search_bar_query_parts = [];
            if (is_numeric($search_value)) { // number can be used to search in numeric columns
                foreach(['zip', 'street_number', 'address_id'] as $column) {
                    $id_array[$column] = $search_value;
                }
                array_push($search_bar_query_parts, '(zip = :zip OR street_number = :street_number OR address_id = :address_id)');
            }
            $search_value = '%'.$search_value.'%';
            foreach(['country', 'city', 'street', 'state'] as $column) {
                $id_array[$column] = $search_value;
            }
            array_push($search_bar_query_parts, '(country LIKE :country OR city LIKE :city OR street LIKE :street OR state LIKE :state)');
            array_push($query_parts, '('.implode(' OR ', $search_bar_query_parts).')');
        }
        if(isset($_GET['address_status']) && $_GET['address_status'] != 'all') {
            $id_array['address_status'] = $_GET['address_status'];
            array_push($query_parts, 'address_status = :address_status');
        }
    }

    return fetch_distinct_table_columns('Address', '*', $id_array, implode(' AND ', $query_parts));
}

function checkRequired(&$method, array $required) {
    foreach($required as $required_value) {
        if(!key_exists($required_value, $method) || empty($method[$required_value])) {
            return false;
        }
    }
    return true;
}

function populateArray(&$method, array &$id_array, array &$values) {
    foreach($values as $value) {
        if(key_exists($value, $method)) {
            $id_array[$value] = $method[$value];
        } else {
            $id_array[$value] = 'NULL';
        }
    }
}

function storeInSession(&$method, array &$indexes, $prefix) {
    foreach($indexes as $index) {
        if(key_exists($index, $method)) {
            $_SESSION[$prefix.$index] = $method[$index];
        }
    }
}

function inSession($value) {
    return isset($_SESSION[$value]);
}

function updateSession(&$method, $session_items) {
    foreach($session_items as &$item) {
        if(isset($method[$item])) {
            $_SESSION[$item] = $method[$item];
        } else if (isset($_SESSION[$item])) {
            unset($_SESSION[$item]);
        }
    }
}


function getSessionVal($value, $default, $index = null) {
    if(!isset($_SESSION[$value])) {
        return htmlspecialchars($default);
    } else if(is_array($value)) {
        return htmlspecialchars($_SESSION[$value][$index]);
    } else {
        return htmlspecialchars($_SESSION[$value]);
    }
}

function echoSessionVal($value, $default, $index = null) {
    echo getSessionVal($value, $default, $index);
}

function getSelectSessionState($session_attribute, $value) {
    if (isset($_SESSION[$session_attribute]) && $_SESSION[$session_attribute] == $value) {
        return "selected";
    } else {
        return "";
    }
}

function echoSelectSessionState($session_attribute, $value) {
    echo getSelectSessionState($session_attribute, $value);
}

function getSelectSessionDefaultState($session_attribute, $default) {
    if(!isset($_SESSION[$session_attribute]) || $_SESSION[$session_attribute] == $default) {
        return 'selected';
    } else {
        return '';
    }
}

function echoSelectSessionDefaultState($session_attribute, $default) {
    echo getSelectSessionDefaultState($session_attribute, $default);
}

function getCheckBoxSessionState($checkbox_name, $value) {
    if(isset($_SESSION[$checkbox_name]) && in_array($value, $_SESSION[$checkbox_name])) {
        return " checked ";
    } else {
        return "";
    }
}

function unsetSessionAttributes(array &$attributes) {
    foreach($attributes as $attribute) {
        if(inSession($attribute)) {
            unset($_SESSION[$attribute]);
        }
    }
}

function getPendingCategories() {
    $return_id = "c.category_id, c.category_name, c.category_description, a.nick, c.super_category_id, c.category_status";
    $tables = "Category c JOIN Account a ON c.account_id = a.account_id ";
    return fetch_distinct_table_columns($tables, $return_id, null, "category_status = 'pending'");
}

function getCategories() {
    $id_array = [];
    $query_parts = [];
    if(($_SERVER["REQUEST_METHOD"] == "GET")) {
        if(isset($_GET['search-bar']) && !empty($_GET['search-bar'])) {
            $id_array['category_name'] = '%'.$_GET['search-bar'].'%';
            array_push($query_parts, 'c.category_name LIKE :category_name');
        }
        if(isset($_GET['category_status']) && $_GET['category_status'] != 'all') {
            $id_array['category_status'] = $_GET['category_status'];
            array_push($query_parts, 'c.category_status = :category_status');
        }
    }

    $return_id = "c.category_id, c.category_name, c.category_description, a.nick, c.super_category_id, c.category_status";
    $tables = "Category c JOIN Account a ON c.account_id = a.account_id ";
    return fetch_distinct_table_columns($tables, $return_id, $id_array, implode(' AND ', $query_parts));
}

function getSubCategories($parent_category = null) {
    $id_array = ($parent_category ? ["super_category_id" => $parent_category] : null);
    $id_string = "super_category_id " . ($parent_category ? "= :super_category_id" : "IS NULL");
    $id_string.=" and category_status = 'approved'";

    return fetch_distinct_table_columns("Category", "category_id, category_name, super_category_id", $id_array, $id_string);
}

function userIsAdmin() {
    return userIsLoggedIn() && getUserAttribute('account_type') == 'administrator';
}

function userIsModerator() {
    return userIsAdmin() || (userIsLoggedIn() && getUserAttribute('account_type') == 'moderator' );
}

function userIsRegular(){
    return userIsLoggedIn() && getUserAttribute('account_type') == 'regular';
}

function echoCurrentPage() {
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
}

function getEventInfo($event_id) {
    // TODO: validate ID
    return fetch_table_entry('Event', '*', ['event_id' => $event_id], 'event_id = :event_id');
}

function getEventPhotos($event_id) {
    // TODO: validate ID
    return fetch_all_table_columns('Photos p JOIN Event e ON p.event_id = e.event_id', 'p.photo_path', ['event_id' => $event_id], 'p.event_id = :event_id');
}

function getEventInstances($event_id) {
    return fetch_all_table_columns('Event_instance', '*', ['event_id' => $event_id], 'event_id = :event_id');
}

function getInstanceEntranceFees($instance_id) {
    return fetch_all_table_columns('Entrance_fee', '*', ['instance_id' => $instance_id], 'instance_id = :instance_id');
}

function userIsOwner($event_id) {
    if (!userIsLoggedIn()) {
        return false;
    }
    $event_owner = fetch_table_column('Event', 'account_id', ['event_id' => $event_id], 'event_id = :event_id');
    return $event_owner == getUserAttribute('account_id');
}

function getTickets($event_id, $confirmed) {
    $id_array['event_id'] = $event_id;
    $query_parts[0] = 'e.event_id = :event_id AND r.time_of_confirmation IS ' . ($confirmed ? 'NOT NULL' : 'NULL');

    if ($confirmed && verifyMethod('GET') && isset($_GET['ticket_search_bar']) && $search = $_GET['ticket_search_bar']) { //assignment also checks if value is not empty string
        $search_query_parts = [];
        if (filter_var($search, FILTER_VALIDATE_INT)) {
            foreach(['reg_id', 'street_number', 'ticket_count'] as $number_column ) {
                $id_array[$number_column] = $search;
            }
            array_push($search_query_parts, '( r.reg_id = :reg_id OR a.street_number = :street_number OR r.ticket_count = :ticket_count )');
        }
        $search = '%'.$search.'%';
        foreach(['nick', 'first_name', 'last_name', 'email', 'country', 'city', 'street', 'fee_name'] as $column) {
            $id_array[$column] = $search;
        }
        array_push($search_query_parts, '( acc.nick LIKE :nick OR acc.first_name LIKE :first_name OR acc.last_name LIKE :last_name OR acc.email LIKE :email
        OR a.country LIKE :country OR a.city LIKE :city OR a.street LIKE :street OR ef.fee_name LIKE :fee_name )');
        array_push($query_parts, '( '.implode(' OR ', $search_query_parts).' )');
    }

    $tables = 'Event e JOIN Event_instance ei ON e.event_id = ei.event_id JOIN Entrance_fee ef ON ei.instance_id = ef.instance_id
    JOIN Registration r ON r.instance_id = ef.instance_id AND r.fee_name = ef.fee_name JOIN Account acc ON r.account_id = acc.account_id
    JOIN Address a ON ei.address_id = a.address_id';
    $return_id = 'r.reg_id, acc.nick, acc.first_name, acc.last_name, acc.email, a.country, a.city, a.street, a.street_number, ef.fee_name, r.ticket_count';
    $id_string = implode(' AND ', $query_parts);
    return fetch_all_table_columns($tables, $return_id, $id_array, $id_string);
}

function generateSessionToken() {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

function updateSessionReturnPage() {
    $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
}

function setPopupMessage($type, $message) {
    if (!isset($_SESSION['POPUP'])) {
        $_SESSION['POPUP'] = [];
    }
    $_SESSION['POPUP']['message'] = "$message";
    $_SESSION['POPUP']['type'] = $type;
}

function getPopupMessage() {
    if(!isset($_SESSION['POPUP'])) {
        return null;
    }
    $message['type'] = $_SESSION['POPUP']['type'];
    $message['message'] = $_SESSION['POPUP']['message'];
    unset($_SESSION['POPUP']);
    return $message;
}

function loadInputData(&$method, &$input_data, &$columns) {
    foreach($columns as $column) {
        if(isset($method[$column]) && !empty($method[$column])) {
            $input_data[$column] = $method[$column];
        }
    }
}


function getColumn(array &$row, string $column) {
    return $row[$column] ?? '';
}

function getSuperCategoryName(array &$category) {
    if ($super_category = getColumn($category, 'super_category_id')) {
        return fetch_table_column('Category', 'category_name', ['category_id' => $super_category], 'category_id = :category_id');
    } else {
        return null;
    }
}

?>
