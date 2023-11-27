<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */

require_once "common/html-components.php";

session_start();
$db = connect_to_db();

if(!userIsAdmin()) {
    redirectForce('index.php');
}

generateSessionToken();
updateSessionReturnPage();
updateSession($_GET, ["search-bar", "account_status", 'account_type']);

makeHead("Eventer | Account Management");
makeHeader();

?>

<main>
    <!-- Create profile popup -->
    <div class="profile-popup" id="profile-add-popup">
        <div class="profile-popup-top-bar">
            <h3>Create Profile</h3>
            <span class="close-edit-btn" id="close-add-profile-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="scripts/account-manage/add-account.php" method="post">
        <input type="hidden" id="add-acc-token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <div class="label-input">
                <p>Nick *</p>
                <input required name="nick" type="text" id="add-acc-nick">
            </div>
            <span>
                <div class="label-input">
                    <p>First name *</p>
                    <input required name="first_name" type="text" id="add-acc-fname">
                </div>
                <div class="label-input">
                    <p>Last name *</p>
                    <input required name="last_name" type="text" id="add-acc-lname">
                </div>
            </span>
            <div class="label-input">
                <p>Email *</p>
                <input required name="email" type="text" id="add-acc-email">
            </div>
            <div class="label-input">
                <p>Type</p>
                <?php makeRoleSelector('add-acc') ?>
            </div>
            <span>
                <div class="label-input">
                    <p>Password *</p>
                    <input required type="password" name="password">
                </div>
                <div class="label-input">
                    <p>Repeat password *</p>
                    <input required type="password" name="password2">
                </div>
            </span>
            <button type="submit" class="button-round-filled-green">Submit</button>
        </form>
    </div>
    <!-- Edit profile popup -->
    <div class="profile-popup" id="profile-edit-popup">
        <div class="profile-popup-top-bar">
            <h3>Edit Profile</h3>
            <span class="close-edit-btn" id="close-edit-profile-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="scripts/account-manage/edit-account.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
        <input type="hidden" id="edit-acc-id" name="account_id">
            <div class="label-input">
                <p>Nick *</p>
                <input type="text" required name='nick' id="edit-acc-nick">
            </div>
            <span>
                <div class="label-input">
                    <p>First name *</p>
                    <input type="text" required name="first_name" id="edit-acc-fname">
                </div>
                <div class="label-input">
                    <p>Last name *</p>
                    <input type="text" required name="last_name" id="edit-acc-lname">
                </div>
            </span>
            <div class="label-input">
                <p>Email *</p>
                <input type="text" required name="email" id="edit-acc-email">
            </div>
            <div class="label-input">
                <p>Type</p>
                <?php makeRoleSelector('edit-acc') ?>
            </div>
            <span>
                <div class="label-input">
                    <p>New password</p>
                    <input name="password" type="password">
                </div>
                <div class="label-input">
                    <p>Repeat password</p>
                    <input name="password2" type="password">
                </div>
            </span>
            <button type="submit" class="button-round-filled-green">Submit</button>
        </form>
    </div>
    <!-- MAIN -->
    <div class="event-create-main-container manage-container">
        <!-- Accounts -->
        <div class="part-lable">
            <h2>Accounts</h2>
        </div>
        <div class="row-block">
            <div class="manage-filters">
                <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <span>
                        <label for="search-bar">Search Accounts</label>
                        <input type="text" id="search-bar" value="<?php echoSessionVal("search-bar", ""); ?>" name="search-bar" placeholder="Nick, Name, Email,..">
                    </span>
                    <span>
                        <label for="account_status">Account status</label>
                        <?php makeAccountStatusSelector() ?>
                    </span>
                    <span>
                        <label for="account_type">Account type</label>
                        <?php makeRoleSelector('_filter'); ?>
                    </span>
                    <button class="button-round-filled-green">Submit filters</button>
                </form>
            </div>
        </div>
        <form action="scripts/account-manage/bulk-manage-accounts.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <div class="manage-tool-bar">
                <button name="change_status" value="change_status" class="button-round-filled">Change status</button>
                <button type="button" class="button-round-filled" onclick="toggleAddProfilePopUp()">Add Account</button>
                <button name="delete" value="delete" class="button-round-filled">Delete</button>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nick</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th><i class="fa-solid fa-check"></i></th>
                    <th>Action</th>
                </tr>
               <?php generateAccountRows() ?>
            </table>
        </form>
    </div>
</main>

<?php

makeFooter();

?>

</html>
