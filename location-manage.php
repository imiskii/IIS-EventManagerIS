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
generateSessionToken();
updateSession($_GET, ['search-bar', 'address_status']);
$db = connect_to_db();

makeHead("Eventer | Location Management");
makeHeader();

?>

<main>
    <!-- Create new Location popup -->
    <div class="profile-popup" id="add-location-popup">
        <div class="profile-popup-top-bar">
            <h3>Create new Location</h3>
            <span class="close-edit-btn" id="close-location-popup-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="scripts/location-manage/create-location.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <span>
                <div class="label-input">
                    <p>Country *</p>
                    <input type="text" name="country" required id="country" placeholder="Country">
                </div>
                <div class="label-input">
                    <p>City/Town *</p>
                    <input type="text" id="city" required name="city" placeholder="City name/Town name">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>Street name *</p>
                    <input type="text" id="s_name" required name="street" placeholder="Street name">
                </div>
                <div class="label-input">
                    <p>Street number *</p>
                    <input type="number" id="s_num" required name="street_number" placeholder="Street number" onclick="checkNegativeInput()">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>State/Province/Region</p>
                    <input type="text" id="region" name="state" placeholder="State/Province/Region">
                </div>
                <div class="label-input">
                    <p>ZIP code</p>
                    <input type="text" id="zip" name="zip" placeholder="ZIP code" oninput="checkNegativeInput(this)">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>Status</p>
                    <?php generateStatusSelectOptions('address_status', 'E-status', false) ?>
                </div>
            </span>
            <div class="label-input">
                <p>Description</p>
                <textarea name="address_description" id="E-desc" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="button-round-filled-green">Submit Location</button>
        </form>
    </div>
    <!-- Edit Location popup -->
    <div class="profile-popup" id="edit-location-popup">
        <div class="profile-popup-top-bar">
            <h3>Edit Location</h3>
            <span class="close-edit-btn" id="E-close-location-popup-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="scripts/location-manage/edit-location.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
        <input type="hidden" id="E-id" name="address_id">
            <span>
                <div class="label-input">
                    <p>Country *</p>
                    <input type="text" name="country" required id="E-country" placeholder="Country">
                </div>
                <div class="label-input">
                    <p>City/Town *</p>
                    <input type="text" name="city" required id="E-city" placeholder="City name/Town name">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>Street name *</p>
                    <input type="text" name="street" required id="E-s_name" placeholder="Street name">
                </div>
                <div class="label-input">
                    <p>Street number *</p>
                    <input type="number" id="E-s_num" required name="street_number" placeholder="Street number" onclick="checkNegativeInput()">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>State/Province/Region</p>
                    <input type="text" id="E-region" name="state" placeholder="State/Province/Region">
                </div>
                <div class="label-input">
                    <p>ZIP code</p>
                    <input type="text" id="E-zip" name="zip" placeholder="ZIP code" oninput="checkNegativeInput(this)">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <?php generateStatusSelectOptions('address_status', 'edit-loc-status', false) ?>
                </div>
            </span>
            <div class="label-input">
                <p>Description</p>
                <textarea id="edit-loc-desc" name="address_description" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="button-round-filled-green">Submit</button>
        </form>
    </div>
    <!-- MAIN -->
    <div class="event-create-main-container manage-container">
        <!-- Proposals -->
        <div class="part-lable">
            <h2>Location proposals</h2>
        </div>
        <form action="scripts/location-manage/bulk-manage-location-proposals.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <div class="manage-tool-bar">
                <button name="accept" value="accept" class="button-round-filled">Accept proposal</button>
                <button name="accept" value="reject" class="button-round-filled">Reject proposal</button>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Author</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Street name</th>
                    <th>Street number</th>
                    <th>State/Province/Region</th>
                    <th>ZIP code</th>
                    <th><i class="fa-solid fa-check"></i></th>
                </tr>
                <?php generateLocationProposalRows() ?>
            </table>
        </form>
        <!-- Locations -->
        <div class="part-lable">
            <h2>All Locations</h2>
        </div>
        <div class="row-block">
            <div class="manage-filters">
                <form action="<?php echoCurrentPage() ?>">
                    <span>
                        <label for="search-bar">Search Location</label>
                        <input type="text" name="search-bar" id="search-bar" value="<?php echoSessionVal('search-bar', '') ?>" placeholder="Location, City, Street, ZIP code...">
                    </span>
                    <span>
                        <label for="address_status">Location status</label>
                        <?php generateStatusSelectOptions('address_status', 'address_status', true) ?>
                    </span>
                    <button class="button-round-filled-green">Submit filters</button>
                </form>
            </div>
        </div>
        <form action="scripts/location-manage/bulk-manage-locations.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <div class="manage-tool-bar">
                <button name="change_status" value="change_status" class="button-round-filled">Change status</button>
                <button type="button" class="button-round-filled" onclick="toggleAddLocationPopUp()">Add Location</button>
                <button name="delete" value="delete" class="button-round-filled">Delete</button>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Street name</th>
                    <th>Street number</th>
                    <th>State/Province/Region</th>
                    <th>ZIP code</th>
                    <th>Status</th>
                    <th><i class="fa-solid fa-check"></i></th>
                    <th>Action</th>
                </tr>
                <?php generateLocationRows() ?>
            </table>
        </form>
    </div>
</main>

<?php

makeFooter();

?>

</html>
