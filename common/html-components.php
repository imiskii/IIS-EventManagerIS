<?php
/**
 * @file html-components.php
 * @brief Common html website components
 * @author Michal Ľaš (xlasmi00)
 * @date 05.08.2023
 */

require_once "db_handler.php";

/**
 * Generator for page head
 *
 * @param string $title title of the page
 * @return void
*/
function makeHead(string $title)
{
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title ?></title>
        <link rel="stylesheet" href="styles/style.css">
        <script src="https://kit.fontawesome.com/2ff75daa4b.js" crossorigin="anonymous"></script>
        <script src="js/design-scripts.js"></script>
    </head>
    <body>

    <?php
}


/**
 * Function generates menu for logged in user based on his role
 *
 * @return void
 */
function generateProfilMenu()
{
    ?>

    <div class="profile-menu">
        <script> window.onload = refreshImage('profile_icon', '<?php echo getUserIcon(); ?>') </script>
        <ul>
            <li><i class='fa-solid fa-user'></i><a href="profile.php?account_id=<?php echoUserAttribute('account_id') ?>">Profile</a></li>

    <?php
    if (userIsModerator())
    {
        echo '<li><i class="fa-solid fa-sun"></i><a href="event-manage.php">Manage Events</a></li>';
        echo '<li><i class="fa-solid fa-paperclip"></i><a href="category-manage.php">Manage Categories</a></li>';
        echo '<li><i class="fa-solid fa-location-dot"></i><a href="location-manage.php">Manage Locations</a></li>';
    }
    if (userIsAdmin())
    {
        echo '<li><i class="fa-solid fa-users-gear"></i><a href="account-manage.php">Manage Accounts</a></li>';
    }
    ?>

            <li><i class="fa-solid fa-right-from-bracket"></i><a href="scripts/logout/logout.php">Log out</a></li>
        </ul>
    </div>

    <?php
}


/**
 * Generator for page header
 *
 * @return void
 */
function makeHeader()
{
    ?>

    <header>
        <div class="top-bar">
            <a id="logo" href="index.php"><p>EVENTER</p></a>
            <div class="search-bar">
                <form action="index.php" method="get">
                    <input type="text" placeholder="Search events..." name="events_search_bar" value="<?php echoSessionVal("events_search_bar", ""); ?>" >
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <!-- src is profile icon-->
            <div class="profile">
                <?php
                    if (userIsLoggedIn())
                    {
                        echo '<div class="profile-icon" onclick="menuToggle();">';
                        echo '<img id="profile_icon" src="'.getUserIcon().'">';
                        echo "</div>";
                        generateProfilMenu();
                    }
                    else
                    {
                        echo "<div class='login-btns'>";
                        echo "<a href='login.php' class='button-sharp-filled'>log in</a>";
                        echo "<a href='signup.php' class='button-sharp-filled'>sign up</a>";
                        echo "</div>";
                    }
                    makeAlertPopup();
                ?>
                <div class="profile-menu">
                    <h3>Name Surname<br><span>Normall user</span></h3>
                    <ul>
                        <li><i class='fa-solid fa-user'></i><a href="#">Profile</a></li>
                        <li><i class="fa-solid fa-right-from-bracket"></i><a href="#">Log out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <?php
}


/**
 * Generator for page footer
 *
 * @return void
 */
function makeFooter()
{
    ?>

    <footer>
        <div class="footer-top">
            <p> ISS Project 2023 | Team xlasmi00 </p>
        </div>
        <div class="footer-bottom">
            <p>&copy; The best Team</p>
        </div>
    </footer>
    <?php
    if(!is_null($message = getPopupMessage())) {
        ?>
        <script>
            window.onload = showAlert('<?php echo $message['type'] ?>', '<?php echo $message['message'] ?>');
        </script>
        <?php
    }
    ?>
    </body>
    </html>

    <?php

}


/**
 * Generates Alert popup
 */
function makeAlertPopup()
{
    ?>

    <div id="alert" class="alert hide">
    <span class="alert-content">
        <i class="fa-solid fa-circle-info"></i>
        <span id="alert-msg" class="msg">Warning: </span>
    </span>
    <span id="alert-close-btn" class="alert-close-btn" onclick="closeAlert()">
        <i class="fa-solid fa-xmark"></i>
    </span>
    </div>

    <?php
}


