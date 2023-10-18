<?php
/**
 * @file html-components.php
 * @brief Common html website components
 * @author Michal Ľaš (xlasmi00)
 * @date 05.08.2023
 */


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
        <!-- change styles hardcoded path -->
        <link rel="stylesheet" href="/iis/styles/style.css">
        <script src="https://kit.fontawesome.com/2ff75daa4b.js" crossorigin="anonymous"></script>
        <script src="/iis/js/design-scripts.js"></script>
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
        <ul>
            <li><i class='fa-solid fa-user'></i><a href="#">Profile</a></li>

    <?php
    /*
    if (user is logged in as moderator)
    {
        echo '<li><i class="fa-solid fa-sun"></i><a href="#">Manage Events</a></li>';
        echo '<li><i class="fa-solid fa-paperclip"></i><a href="#">Manage Categories</a></li>';
        echo '<li><i class="fa-solid fa-location-dot"></i><a href="#">Manage Locations</a></li>';
    }
    if (user is logged in as administrator)
    {
        echo '<li><i class="fa-solid fa-users-gear"></i><a href="#">Manage Accounts</a></li>';
    }
    */
    ?>

            <li><i class="fa-solid fa-right-from-bracket"></i><a href="#">Log out</a></li>
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
                <!-- action is a function in BG that will search the result -->
                <form action="" method="get">
                    <input type="text" placeholder="Search events...">
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <!-- src is profile icon-->
            <div class="profile">
                <?php
                    /*
                    if (user is logged in )
                    {
                        echo '<div class="profile-icon" onclick="menuToggle();">';
                        echo "<img src='profil icon'>";
                        echo "</div>"; 
                        generateProfilMenu();
                    }
                    else
                    {
                        echo "<div class='login-btns'>";
                        echo "<a href='' class='button-sharp-filled'>log in</a>";
                        echo "<a href='' class='button-sharp-filled'>sign in</a>";
                        echo "</div>"; 
                    }
                    */
                    
                    // TEST CODE

                    echo '<div class="profile-icon" onclick="menuToggle();">';
                    echo "<img src=/iis/1.png>";

                    // echo "<div class='login-btns'>";
                    // echo "<a href='' class='button-sharp-filled'>log in</a>";
                    // echo "<a href='' class='button-sharp-filled'>sign in</a>";
                    
                    echo "</div>";

                    // END OF TEST COED

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
    </body>
    </html>

    <?php
}


/**
 * Function generates Event Cards
 * 
 * @param array $events is array of values that are displayed on card like Event name, Location, etc.
 * @param string $card_type is type of card that will be generated, default is "" -> normall card, "owner" -> card for event owners, "participant" -> card for event participant
 * @return void
 * 
 */
function generateEventCards(array $events, string $card_type="")
{
    if ($card_type != "" || $card_type != "owner")
    {
        $card_type = "";
    }

    if ($card_type != "")
    {
        $card_type = "-" . $card_type;
    }

    /* TEST CODE */
    for ($i = 0; $i <= 10; $i++)
    {
        ?>

        <!-- TEST CODE -->
        <a href="" class="event-card">
            <img src="/iis/1.png">
            <div class="name-rating">
                <h3>Event Name</h3>
                <div class="rating">
                    <p>4/5</p>
                    <i class="fa-regular fa-star"></i>
                </div>
            </div>
            <ul>
                <li><i class="fa-solid fa-calendar-days"></i>30.02.2024-31.03.2024</li>
                <li><i class="fa-solid fa-location-dot"></i>Everywhere</li>
            </ul>
        </a>
        <!-- END OF TEST CODE -->

        <?php
    }

    /*

    foreach($events as $event)
    {
        ?>

        <a href="event-detail.php?id='<?php echo $event['id']?>'" class="<?php echo 'event-card' . $card_type ?>">
            <img src="<?php echo $event['image_url']; ?>">
            <div class="name-rating">
                <h3><?php echo $event['event_name']; ?></h3>
                <div class="rating">
                    <p><?php echo $event['rating']; ?></p>
                    <i class="fa-regular fa-star"></i>
                </div>
            </div>
            <ul>
                <li><i class="fa-solid fa-calendar-days"></i><?php echo $event['date_from'] . $event['date_to']; ?></li>
                <li><i class="fa-solid fa-location-dot"></i><?php echo $event['location']; ?></li>
            </ul>
        </a>

        <?php
    }

    */
}


/**
 * Function generates list of locations
 * 
 * @return void
 */
function generateLocations()
{
    /*
    $locations = getLocations();
    foreach ($locations as $location)
    {
        echo '<li>' . $location . '</li>';
    }
    */
}


/**
 * Function generates tree of categories
 * 
 * @param string|null $parent_category name of parent category
 * @return void
 */
