<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */


require "components/html-components.php";

makeHead("Eventer | Location Management");
makeHeader();

?>

<main>
    <!-- Create new Location popup -->
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
                    <input type="text" id="s_name" placeholder="Street name">
                </div>
                <div class="label-input">
                    <p>Street number</p>
                    <input type="number" id="s_num" placeholder="Street number" onclick="checkNegativeInput()">
                </div>
            </span>
            <span>
                <div class="label-input">
                    <p>State/Province/Region</p>
                    <input type="text" id="region" placeholder="State/Province/Region">
                </div>
                <div class="label-input">
                    <p>ZIP code</p>
                    <input type="text" id="zip" placeholder="ZIP code" oninput="checkNegativeInput(this)">
                </div>
            </span>
            <button type="submit" class="button-round-filled-green">Submit Location</button>
        </form>
    </div>
    <!-- MAIN -->
    <div class="event-create-main-container manage-container">
        <!-- Proposals -->
        <div class="part-lable">
            <h2>Location proposals</h2>
        </div>
        <form action="">
            <div class="manage-tool-bar">
                <button class="button-round-filled">Accept proposal</button>
                <button class="button-round-filled">Reject proposal</button>
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
                <form action="">
                    <span>
                        <label for="search-bar">Search Location</label>
                        <input type="text" id="search-bar" placeholder="Location, City, Street, ZIP code...">
                    </span>
                    <span>
                        <label for="status">Location status</label>
                        <select name="" id="status">
                            <option value="all">All</option>
                            <option value="enable">Enable</option>
                            <option value="disable">Disable</option>
                        </select>
                    </span>
                    <button class="button-round-filled-green">Submit filters</button>
                </form>
            </div>
        </div>
        <form action="">
            <div class="manage-tool-bar">
                <button class="button-round-filled">Change status</button>
                <button type="button" class="button-round-filled" onclick="toggleAddLocationPopUp()">Add Location</button>
                <button class="button-round-filled">Delete</button>
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

