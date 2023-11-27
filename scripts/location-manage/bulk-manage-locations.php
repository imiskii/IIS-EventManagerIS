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
$valid_columns = ['delete', 'change_status', 'address_id'];
loadInputData($_POST, $input_data, $valid_columns);

if(!key_exists('address_id', $input_data)) {
    setPopupMessage('warning', 'no locations were selected');
    redirect('../../index/php');
}

if (in_array('delete', $input_data)) {
    if(!delete_from_table('Address', $input_data['address_id'], 'address_id')) {
        setPopupMessage('error', 'could not delete the selected locations.');
    } else {
        setPopupMessage('success', 'locations deleted successfully.');
    }
} else {
    $approved_locations = getTableColumnsByValue('Address', 'address_id', $input_data['address_id'], 'address_status', 'approved');
    $pending_locations = getTableColumnsByValue('Address', 'address_id', $input_data['address_id'], 'address_status', 'pending');
    if (!empty($approved_locations) && !update_table_column('Address', 'SET address_status = "pending"', 'address_id IN ("'.implode('", "', $approved_locations).'")', null) ||
        !empty($pending_locations) && !update_table_column('Address', 'SET address_status = "approved"', 'address_id IN ("'.implode('", "', $pending_locations).'")', null) ) {
        setPopupMessage('error', 'could not change status on the selected locations.');
    } else {
        setPopupMessage('success', 'locations updated successfully!');
    }
}

redirect('../../index.php');

?>