function generateCategoryTree($parent_category = null) 
{

    // getParentCategories($parent_category = null) is function that return list subcategories of given parent category
    // it has one parameter and it is name of parent category, default value is null

    /*
    $categories = getParentCategories($parent_category);

    echo '<ul class="category-tree">';
    foreach ($categories as $category)
    {
        if ($category['parent_name'] == $parent_category)
        {
            echo '<li>';
            echo '<input type="checkbox" name="categories[]" value="' . $category['name'] . '">';
            echo $category['name'];
            generateCategoryTree($category['name']);
            echo '<\li>';
        }
    }
    echo '</ul>';
    */
}


function generateCategorySelecetOptions($parent_category = null, $prev_categories = '')
{
    // TEST CODE
    ?>

    <option value="1">Category 1</option>
    <option value="2">Category 2</option>
    <option value="3">Category 3</option>

    <?php 
    // END OF TEST CODE

    /*
    $categories = getParentCategories($parent_category);
    foreach ($categories as $category)
    {
        if ($category['parent_category'] == $parent_category)
        {
            $prev_categories = $prev_categories . '->' . $category['name'];
            echo '<option value="'.$category['id'].'">'.$prev_categories.'</option>';
            generateCategorySelecetOptions($category['name'], $prev_categories);
        }   
    }
    */
}


function generateLocationSelecetOptions()
{
    // TEST CODE
    ?>

    <option value="loc1">Location 1</option>
    <option value="loc2">Location 2</option>
    <option value="loc3">Location 3</option>

    <?php 
    // END OF TEST CODE
    
    /*
    $locations = getLocations();
    $counter = 0;
    foreach ($locations as $location)
    {
        echo '<option value="loc'.$counter.'">'.$location.'</option>';
        $counter += 1;
    }
    */
}


/**
 * Generator for event tickets
 * 
 * @param int $eventID ID of event, which tickets variants will be generated
 * @return void
 */
function generateEventTickets($eventID)
{
    ?>
    <!-- TEST CODE -->
    <div class="ticket">
        <div class="ticket-ticket">
            <div class="ticket-info">
                <h3>Event name</h3>
                <p>
                    date from - date to <br> Time from - Time to <br> Location <br>
                </p>
            </div>
            <button ticket-arrow-button="ticket-1" class="arrow-button" onclick="toggleTicketDetail('ticket-1')">▼</button>
        </div>
        <div class="ticket-types" id="ticket-1">
            <table>
                <tr>
                    <td>Normal ticket</td>
                    <td id="ticket-1-price-1">$32</td>
                    <td>200 left</td>
                    <td class="row-10"><input type="number" min="0" value="0" id="ticket-1-quantity-1" oninput="calcTicketsVal(1,2)"></td>
                </tr>
                <tr>
                    <td>VIP ticket</td>
                    <td id="ticket-1-price-2">$52</td>
                    <td>50 left</td>
                    <td class="row-10"><input type="number" min="0" value="0" id="ticket-1-quantity-2" oninput="calcTicketsVal(1,2)"></td>
                </tr>
                <tr class="tickets-reserved">
                    <td><p>Total: </p></td>
                    <td><p id="total-ticket-1">$0</p></td>
                    <td></td>
                    <td class="row-10"><button class="button-round-empty">Reserve</button></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="ticket">
        <div class="ticket-ticket">
            <div class="ticket-info">
                <h3>Event name</h3>
                <p>
                    date from - date to <br> Time from - Time to <br> Location <br>
                </p>
            </div>
            <button ticket-arrow-button="ticket-2" class="arrow-button" onclick="toggleTicketDetail('ticket-2')">▼</button>
        </div>
        <div class="ticket-types" id="ticket-2">
            <table>
                <tr>
                    <td>Normal ticket</td>
                    <td id="ticket-2-price-1">$32</td>
                    <td>200 left</td>
                    <td class="row-10"><input type="number" min="0" value="0" id="ticket-2-quantity-1" oninput="calcTicketsVal(2,2)"></td>
                </tr>
                <tr>
                    <td>VIP ticket</td>
                    <td id="ticket-2-price-2">$52</td>
                    <td>50 left</td>
                    <td class="row-10"><input type="number" min="0" value="0" id="ticket-2-quantity-2" oninput="calcTicketsVal(2,2)"></td>
                </tr>
                <tr class="tickets-reserved">
                    <td><p>Total: </p></td>
                    <td><p id="total-ticket-2">$0</p></td>
                    <td></td>
                    <td class="row-10"><button class="button-round-empty">Reserve</button></td>
                </tr>
            </table>
        </div>
    </div>
    <!-- END OF TEST CODE -->
    <?php

    /*
    // getEventTickets return basically 'Event instance' table for choosen event
    // but there also has to be 'event_name', and some address info so maybe consider join it with 'Event' and 'Address' table
    $eventTickets = getEventTickets($eventID);

    $cnt_t = 1;  // counter for tickets

    foreach ($eventTickets as $ticket)
    {
        ?>
        <div class="ticket">
            <div class="ticket-ticket">
                <div class="ticket-info">
                    <h3><?php $ticket['event_name'] ?></h3>
                    <p>
                        <?php $ticket['date_from'] . '-' . $ticket['date_to'] . '<br>' . $ticket['time_from'] . '-' . $ticket['time_to'] . '<br>' . $ticket['Country'] . ', ' . $ticket['city'] . ', ' . $ticket['street_number']?>;
                    </p>
                </div>
                <button ticket-arrow-button="ticket-<?php $cnt_t ?>" class="arrow-button" onclick="toggleTicketDetail('ticket-<?php $cnt_t ?>')">▼</button>
            </div>
            <div class="ticket-types" id="ticket-<?php $cnt_t ?>">
                <table>
        <?php

        // getEventTicketTypes return array of Entrence fees for choosen event and location
        // adjust it based on how the final database will looks like
        $ticketTypes = getEventTicketTypes($eventID, $ticket['addressID']);

        $cnt_tt = 1; // counter fot tickets types
        $num_tt = count($ticketTypes);
        
        foreach ($ticketTypes as $type)
        {
            echo '<tr>';
            echo '<td>' . $type['fee_name'] . '</td>';
            echo '<td id="ticket-'.$cnt_t.'-price-'.$cnt_tt.'">' . $type['cost'] . '</td>';
            echo '<td>' . $type['max_tickets'] - $type['sold_tickets'] . ' left</td>';
            echo '<td class="row-10"><input type="number" min="0" value="0" id="ticket-'.$cnt_t.'-quantity-'.$cnt_tt.'" oninput="calcTicketsVal('.$cnt_t.','.$num_tt.')"></td>';
            echo '</tr>';

            $cnt_tt += 1;
        }

        ?>
                <tr class="tickets-reserved">
                        <td><p>Total: </p></td>
                        <td><p id="total-ticket-<?php $cnt_t ?>">$0</p></td>
                        <td></td>
                        <td class="row-10"><button class="button-round-empty">Reserve</button></td>
                </tr>
                </table>
            </div>
        </div>

        <?php

        $cnt_t += 1;
    }
    */
}


