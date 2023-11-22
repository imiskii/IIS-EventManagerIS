<?php
require 'config/common.php';

session_start();
$db = connect_to_db(); // connect to database -> returns pdo that allows us to work with the db

require "src/front-end/components/html-components.php";

makeHead("Eventer");
makeHeader();

?>

<main>
    <div class="filter-bar">
        <ul>
            <li>
                <a href="#">Categories</a>
                <div class="filter-opt">
                    <ul class="category-tree">
                        <?php
                        generateCategoryTree();
                        ?>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#">Locations</a>
                <div class="filter-opt">
                    <ul>
                        <?php   
                        generateLocations();
                        ?>

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
            <li>
                <div class="submit-button">
                    <button class="button-round-filled-green" type="submit">Submit filters</button>
                </div>
            </li>
        </ul>
    </div>

    <h2>Today</h2>
    <div class="card-container">

        <?php
            /* generateEventCards(getEventsByDate(date)); */
            $fill = array("a" => "bar", "b" => "foo"); // tmp code
            generateEventCards($fill);
        ?>

    </div>

    <h2>This Week</h2>
    <div class="card-container">

        <?php
            /* generateEventCards(getEventsByDate(date)); */
            generateEventCards($fill);
        ?>

    </div>

    <h2>This Month</h2>
    <div class="card-container">

        <?php
            /* generateEventCards(getEventsByDate(date)); */
            generateEventCards($fill);
        ?>

    </div>
</main>

<?php

makeFooter();

?>
