<?php
/**
 * @file event-detail.php
 * @brief page with detail information about specific event
 * @author Michal Ľaš (xlasmi00)
 * @date 06.10.2023
 */

require_once "config/common.php";
require "src/front-end/components/html-components.php";

session_start();
$db = connect_to_db();

makeHead("Eventer | Event Detail");
makeHeader();

//FIXME: Handle missing or wrong event ID

?>

<main class="event-detail-main-container">
    <div class="info-container">
        <!-- Replace null with eventID !!! -->
        <?php makeEventInfo($_GET["event_id"]) ?>
    </div>
    <div class="part-lable">
        <h2>Tickets</h2>
        <?php
        /*
        if(user is event owner || moderator || administrator)
        {
            // link to ticket-manage page
            echo '<a href="#" class="button-round-filled">Manage tickets</a>';
        }
        */
        ?>
    </div>
    <div class="tickets-container">
        <script src="src/front-end/js/calcTicketsVal.js"></script>
        <?php generateEventTickets($_GET["event_id"]) ?>
    </div>
    <div class="part-lable">
        <h2>Comments</h2>
    </div>
    <div class="comments-container">
        <div class="comment-form">
            <form action="">
                <input type="hidden" value="User nick">
                <input type="hidden" value="<?php date('Y-m-d H:i:s') ?>">
                <div class="form-input">
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                    <span>
                        <label for="rating">Choose rating</label>
                        <input type="number" id="rating" pattern="[0-5]" value="5" oninput="checkRatingInput()">
                    </span>
                </div>
                <button type="Submit" class="button-round-filled">Submit</button>
            </form>
        </div>
        <div class="comments-block">
            <div class="comment-edit-popup">
                <div class="edit-popup-top-bar">
                    <h3>Edit Comment</h3>
                    <span class="close-edit-btn"><i class="fa-solid fa-xmark"></i></span>
                </div>
                <form action="">
                    <input type="hidden" id="cid">
                    <input type="hidden" value="<?php date('Y-m-d H:i:s') ?>">
                    <textarea name="" id="ctext" cols="30" rows="10"></textarea>
                    <button type="submit" class="button-round-filled-green">Submit Edit</button>
                </form>
            </div>
            <?php generateComments($_GET["event_id"]) ?>
        </div>
    </div>
</main>

<?php

makeFooter();

?>