/**
 * Generates one event card
 *
 * @param array $event array with specific event informations
 * @param string|null $card_type type of card style that will be generated. "" -> normall card, "owner" -> card for event owners, "participant" -> card for event participant.
 */
function generateEventCard(&$event, $card_type = null) {

    echo '<script> window.onload = refreshImage("icon-'.$event['event_id'].'", "'.getEventIcon($event).'") </script>';
    echo '<a href="event-detail.php?event_id='.$event["event_id"].'" class="event-card'.$card_type.'">';
    echo '<img id="icon-'.$event['event_id'].'" src="'.getEventIcon($event).'">';
    echo '<div class="name-rating">';
    echo '    <h3>' . $event["event_name"] . '</h3>';
    echo '    <div class="rating">';
    echo '        <p>' . ($event["rating"] ?? '-'). '</p>';
    echo '        <i class="fa-regular fa-star"></i>';
    echo '    </div>';
    echo '</div>';
    echo '<ul>';
    echo '    <li><i class="fa-solid fa-calendar-days"></i>' . $event["earliest_date"] . ' - ' . $event["latest_date"] . '</li>';
    echo '    <li><i class="fa-solid fa-location-dot"></i>' . $event["cities"] .  '</li>';
    echo '</ul>';
    echo '</a>';
}

/**
 * Function generates Event Cards
 *
 * @param string|null $card_type is type of card that will be generated, default is "" -> normall card, "owner" -> card for event owners, "participant" -> card for event participant
 * @param int|null $account_id
 *  @return void
 *
 */
function generateEventCards(string $card_type=null, $account_id = null)
{
    if($card_type) {
        $card_type = '-'.$card_type;
    }
    $events = getEvents('all', $account_id);

    foreach($events as &$event) {
        generateEventCard($event, $card_type);
    }
}

function generateEventCardsbyDate() {
    $events = getEvents('approved');
    echo '<div class="card-container">';
    foreach($events as &$event) {
            generateEventCard($event);
    }
    echo '</div>';
}

/**
 * Function generates list of locations
 *
 * @return void
 */
function generateLocations()
{
    $locations = getCities();
    if(!$locations) {
        return;
    }

    foreach ($locations as $location)
    {
        echo '<li>';
        echo '<input type="checkbox" name="locations[]" value="' . $location["city"] . '"' . getCheckBoxSessionState("locations", $location["city"]) . '>';
        echo $location["city"];
        echo '</li>';
    }
}

/**
 * Function generates tree of categories
 *
 * @param string|null $parent_category name of parent category
 * @return void
 */
function generateCategoryTree($parent_category = null)
{
    // getSubCategories($parent_category = null) is function that returns list of subcategories of given parent category
    // it has one parameter and it is name of parent category, default value is null

    $categories = getSubCategories($parent_category);
    if(!$categories) {
        return;
    }

    echo '<ul class="category-tree">';
    foreach ($categories as $category)
    {
        echo '<li>';
        echo '<input
                type="checkbox"
                name="categories[]"
                value="' . $category["category_id"] .
                '" parent="' . $parent_category . '"' .
                ' onchange="updateChildCheckboxes(this)"' .
                getCheckBoxSessionState("categories", $category["category_id"]) .
            '>';
        echo $category["category_name"];
        generateCategoryTree($category["category_id"]);
        echo '</li>';
    }
    echo '</ul>';
}


/**
 * Generates gategories options for select element in html
 *
 * @param string|null $parent_category name of paren category, roots parent category is null
 * @param string $prev_categories string with all root categories
 * @param string|null $default sign of selected category, default is null
 */
function generateCategorySelectOptions($parent_category = null, $prev_categories = '', $default = null)
{
    $categories = getSubCategories($parent_category);
    foreach ($categories as $category)
    {
        $id = $category['category_id'];
        $name = $category['category_name'];
        $selected = ($name == $default ? 'selected' : '');
        echo '<option value="'.$id.'" '.$selected.'>'.$prev_categories.$name.'</option>';
        generateCategorySelectOptions($id, $prev_categories . $name .' -> ', $default);
    }
}


/**
 * Generates location options for html select element
 */
function generateLocationSelectOptions($default = null)
{

    $locations = getApprovedLocations();
    foreach ($locations as $location)
    {
        echo '<option value="'.$location['address_id'].'"'.($location['address_id'] == $default ? ' selected' : '').'>'.formatAddress($location).'</option>';
    }
}


