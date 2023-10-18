<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */


require "components/html-components.php";

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
                <form action="">
                    <span>
                        <label for="search-bar">Search Event</label>
                        <input type="text" id="search-bar" placeholder="ID, Event name..">
                    </span>
                    <span>
                        <label for="status">Event status</label>
                        <select name="" id="acc-status">
                            <option value="all">All</option>
                            <option value="enable">Enable</option>
                            <option value="disable">Disable</option>
                        </select>
                    </span>
                    <div class="filter-bar">
                        <ul>
                            <li>
                                <a href="#">Categories</a>
                                <div class="filter-opt">
                                    <ul class="category-tree">
                                        <?php
                                        /* uncomment this after getParentCategories() function will be finished */
                                        /**** 
                                        generateCategoryTree();
                                        ****/
                                        ?>

                                        <!-- TEST CODE -->

                                        <li><input type="checkbox">Item 1</li>
                                        <li>
                                            <input type="checkbox">Item 2
                                            <ul class="category-tree">
                                                <li><input type="checkbox">item 2.1</li>
                                                <li><input type="checkbox">Item 2.2</li>
                                                <li><input type="checkbox">Item 2.3</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <input type="checkbox">Item 3
                                            <ul class="category-tree">
                                                <li>
                                                    <input type="checkbox">Item 3.1
                                                    <ul class="category-tree">
                                                        <li><input type="checkbox">Item 3.1.1</li>
                                                        <li><input type="checkbox">item 3.1.2</li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <input type="checkbox">Item 3.2
                                                    <ul class="category-tree">
                                                        <li><input type="checkbox">Item 3.2.1</li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <!-- END OF TEST CODE -->

                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#">Locations</a>
                                <div class="filter-opt">
                                    <ul>
                                        <?php
                                        /* location generator */
                                        /****
                                        generateLocations();    
                                        ****/
                                        ?>

                                        <!-- TEST CODE -->

                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>
                                        <li><input type="checkbox">Random location 123</li>

                                        <!-- END OF TEST CODE -->

                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#">Rating</a>
                                <div class="filter-opt">
                                    <ul>
                                        <li>
                                            <div class="rating-input">
                                                <label for="min-r">Min rating</label>
                                                <input type="number" id="min-r" pattern="[0-5]" value="0" oninput="checkRatingFilterInput()">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="rating-input">
                                                <label for="max-r">Max rating</label>
                                                <input type="number" id="max-r" pattern="[0-5]" value="5" oninput="checkRatingFilterInput()">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="filter-date">
                                    <label for="date-from-input">Date from:</label>
                                    <input type="date" id="date-from-input">
                                </div>
                            </li>
                            <li>
                                <div class="filter-date">
                                    <label for="date-from-input">Date to:</label>
                                    <input type="date" id="date-from-input">
                                </div>
                            </li>
                        </ul>
                    </div>
                    <button class="button-round-filled-green">Submit filters</button>
                </form>
            </div>
        </div>
        <form action="">
            <div class="manage-tool-bar">
                <button class="button-round-filled">Change status</button>
                <!-- link to event create page -->
                <a href="#" class="button-round-filled">Add Event</a>
                <button class="button-round-filled">Delete</button>
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
                    <th>Action</th>
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

