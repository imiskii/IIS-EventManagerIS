<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */

require_once "common/html-components.php";

session_start();
if(!userIsModerator()) {
    redirectForce('index.php');
}

updateSessionReturnPage();
$db = connect_to_db();
generateSessionToken();
updateSession($_GET, ["categories", "locations", "min_rating", "max_rating", "date_from", "date_to", "events_search_bar", "search_bar", 'event_id', 'event_status', 'nick'] );

makeHead("Eventer | Event Management");
makeHeader();

?>

<main>
    <!-- MAIN -->
    <div class="event-create-main-container manage-container">
        <!-- Accounts -->
        <div class="part-lable">
            <h2>Events</h2>
        </div>
        <div class="row-block">
            <div class="manage-filters">
                <form method="get" action="<?php echoCurrentPage(); ?>">
                    <span>
                        <label for="search_bar">Search Event</label>
                        <input type="text" id="search_bar" name='search_bar' value="<?php echoSessionVal('search_bar', "") ?>" placeholder="ID, Event name..">
                    </span>
                    <span>
                        <label for="event_status">Event status</label>
                        <?php generateStatusSelectOptions('event_status', 'event_status', true) ?>
                    </span>
                    <div class="filter-bar">
                        <ul>
                            <li>
                                <a href="#">Categories</a>
                                <div class="filter-opt">
                                    <ul class="category-tree">
                                        <?php generateCategoryTree(); ?>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#">Locations</a>
                                <div class="filter-opt">
                                    <ul>
                                        <?php generateLocations(); ?>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#">Rating</a>
                                <div class="filter-opt">
                                    <ul>
                                        <li>
                                            <div class="rating-input">
                                                <label for="min_rating">Min rating</label>
                                                <input type="number" id="min_rating" name="min_rating" pattern="[0-5]" value="<?php echoSessionVal('min_rating', 0) ?>" oninput="checkRatingFilterInput()">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="rating-input">
                                                <label for="max_rating">Max rating</label>
                                                <input type="number" id="max_rating" name="max_rating" pattern="[0-5]" value="<?php echoSessionVal('max_rating', 5) ?>" oninput="checkRatingFilterInput()">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="filter-date">
                                    <label for="date_from">Date from:</label>
                                    <input type="date" id="date_from" name="date_from" value="<?php echoSessionVal('date_from', "") ?>">
                                </div>
                            </li>
                            <li>
                                <div class="filter-date">
                                    <label for="date_to">Date to:</label>
                                    <input type="date" id="date_to" name="date_to" value="<?php echoSessionVal('date_to', "") ?>">
                                </div>
                            </li>
                        </ul>
                    </div>
                    <button class="button-round-filled-green">Submit filters</button>
                </form>
            </div>
        </div>
        <form action="scripts/event-manage/bulk-manage-events.php" method="post">
        <input type="hidden" name="token" value="<?php echoSessionVal('token', ''); ?>">
            <div class="manage-tool-bar">
                <button name='change_status' value='change_status' class="button-round-filled">Change status</button>
                <a href="event-create.php" class="button-round-filled">Add Event</a>
                <button name='delete' value='delete' class="button-round-filled">Delete</button>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Event Owner</th>
                    <th>Date from</th>
                    <th>Date to</th>
                    <th>Location</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th><i class="fa-solid fa-check"></i></th>
                </tr>
                <?php generateEventRows() ?>
            </table>
        </form>
    </div>
</main>

<?php

makeFooter();

?>

</html>
