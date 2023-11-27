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
$valid_columns = ['delete', 'change_status', 'event_id'];
loadInputData($_POST, $input_data, $valid_columns);

if(!key_exists('event_id', $input_data)) {
    setPopupMessage('warning', 'no events were selected');
    redirect('../../index/php');
}

if (in_array('delete', $input_data)) {
    if(!delete_from_table('Event', $input_data['event_id'], 'event_id')) {
        setPopupMessage('error', 'could not delete the selected events.');
    } else {
        setPopupMessage('success', 'events deleted successfully.');
    }
} else {
    $approved_events = getEventIdsByStatus($input_data['event_id'], 'approved');
    $pending_events = getEventIdsByStatus($input_data['event_id'], 'pending');
    if (!empty($approved_events) && !update_table_column('Event', 'SET event_status = "pending"', 'event_id IN ('.implode(', ', $approved_events).')', null) ||
        !empty($pending_events) && !update_table_column('Event', 'SET event_status = "approved"', 'event_id IN ('.implode(', ', $pending_events).')', null) ) {
        setPopupMessage('error', 'could not change status on the selected events.');
    } else {
        setPopupMessage('success', 'Events updated successfully!');
    }
}

redirect('../../index.php');

?>
