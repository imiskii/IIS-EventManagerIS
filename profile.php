<?php
/**
 * @file profile.php
 * @brief page with profile information, tickets and events
 * @author Michal Ľaš (xlasmi00)
 * @date 06.10.2023
 */

require_once "config/common.php";
require "src/front-end/components/html-components.php";

session_start();
$db = connect_to_db();

makeHead("Eventer | Profile");
makeHeader();

if (!idMatchesUser()) {
    // unauthorized access gets redirected to home page
    redirectForce('index.php');
}

$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
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
    <!-- Profile Info -->
    <div class="info-container">
        <?php makeProfileInfo(getUserAttribute()) ?>
    </div>
    <!-- Profile tickets -->
    <div class="part-lable">
        <h2>My Tickets</h2>
    </div>
    <div class="ticket">
        <?php generateProfileTickets(getUserAttribute()) ?>
    </div>
    <!-- Profile events -->
    <div class="part-lable">
        <h2>My Events</h2>
        <a href="event-create.php" class="button-round-filled">Create New Event</a>
    </div>
    <div class="profile-events">
        <div class="card-container">
        <?php generateEventCards("owner", getUserAttribute()); ?>
        </div>
    </div>
</main>

<?php

makeFooter();

?>
