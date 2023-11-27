<?php
/**
 * @file event-detail.php
 * @brief page with detail information about specific event
 * @author Michal Ľaš (xlasmi00)
 * @date 06.10.2023
 */

require_once "common/html-components.php";

session_start();

if(!isset($_GET['event_id'])) {
    setPopupMessage('error', 'invalid event id!');
    redirectForce('index.php');
}
$event_id = $_GET['event_id'];

generateSessionToken();
updateSessionReturnPage();
$db = connect_to_db();

makeHead("Eventer | Event Detail");
makeHeader();


?>

<main class="event-detail-main-container">
    <div class="info-container">
        <?php makeEventInfo($event_id) ?>
    </div>
    <div class="part-lable">
        <h2>Tickets</h2>
        <?php
        if(userIsAdmin() || userIsOwner($event_id)) {
            echo '<a href="ticket-manage.php?event_id='.$event_id.'" class="button-round-filled">Manage tickets</a>';
        }
        ?>
    </div>
    <div class="tickets-container">
        <?php generateEventTickets($event_id) ?>
    </div>
    <div class="part-lable">
        <h2>Comments</h2>
    </div>
    <div class="comments-container">
        <div class="comment-form">
            <?php if (userIsLoggedIn()) { ?>
            <form action="scripts/event-detail/post-comment.php" method="post">
            <input type="hidden" id="token" name="token" value="<?php echoSessionVal('token', '') ?>" >
            <input type="hidden" id="comment_event_id" name="event_id" value="<?php echo $event_id ?>" >
            <input type="hidden" id="comment_account_id" name="account_id" value="<?php echoUserAttribute('account_id') ?>" >
                <div class="form-input">
                    <textarea name="comment_text" id="comment_text" cols="30" rows="10"></textarea>
                    <span>
                        <label for="rating">Choose rating</label>
                        <input type="number" name="comment_rating" id="rating" pattern="[0-5]" value="5" oninput="checkRatingInput()">
                    </span>
                </div>
                <button type="Submit" class="button-round-filled">Submit</button>
            </form>
            <?php } ?>
        </div>
        <div class="comments-block">
            <div class="comment-edit-popup">
                <div class="edit-popup-top-bar">
                    <h3>Edit Comment</h3>
                    <span class="close-edit-btn"><i class="fa-solid fa-xmark"></i></span>
                </div>
                <form action="scripts/event-detail/edit-comment.php" method="post">
                    <input type="hidden" id="cid" name="comment_id">
                    <input type="hidden" name="token" value="<?php echoSessionVal('token', ''); ?>">
                    <input type="hidden" value="<?php date('Y-m-d H:i:s') ?>">
                    <textarea name="comment_text" id="ctext" cols="30" rows="10"></textarea>
                    <button type="submit" class="button-round-filled-green">Submit Edit</button>
                </form>
            </div>
            <?php generateComments($event_id) ?>
        </div>
    </div>
</main>

<?php

makeFooter();

?>
