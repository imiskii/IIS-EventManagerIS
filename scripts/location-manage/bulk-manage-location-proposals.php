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
$valid_columns = ['accept', 'reject', 'address_id'];
loadInputData($_POST, $input_data, $valid_columns);

if(!key_exists('address_id', $input_data)) {
    setPopupMessage('warning', 'no locations were selected');
    redirect('../../index/php');
}

$op_success = true;
if(in_array('accept', $input_data)) {
    $search_by_array = [];
    for($i = 0; $i < sizeof($input_data['address_id']); $i++) {
        $id_aray['address_id'.$i] = $input_data['address_id'][$i];
        array_push($search_by_array, ":address_id$i");
    }
    if (update_table_column('Address', 'SET address_status = "approved"', 'address_id IN ('.implode(', ', $search_by_array).')', $id_aray)) {
        setPopupMessage('success', 'categories approved successfully.');
    } else {
        setPopupMessage('error', 'could not update all categories.');
    }
} else {
    if (delete_from_table('Address', $input_data['address_id'], 'address_id')) {
        setPopupMessage('success', 'locations rejected successfully.');
    } else {
        setPopupMessage('error', 'could not update all locations.');
    }
}

redirect('../../index.php');

?>
