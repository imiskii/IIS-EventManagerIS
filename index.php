<?php
/**
 * @file index.php
 * @brief index
 * @author Michal Ľaš (xlasmi00)
 * @date 05.10.2023
 */

require_once "common/html-components.php";

session_start();
updateSessionReturnPage();
$db = connect_to_db();

updateSession($_GET, ["categories", "locations", "min_rating", "max_rating", "date_from", "date_to", "events_search_bar"] );

makeHead("Eventer");
makeHeader();

?>

<main>
    <form method="get" action="<?php echoCurrentPage(); ?>">
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
                                    <input type="number" name="min_rating" id="min_rating" pattern="[0-5]" value="<?php echoSessionVal("min_rating", 0); ?>" oninput="checkRatingFilterInput()">
                                </div>
                            </li>
                            <li>
                                <div class="rating-input">
                                    <label for="max_rating">Max rating</label>
                                    <input type="number" name="max_rating" id="max_rating" pattern="[0-5]" value="<?php echoSessionVal("max_rating", 5); ?>" oninput="checkRatingFilterInput()">
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="filter-date">
                        <label for="date-from-input">Date from:</label>
                        <input type="date" id="date-from-input" value="<?php echoSessionVal("date_from", ""); ?>"  name="date_from">
                    </div>
                </li>
                <li>
                    <div class="filter-date">
                        <label for="date-to-input">Date to:</label>
                        <input type="date" id="date-to-input" value="<?php echoSessionVal("date_to", ""); ?>" name="date_to">
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
    generateEventCardsByDate();
    ?>
</main>

<?php
makeFooter();
?>
