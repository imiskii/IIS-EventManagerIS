<?php
/**
 * @file login.php
 * @brief page log in form
 * @author Michal Ľaš (xlasmi00)
 * @date 06.10.2023
 */

require_once "common/html-components.php";

session_start();

if(userIsLoggedIn()) {
    redirectForce('index.php');
}

generateSessionToken();
updateSessionReturnPage();
$db = connect_to_db();

makeHead("Eventer | Sign in");

?>

<main>
    <div class="center-block">
        <div class="form-container">
            <h2>Log in</h2>
            <?php makeAlertPopup(); ?>
            <form action="scripts/login/login.php" method="post">
                <ul>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" required name="email" id="email" placeholder="Email">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <input type="password" required name="pwd" id="pwd" placeholder="Password">
                        </div>
                    </li>
                    <li>
                        <div class="buttons">
                            <button class="button-round-filled" type="submit">Log in</button>
                            <a href="signup.php" class="button-round-empty">Create new account</a>
                            <a href="index.php" class="button-round-empty"><i class="fa-solid fa-arrow-left"></i>Go back Home</a>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</main>

<?php
makeFooter();
?>

</html>
