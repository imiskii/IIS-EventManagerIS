<?php

require_once "../../common/db_handler.php";
require_once "../../common/input_validator.php";

session_start();
$db = connect_to_db();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../index.php');
}

$valid_columns = ['event_name', 'even_description', 'event_icon', 'category_id'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../index.php');
}

if($event_name = find_table_column('event_name', 'Event', $input_data)) {
    setPopupMessage('error', 'event with given attributes already exists!');
    redirect('../index.php');
}

$input_data['event_status'] = 'pending';
$input_data['account_id'] = getUserAttribute('account_id');
if(!insert_into_table('Event', $input_data)) {
    setPopupMessage('error', 'could not insert event into database');
    redirect('../index.php');
}
$event_id = find_table_column('event_id', 'Event', $input_data);
$event_id_delete = [$event_id];


/*************************************************************** */

if(isset($_FILES['event_icon']['name'])     ) {
    if($_FILES['event_icon']['error'] != UPLOAD_ERR_OK) {
        delete_from_table('Event', $event_id_delete, 'event_id');
        setPopupMessage('error', 'could not upload event icon.');
        redirect('../../index.php');
    }

    $tmp_filename = $_FILES['event_icon']['tmp_name'];
    if(!exif_imagetype($tmp_filename)) {
        delete_from_table('Event', $event_id_delete, 'event_id');
        setPopupMessage('error', 'invalid file format!');
        redirect('../../index.php');
    }

    $filename = $_FILES['event_icon']['name'];
    $extension = pathinfo($_FILES['event_icon']['name'], PATHINFO_EXTENSION);
    $icon_location = 'event-icons/' . $event_id . '.' . $extension ;
    $max_filename_length = 256;
    if(mb_strlen($icon_location) > 256) { // extremely rare occasion if someone tries to "attack" server by made-up file extension but valid actual file format.
        delete_from_table('Event', $event_id_delete, 'event_id');
        setPopupMessage('error', "invalid file extension '$extension'.");
        redirect('../../index.php');
    }

    $umask = umask(); // store current umask
    umask(000);
    if (!move_uploaded_file($tmp_filename, '../../'.$icon_location)) {
        delete_from_table('Event', $event_id_delete, 'event_id');
        setPopupMessage('error', "unable to store the event icon.");
        umask($umask);
        redirect('../../index.php');
    }
    umask($umask); // load umask back

    $id_array = ['event_id' => $event_id, 'event_icon' => $icon_location];
    update_table_column('Event', 'SET event_icon = :event_icon', 'event_id = :event_id', $id_array);

}

if(isset($_FILES['event_images']['name'])) {
    for($i = 0; $i < sizeof($_FILES['event_images']['name']); $i++) {
        $file = $_FILES['event_images']['name'][$i];
        if($_FILES['event_images']['error'][$i] != UPLOAD_ERR_OK) {
            delete_from_table('Event', $event_id_delete, 'event_id');
            setPopupMessage('error', 'could not upload event image.');
            redirect('../../index.php');
        }

        $tmp_filename = $_FILES['event_images']['tmp_name'][$i];
        if(!exif_imagetype($tmp_filename)) {
            delete_from_table('Event', $event_id_delete, 'event_id');
            setPopupMessage('error', 'invalid file format!');
            redirect('../../index.php');
        }


        $umask = umask();
        umask(000);
        $image_dir = "../../event-images/$event_id";
        if(!is_dir($image_dir)) {
            if (!mkdir($image_dir, 0777, true)) {
                delete_from_table('Event', $event_id_delete, 'event_id');
                setPopupMessage('error', "could not create directory for event images.");
                redirect('../../index.php');
            }
        }

        $filename = $_FILES['event_images']['name'][$i];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $image_location = 'event-images/'.$event_id.'/' . $i . '.' . $extension ;
        $max_filename_length = 256;
        if(mb_strlen($image_location) > 256) {
            delete_from_table('Event', $event_id_delete, 'event_id');
            setPopupMessage('error', "invalid file extension '$extension'.");
            redirect('../../index.php');
        }
        
        if (!move_uploaded_file($tmp_filename, '../../'.$image_location)) {
            delete_from_table('Event', $event_id_delete, 'event_id');
            setPopupMessage('error', "unable to store the event image.");
            umask($umask);
            redirect('../../index.php');
        }
        umask($umask);
        $id_array = ['event_id' => $event_id, 'photo_path' => $image_location];
        insert_into_table('Photos', $id_array);
    }
}

/****************************************************************** */

for($i  = 0; $i < sizeof($_POST['date_from']); $i++) {
    $valid_columns = ['date_from', 'date_to', 'time_from', 'time_to', 'address_id'];
    $instance_input_data = [];
    foreach($valid_columns as $column) {
        $instance_input_data[$column] = $_POST[$column][$i];
    }
    $error_msg_array = [];
    if (!validateData($instance_input_data, $error_msg_array)) {
        delete_from_table('Event', $event_id_delete, 'event_id');
        setPopupMessage('error', implode(' ', $error_msg_array));
        redirect('../index.php');
    }
    $instance_input_data['event_id'] = $event_id;

    if(!insert_into_table('Event_instance', $instance_input_data)) {
        delete_from_table('Event', $event_id_delete, 'event_id');
        setPopupMessage('error', 'could not insert event instance into database');
        redirect('../index.php');
    }

    $instance_id = find_table_column('instance_id', 'Event_instance', $instance_input_data);

    $ticket_type_index = ($i+1) . '_ticket_type';
    $ticket_cost_index = ($i+1) . '_ticket_cost';
    $ticket_count_index = ($i+1) . '_ticket_count';
    for($j = 0; $j < sizeof($_POST[$ticket_type_index]); $j++) {
        $entrance_fee_input_data = [];
        $entrance_fee_input_data['fee_name'] = $_POST[$ticket_type_index][$j];
        $entrance_fee_input_data['cost'] = $_POST[$ticket_cost_index][$j];
        $entrance_fee_input_data['max_tickets'] = $_POST[$ticket_count_index][$j];
        $entrance_fee_input_data['instance_id'] = $instance_id;
        if (!validateData($entrance_fee_input_data, $error_msg_array)) {
            delete_from_table('Event', $event_id_delete, 'event_id');
            setPopupMessage('error', implode(' ', $error_msg_array));
            redirect('../index.php');
        }
        if (!insert_into_table('Entrance_fee', $entrance_fee_input_data)) {
            delete_from_table('Event', $event_id_delete, 'event_id');
            setPopupMessage('error', 'could not load entrance fee data.');
            redirect('../index.php');
        }
    }
}

setPopupMessage('success', 'Event registered! Please wait for confirmation from moderators.');
redirect('../../index.php');

?>
