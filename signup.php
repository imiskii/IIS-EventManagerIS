<?php
/**
 * @file signin.php
 * @brief page sign in form
 * @author Michal Ľaš (xlasmi00)
 * @date 06.10.2023
 */

require_once "common/html-components.php";

session_start();

if (userIsLoggedIn()) {
    // unauthorized access gets redirected to home page
    redirectForce('index.php');
}

updateSessionReturnPage();
generateSessionToken();
$db = connect_to_db();

updateSession($_POST, ['email', 'first_name', 'last_name', 'nick']);

makeHead("Eventer | Sign up");

?>

<main>
    <div class="center-block">
        <div class="form-container">
            <h2>Sign up</h2>
            <?php makeAlertPopup(); ?>
            <form action="scripts/sign-up/signup.php" method="post">
            <input type="hidden" name="token" value="<?php echoSessionVal('token', ''); ?>">
                <ul>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" required value="<?php echoSessionVal('nick', '') ?>" name="nick" id="nick" placeholder="Username">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" required value="<?php echoSessionVal('first_name', '') ?>" name="first_name" id="first_name" placeholder="First name">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" required value="<?php echoSessionVal('last_name', '') ?>" name="last_name" id="last_name" placeholder="Last name">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <input type="text" required value="<?php echoSessionVal('email', '') ?>" name="email" id="email" placeholder="Email">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <input type="password" required name="password" id="password" placeholder="Password">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <input type="password" required name="password2" id="password2" placeholder="Repeat password">
                        </div>
                    </li>
                    <li>
                        <div class="buttons">
                            <button class="button-round-filled" type="submit">Sign up</button>
                            <a href="login.php" class="button-round-empty">Log in to existing account</a>
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
