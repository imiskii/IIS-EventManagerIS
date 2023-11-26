<?php

function validateData(array &$data_array, array &$errmsg_array) {
    $data_valid = true;
    foreach($data_array as $attribute => $value) {
        switch ($attribute) {
        case 'category_name':
        case 'country':
        case 'city':
        case 'street':
        case 'state':
            if (mb_strlen($value) > 128) {
                $data_valid = false;
                array_push($errmsg_array, "$attribute can be at most 128 characters long.");
            }
            if (!preg_match('/^[\p{L}\s\-]+$/u', $value)) {
                $data_valid = false;
                array_push($errmsg_array, "$attribute \'$value\' contains characters which are not allowed. Please only use letters, whitespaces, or hyphen.");
            }
            break;
        case 'zip':
        case 'street_number':
            if (!filter_var($value, FILTER_VALIDATE_INT) || $value <= 0) {
                $data_valid = false;
                array_push($errmsg_array, "$attribute must be a positive integer.");
            }
            break;
        case 'category_description':
        case 'address_description':
            if (mb_strlen($value) > 16777215) { // Medium text max length
                $data_valid = false;
                array_push($errmsg_array, "$attribute length exceeded. Length cannot exceed 16777215 characters.");
            }
            break;
        case 'super_category': // no need to check for values. Users can only choose from selection.
        case 'category_status':
        case 'address_status':
            break;
        default:
            $data_valid = false;
            array_push($errmsg_array, "Unknown attribute \'$attribute\'.");
            break;
        }
    }
    return $data_valid;
}

?>
