<?php
require_once "../common/db_handler.php";
require_once '../common/input_validator.php';

session_start();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../index.php');
}

$db = connect_to_db();

$input_data = [];
$valid_columns = ['accept', 'reject', 'category_name'];
loadInputData($_POST, $input_data, $valid_columns);

if(!key_exists('category_name', $input_data)) {
    setPopupMessage('warning', 'no categories were selected');
    redirect('../index/php');
}

$op_success = true;
if(in_array('accept', $input_data)) {
    foreach($input_data['category_name'] as $category) {
        $id_aray = []; // reset the array
        $id_aray['category_name'] = $category;
        $super_category = $_POST[str_replace(' ', '_', $category).'_super_category']; // spaces with '_' in $_POST keys
        if (!empty($super_category)) {
            echo 'super_category located\n';
            $id_aray['super_category'] = $super_category;
            if (!update_table_column('Category', 'SET category_status = "approved", super_category = :super_category', 'category_name = :category_name', $id_aray)) {
                $op_success = false;
            }
        } else if (!update_table_column('Category', 'SET category_status = "approved"', 'category_name = :category_name', $id_aray)) {
            $op_success = false;
        }
    }
    if ($op_success) {
        setPopupMessage('success', 'categories approved successfully.');
    } else {
        setPopupMessage('error', 'could not update all categories.');
    }
} else {
    // FIXME: Add rejected status so the user can see their category has been rejected
    if (delete_from_table('Category', $input_data['category_name'], 'category_name')) {
        setPopupMessage('success', 'categories rejected successfully.');
    } else {
        setPopupMessage('error', 'could not update all categories.');
    }
}

redirect('..index.php');

?>
