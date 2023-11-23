<?php
require 'config/common.php';
require "src/front-end/components/html-components.php";

session_start();
$db = connect_to_db();

updateSession(["categories", "locations", "min_rating", "max_rating", "date_from", "date_to", "search"] );
makeHead("Eventer");
makeHeader();

?>

<main>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="filter-bar">
            <ul>
                <li>
                    <a href="#">Categories</a>
                    <div class="filter-opt">
                        <ul class="category-tree">
                            <script src="src/front-end/js/updateChildCheckboxes.js"></script>
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
                                    <input type="number" id="min-r" pattern="[0-5]" <?php getSessionVal("min_rating", null, 0) ?> oninput="checkRatingFilterInput()" name="min_rating">
                                </div>
                            </li>
                            <li>
                                <div class="rating-input">
                                    <label for="max-r">Max rating</label>
                                    <input type="number" id="max-r" pattern="[0-5]" <?php getSessionVal("max_rating", null, 5) ?> oninput="console.log('function called')" name="max_rating">
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="filter-date">
                        <label for="date-from-input">Date from:</label>
                        <input type="date" id="date-from-input" <?php getSessionVal("date_from") ?>  name="date_from">
                    </div>
                </li>
                <li>
                    <div class="filter-date">
                        <label for="date-to-input">Date to:</label>
                        <input type="date" id="date-to-input" <?php getSessionVal("date_to"); ?> name="date_to">
                    </div>
                </li>
                <li>
                    <div class="submit-button">
                        <button class="button-round-filled-green" type="submit">Submit filters</button>
                    </div>
                </li>
            </ul>
        </div>
    </form>


    <?php
        generateEventCards();
    ?>
</main>

<?php

makeFooter();

?>
