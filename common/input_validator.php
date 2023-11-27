<?php

function check_max_len ($attribute, $value, $maxlen, &$data_valid, &$errmsg_array) {
    if (mb_strlen($value) > $maxlen) {
        $data_valid = false;
        array_push($errmsg_array, "$attribute can be at most $maxlen characters long.");
    }
}

function validateData(array &$data_array, array &$errmsg_array) {
    $data_valid = true;
    foreach($data_array as $attribute => $value) {
        if(is_array($value)) {
            $data_valid = validateData($value, $errmsg_array);
        } else switch ($attribute) {
        case 'email':
            check_max_len($attribute, $value, 256, $data_valid, $errmsg_array);
            if (!preg_match('/^[\d\p{L}\-_\.]+@[\.\-_\d\p{L}]+\.[a-zA-Z]+$/', $value)) {
                $data_valid = false;
                array_push($errmsg_array, "\'$value\' is not a valid email format.");
            }
            break;
        case 'fee_name':
        case 'event_name':
        case 'last_name':
        case 'first_name':
        case 'category_name':
        case 'country':
        case 'city':
        case 'street':
        case 'state':
            check_max_len($attribute, $value, 128, $data_valid, $errmsg_array);
            if (!preg_match('/^[\p{L}\s\-\.\d]+$/u', $value)) {
                $data_valid = false;
                array_push($errmsg_array, "$attribute \'$value\' contains characters which are not allowed. Please only use alphanumeric characters, whitespaces, hyphen, or dot.");
            }
            break;
        case 'nick':
            check_max_len($attribute, $value, 128, $data_valid, $errmsg_array);
            if (!preg_match('/^[\p{L}\s\-\.\d_]+$/u', $value)) {
                $data_valid = false;
                array_push($errmsg_array, "Only alphanumeric charcters, whitespaces, hyphen, underscore or dot allowed to be used from nickname.");
            }
            break;
        case 'cost':
        case 'max_tickets':
            if (!filter_var($value, FILTER_VALIDATE_INT) || $value < 0) {
                $data_valid = false;
                array_push($errmsg_array, "$attribute must be a non-negative integer.");
            }
            break;
        case 'zip':
        case 'street_number':
            if (!filter_var($value, FILTER_VALIDATE_INT) || $value <= 0) {
                $data_valid = false;
                array_push($errmsg_array, "$attribute must be a positive integer.");
            }
            break;
        case 'comment_text':
        case 'category_description':
        case 'address_description':
            if (mb_strlen($value) > 16777215) { // Medium text max length
                $data_valid = false;
                array_push($errmsg_array, "$attribute length exceeded. Length cannot exceed 16777215 characters.");
            }
            break;
        case 'comment_rating':
            if (!filter_var($value, FILTER_VALIDATE_INT) || $value < 0 || $value > 5) {
                $data_valid = false;
                array_push($errmsg_array, "rating must be of of value from 0 to 5.");
            }
            break;
        case 'password':
        case 'password2':
            check_max_len($attribute, $value, 128, $data_valid, $errmsg_array);
            if (mb_strlen($value) < 8) { // Medium text max length
                $data_valid = false;
                array_push($errmsg_array, "password must be at least 8 characters long.");
            }
            break;
        case 'event_id':
        case 'account_id':
        case 'category_id':
        case 'address_id':
        case 'instance_id':
        case 'super_category_id':
            if (!filter_var($value, FILTER_VALIDATE_INT) || $value < 0) {
                $data_valid = false;
                array_push($errmsg_array, "invalid $attribute.");
            }
            break;
        case 'category_status': // no need to check for values. Users can only choose from selection or input is rescricted in html
        case 'address_status':
        case 'account_type':
        case 'account_status':
        case 'date_from':
        case 'date_to':
        case 'time_from':
        case 'time_to':
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
