<?php
require_once "../../common/db_handler.php";
require_once '../../common/input_validator.php';

session_start();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}

$db = connect_to_db();

$input_data = [];
$valid_columns = ['accept', 'reject', 'reg_id'];
loadInputData($_POST, $input_data, $valid_columns);

if(!key_exists('reg_id', $input_data)) {
    setPopupMessage('warning', 'no tickets were selected');
    redirect('../../index/php');
}

$op_success = true;
if(in_array('accept', $input_data)) {
    $search_by_array = [];
    for($i = 0; $i < sizeof($input_data['reg_id']); $i++) {
        $id_aray['reg_id'.$i] = $input_data['reg_id'][$i];
        array_push($search_by_array, ":reg_id$i");
    }
    if (update_table_column('Registration', 'SET time_of_confirmation = "'.date('Y-m-d H:i:s').'"', 'reg_id IN ('.implode(', ', $search_by_array).')', $id_aray)) {
        setPopupMessage('success', 'registrations confirmed successfully.');
    } else {
        setPopupMessage('error', 'could  not confirm the registrations.');
    }
} else {
    if (delete_from_table('Registration', $input_data['reg_id'], 'reg_id')) {
        setPopupMessage('success', 'registrations rejected successfully.');
    } else {
        setPopupMessage('error', 'could not update the registrations.');
    }
}

redirect('../../index.php');

?>
