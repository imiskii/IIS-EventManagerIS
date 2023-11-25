<?php
/**
 * @file event-create.php
 * @brief page with event create form
 * @author Michal Ľaš (xlasmi00)
 * @date 13.10.2023
 */


require_once "config/common.php";
require "src/front-end/components/html-components.php";

session_start();
$db = connect_to_db();

if(is_null($event_id = $_GET['event_id'] ?? null) || (!userIsAdmin() && !userIsOwner($event_id))) {
    redirect('index.php'); // TODO: Error message
}

updateSession($_GET, ['ticket_search_bar']);
$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];

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
                <?php generateTicketOrdersRows($event_id) ?>
            </table>
        </form>
        <!-- Bought tickets -->
        <div class="part-lable">
            <h2>Confirmed Registrations</h2>
        </div>
        <div class="row-block">
            <div class="manage-filters">
                <form action="<?php echoCurrentPage() ?>" method="get">
                    <span>
                        <label for="ticket_search_bar">Search buyers or tickets</label>
                        <input type="text" id="ticket_search_bar" name="ticket_search_bar" value="<?php echoSessionVal('ticket_search_bar', ''); ?>" placeholder="Nick, Name, Email,...">
                        <input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id ?>">
                    </span>
                    <button class="button-round-filled-green">Search</button>
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
                <?php generateTicketRows($event_id) ?>
            </table>
        </form>
    </div>
</main>

<?php

makeFooter();

?>

</html>