function getLocationSelectOptions($default = null)
{
    $locations = getApprovedLocations();
    $options_str = '';
    foreach ($locations as $location)
    {
        $options_str .= '<option value="'.$location['address_id'].'"'.($location['address_id'] == $default ? ' selected' : '').'>'.formatAddress($location).'</option>';
    }
    return htmlspecialchars($options_str);
}


/**
 * Generator for event tickets
 *
 * @param int $eventID ID of event, which tickets variants will be generated
 * @return void
 */
function generateEventTickets($eventID)
{
    // getEventTickets return basically 'Event instance' table for choosen event
    // but there also has to be 'event_name', and some address info so maybe consider join it with 'Event' and 'Address' table
    $tables_joined = "Event e NATURAL JOIN Event_instance ei JOIN Address a ON ei.address_id = a.address_id";
    $result_id = "instance_id, event_name, date_from, date_to, time_from, time_to, country, city, street, street_number";
    $event_instances = fetch_all_table_columns($tables_joined, $result_id, ["event_id" => $eventID] ,"event_id = :event_id", null);
    $cnt_t = 1;  // counter for tickets
    foreach ($event_instances as $event_instance)
    {
        echo '<div class="ticket">
            <div class="ticket-ticket">
                <div class="ticket-info">
                    <h3>'.$event_instance['event_name'].'</h3>
                    <p>
                        from: '.formatTime($event_instance, 'date_from', 'time_from').
                        '<br>to: ' .formatTime($event_instance, 'date_to', 'time_to').
                        '<br>' . formatAddress($event_instance) .'
                    </p>
                </div>
                <button ticket-arrow-button="ticket-'.$cnt_t.'" class="arrow-button" onclick="toggleTicketDetail(\'ticket-'.$cnt_t.'\')">▼</button>
            </div>';
        if(userIsLoggedIn()) {
            echo '<div class="ticket-types" id="ticket-'.$cnt_t.'">
            <form action="scripts/event-detail/register-tickets.php" method="post">
            <input type="hidden" name="instance_id" value="'.$event_instance['instance_id'].'">
            <input type="hidden" id="token" name="token" value="'.htmlspecialchars(getSessionVal('token', '')).'" >
            <table>';

            // getEventTicketTypes return array of Entrence fees for choosen event and location
            // adjust it based on how the final database will looks like
            $result_id = "fee_name, max_tickets, sold_tickets, cost";
            $entrance_fees = fetch_all_table_columns("Entrance_fee", $result_id, ["instance_id" => $event_instance['instance_id']] ,"instance_id = :instance_id", null);

            $cnt_tt = 1; // counter fot tickets types
            $num_tt = count($entrance_fees);

            foreach ($entrance_fees as $fee)
            {
                echo '<tr>';
                echo '<td>' . $fee['fee_name'] . '</td>';
                echo '<td id="ticket-'.$cnt_t.'-price-'.$cnt_tt.'">' . $fee['cost'] . ',-</td>';
                echo '<td>' . $fee['max_tickets'] - $fee['sold_tickets'] . ' left</td>';
                echo '<input type="hidden" name="fee_name[]" value="'.$fee['fee_name'].'">';
                echo '<td class="row-10"><input type="number" name="ticket_count[]" min="0" value="0" id="ticket-'.$cnt_t.'-quantity-'.$cnt_tt.'" oninput="calcTicketsVal('.$cnt_t.','.$cnt_tt.')"></td>';
                echo '</tr>';

                $cnt_tt += 1;
            }

            echo '<tr class="tickets-reserved">
                            <td><p>Total: </p></td>
                            <td><p id="total-ticket-'.$cnt_t.'">0.00,-</p></td>
                            <td></td>
                            <td class="row-10"><button type="submit" class="button-round-empty">Reserve</button></td>
                    </tr>
                    </table>
                    </form>
                </div>';
        }
        echo '</div>';

        $cnt_t++;
    }
}

/**
 * Make information section for event
 *
 * @param int $eventID ID of event
 * @return void
 */