/**
 * Make information section for event
 * 
 * @param int $eventID ID of event
 * @return void
 */
function makeEventInfo($eventID)
{
    ?>
    <!-- TEST CODE -->
    <div class="gallery-popup">
        <div class="gallery-popup-top-bar">
            <span class="close-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <button class="arrow-btn left-arrow"><i class="fa-solid fa-arrow-left"></i></button>
        <button class="arrow-btn right-arrow"><i class="fa-solid fa-arrow-right"></i></button>
        <img class="large-image">
        <h1 class="image-index">1</h1>
    </div>
    <div class="icon-container">
        <img src="1.png">
        <button class="button-round-filled" onclick="toggleGallery(['1.png', '1.png', '1.png'])">Gallery</button>
    </div>
    <div class="description-container">
        <!-- replace -->
        <h3>Random Event</h3>
        <p>Description</p>
    </div>
    <!-- END OF TEST CODE -->

    <?php

    /*
    // getEventInfo() return event details so basically 'Event' table
    // also get pohotos
    $eventInfo = getEventInfo($eventID);

    ?>
    
    <div class="gallery-popup">
        <div class="gallery-popup-top-bar">
            <span class="close-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <button class="arrow-btn left-arrow"><i class="fa-solid fa-arrow-left"></i></button>
        <button class="arrow-btn right-arrow"><i class="fa-solid fa-arrow-right"></i></button>
        <img class="large-image">
        <h1 class="image-index">1</h1>
    </div>
    <div class="icon-container">
        <img src="<?php $eventInfo['icon']" ?>>
        <!-- getEventImages($eventID) return list of event images paths -->
        <button class="button-round-filled" onclick="toggleGallery(<?php json_encode(getEventImages($eventID)) ?>)">Gallery</button>
    </div>
    <div class="description-container">
        <!-- replace -->
        <h3><?php $eventInfo['event_name'] ?></h3>
        <p><?php $eventInfo['description'] ?></p>
    </div>


    <?php
    */
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

    ?>

    <!-- TEST CODE -->
    <div class="comment">
        <div class="comment-header">
            <span>
                <div class="profile-icon">
                    <img src="1.png">
                </div>
                <div class="comment-header-text">
                    <h3>User nick</h3>
                    <p>date-time</p>
                </div>
                <p class="rating-text">4/5</p>
                <i class="fa-regular fa-star"></i>
            </span>
            <div class="comment-header-buttons">
                <button class="button-round-filled" onclick="toggleEditCommentPopUp(1, 'Comment text')">Edit</button>
                <form action="">
                    <input type="hidden" value="">
                    <button type="submit" class="button-round-filled">Delete</button>
                </form>
            </div>
        </div>
        <div class="comment-body">
            <p>Comment text</p>
        </div>
    </div>
    <!-- END OF TEST CODE -->

    <?php

    /*
    // fetch comments + nick and profile image of comment author
    $allComments = getEventComments($eventID);

    while ($row = $allComments->fetch_assoc())
    {
        // echo header (profile icon, nick, datetime)
        echo '
        <div class="comment">
            <div class="comment-header">
                <span>
                    <div class="profile-icon">
                        <img src="'.$row['profile_icon'].'">
                    </div>
                    <div class="comment-header-text">
                        <h3>'.$row['nick'].'</h3>
                        <p>'.$row['datetime'].'</p>
                    </div>
                    <p class="rating-text">'.$row['rating'].'/5</p>
                    <i class="fa-regular fa-star"></i>
                </span>
        ';

        // if l(ogged user is author of the comment or moderator or administrator)
        if ()
        {
            echo '
            <div class="comment-header-buttons">
                <button class="button-round-filled" onclick="toggleEditCommentPopUp('.$row['comment_id'].', '.ln2br($row['comment_text']).')">Edit</button>
                <form action="">
                    <input type="hidden" value="'.$row['comment_id'].'">
                    <button type="submit" class="button-round-filled">Delete</button>
                </form>
            </div>
            ';
        }

        // echo comment text
        echo '
            </div>
            <div class="comment-body">
                <p>'.ln2br($row['comment_text']).'</p>
            </div>
        </div>
        ';
    }
    */
}


