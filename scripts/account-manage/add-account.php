<?php

require_once "../../common/db_handler.php";
require_once '../../common/input_validator.php';

session_start();

if (!verifyMethod('POST') || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}
$db = connect_to_db();

$valid_columns = ['nick', 'first_name', 'last_name', 'email', 'password', 'password2', 'account_type'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../../index.php');
}

$conflicting_email = find_table_column('email', 'Account', ['email' => $_POST['email']]);
if (!empty($conflicting_email)) {
    setPopupMessage('error', 'account with this email already exists.');
    redirect('../../index.php');
}
$conflicting_nick = find_table_column('email', 'Account', ['nick' => $_POST['nick']]);
if (!empty($conflicting_nick)) {
    setPopupMessage('error', "account with nickname \'$conflicting_nick\' already exists.");
    redirect('../../index.php');
}

if($_POST['password'] != $_POST['password2']) {
    setPopupMessage('error', 'passwords do not match.');
    redirect('../../index.php');
}
unset($input_data['password2']);
$input_data['account_status'] = 'active';

if (!insert_into_table('Account', $input_data)) {
    setPopupMessage('error', 'could not create the new account.');
} else {
    setPopupMessage('success', 'account created successfully.');
}

redirect('../../index.php');

?>