function makeEventInfo($eventID)
{
    // getEventInfo() return event details so basically 'Event' table
    // also get pohotos
    //$eventInfo = getEventInfo($eventID);
    $event = fetch_table_entry("Event", "event_icon, event_name, event_description", ["event_id" => $eventID], "event_id = :event_id");
    $event_images = fetch_all_table_columns("Photos", "photo_path", ["event_id" => $eventID], "event_id = :event_id");
    $event_image_paths = [];
    foreach($event_images as $event_image) {
        array_push($event_image_paths, $event_image['photo_path']);
    }


    echo '<div class="gallery-popup">
        <div class="gallery-popup-top-bar">
            <span class="close-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <button class="arrow-btn left-arrow"><i class="fa-solid fa-arrow-left"></i></button>
        <button class="arrow-btn right-arrow"><i class="fa-solid fa-arrow-right"></i></button>
        <img class="large-image">
        <h1 class="image-index">1</h1>
    </div>
    <div class="icon-container">
        <img src="'.getEventIcon($event).'">
        <button class="button-round-filled" onclick="toggleGallery('.htmlspecialchars(json_encode($event_image_paths)).')">Gallery</button>
    </div>
    <div class="description-container">
        <h3>'.$event["event_name"].'</h3>
        <p>'.$event['event_description'].'</p>
    </div>';

}

/**
 * Generator for event comments
 *
 * @param int $eventID ID of event, which comments will be generated
 * @return void
 */
function generateComments($eventID)
{
    date_default_timezone_set('Europe/Prague');

    // fetch comments + nick and profile image of comment author
    //$allComments = getEventComments($eventID);
    $comments = fetch_distinct_table_columns("Comment natural join Account", "*", ["event_id" => $eventID], "event_id = :event_id");

    foreach ($comments as $comment)
    {
        echo '
        <div class="comment">
            <div class="comment-header">
                <span>
                    <div class="profile-icon">
                        <img src="'.getUserIcon($comment).'">
                    </div>
                    <div class="comment-header-text">
                        <h3>'.$comment['nick'].'</h3>
                        <p>'.$comment['time_of_posting'].'</p>
                    </div>
                    <p class="rating-text">'.$comment['comment_rating'].'/5</p>
                    <i class="fa-regular fa-star"></i>
                </span>';

        if (userIsModerator() || getUserAttribute('account_id') == $comment['account_id']) {
            echo '
            <div class="comment-header-buttons">
                <button class="button-round-filled" onclick="toggleEditCommentPopUp('."'".htmlspecialchars($comment['comment_id'])."', '".htmlspecialchars(nl2br($comment['comment_text']))."'".')">Edit</button>
                <form action="scripts/event-detail/delete-comment.php" method="post">
                    <input type="hidden" name="account_id" value="'.$comment['account_id'].'">
                    <input type="hidden" name="comment_id" value="'.$comment['comment_id'].'">
                    <input type="hidden" name="token" value="'.htmlspecialchars(getSessionVal('token', '')).'">
                    <button type="submit" class="button-round-filled">Delete</button>
                </form>
            </div>';
        }

        // echo comment text
        echo '
            </div>
            <div class="comment-body">
                <p>'.nl2br($comment['comment_text']).'</p>
            </div>
        </div>
        ';
    }
}


/**
 * Make chooser for roles in IS accessible only for administrator
 *
 * @return void
 */
function makeRoleSelector($id = "")
{
    if (userIsAdmin()) {
        echo '<select name="account_type" id="role-'.$id.'">';
        if($id == '_filter') {
            $selected = getSessionVal("account_type", "") ? "" : 'selected';
            echo '<option value="all" '.$selected.' >all</option>';
        }
        foreach (['administrator', 'moderator', 'regular'] as $account_type) {
            echo '<option value="'.$account_type.'" '.getSelectSessionState("account_type", $account_type).'>'.$account_type.'</option>';
        }
        echo '</select>';
    } else {
        echo '<input type="hidden" name="account_status" id="role-edit-acc" value="'.getUserAttribute('account_type').'">';
    }
}


/**
 * Make section with information about profile
 *
 * @param int $profileID ID of profile
 * @return void
 */
