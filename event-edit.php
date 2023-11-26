<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */


require_once "common/html-components.php";

session_start();

if (!userIsModerator() || is_null($event_id = $_GET['event_id'] ?? null)) {
    redirectForce('index.php');
}

updateSessionReturnPage();
$db = connect_to_db();

makeHead("Eventer | Edit Event");
makeHeader();

?>

<main>
    <!-- Category popup -->
    <div class="profile-popup" id="add-category-popup">
        <div class="profile-popup-top-bar">
            <h3>Propose new Category</h3>
            <span class="close-edit-btn" id="close-category-popup-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="">
            <div class="label-input">
                <p>Name of new Category</p>
                <input type="text" id="category-name" placeholder="Category name">
            </div>
            <div class="label-input">
                <p>Additional note</p>
                <textarea name="" id="" cols="30" rows="10" placeholder="Why you propose this category..."></textarea>
            </div>
            <button type="submit" class="button-round-filled-green">Submit Category</button>
        </form>
    </div>
    <!-- Location popup -->
    <div class="profile-popup" id="add-location-popup">
        <div class="profile-popup-top-bar">
            <h3>Propose new Location</h3>
            <span class="close-edit-btn" id="close-location-popup-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="">
            <span>
                <div class="label-input">
                    <p>Country</p>
                    <input type="text" id="country" placeholder="Country">
                </div>
                <div class="label-input">
                    <p>City/Town</p>
                    <input type="text" id="city" placeholder="City name/Town name">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>Street name</p>
                    <input type="text" id="country" placeholder="Street name">
                </div>
                <div class="label-input">
                    <p>Street number</p>
                    <input type="number" id="city" placeholder="Street number" onclick="checkNegativeInput()">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>State/Province/Region</p>
                    <input type="text" id="country" placeholder="State/Province/Region">
                </div>
                <div class="label-input">
                    <p>ZIP code</p>
                    <input type="text" id="city" placeholder="ZIP code" oninput="checkNegativeInput(this)">
                </div>
            </span>
            <div class="label-input">
                <p>Additional description</p>
                <textarea name="" id="" cols="30" rows="10" placeholder="Why you propose this category..."></textarea>
            </div>
            <button type="submit" class="button-round-filled-green">Submit Location</button>
        </form>
    </div>
    <!-- MAIN -->
    <div class="event-create-main-container">
        <form action="scripts/edit-event.php" method='post'>
        <input type="hidden" name="token" value="<?php echoSessionVal('token', ''); ?>">
            <?php makeEditEventForm($event_id) ?>
            <!-- Ticket section -->
            <div class="part-lable">
                <h2>Edit event instances</h2>
            </div>
            <div class="form-block">
                <button type="button" class="button-round-filled" onclick="addEventVariant()">Add ticket variant</button>
                <button type="button" class="button-round-filled" onclick="toggleAddCategoryPopUp()">Propose new category</button>
                <button type="button" class="button-round-filled" onclick="toggleAddLocationPopUp()">Propose new location</button>
            </div>
            <div class="tickets-container" id="tickets-variants">
                <?php generateEditEventVariants($event_id) ?>
            </div>
            <div class="form-block">
                <button type="submit" class="button-round-filled-green">Edit this event</button>
            </div>
        </form>
    </div>
</main>

<?php

makeFooter();

?>

</html>
