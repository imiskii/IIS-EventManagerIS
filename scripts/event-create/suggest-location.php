<?php

require_once "../../common/db_handler.php";
require_once '../../common/input_validator.php';

session_start();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../../index.php');
}

$db = connect_to_db();

$valid_columns = ['country','city','street','street_number', 'zip', 'state', 'address_description'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../../index.php');
}

if ($status = find_table_column('address_status', 'Address', $input_data)) {
    setPopupMessage('error', "Given address already exists with status \'".$status."\'.");
    redirect('../../index.php');
}

$input_data['address_status'] = 'pending';
$input_data['account_id'] = getUserAttribute('account_id');

if (insert_into_table('Address', $input_data)) {
    setPopupMessage('success', 'location submitted successfully!');
} else {
    setPopupMessage('error', 'could not insert values into database.');
}

redirect('../../index.php');

?>