/**
 * Make chooser for roles in IS accessible only for administrator
 * 
 * @return void
 */
function makeRoleSelector()
{
    // TEST CODE
    ?>

    <select name="" id="role">
        <option value="user">Normal user</option>
        <option value="moderator">Moderator</option>
        <option value="administrator">Administrator</option>
    </select>

    <?php
    // END OF TEST CODE

    /*
    // user is logged in AND (user is administrator)
    if ()
    {
        ?>

        <select name="" id="role">
            <option value="Normall user"></option>
            <option value="Moderator"></option>
            <option value="Administrator"></option>
        </select>

        <?php
    }
    */
}


/**
 * Make section with information about profile
 * 
 * @param int $profileID ID of profile
 * @return void
 */
function makeProfileInfo($profileID)
{

    // TEST CODE
    ?>
    <div class="icon-container">
        <img src="1.png">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file">
            <button type="submit" class="button-round-filled">Change Profile Icon</button>
        </form>
    </div>
    <div class="description-container">
        <div class="nick-container">
            <!-- replace -->
            <h3>Profile name</h3>
            <p>role</p>
        </div>
        <div class="name-container">
            <p>First name</p>
            <p>Last name</p>
        </div>
        <p>Email</p>
        <span>
            <button class="button-round-filled" onclick="toggleEditProfilePopUp('Profile name', 'First name', 'Last name', 'Email', 'user')">Edit profile</button>
            <button class="button-round-filled" onclick="togglePasswordChangeProfilePopUp()">Change password</button>
            <form action="" method="post">
                <input type="hidden" value="">
                <button class="button-round-filled">Delete account</button>
            </form>
        </span>
    </div>
    <?php
    // END OF TEST CODE

    /*
    // get information from databese
    $profile = getProfileInfo($profileID);

    ?>

    <div class="icon-container">
        <img src="<?php $profile['icon'] ?>">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file">
            <button type="submit" class="button-round-filled">Change Profile Icon</button>
        </form>
    </div>
    <div class="description-container">
        <div class="nick-container">
            <!-- replace -->
            <h3><?php $profile['nick'] ?></h3>
            <p><?php $profile['role'] ?></p>
        </div>
        <div class="name-container">
            <p><?php $profile['first_name'] ?></p>
            <p><?php $profile['last_name'] ?></p>
        </div>
        <p><?php $profile['email'] ?></p>
        <span>
            <button class="button-round-filled" onclick="toggleEditProfilePopUp('Profile name', 'First name', 'Last name', 'Email', 'user')">Edit profile</button>
            <button class="button-round-filled" onclick="togglePasswordChangeProfilePopUp()">Change password</button>
            <form action="" method="post">
                <input type="hidden" value="<?php $profile['account_id'] ?>">
                <button class="button-round-filled">Delete account</button>
            </form>
        </span>
    </div>

    <?php
    */
}


/**
 * Generate tickets for profile
 * 
 * @param int $profileID ID of profile, which tickets will be generated
 * @return void
 */