function makeProfileInfo($profileID)
{
    // if user is logged in, user info is already stored in session
    $icon = getUserAttribute('profile_icon')
    ?>

    <div class="icon-container">
        <img id="img-preview" src="<?php echo getUserIcon(); ?>">
        <form action="scripts/profile/upload-profile-icon.php" method="post" enctype="multipart/form-data">
            <input type="file" id="file-input" name="profile-icon" onchange="previewFile()">
            <script> window.onload = refreshImage('img-preview', '<?php echo getUserIcon(); ?>') </script>
            <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <button type="submit" class="button-round-filled">Change Profile Icon</button>
        </form>
    </div>
    <div class="description-container">
        <div class="nick-container">
            <h3><?php echoUserAttribute('nick'); ?></h3>
            <p><?php echoUserAttribute('account_type'); ?></p>
        </div>
        <div class="name-container">
            <p><?php echoUserAttribute('first_name'); ?></p>
            <p><?php echoUserAttribute('last_name'); ?></p>
        </div>
        <p><?php echoUserAttribute('email'); ?></p>
        <span>
            <button class="button-round-filled" onclick="toggleEditProfilePopUp('<?php echoUserAttribute('nick')?>', '<?php echoUserAttribute('first_name') ?>',
            '<?php echoUserAttribute('last_name') ?>', '<?php echoUserAttribute('email') ?>', '<?php echoUserAttribute('account_type') ?>', '<?php echoUserAttribute('account_id') ?>')">Edit profile</button>
            <button class="button-round-filled" onclick="togglePasswordChangeProfilePopUp()">Change password</button>
            <form action="scripts/profile/delete-account.php" method="post">
                <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
                <button class="button-round-filled">Delete account</button>
            </form>
        </span>
    </div>

    <?php
}


/**
 * Generate tickets for profile
 *
 * @param int $profileID ID of profile, which tickets will be generated
 * @return void
 */
function generateProfileTickets($account_id)
{
    // get all tickets for particular user
    // they should be group by status and then group by ticket type
    // it could be done with queries or make some function for this
    $tickets = getUserTickets($account_id);

    foreach($tickets as $ticket)
    {


        // getEventLink() get link to event-detail page of particular event
        echo '<div class="ticket">';
        echo '<a href="'.getEventLink($ticket['event_id']).'" class="ticket-ticket profile-ticket">';
        echo '<span>
        <h3>'.$ticket['event_name'].'</h3>
            <p>from: '.formatTime($ticket, 'date_from', 'time_from').'</p>';
        echo '<p>to: '.formatTime($ticket, 'date_to', 'time_to').'</p>
            <p>'.formatAddress($ticket).'</p>';
        echo '</span>
        <span>
        <h4>Confirmed Tickets</h4>';

        // $ticketsConfirmed is an array/dict with type of ticket and number of tickets of that type
        $confirmed_registrations = getRegistrations($account_id, $ticket['instance_id'],true);
        foreach ($confirmed_registrations as $registration)
        {
            echo '<p>'.$registration['tickets_total'].' '.$registration['fee_name'].'</p>';
        }

        echo '</span>
        <span>
        <h4>Unconfirmed Tickets</h4>';

        $unconfirmed_registrations = getRegistrations($account_id, $ticket['instance_id'],false);
        foreach ($unconfirmed_registrations as $registration)
        {
            echo '<p>'.$registration['tickets_total'].' '.$registration['fee_name'].'</p>';
        }
        echo '</span>
        </a> </div>';
    }
}


/**
 * Generate table rows with category proposals
 */
function generateCategoryProposalRows()
{
    // db query
    $category_proposals = getPendingCategories();


    foreach($category_proposals as $proposal)
    {
        echo '<tr>';
        echo '<td>'.$proposal['category_name'].'</td>';
        echo '<td>'.$proposal['nick'].'</td>';
        echo '<td>'.$proposal['category_description'].'</td>';
        echo '<td>
                <select name="'.$proposal['category_id'].'_super_category" id="categories">';
        if (!$super_category = getSuperCategoryName($proposal)) {
            echo '<option value="" selected></option>';
        }
        generateCategorySelectOptions(null, '', $super_category);
        echo '</select>
            </td>';
        echo '<td class="cell-center cell-small">
                <input name="category_id[]" value="'.$proposal['category_id'].'" type="checkbox">
            </td>';
        echo '</tr>';
    }
}


/**
 * Generates html element select and its options for status
 */
function generateStatusSelectOptions($select_name, $select_id, $include_all = false) {
    echo '<select name="'.$select_name.'" id="'.$select_id.'">';
    echo $include_all ? '<option value="all" '.getSelectSessionDefaultState($select_name, 'all').' >all</option>' : '';
    foreach(['approved', 'pending'] as $status) {
        echo '<option value="'.$status.'" '.getSelectSessionState($select_name, $status) .' >'.$status.'</option>';
    }
    echo '</select>';
}

