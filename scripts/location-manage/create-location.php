<?php
require_once "../../common/db_handler.php";
require_once '../../common/input_validator.php';

session_start();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../../index.php');
}

$db = connect_to_db();

$valid_columns = ['country', 'city', 'street', 'street_number', 'state', 'zip', 'address_status', 'address_description'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../../index.php');
}

$unique_data_columns = ['country', 'city', 'street', 'street_number'];
$unique_data = [];
loadInputData($_POST, $unique_data, $unique_data_columns);

if ($address = find_table_row('Address', $unique_data)) {
    setPopupMessage('error', "address \'".formatAddress($address)."\' already exists.");
    redirect('../../index.php');
}

$input_data['account_id'] = getUserAttribute('account_id');

if (insert_into_table('Address', $input_data)) {
    setPopupMessage('success', 'location created successfully!');
} else {
    setPopupMessage('error', 'could not insert values into database.');
}

redirect('../../index.php');

?>