function generateProfileTickets($profileID)
{
    // TEST CODE
    ?>
    <a href="#" class="ticket-ticket profile-ticket">
        <span>
            <h3>Event name</h3>
            <p>Date</p>
            <p>Time from - Time to</p>
            <p>Location</p>
        </span>
        <span>
            <h4>Confirmed Tickets</h4>
            <p>2x Adult</p>
            <p>2x Kid</p>
        </span>
        <span>
            <h4>Unconfirmed Tickets</h4>
            <p>3x VIP</p>
        </span>
    </a>
    <?php
    // END OF TEST CODE

    /*
    // get all tickets for particular user
    // they should be group by status and then group by ticket type
    // it could be done with queries or make some function for this
    $pTickets = getUserTickets($profileID);

    while ($row = $pTickets->fetch_assoc())
    {
        
        
        // getEventLink() get link to event-detail page of particular event
        $eventLink = getEventLink($row['eventID']);

        // href is link to page with particular event
        echo '<a href="'.$eventLink.'" class="ticket-ticket profile-ticket">';
        echo '<span>
        <h3>Event name</h3>
            <p>'.$row['date'].'</p>
            <p>'.$row['time_from'].'-'.$row['time_to'].'</p>
            <p>'.$row['location'].'</p>
        </span>
        <span>
        <h4>Confirmed Tickets</h4>';

        // $ticketsConfirmed is an array/dict with type of ticket and number of tickets of that type
        foreach ($ticketsConfirmed as $ticketType)
        {
            echo '<p>'.$ticketType['num'].' '.$ticketType['name'].'</p>';
        }

        echo '</span>
        <span>
        <h4>Unconfirmed Tickets</h4>';

        foreach ($ticketsUnconfirmed as $ticketType)
        {
            echo '<p>'.$ticketType['num'].' '.$ticketType['name'].'</p>';
        }
        echo '</span>
        </a>';
    }
    */
}


/**
 * Generate table rows with category proposals
 */
function generateCategoryProposalRows()
{
    // TEST CODE
    ?>

    <tr>
        <td class="cell-center cell-small">1</td>
        <td>Sport</td>
        <td>Joe Doe</td>
        <td>Description...</td>
        <td>
            <select name="" id="">
                <?php generateCategorySelecetOptions() ?>
            </select>
        </td>
        <td class="cell-center cell-small">
            <input type="checkbox">
        </td>
    </tr>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $categoryProposals = getCategoryProposals();
    
    while($row = $categoryProposals->fetch_assoc())
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$row['id'].'</td>';
        echo '<td>'.$row['category_name'].'</td>';
        echo '<td>'.$row['category_author'].'</td>';
        echo '<td>'.$row['category_description'].'</td>';
        echo '<td>
                <select name="" id="">
                    <?php generateCategorySelecetOptions() ?>
                </select>
            </td>';
        echo '<td class="cell-center cell-small">
                <input type="checkbox">
            </td>';
        echo '</tr>';
    }
    */

}


/**
 * Generate table rows with categories
 */
function generateCategoryRows()
{
    // TEST CODE
    ?>

    <tr>
        <td class="cell-center cell-small">1</td>
        <td>Sport</td>
        <td>Root</td>
        <td class="cell-center cell-small">Enable</td>
        <td class="cell-center cell-small"><input type="checkbox"></td>
        <td class="cell-center cell-small"><button type="button" class="button-round-filled" onclick="toggleEditCategoryPopUp('Category 1', 3)">Edit</button></td>
    </tr>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $categories = getCategories();
    
    while($row = $categories->fetch_assoc())
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$row['id'].'</td>';
        echo '<td>'.$row['category_name'].'</td>';
        echo '<td>'.$row['parent_category_name'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['status'].'</td>';
        echo '<td class="cell-center cell-small">
                <input type="checkbox">
            </td>';
        echo '<td class="cell-center cell-small"><button type="button" class="button-round-filled" onclick="toggleEditCategoryPopUp('.$row['category_name'].', '.$row['parent_category_id'].')">Edit</button></td>';
        echo '</tr>';
    }
    */
}


/**
 * Generate location proposals table rows
 */
