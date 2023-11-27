<?php
require_once "../common/db_handler.php";
require_once '../common/input_validator.php';

session_start();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../index.php');
}

$db = connect_to_db();

$valid_columns = ['country', 'city', 'street', 'street_number', 'state', 'zip', 'address_status', 'address_description'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../index.php');
}

if(!update_table_row('Address', $input_data, 'address_id', $_POST['address_id'])) {
    setPopupMessage('error', 'could not update the location.');
} else {
    setPopupMessage('success', 'location updated successfully!');
}

redirect('../index.php');

?>
