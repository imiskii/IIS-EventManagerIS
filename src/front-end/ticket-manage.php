<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */


require "components/html-components.php";

makeHead("Eventer | Ticket Management");
makeHeader();

?>

<main>
    <!-- MAIN -->
    <div class="event-create-main-container manage-container">
        <!-- Tickets waiting on Confirmation -->
        <div class="part-lable">
            <h2>Tickets waiting on Confirmation</h2>
        </div>
        <form action="">
            <div class="manage-tool-bar">
                <button class="button-round-filled">Confirm</button>
                <button class="button-round-filled">Delete</button>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nick</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Ticket Type</th>
                    <th>Count</th>
                    <th><i class="fa-solid fa-check"></i></th>
                </tr>
                <?php generateTicketOrdersRows() ?>
            </table>
        </form>
        <!-- Bought tickets -->
        <div class="part-lable">
            <h2>Bought Tickets</h2>
        </div>
        <div class="row-block">
            <div class="manage-filters">
                <form action="">
                    <span>
                        <label for="search-bar">Search buyers or tickets</label>
                        <input type="text" id="search-bar" placeholder="Nick, Name, Email,..">
                    </span>
                    <span>
                        <label for="ticket-type">Ticket type</label>
                        <select name="" id="ticket-type">
                            <option value="all">All</option>
                            <option value="normal">Normal</option>
                            <option value="student">Student</option>
                            <option value="family">Family</option>
                        </select>
                    </span>
                    <button class="button-round-filled-green">Submit filters</button>
                </form>
            </div>
        </div>
        <form action="">
            <div class="manage-tool-bar">
                <button class="button-round-filled">Delete</button>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nick</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Ticket Type</th>
                    <th>Count</th>
                    <th><i class="fa-solid fa-check"></i></th>
                </tr>
                <?php generateTicketRows() ?>
            </table>
        </form>
    </div>
</main>

<?php

makeFooter();

?>

</html>