/**
 * Generates table rows with categories
 */
function generateCategoryRows()
{
    $categories = getCategories();

    foreach($categories as $category)
    {
        echo '<tr>';
        echo '<td>'.$category['category_name'].'</td>';
        echo '<td>'.getSuperCategoryName($category).'</td>';
        echo '<td class="cell-center cell-small">'.$category['category_status'].'</td>';
        echo '<td class="cell-center cell-small">
                <input name="category_id[]" value="'.$category['category_id'].'" type="checkbox">
            </td>';
        echo '<td class="cell-center cell-small"><button type="button" class="button-round-filled"
        onclick="toggleEditCategoryPopUp('."'".getColumn($category, 'category_name')."', '". getColumn($category, 'super_category_id').
        "', '".getColumn($category, 'category_description')."', '".getColumn($category, 'category_status')."', '".getColumn($category, 'category_id')."'".')">Edit</button></td>';
        echo '</tr>';
    }
}


/**
 * Generates location proposals table rows
 */
function generateLocationProposalRows()
{
    $location_proposals = getlocationProposals();

    foreach($location_proposals as $proposal)
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$proposal['address_id'].'</td>';
        echo '<td>'.getColumn($proposal, 'nick').'</td>';
        echo '<td>'.$proposal['country'].'</td>';
        echo '<td>'.$proposal['city'].'</td>';
        echo '<td>'.$proposal['street'].'</td>';
        echo '<td class="cell-center cell-small">'.$proposal['street_number'].'</td>';
        echo '<td>'.getColumn($proposal, 'state').'</td>';
        echo '<td class="cell-center cell-small">'.getColumn($proposal, 'zip').'</td>';
        echo '<td class="cell-center cell-small">
                <input name="address_id[]" value="'.$proposal['address_id'].'" type="checkbox">
            </td>';
        echo '</tr>';
    }
}


/**
 * Generates location table rows
 */
function generateLocationRows()
{
    // db query
    $locations = getLocations();

    foreach($locations as $location)
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$location['address_id'].'</td>';
        echo '<td>'.$location['country'].'</td>';
        echo '<td>'.$location['city'].'</td>';
        echo '<td>'.$location['street'].'</td>';
        echo '<td class="cell-center cell-small">'.$location['street_number'].'</td>';
        echo '<td>'.$location['state'].'</td>';
        echo '<td class="cell-center cell-small">'.$location['zip'].'</td>';
        echo '<td class="cell-center cell-small">'.$location['address_status'].'</td>';
        echo '<td class="cell-center cell-small">
                <input name="address_id[]" value="'.$location['address_id'].'" type="checkbox">
            </td>';
        echo '<td class="cell-center cell-small"><button type="button" class="button-round-filled" onclick="toggleEditLocationPopUp('."'".$location['country'].
        "', '".$location['city']."', '".$location['street']."', '".$location['street_number']."', '".$location['state']."'".', '."'".$location['zip']."', '".
        getColumn($location, 'address_description')."', '".$location['address_id']."', '".$location['address_status']."'".')">Edit</button></td>';
        echo '</tr>';
    }
}


/**
 * Generates account table rows
 */
function generateAccountRows()
{
    $accounts = getAccounts();

    foreach($accounts as $account)
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$account['account_id'].'</td>';
        echo '<td>'.$account['nick'].'</td>';
        echo '<td>'.$account['first_name'].'</td>';
        echo '<td>'.$account['last_name'].'</td>';
        echo '<td>'.$account['email'].'</td>';
        echo '<td class="cell-center cell-small">'.$account['account_type'].'</td>';
        echo '<td class="cell-center cell-small">'.$account['account_status'].'</td>';
        echo '<td class="cell-center cell-small">
                <input name="account_id[]" value="'.$account['account_id'].'" type="checkbox">
            </td>';
        echo '<td class="cell-center cell-small"><button type="button" class="button-round-filled" onclick="toggleEditProfilePopUp('."'".$account['nick']."', '".
        $account['first_name']."', '".$account['last_name']."', '".$account['email']."', '".$account['account_type']."', '".$account['account_id']."'".')">Edit</button></td>';
        echo '</tr>';
    }
}


/**
 * Generates event table rows
 */
