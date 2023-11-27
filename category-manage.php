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
updateSession($_GET, ['search-bar', 'category_status']);
$db = connect_to_db();

makeHead("Eventer | Category Management");
makeHeader();

?>

<main>
    <!-- Create new Category popup -->
    <div class="profile-popup" id="add-category-popup">
        <div class="profile-popup-top-bar">
            <h3>Create new Category</h3>
            <span class="close-edit-btn" id="close-category-popup-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="scripts/category-manage/create-category.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <div class="label-input">
                <p>Name of new Category *</p>
                <input type="text" name="category_name" required placeholder="Category name">
            </div>
            <div class="label-input">
                <p>Parent Category to new created category</p>
                <select name="super_category">
                    <option value="" selected></option>
                    <?php generateCategorySelectOptions() ?>
                </select>
            </div>
            <div class="label-input">
                <p>Status</p>
                <?php generateStatusSelectOptions('category_status', 'c-add-status', false) ?>
            </div>
            <div class="label-input">
                <p>Description</p>
                <textarea cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="button-round-filled-green">Submit Category</button>
        </form>
    </div>
    <!-- Edit Category popup -->
    <div class="profile-popup" id="edit-category-popup">
        <div class="profile-popup-top-bar">
            <h3>Edit Category</h3>
            <span class="close-edit-btn" id="edit-close-category-popup-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <form action="scripts/category-manage/edit-category.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
        <input type="hidden" id="category-id" name="category_id" >
            <div class="label-input">
                <p>Category Name *</p>
                <input type="text" required name="category_name" id="category-name" placeholder="Category name">
            </div>
            <div class="label-input">
                <p>Parent Category</p>
                <select name="super_category_id" id="category-parent">
                    <?php generateCategorySelectOptions() ?>
                </select>
            </div>
            <div class="label-input">
                <p>Status</p>
                <?php generateStatusSelectOptions('category_status', 'c-edit-status', false) ?>
            </div>
            <div class="label-input">
                <p>Description</p>
                <textarea id="c-desc" name="category_description" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="button-round-filled-green">Submit</button>
        </form>
    </div>
    <!-- MAIN -->
    <div class="event-create-main-container manage-container">
        <!-- Proposals -->
        <div class="part-lable">
            <h2>Category proposals</h2>
        </div>
        <form action="scripts/category-manage/bulk-manage-category-proposals.php" method="post">
            <div class="manage-tool-bar">
                <input type="hidden" name="token" value="<?php echoSessionVal('token', ''); ?>">
                <button name='accept' value='accept' class="button-round-filled">Accept proposal</button>
                <button name='reject' value='reject' class="button-round-filled">Reject proposal</button>
            </div>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>Parrent category</th>
                    <th><i class="fa-solid fa-check"></i></th>
                </tr>
                <?php generateCategoryProposalRows() ?>
            </table>
        </form>
        <!-- Categories -->
        <div class="part-lable">
            <h2>All categories</h2>
        </div>
        <div class="row-block">
            <div class="manage-filters">
                <form action="<?php echoCurrentPage() ?>" method="get">
                    <span>
                        <label for="search-bar">Search Category</label>
                        <input type="text" name="search-bar" id="search-bar" value="<?php echoSessionVal('search-bar', '') ?>" placeholder="Category..">
                    </span>
                    <span>
                        <label for="category_status">Category status</label>
                        <?php generateStatusSelectOptions('category_status', 'category_status', true) ?>
                    </span>
                    <button class="button-round-filled-green">Submit filters</button>
                </form>
            </div>
        </div>
        <form action="scripts/category-manage/bulk-manage-categories" method="post">
            <div class="manage-tool-bar">
                <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
                <button name="change_status" value="change_status" class="button-round-filled">Change status</button>
                <button type="button" class="button-round-filled" onclick="toggleAddCategoryPopUp()">Add Category</button>
                <button name="delete" value="delete" class="button-round-filled">Delete</button>
            </div>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Parent category</th>
                    <th>Status</th>
                    <th><i class="fa-solid fa-check"></i></th>
                    <th>Action</th>
                </tr>
                <?php generateCategoryRows() ?>
            </table>
        </form>
    </div>
</main>

<?php

makeFooter();

?>

</html>
