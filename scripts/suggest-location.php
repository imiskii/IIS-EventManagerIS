<?php

require_once "../config/common.php";
session_start();
$db = connect_to_db();

$address_columns = ['country','city','street','street_number', 'zip', 'state', 'address_description'];
$session_address_columns = array_map(function($value) {
    return 'suggest-location_'.$value;
}, $address_columns);
storeInSessionFromGet($address_columns, 'suggest-location_');

if(!checkRequiredInGet(['country','city','street','street_number'])) {
    //TODO: display error message
    redirect();
}

$id_array = [];
populateArrayFromGet($id_array, $address_columns);
$id_array['address_status'] = 'pending';
$id_array['account_id'] = getUserAttribute();
if (insert_into_table('Address', $id_array)) {
    unsetSessionAttributes($session_address_columns);
}

redirect();

?>
