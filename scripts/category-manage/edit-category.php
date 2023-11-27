<?php
require_once "../../common/db_handler.php";
require_once '../../common/input_validator.php';

session_start();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../../index.php');
}

$db = connect_to_db();

$valid_columns = ['category_name', 'category_description', 'category_status', 'super_category_id'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../../index.php');
}


if(($super_category = getColumn($input_data, 'super_category_id')) && $super_category == $_POST['category_id']) {
    setPopupMessage('error', 'category cannot be a sub category of itself.');
    redirect('../../index.php');
}

if(($conflicting_category_id = find_table_column('category_id', 'Category', ['category_name' => $input_data['category_name']])) &&
    $conflicting_category_id != $_POST['category_id']) {
    setPopupMessage('error', "category with name \'".$input_data['category_name']."\' already exists.");
    redirect('../../index.php');
}

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../../index.php');
}

if(!update_table_row('Category', $input_data, 'category_id', $_POST['category_id'])) {
    setPopupMessage('error', 'could not update the category.');
} else {
    setPopupMessage('success', 'category updated successfully!');
}

redirect('../../index.php');

?>
