<?php
/**
 * @file profile.php
 * @brief page with profile information, tickets and events
 * @author Michal Ľaš (xlasmi00)
 * @date 06.10.2023
 */


require "components/html-components.php";

makeHead("Eventer | Profile");
makeHeader();

?>

<main class="profile-main-container">
    <!-- Edit profile PopUp -->
    <div class="profile-popup" id="profile-edit-popup">
        <div class="profile-popup-top-bar">
            <h3>Edit Profile</h3>
            <span class="close-edit-btn" id="close-edit-profile-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="">
            <div class="label-input">
                <p>Nick</p>
                <input type="text" id="nick">
            </div>
            <span>
                <div class="label-input">
                    <p>First name</p>
                    <input type="text" id="fname">
                </div>
                <div class="label-input">
                    <p>Last name</p>
                    <input type="text" id="lname">
                </div>
            </span>
            <div class="label-input">
                <p>Email</p>
                <input type="text" id="email">
            </div>
            <?php makeRoleSelector() ?>
            <button type="submit" class="button-round-filled-green">Submit Edit</button>
        </form>
    </div>
    <!-- Change password PopUp -->
    <div class="profile-popup" id="profile-password-popup">
        <div class="profile-popup-top-bar">
            <h3>Change password</h3>
            <span class="close-edit-btn" id="close-password-profile-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="">
            <div class="label-input">
                <p>Old password</p>
                <input type="password">
            </div>
            <span>
                <div class="label-input">
                    <p>New password</p>
                    <input type="password">
                </div>
                <div class="label-input">
                    <p>Repeat password</p>
                    <input type="password">
                </div>
            </span>
            <button type="submit" class="button-round-filled-green">Submit Edit</button>
        </form>
    </div>
    <!-- Prfole Info -->
    <div class="info-container">
        <!-- Replace null with profileID !!! -->
        <?php makeProfileInfo(null) ?>
    </div>
    <!-- Profile tickets -->
    <div class="part-lable">
        <h2>My Tickets</h2>
    </div>
    <div class="ticket">
        <!-- Replace null with profileID !!! -->
        <?php generateProfileTickets(null) ?>
    </div>
    <!-- Profile events -->
    <div class="part-lable">
        <h2>My Events</h2>
        <a href="#" class="button-round-filled">Create New Event</a>
    </div>
    <div class="profile-events">
        <div class="card-container">
        <?php
            /* generateEventCards(getEventCardsByUser($userID), "owner"); */
            $fill = array("a" => "bar", "b" => "foo"); // tmp code
            generateEventCards($fill, "owner");
        ?>
        </div>
    </div>
</main>

<?php

makeFooter();

?>

