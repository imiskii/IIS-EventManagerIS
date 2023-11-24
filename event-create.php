<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */


require_once "config/common.php";
require "src/front-end/components/html-components.php";

session_start();
$db = connect_to_db();

if(!userIsLoggedIn()) {
    redirectForce('index.php');
}

makeHead("Eventer | Create Event");
makeHeader();

$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];

?>

<main>
    <!-- Category popup -->
    <div class="profile-popup" id="add-category-popup">
        <div class="profile-popup-top-bar">
            <h3>Propose new Category</h3>
            <span class="close-edit-btn" id="close-category-popup-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form name="suggest-category" action="scripts/suggest-category.php" method="get">
            <div class="label-input">
                <p>Name of new Category</p>
                <input type="text" id="category_name" name="category_name" <?php echoSessionVal('suggest-category_category_name') ?> placeholder="Category name">
            </div>
            <div class="label-input">
                <p>Additional note</p>
                <textarea name="category_description" id="category_description" cols="30" rows="10" <?php echoSessionVal('suggest-category_category_name') ?> placeholder="Why you propose this category..."></textarea>
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
        <form name="suggest-location" action="init.php/Address" method='post'>
            <span>
                <div class="label-input">
                    <p>Country</p>
                    <input type="text" id="country" required name='country' placeholder="Country" <?php echoSessionVal('suggest-location_country') ?> >
                </div>
                <div class="label-input">
                    <p>City/Town</p>
                    <input type="text" id="city" required name='city'placeholder="City name/Town name" <?php echoSessionVal('suggest-location_city') ?> >
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>Street name</p>
                    <input type="text" id="street" name="street" required placeholder="Street name" <?php echoSessionVal('suggest-location_street') ?> >
                </div>
                <div class="label-input">
                    <p>Street number</p>
                    <input type="number" id="street_number" required  name="street_number" <?php echoSessionVal('suggest-location_street_number') ?> placeholder="Street number" onclick="checkNegativeInput()">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>State/Province/Region</p>
                    <input type="text" id="state" name="state" placeholder="State/Province/Region" <?php echoSessionVal('suggest-location_state') ?>>
                </div>
                <div class="label-input">
                    <p>ZIP code</p>
                    <input type="text" id="zip" name='zip' placeholder="ZIP code" <?php echoSessionVal('suggest-location_zip') ?> oninput="checkNegativeInput(this)">
                </div>
            </span>
            <div class="label-input">
                <p>Additional description</p>
                <!-- FIXME value not retrieved -->
                <textarea name="address_description" id="address_description" <?php echoSessionVal('suggest-location_address_description') ?> cols="30" rows="10" placeholder="Why do you propose this location..."></textarea>
            </div>
            <button type="submit" class="button-round-filled-green">Submit Location</button>
        </form>
    </div>
    <!-- MAIN -->
    <div class="event-create-main-container">
        <form action="scripts/suggest-event.php" method="post" enctype="multipart/form-data">
            <div class="form-block">
                <span>
                    <label for="event_name">What is name for your event ?</label>
                    <input type="text" name="event_name" id="event_name" placeholder="Event name">
                </span>
            </div>
            <div class="form-block">
                <span>
                    <label for="event_description">Write description of yor event</label>
                    <textarea name="" id="event_description" cols="30" rows="10" placeholder="Description..."></textarea>
                </span>
            </div>
            <div class="form-block">
                <span>
                    <label for="event_icon">Choose front image for your event</label>
                    <input type="file" name="event_icon">
                </span>
                <span>
                    <label for="event_images">Choose gallery images for your event</label>
                    <input type="file" name="event_images[]" multiple>
                </span>
            </div>
            <div class="form-block">
                <span>
                    <label for="category-select">Select category for your event</label>
                    <select name="category-select" id="category-select">
                        <?php generateCategorySelectOptions() ?>
                    </select>
                </span>
            </div>
            <!-- Ticket section -->
            <div class="part-lable">
                <h2>Create Tickets</h2>
            </div>
            <div class="form-block">
                <button type="button" class="button-round-filled" onclick="addEventVariant()">Add ticket variant</button>
                <button type="button" class="button-round-filled" onclick="toggleAddCategoryPopUp()">Propose new category</button>
                <button type="button" class="button-round-filled" onclick="toggleAddLocationPopUp()">Propose new location</button>
            </div>
            <div class="tickets-container" id="tickets-variants">
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
                                    <?php generateLocationSelectOptions() ?>
                                </select>
                            </span>
                        </div>
                        <button type="button" ticket-arrow-button="ticket-1" class="arrow-button" onclick="toggleTicketDetail('ticket-1')">▼</button>
                    </div>
                    <div class="ticket-types" id="ticket-1">
                        <table id="variant-types-1">
                            <tr>
                                <td>Ticket type</td>
                                <td class="row-15">Ticket cost in czk</td>
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
            </div>
            <div class="form-block">
                <button type="submit" class="button-round-filled-green">Create this event</button>
            </div>
        </form>
    </div>
</main>

<?php

makeFooter();

?>

</html>
