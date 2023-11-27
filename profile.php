<?php
/**
 * @file profile.php
 * @brief page with profile information, tickets and events
 * @author Michal Ľaš (xlasmi00)
 * @date 06.10.2023
 */

require_once "common/html-components.php";

session_start();

if (!urlIdMatchesUser()) {
    // unauthorized access gets redirected to home page
    redirectForce('index.php');
}

generateSessionToken();
updateSessionReturnPage();
$db = connect_to_db();

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
        <form action="scripts/account-manage/edit-account.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
        <input type="hidden" id="edit-acc-id" name="account_id" value="<?php echoUserAttribute('account_id', '') ?>" >
            <div class="label-input">
                <p>Nick *</p>
                <input type="text" name="nick" required id="edit-acc-nick">
            </div>
            <span>
                <div class="label-input">
                    <p>First name *</p>
                    <input type="text" name="first_name" required id="edit-acc-fname">
                </div>
                <div class="label-input">
                    <p>Last name *</p>
                    <input type="text" name="last_name" required id="edit-acc-lname">
                </div>
            </span>
            <div class="label-input">
                <p>Email *</p>
                <input type="text" name="email" required id="edit-acc-email">
            </div>
            <?php makeRoleSelector('edit-acc'); ?>
            <button type="submit" class="button-round-filled-green">Submit Edit</button>
        </form>
    </div>
    <!-- Change password PopUp -->
    <div class="profile-popup" id="profile-password-popup">
        <div class="profile-popup-top-bar">
            <h3>Change password</h3>
            <span class="close-edit-btn" id="close-password-profile-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="scripts/profile/update-password.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <div class="label-input">
                <p>Old password *</p>
                <input  required type="password" name="old_password">
            </div>
            <span>
                <div class="label-input">
                    <p>New password *</p>
                    <input required type="password" name="password">
                </div>
                <div class="label-input">
                    <p>Repeat password *</p>
                    <input required type="password" name="password2">
                </div>
            </span>
            <button type="submit" class="button-round-filled-green">Submit Edit</button>
        </form>
    </div>
    <!-- Profile Info -->
    <div class="info-container">
        <?php makeProfileInfo(getUserAttribute('account_id')); ?>
    </div>
    <!-- Profile tickets -->
    <div class="part-lable">
        <h2>My Tickets</h2>
    </div>
    <div class="tickets-container">
        <?php generateProfileTickets(getUserAttribute('account_id')); ?>
    </div>
    <!-- Profile events -->
    <div class="part-lable">
        <h2>My Events</h2>
        <a href="event-create.php" class="button-round-filled">Create New Event</a>
    </div>
    <div class="profile-events">
        <div class="card-container">
        <?php generateEventCards("owner", getUserAttribute('account_id')); ?>
        </div>
    </div>
</main>

<?php

makeFooter();

?>
