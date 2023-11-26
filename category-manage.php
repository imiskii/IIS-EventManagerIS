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
        <form action="">
            <div class="label-input">
                <p>Name of new Category</p>
                <input type="text" id="category-name" placeholder="Category name">
            </div>
            <div class="label-input">
                <p>Parrent Category to new created category</p>
                <select name="" id="category-parent">
                    <option value="root">Root</option>
                    <?php generateCategorySelectOptions() ?>
                </select>
            </div>
            <button type="submit" class="button-round-filled-green">Submit Category</button>
        </form>
    </div>
    <!-- MAIN -->
    <div class="event-create-main-container manage-container">
        <!-- Proposals -->
        <div class="part-lable">
            <h2>Category proposals</h2>
        </div>
        <form action="">
            <div class="manage-tool-bar">
                <button class="button-round-filled">Accept proposal</button>
                <button class="button-round-filled">Reject proposal</button>
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
                        <?php generateStatusSelectOptions('category_status') ?>
                    </span>
                    <button class="button-round-filled-green">Submit filters</button>
                </form>
            </div>
        </div>
        <form action="">
            <div class="manage-tool-bar">
                <button class="button-round-filled">Change status</button>
                <button type="button" class="button-round-filled" onclick="toggleAddCategoryPopUp()">Add Category</button>
                <button class="button-round-filled">Delete</button>
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
