<?php
function connect_to_db()
{
    $host = 'localhost';
    $db_name = 'xkurca01';
    $username = 'xkurca01';
    $password = '9emtirde';
    $port = '/var/run/mysql/mysql.sock';

    $dsn = "mysql:host=$host;dbname=$db_name;port=$port";
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

function fetch_valid_columns($table, $method)
{
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
                        'account_type' => function ($value) {
                            // Assuming account types are predefined, you might check against a list of valid types.
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
                            // Assuming category names can contain letters, numbers, and spaces
                            return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                        },
                        'description' => function ($value) {
                            // You might want to add more specific validation for comment text.
                            // For example, checking for length, forbidden words, etc.
                            return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
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
                        'event_name' => function ($value) {
                            // Assuming event names can contain letters, numbers, spaces, and some special characters
                            return preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $value) && strlen($value) <= 128;
                        },
                        'description' => function ($value) {
                            // You might want to add more specific validation for comment text.
                            // For example, checking for length, forbidden words, etc.
                            return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                        },
                        'icon' => function ($value){
                            return true;
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
                    return $allowed_filters_for_Registration = [
                        'owner_id' => function ($value) {
                            return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                        },
                        'instance_id' => function ($value) {
                            return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                        },
                        'time_of_confirmation' => function ($value) {
                            // Assuming a specific datetime format for validation, e.g., "Y-m-d H:i:s".
                            return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
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
                        'time_of_posting' => function ($value) {
                            return DateTime::createFromFormat('Y-m-d H:i:s', $value);
                        },
                        'comment_text' => function ($value) {
                            // You might want to add more specific validation for comment text.
                            // For example, checking for length, forbidden words, etc.
                            return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
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
                case "Login":
                    return $allowed_filters_for_Comment = [
                        'email' => function ($value) {
                            return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                        },
                        'password' => function ($value) {
                            return preg_match('/^\w+$/', $value) && strlen($value) <= 128;
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
                            // Assuming account types are predefined, you might check against a list of valid types.
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
                            // Assuming category names can contain letters, numbers, and spaces
                            return preg_match('/^[a-zA-Z0-9\s]+$/', $value) && strlen($value) <= 128;
                        },
                        'description' => function ($value) {
                            return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
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
                        'description' => function ($value) {
                            return is_string($value) && strlen($value) <= 16777215; // MEDIUMTEXT max length
                        },
                        'icon' => function ($value) {
                            return !empty($value) && is_string($value);
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
                        'date_of_creation' => function ($value) {
                            return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
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
                case "Entrace_fee": //TODO maybe add 'id' tp this db table -> otherwise requires unique handling
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
                        'time_of_confirmation' => function ($value) {
                            // Assuming a specific datetime format for validation, e.g., "Y-m-d H:i:s".
                            return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
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
                        'time_of_posting' => function ($value) {
                            return DateTime::createFromFormat('Y-m-d H:i:s', $value);
                        },
                        'comment_text' => function ($value) {
                            // You might want to add more specific validation for comment text.
                            // For example, checking for length, forbidden words, etc.
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
                            // Assuming category names can contain letters, numbers, and spaces
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
                    return $required_columns = ['category_name', 'account_id']; 
                case "Event":
                    return $required_columns = ['owner_id']; 
                case "Address":
                    return $required_columns = ['account_id']; 
                case "Event_Instance":
                    return $required_columns = ['event_id', 'address_id']; 
                case "Entrance_fee":
                    return $required_columns = ['instance_id']; 
                case "Registration":
                    return $required_columns = ['owner_id', 'instance_id']; 
                case "Photos":
                    return $required_columns = ['event_id', 'address_id']; 
                case "Comment":
                    return $required_columns = ['author_id', 'event_id']; 
                case "Login":
                    return $required_columns = ['email', 'password']; 
                case "Logout":
                    return $required_columns = []; 
            }
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

function item_exists($db, $table, $id)
{
    $query = "SELECT COUNT(*) FROM $table WHERE id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    return $stmt->fetchColumn() > 0;
}

function validate_data($table, $data, $method)
{
    $isValid = true;
    $required_columns = fetch_required_columns($table, $method);
    $valid_data_check = fetch_valid_columns($table, $method);

    // check if all required columns are present
    foreach ($required_columns as $required_column) {
        if (!property_exists($data, $required_column)) {
            $isValid = false;
            break;
        }
    }

    if ($isValid) {
        // data validation
        foreach ($data as $key => $value) {
            // Check if the filter is allowed and valid
            if (isset($valid_data_check[$key]) && is_callable($valid_data_check[$key])) {
                if (!$valid_data_check[$key]($value)) {
                    $isValid = false;
                    print("Invalid filter: $key with value: \"$value\"\n");
                    break;
                }
            } else {
                $isValid = false;
                print("invalid filter: $key with value: \"$value\"\n");
                break;
            }
        }
    }

    return $isValid;
}

function session_handler($db, $table, $data)
{
    if ($table == 'Login' && !isset($_SESSION['account_type'])){
        $email = $data->email;
        $query = "SELECT password, account_type FROM Account WHERE email = :email";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $stored_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // if (password_verify($data['pwd'], $stored_data['pwd'])) { // right now we don't hash passwords
        if ($stored_data['password'] == $data->password){
            $_SESSION['account_type'] = $stored_data['account_type'];
            sendResponse(200, "Log in successfull.\n");
        }
        else{
            sendResponse(401, "Log in failed: No email-password configuration found or valid.\n");
        }
    }
    else if ($table == 'Login' && isset($_SESSION['account_type'])){
        sendResponse(200, "You are already logged in.\n");
    }
    else if ($table == 'Logout' && isset($_SESSION['account_type'])){
        session_destroy();
        sendResponse(200, "Log out successfull.\n");
    }
    else{
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