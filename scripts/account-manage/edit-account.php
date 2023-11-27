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

$account = find_table_row('Account', ['account_id' => $_POST['account_id']]);
if ($account['account_type'] == 'administrator' && $account['account_id'] != getUserAttribute('account_id')) {
    setPopupMessage('error', "cannot edit account of another administrator!");
    redirect('../../index.php');
}

if (($conflicting_account_id = find_table_column('account_id', 'Account', ['email' => $_POST['email']])) && $conflicting_account_id != $_POST['account_id']) {
    setPopupMessage('error', "account with email \'".$input_data['email']."\' already exists.");
    redirect('../../index.php');
}

if (($conflicting_account_id = find_table_column('account_id', 'Account', ['nick' => $_POST['nick']])) && $conflicting_account_id != $_POST['account_id']) {
    setPopupMessage('error', "account with nickname \'".$input_data['nick']."\' already exists.");
    redirect('../../index.php');
}

if(($password = getColumn($input_data, 'password')) && $password != getColumn($input_data, 'password2')) {
    setPopupMessage('error', 'passwords do not match.');
    redirect('../../index.php');
}
unset($input_data['password2']);

if (!update_table_row('Account', $input_data, 'account_id', $_POST['account_id'])) {
    setPopupMessage('error', 'could not update the account.');
} else {
    setPopupMessage('success', 'account updated successfully.');
}

if(getUserAttribute('account_id') == $_POST['account_id']) { // update current user if their profile was the one being edited
    $_SESSION['USER'] = fetch_table_entry('Account', '*', ['account_id' => $_POST['account_id']], 'account_id = :account_id');
}

redirect('../../index.php');

?>