function generateEventRows()
{
    $events = getEvents('all');

    foreach($events as $event)
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$event['event_id'].'</td>';
        echo '<td>'.$event['event_name'].'</td>';
        echo '<td>'.$event['nick'].'</td>';
        echo '<td class="cell-center cell-small">'.$event['earliest_date'].'</td>';
        echo '<td class="cell-center cell-small">'.$event['latest_date'].'</td>';
        echo '<td class="cell-large">'.$event['cities'].'</td>';
        echo '<td class="cell-center cell-small">'.$event['rating'].'/5<i class="fa-regular fa-star"></i></td>';
        echo '<td class="cell-center cell-small">'.$event['event_status'].'</td>';
        echo '<td class="cell-center cell-small">
                <input type="checkbox" value="'.$event['event_id'].'" name="event_id[]'.$event['event_id'].'">
            </td>';
        echo '</tr>';
    }
}


/**
 * Generates html table rows with attributs of ordered tickets for specific event
 *
 * @param int $event_id id of event
 */
function generateTicketOrdersRows($event_id)
{
    // db query
    $tickets = getTickets($event_id, false);

    foreach($tickets as $ticket)
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$ticket['reg_id'].'</td>';
        echo '<td>'.$ticket['nick'].'</td>';
        echo '<td>'.$ticket['first_name'].'</td>';
        echo '<td>'.$ticket['last_name'].'</td>';
        echo '<td>'.$ticket['email'].'</td>';
        echo '<td>'.formatAddress($ticket).'</td>';
        echo '<td>'.$ticket['time_from'].'</td>';
        echo '<td>'.$ticket['fee_name'].'</td>';
        echo '<td class="cell-center cell-small">'.$ticket['ticket_count'].'</td>';
        echo '<td class="cell-center cell-small">
                <input name="reg_id[]" value="'.$ticket['reg_id'].'" type="checkbox">
            </td>';
        echo '</tr>';
    }
}


/**
 * Generates html table rows with attributs of confirmed tickets for specific event
 *
 * @param int $event_id id of event
 */
function generateTicketRows($event_id)
{
    // db query
    $tickets = getTickets($event_id, true);

    foreach($tickets as $ticket)
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$ticket['reg_id'].'</td>';
        echo '<td>'.$ticket['nick'].'</td>';
        echo '<td>'.$ticket['first_name'].'</td>';
        echo '<td>'.$ticket['last_name'].'</td>';
        echo '<td>'.$ticket['email'].'</td>';
        echo '<td>'.formatAddress($ticket).'</td>';
        echo '<td>'.$ticket['time_from'].'</td>';
        echo '<td>'.$ticket['fee_name'].'</td>';
        echo '<td class="cell-center cell-small">'.$ticket['ticket_count'].'</td>';
        echo '<td class="cell-center cell-small">
                <input name="reg_id[]" value="'.$ticket['reg_id'].'" type="checkbox">
            </td>';
        echo '</tr>';
    }
}


/**
 * Creates form for the editing event
 *
 * @param int $eventID id of the event
 */
function makeEditEventForm($eventID)
{
    // db query
    $event = getEventInfo($eventID);
    $eventPhotos = getEventPhotos($eventID);

    ?>
    <div class="form-block">
        <span>
            <label for="e-name">What is name for your event ?</label>
            <input type="text" id="e-name" name="event_name" value="<?php echo $event['event_name'] ?>" placeholder="Event name">
        </span>
    </div>
    <div class="form-block">
        <span>
            <label for="e-description">Write description of yor event</label>
            <textarea name="" id="e-description" name="event_description" cols="30" rows="10" placeholder="Description..."><?php echo $event['event_description'] ?></textarea>
        </span>
    </div>
    <div class="form-block">
        <span>
            <label for="e-icon">Choose front image for your event</label>
            <input type="file" name="event_icon" value="<?php echo getEventIcon($event) ?>" name="e-icon">
        </span>
        <span>
            <label for="e-images">Choose gallery images for your event</label>
            <input type="file" name="event_images[]" value="<?php $eventPhotos ?>" multiple>
        </span>
    </div>
    <div class="form-block">
        <span>
            <label for="category-select">Select category for your event</label>
            <select name="category_name" id="category-select" >
                <?php generateCategorySelectOptions(null, null, $event['category_name']) ?>
            </select>
        </span>
    </div>
    <?php
}


