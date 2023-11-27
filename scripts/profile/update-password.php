<?php

require_once '../../common/db_handler.php';
require_once '../../common/input_validator.php';

session_start();
$db = connect_to_db();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}

if($_POST['old_password'] != getUserAttribute('password')) {
    setPopupMessage('error', 'invalid current password.');
    redirect('../../index.php');
}

$valid_columns = ['password', 'password2'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../../index.php');
}

if(($password = getColumn($input_data, 'password')) && $password != getColumn($input_data, 'password2')) {
    setPopupMessage('error', 'passwords do not match.');
    redirect('../../index.php');
}



if(update_table_column('Account', 'SET password = :password', 'account_id = :account_id',
['password' => $password, 'account_id' => getUserAttribute('account_id')])) {
    setUserAttribute('password', $password);
    setPopupMessage('success', 'password updated successfully!');
} else {
    setPopupMessage('error', 'Could not update password.');
}

redirect('../../index.php');

?>
