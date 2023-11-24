<?php

require_once "../config/common.php";
session_start();
$db = connect_to_db();

var_dump($_POST);

$event_columns = ['event_name','event_icon','event_description','event_images', 'category-select', 'location-select'];
$session_event_columns = array_map(function($value) {
    return 'suggest-event_'.$value;
}, $event_columns);
storeInSession($_POST, $event_columns, 'suggest-event_');

if(!checkRequired($_POST, ['event_name','event_descirption','category-select','location-select'])) {
    //TODO: display error message
    redirect('../index.php');
}

// $id_array = [];
// populateArray($_POST, $id_array, $address_columns);
// $id_array['address_status'] = 'pending';
// $id_array['account_id'] = getUserAttribute();
// if (insert_into_table('Address', $id_array)) {
//     unsetSessionAttributes($session_address_columns);
// }

?>
