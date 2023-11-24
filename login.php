<?php
/**
 * @file login.php
 * @brief page log in form
 * @author Michal Ľaš (xlasmi00)
 * @date 06.10.2023
 */

require_once "config/common.php";
require "src/front-end/components/html-components.php";

session_start();
$db = connect_to_db();

makeHead("Eventer | Sign in");

?>

<main>
    <div class="center-block">
        <div class="form-container">
            <h2>Log in</h2>
            <form action="validate_login.php" method="post">
                <ul>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" name="email" id="email" placeholder="Email">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <input type="password" name="pwd" id="pwd" placeholder="Password">
                        </div>
                    </li>
                    <li>
                        <div class="buttons">
                            <button class="button-round-filled" type="submit">Log in</button>
                            <a href="#" class="button-round-empty">Create new account</a>
                            <!-- FIXME $_SESSION['return_to'] -->
                            <a href="#" class="button-round-empty"><i class="fa-solid fa-arrow-left"></i>Go back Home</a>
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