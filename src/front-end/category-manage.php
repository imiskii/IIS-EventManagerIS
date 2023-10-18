<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */


require "components/html-components.php";

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
                    <?php generateCategorySelecetOptions() ?>
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
                    <th>ID</th>
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
                <form action="">
                    <span>
                        <label for="search-bar">Search Category</label>
                        <input type="text" id="search-bar" placeholder="Category..">
                    </span>
                    <span>
                        <label for="status">Category status</label>
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
                <button type="button" class="button-round-filled" onclick="toggleAddCategoryPopUp()">Add Category</button>
                <button class="button-round-filled">Delete</button>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Parrent category</th>
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

