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
        switch ($attribute) {
        case 'email':
            check_max_len($attribute, $value, 256, $data_valid, $errmsg_array);
            if (!filter_var($attribute, FILTER_VALIDATE_EMAIL)) { // FIXME: not working?
                $data_valid = false;
                array_push($errmsg_array, "$\'$value\' is not a valid email format.");
            }
            break;
        case 'last_name':
        case 'first_name':
        case 'category_name':
        case 'country':
        case 'city':
        case 'street':
        case 'state':
            check_max_len($attribute, $value, 128, $data_valid, $errmsg_array);
            if (!preg_match('/^[\p{L}\s\-\.]+$/u', $value)) {
                $data_valid = false;
                array_push($errmsg_array, "$attribute \'$value\' contains characters which are not allowed. Please only use letters, whitespaces, hyphen, or dot.");
            }
            break;
        case 'nick':
            check_max_len($attribute, $value, 128, $data_valid, $errmsg_array);
            if (!preg_match('/^[\p{L}\s\-\.\d_]+$/u', $value)) {
                $data_valid = false;
                array_push($errmsg_array, "Only alphanumeric charcters, whitespaces, hyphen, underscore or dot allowed to be used from nickname.");
            }
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
        case 'password':
        case 'password2':
            check_max_len($attribute, $value, 128, $data_valid, $errmsg_array);
            if (mb_strlen($value) < 8) { // Medium text max length
                $data_valid = false;
                array_push($errmsg_array, "password must be at least 8 characters long.");
            }
        case 'super_category_id': // no need to check for values. Users can only choose from selection. TODO: check values in case of direct html edits
        case 'category_status':
        case 'address_status':
        case 'account_type':
        case 'account_status':
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
