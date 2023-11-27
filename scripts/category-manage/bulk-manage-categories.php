<?php
require_once "../../common/db_handler.php";
require_once '../../common/input_validator.php';

session_start();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../../index.php');
}

$db = connect_to_db();

$input_data = [];
$valid_columns = ['delete', 'change_status', 'category_id'];
loadInputData($_POST, $input_data, $valid_columns);

if(!key_exists('category_id', $input_data)) {
    setPopupMessage('warning', 'no categories were selected');
    redirect('../../index/php');
}

if (in_array('delete', $input_data)) {
    if(!delete_from_table('Category', $input_data['category_id'], 'category_id')) {
        setPopupMessage('error', 'could not delete the selected categories.');
    } else {
        setPopupMessage('success', 'categories deleted successfully.');
    }
} else {
    $approved_categories = getTableColumnsByValue('Category', 'category_id', $input_data['category_id'], 'category_status', 'approved');
    $pending_categories = getTableColumnsByValue('Category', 'category_id', $input_data['category_id'], 'category_status', 'pending');
    if (!empty($approved_categories) && !update_table_column('Category', 'SET category_status = "pending"', 'category_id IN ("'.implode('", "', $approved_categories).'")', null) ||
        !empty($pending_categories) && !update_table_column('Category', 'SET category_status = "approved"', 'category_id IN ("'.implode('", "', $pending_categories).'")', null) ) {
        setPopupMessage('error', 'could not change status on the selected categories.');
    } else {
        setPopupMessage('success', 'Categories updated successfully!');
    }
}

redirect('../../index.php');

?>
