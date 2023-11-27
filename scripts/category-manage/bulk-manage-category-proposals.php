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
$valid_columns = ['accept', 'reject', 'category_id'];
loadInputData($_POST, $input_data, $valid_columns);

if(!key_exists('category_id', $input_data)) {
    setPopupMessage('warning', 'no categories were selected');
    redirect('../../index/php');
}

$op_success = true;
if(in_array('accept', $input_data)) {
    foreach($input_data['category_id'] as $category) {
        $id_aray = []; // reset the array
        $id_aray['category_id'] = $category;
        $super_category = $_POST[$category.'_super_category']; // spaces with '_' in $_POST keys
        if (!empty($super_category)) {
            $id_aray['super_category_id'] = $super_category;
            if (!update_table_column('Category', 'SET category_status = "approved", super_category_id = :super_category_id', 'category_id = :category_id', $id_aray)) {
                $op_success = false;
            }
        } else if (!update_table_column('Category', 'SET category_status = "approved"', 'category_id = :category_id', $id_aray)) {
            $op_success = false;
        }
    }
    if ($op_success) {
        setPopupMessage('success', 'categories approved successfully.');
    } else {
        setPopupMessage('error', 'could not update all categories.');
    }
} else {
    if (delete_from_table('Category', $input_data['category_id'], 'category_id')) {
        setPopupMessage('success', 'categories rejected successfully.');
    } else {
        setPopupMessage('error', 'could not update all categories.');
    }
}

redirect('../../index.php');

?>