/**
 * Generates ticket variants of specific event for editing
 *
 * @param int $eventID id of the event
 */
function generateEditEventVariants($eventID)
{
    // db query
    $event_instances = getEventInstances($eventID);
    $cnt = 1;

    foreach($event_instances as $instance)
    {
        ?>
        <div class="ticket" id="event-variant-<?php echo $cnt ?>">
            <div class="form-block ticket-create">
                <button type="button" class="button-round-filled" onclick="removeEventVariant(<?php echo $cnt ?>)"><i class="fa-solid fa-trash"></i></button>
                <div class="ticket-form-inputs">
                    <div class="filter-date">
                        <label for="e-date-from">Date from:</label>
                        <input type="date" id="e-date-from<?php echo $cnt ?>" name="e-date-from<?php echo $cnt ?>" value="<?php echo $instance['date_from'] ?>">
                    </div>
                    <div class="filter-date">
                        <label for="e-date-to">Date to:</label>
                        <input type="date" id="e-date-to<?php echo $cnt ?>" name="e-date-to<?php echo $cnt ?>" value="<?php echo $instance['date_to'] ?>">
                    </div>
                    <div class="filter-date">
                        <label for="e-time-from">Time from:</label>
                        <input type="time" id="e-time-from<?php echo $cnt ?>" name="e-time-from<?php echo $cnt ?>" value="<?php echo $instance['time_from'] ?>">
                    </div>
                    <div class="filter-date">
                        <label for="e-time-to">Time to:</label>
                        <input type="time" id="e-time-to<?php echo $cnt ?>" name="e-time-to<?php echo $cnt ?>" value="<?php echo $instance['time_to'] ?>">
                    </div>
                    <span>
                        <label for="location-select">Select location</label>
                        <select name="location-select<?php echo $cnt ?>" id="location-select<?php echo $cnt ?>">
                            <?php generateLocationSelectOptions($instance['address_id']) ?>
                        </select>
                    </span>
                </div>
                <button type="button" ticket-arrow-button="ticket-1" class="arrow-button" onclick="toggleTicketDetail('ticket-<?php echo $cnt ?>')">▼</button>
            </div>
            <div class="ticket-types" id="ticket-<?php echo $cnt ?>">
                <table id="variant-types-<?php echo $cnt ?>">
                    <tr>
                        <td>Ticket type</td>
                        <td class="row-15">Ticket cost in czk</td>
                        <td class="row-15">Number of tickets</td>
                        <td class="row-10"><button type="button" class="button-round-filled" onclick="addTicketType(<?php echo $cnt ?>)"><i class="fa-solid fa-plus"></i></button></td>
                    </tr>
                    <?php
                    // db query
                    $entrance_fees = getInstanceEntranceFees($instance['instance_id']);

                    $fee_cnt = 1;
                    foreach ($entrance_fees as $fee)
                    {
                        ?>
                        <tr>
                            <td>
                                <input type="text" name="ticket-type<?php echo $fee_cnt?>" id="ticket-type<?php echo $fee_cnt?>" value="<?php echo $fee['fee_name'] ?>" placeholder="Ticket type name">
                            </td>
                            <td class="row-15">
                                <input type="number" name="ticket-cost<?php echo $fee_cnt?>" id="ticket-cost<?php echo $fee_cnt?>" value="<?php echo $fee['cost'] ?>" placeholder="Cost" oninput="checkNegativeInput(this)">
                            </td>
                            <td class="row-15">
                                <input type="number" name="ticket-cnt<?php echo $fee_cnt?>" id="ticket-cnt<?php echo $fee_cnt?>" value="<?php echo $fee['max_tickets'] ?>" placeholder="Num." oninput="checkNegativeInput(this)">
                            </td>
                            <td class="row-10"><button type="button" class="button-round-filled" onclick="removeTicketType(this)"><i class="fa-solid fa-trash"></i></button></td>
                        </tr>
                        <?php
                        $fee_cnt++;
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
        $cnt++;
    }
}


/**
 * Generates select with options for account status selection
 */
function makeAccountStatusSelector() {
    echo '<select name="account_status" id="account_status">';
    foreach(['all', 'active', 'disabled'] as $status) {
        $selected = getSessionVal('account_status', '') == $status ? 'selected' : '';
        echo '<option value="'.$status.'" '.$selected.'>'.$status.'</option>';
    }
    echo '</select>';
}
