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

if(is_null($event_id = $_GET['event_id'] ?? null) || (!userIsAdmin() && !userIsOwner($event_id))) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('index.php');
}

generateSessionToken();
updateSessionReturnPage();
updateSession($_GET, ['ticket_search_bar']);

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
        <form action="scripts/ticket-manage/confirm-pending-tickets.php" method="post">
        <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <div class="manage-tool-bar">
                <button name="accept" value="accept" class="button-round-filled">Confirm</button>
                <button name="delete" value="delete" class="button-round-filled">Delete</button>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nick</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Time</th>
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
        <form action="scripts/ticket-manage/bulk-manage-registrations.php" method="post">
            <div class="manage-tool-bar">
                <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
                <button name="delete" value="delete" class="button-round-filled">Delete</button>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nick</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Time</th>
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
