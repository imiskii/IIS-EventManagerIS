<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */


require "components/html-components.php";

makeHead("Eventer | Sign in");
makeHeader();

?>

<main>
    <div class="event-create-main-container">
        <form action="">
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
            <div class="form-block ticket-create">
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
            </div>
        </form>
    </div>
</main>

<?php

makeFooter();

?>

</html>