function generateLocationProposalRows()
{
    // TEST CODE
    ?>

    <tr>
        <td class="cell-center cell-small">1</td>
        <td>Joe Doe</td>
        <td>United Kingdom</td>
        <td>Dulcote</td>
        <td>Orwell</td>
        <td class="cell-center cell-small">88</td>
        <td>Wells</td>
        <td class="cell-center cell-small">12305</td>
        <td><input type="checkbox"></td>
    </tr>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $locationProposals = getlocationProposals();
    
    while($row = $categoryProposals->fetch_assoc())
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$row['id'].'</td>';
        echo '<td>'.$row['location_author'].'</td>';
        echo '<td>'.$row['country'].'</td>';
        echo '<td>'.$row['city'].'</td>';
        echo '<td>'.$row['street_name'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['street_number'].'</td>';
        echo '<td>'.$row['region'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['zip_code'].'</td>';
        echo '<td class="cell-center cell-small">
                <input type="checkbox">
            </td>';
        echo '</tr>';
    }
    */

}


/**
 * Generate location table rows
 */
function generateLocationRows()
{
    // TEST CODE
    ?>

    <tr>
        <td class="cell-center cell-small">1</td>
        <td>United Kingdom</td>
        <td>Dulcote</td>
        <td>Orwell</td>
        <td class="cell-center cell-small">88</td>
        <td>Wells</td>
        <td class="cell-center cell-small">12305</td>
        <td class="cell-center cell-small">enable</td>
        <td><input type="checkbox"></td>
        <td class="cell-center cell-small"><button type="button" class="button-round-filled" onclick="toggleEditLocationPopUp('UK', 'Dulcote', 'Orwell', 88, 'Wells', 12305)">Edit</button></td>
    </tr>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $locations = getLocations();
    
    while($row = $locations->fetch_assoc())
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$row['id'].'</td>';
        echo '<td>'.$row['country'].'</td>';
        echo '<td>'.$row['city'].'</td>';
        echo '<td>'.$row['street_name'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['street_number'].'</td>';
        echo '<td>'.$row['region'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['zip_code'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['status'].'</td>';
        echo '<td class="cell-center cell-small">
                <input type="checkbox">
            </td>';
        echo '<td class="cell-center cell-small"><button type="button" class="button-round-filled" onclick="toggleEditLocationPopUp('.$row['country'].', '.$row['city'].', '.$row['street_name'].', '.$row['street_number'].', '.$row['region'].', '.$row['zip_code'].')">Edit</button></td>';
        echo '</tr>';
    }
    */
}


/**
 * Generate account table rows
 */
function generateAccountRows()
{
    // TEST CODE
    ?>

    <tr>
        <td class="cell-center cell-small">1</td>
        <td>JD</td>
        <td>Joe</td>
        <td>Doe</td>
        <td>joe.doe@mail.com</td>
        <td class="cell-center cell-small">User</td>
        <td class="cell-center cell-small">Enable</td>
        <td><input type="checkbox"></td>
        <td class="cell-center cell-small">
            <button type="button" class="button-round-filled" onclick="toggleEditProfilePopUp('JD', 'Joe', 'Doe', 'joe.doe@mail.com', 'user')">Edit</button>
        </td>
    </tr>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $accounts = getAccounts();
    
    while($row = $accounts->fetch_assoc())
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$row['id'].'</td>';
        echo '<td>'.$row['nick'].'</td>';
        echo '<td>'.$row['first_name'].'</td>';
        echo '<td>'.$row['last_name'].'</td>';
        echo '<td>'.$row['email'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['role'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['status'].'</td>';
        echo '<td class="cell-center cell-small">
                <input type="checkbox">
            </td>';
        echo '<td class="cell-center cell-small"><button type="button" class="button-round-filled" onclick="toggleEditProfilePopUp('.$row['nick'].', '.$row['first_name'].', '.$row['last_name'].', '.$row['email'].', '.$row['role'].')">Edit</button></td>';
        echo '</tr>';
    }
    */
}


/**
 * Generate event table rows
 */
function generateEventRows()
{
    // TEST CODE
    ?>

    <tr>
        <td class="cell-center cell-small">1</td>
        <td>MS hokej</td>
        <td>SZĽH</td>
        <td class="cell-center cell-small">15.04.2024</td>
        <td class="cell-center cell-small">12.05.2024</td>
        <td class="cell-large">Bratislava, Košice</td>
        <td class="cell-center cell-small">4/5<i class="fa-regular fa-star"></i></td>
        <td class="cell-center cell-small">Enable</td>
        <td class="cell-center cell-small"><input type="checkbox"></td>
        <td class="cell-center cell-small">
            <!-- link to event edit page -->
            <a href="#" class="button-round-filled">Edit</a>
        </td>
    </tr>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $events = getEvents();

    while($row = $events->fetch_assoc())
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$row['id'].'</td>';
        echo '<td>'.$row['event_name'].'</td>';
        echo '<td>'.$row['author'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['date_from'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['date_to'].'</td>';
        // multiple locations !!! replace by some string of locations separated with comma
        echo '<td class="cell-large">'.$row['location'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['rating'].'/5<i class="fa-regular fa-star"></i></td>';
        echo '<td class="cell-center cell-small">'.$row['status'].'</td>';
        echo '<td class="cell-center cell-small">
                <input type="checkbox">
            </td>';
        // link to event edit page
        echo '<td class="cell-center cell-small"><a href="#" class="button-round-filled">Edit</a></td>';
        echo '</tr>';
    }
    */
}



function generateTicketOrdersRows()
{
    // TEST CODE
    ?>

    <tr>
        <td class="cell-center cell-small">1</td>
        <td>JD</td>
        <td>Joe</td>
        <td>Doe</td>
        <td>joe.doe@mail.com</td>
        <td>Prague</td>
        <td>VIP</td>
        <td class="cell-center cell-small">2</td>
        <td><input type="checkbox"></td>
    </tr>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $tickets = getTicketOrders();

    while($row = $tickets->fetch_assoc())
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$row['id'].'</td>';
        echo '<td>'.$row['buyer_nick'].'</td>';
        echo '<td>'.$row['buyer_first_name'].'</td>';
        echo '<td>'.$row['buyer_last_name'].'</td>';
        echo '<td>'.$row['buyer_email'].'</td>';
        echo '<td>'.$row['location'].'</td>';
        echo '<td>'.$row['ticket_type'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['ticket_count'].'</td>';
        echo '<td class="cell-center cell-small">
                <input type="checkbox">
            </td>';
        echo '</tr>';
    }
    */
}



function generateTicketRows()
{
    // TEST CODE
    ?>

    <tr>
        <td class="cell-center cell-small">1</td>
        <td>JD</td>
        <td>Joe</td>
        <td>Doe</td>
        <td>joe.doe@mail.com</td>
        <td>Prague</td>
        <td>Family</td>
        <td class="cell-center cell-small">2</td>
        <td><input type="checkbox"></td>
    </tr>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $tickets = getTickets();

    while($row = $tickets->fetch_assoc())
    {
        echo '<tr>';
        echo '<td class="cell-center cell-small">'.$row['id'].'</td>';
        echo '<td>'.$row['buyer_nick'].'</td>';
        echo '<td>'.$row['buyer_first_name'].'</td>';
        echo '<td>'.$row['buyer_last_name'].'</td>';
        echo '<td>'.$row['buyer_email'].'</td>';
        echo '<td>'.$row['location'].'</td>';
        echo '<td>'.$row['ticket_type'].'</td>';
        echo '<td class="cell-center cell-small">'.$row['ticket_count'].'</td>';
        echo '<td class="cell-center cell-small">
                <input type="checkbox">
            </td>';
        echo '</tr>';
    }
    */
}


function makeEditEventForm($eventID)
{
    // TEST CODE
    ?>

    <div class="form-block">
        <span>
            <label for="e-name">What is name for your event ?</label>
            <input type="text" id="e-name" placeholder="Event name">
        </span>
    </div>
    <div class="form-block">
        <span>
            <label for="e-description">Write description of yor event</label>
            <textarea name="" id="e-description" cols="30" rows="10" placeholder="Description..."></textarea>
        </span>
    </div>
    <div class="form-block">
        <span>
            <label for="e-icon">Choose front image for your event</label>
            <input type="file" name="e-icon">
        </span>
        <span>
            <label for="e-images">Choose gallery images for your event</label>
            <input type="file" name="e-images[]" multiple>
        </span>
    </div>
    <div class="form-block">
        <span>
            <label for="category-select">Select category for your event</label>
            <select name="category-select" id="category-select">
                <?php generateCategorySelecetOptions() ?>
            </select>
        </span>
    </div>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $eventInfo = getEventInfo($eventID);
    $eventPhotos = getEventPhotos($eventID);

    ?>
    <div class="form-block">
        <span>
            <label for="e-name">What is name for your event ?</label>
            <input type="text" id="e-name" value="<?php $eventInfo['event_name'] ?>" placeholder="Event name">
        </span>
    </div>
    <div class="form-block">
        <span>
            <label for="e-description">Write description of yor event</label>
            <textarea name="" id="e-description" cols="30" rows="10" placeholder="Description..."><?php $eventInfo['description'] ?></textarea>
        </span>
    </div>
    <div class="form-block">
        <span>
            <label for="e-icon">Choose front image for your event</label>
            <input type="file" value="<?php $eventInfo['icon_src'] ?>" name="e-icon">
        </span>
        <span>
            <label for="e-images">Choose gallery images for your event</label>
            <input type="file" name="e-images[]" value="<?php $eventPhotos ?>" multiple>
        </span>
    </div>
    <div class="form-block">
        <span>
            <label for="category-select">Select category for your event</label>
            <select name="category-select" id="category-select" value="<?php $eventInfo['category'] ?>">
                <?php generateCategorySelecetOptions() ?>
            </select>
        </span>
    </div>
    <?php
    */
}


function generateEditEventVariants($eventID)
{
    // TEST CODE
    ?>

    <div class="ticket" id="event-variant-1">
        <div class="form-block ticket-create">
            <button type="button" class="button-round-filled" onclick="removeEventVariant(1)"><i class="fa-solid fa-trash"></i></button>
            <div class="ticket-form-inputs">
                <div class="filter-date">
                    <label for="e-date-from">Date from:</label>
                    <input type="date" id="e-date-from">
                </div>
                <div class="filter-date">
                    <label for="e-date-to">Date to:</label>
                    <input type="date" id="e-date-to">
                </div>
                <div class="filter-date">
                    <label for="e-time-from">Time from:</label>
                    <input type="time" id="e-time-from">
                </div>
                <div class="filter-date">
                    <label for="e-time-to">Time to:</label>
                    <input type="time" id="e-time-to">
                </div>
                <span>
                    <label for="location-select">Select location</label>
                    <select name="location-select" id="location-select">
                        <?php generateLocationSelecetOptions() ?>
                    </select>
                </span>
            </div>
            <button type="button" ticket-arrow-button="ticket-1" class="arrow-button" onclick="toggleTicketDetail('ticket-1')">▼</button>
        </div>
        <div class="ticket-types" id="ticket-1">
            <table id="variant-types-1">
                <tr>
                    <td>Ticket type</td>
                    <td class="row-15">Ticket cost in $</td>
                    <td class="row-15">Number of tickets</td>
                    <td class="row-10"><button type="button" class="button-round-filled" onclick="addTicketType(1)"><i class="fa-solid fa-plus"></i></button></td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="" id="ticket-type" placeholder="Ticket type name">
                    </td>
                    <td class="row-15">
                        <input type="number" name="" id="ticket-cost" placeholder="Cost" oninput="checkNegativeInput(this)">
                    </td>
                    <td class="row-15">
                        <input type="number" name="" id="ticket-cnt" placeholder="Num." oninput="checkNegativeInput(this)">
                    </td>
                    <td class="row-10"><button type="button" class="button-round-filled" onclick="removeTicketType(this)"><i class="fa-solid fa-trash"></i></button></td>
                </tr>
            </table>
        </div>
    </div>

    <?php
    // END OF TEST CODE

    /*
    // db query
    $eventVariants = getEventInstances($eventID);
    $cnt = 1;

    while ($row = $eventVariants->fetch_assoc())
    {
        ?>
        <div class="ticket" id="event-variant-<?php $cnt ?>">
            <div class="form-block ticket-create">
                <button type="button" class="button-round-filled" onclick="removeEventVariant(<?php $cnt ?>)"><i class="fa-solid fa-trash"></i></button>
                <div class="ticket-form-inputs">
                    <div class="filter-date">
                        <label for="e-date-from">Date from:</label>
                        <input type="date" id="e-date-from" value="<?php $row['date_from'] ?>">
                    </div>
                    <div class="filter-date">
                        <label for="e-date-to">Date to:</label>
                        <input type="date" id="e-date-to" value="<?php $row['date_to'] ?>">
                    </div>
                    <div class="filter-date">
                        <label for="e-time-from">Time from:</label>
                        <input type="time" id="e-time-from" value="<?php $row['time_from'] ?>">
                    </div>
                    <div class="filter-date">
                        <label for="e-time-to">Time to:</label>
                        <input type="time" id="e-time-to" value="<?php $row['time_to'] ?>">
                    </div>
                    <span>
                        <label for="location-select">Select location</label>
                        <select name="location-select" id="location-select" value="<?php $row['location_id'] ?>">
                            <?php generateLocationSelecetOptions() ?>
                        </select>
                    </span>
                </div>
                <button type="button" ticket-arrow-button="ticket-1" class="arrow-button" onclick="toggleTicketDetail('ticket-<?php $cnt ?>')">▼</button>
            </div>
            <div class="ticket-types" id="ticket-<?php $cnt ?>">
                <table id="variant-types-<?php $cnt ?>">
                    <tr>
                        <td>Ticket type</td>
                        <td class="row-15">Ticket cost in $</td>
                        <td class="row-15">Number of tickets</td>
                        <td class="row-10"><button type="button" class="button-round-filled" onclick="addTicketType(<?php $cnt ?>)"><i class="fa-solid fa-plus"></i></button></td>
                    </tr>
                    <?php
                    // db query
                    $eventTicketTypes = getEventInstanceFees($eventID, $eventVariants['location']);

                    while ($type = $eventTicketTypes->fetch_assoc())
                    {
                        ?>
                        <tr>
                            <td>
                                <input type="text" name="" id="ticket-type" value="<?php $type['fee_name'] ?>" placeholder="Ticket type name">
                            </td>
                            <td class="row-15">
                                <input type="number" name="" id="ticket-cost" value="<?php $type['cost'] ?>" placeholder="Cost" oninput="checkNegativeInput(this)">
                            </td>
                            <td class="row-15">
                                <input type="number" name="" id="ticket-cnt" value="<?php $type['max_tickets'] ?>" placeholder="Num." oninput="checkNegativeInput(this)">
                            </td>
                            <td class="row-10"><button type="button" class="button-round-filled" onclick="removeTicketType(this)"><i class="fa-solid fa-trash"></i></button></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
    }
    */
}