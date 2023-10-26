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
        echo "Successfully connected!";
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function fetch_valid_column_value_for_table($table)
{
    switch ($table){
       case "Account":
            return $allowed_filters_for_Account = [
                'id' => function ($value) {
                    // Ensure the owner_id is a positive integer.
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
            break;
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
            break;
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
            break;
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
                'account_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
            ];
            break;
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
            break;
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
            break;
        case "Registration":
            $allowed_filters_for_Registration = [
                'owner_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'instance_id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
                'fee_name' => function ($value) {
                    return is_string($value) && strlen($value) <= 128;
                },
                'time_of_confirmation' => function ($value) {
                    // Assuming a specific datetime format for validation, e.g., "Y-m-d H:i:s".
                    return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
                },
            ];
            break;
        case "Photos":
            $allowed_filters_for_Photos = [
                'id' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
                },
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
            break;
        case "Comment":
            $allowed_filters_for_Comment = [
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
            break;
        default:
            sendResponse(400, 'Back-End Fail, fetch_valid function failed.');
            exit;
            break;
    }
}

function fetch_allowed_filters_for_table($table)
{
    switch ($table){
        case "Accounts":
            break;
        case "Events":
            break;
        case "Locations":
            break;
        case "Event_Instaces":
            break;
        case "Categories":
            break;
        case "Comments":
            break;
        case "Entrace_fees":
            break;
        case "Registration":
            break;
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

// if isValid is true -> all filters are valid | else invalid filters are stored in $invalid_filters and returned
function validate_data($table, $data, $invalid_data)
{
    $isValid = true;
    // $allowedFilters = fetch_allowed_filters_for_table($table); // if $table is not valid -> we will fail inside this function
    $valid_data_check = fetch_valid_column_value_for_table($table);

    foreach ($data as $key => $value) {
        // Check if the filter is allowed and valid
        if (isset($valid_data_check[$key]) && is_callable($valid_data_check[$key])) { // is data valid and does it have a value checker implemented
            if (!$valid_data_check[$key]($value)) { // is data value valid for given column
                $isValid = false;
                $invalid_data[] = $key;
            }
        } 
        else {
            $isValid = false;
            $invalid_data[] = $key;
        }
    }

    return $isValid;
}

// Utility function to send JSON responses
function sendResponse($statusCode, $message)
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode(['status' => $statusCode, 'message' => $message]);
}
?>