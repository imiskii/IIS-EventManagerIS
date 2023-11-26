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

updateSessionReturnPage();
updateSession($_GET, ["search-bar", "account_status", 'account_type_filter']);

makeHead("Eventer | Account Management");
makeHeader();

?>

<main>
    <!-- Edit profile popup -->
    <div class="profile-popup" id="profile-edit-popup">
        <div class="profile-popup-top-bar">
            <h3>Create/Edit Profile</h3>
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
            <div class="label-input">
                <p>Type</p>
                <?php makeRoleSelector() ?>
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
                        <select name="account_status" id="account_status">
                            <option value="all">All</option>
                            <option value="active">active</option>
                            <option value="disabled">disabled</option>
                        </select>
                    </span>
                    <span>
                        <label for="account_type_filter">Account type</label>
                        <?php makeRoleSelector('_filter'); ?>
                    </span>
                    <button class="button-round-filled-green">Submit filters</button>
                </form>
            </div>
        </div>
        <form action="">
            <div class="manage-tool-bar">
                <button class="button-round-filled">Change status</button>
                <button type="button" class="button-round-filled" onclick="toggleEditProfilePopUp()">Add Account</button>
                <button class="button-round-filled">Delete</button>
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
