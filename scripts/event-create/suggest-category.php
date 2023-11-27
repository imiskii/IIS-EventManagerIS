<?php
require_once "../../common/db_handler.php";
require_once '../../common/input_validator.php';

session_start();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../../index.php');
}

$db = connect_to_db();

$valid_columns = ['category_name', 'category_description'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../../index.php');
}

if ($status = find_table_column('category_status', 'Category', $input_data)) {
    setPopupMessage('error', "Given category already exists with status \'$status\'.");
    redirect('../../index.php');
}

$input_data['category_status'] = 'pending';
$input_data['account_id'] = getUserAttribute('account_id');

if (insert_into_table('Category', $input_data)) {
    setPopupMessage('success', 'category submitted successfully!');
} else {
    setPopupMessage('error', 'could not insert values into database.');
}

redirect('../../index.php');

?>
