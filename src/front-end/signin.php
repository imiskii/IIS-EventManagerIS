<?php
/**
 * @file signin.php
 * @brief page sign in form
 * @author Michal Ľaš (xlasmi00)
 * @date 06.10.2023
 */

require "components/html-components.php";

makeHead("Eventer | Log in");

?>

<main>
    <div class="center-block">
        <div class="form-container">
            <h2>Sign in</h2>
            <form action="" method="post">
                <ul>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" name="nick" id="nick" placeholder="Username">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" name="name" id="name" placeholder="First name">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" name="surname" id="surname" placeholder="Last name">
                        </div>
                    </li>
                    <li>
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-envelope"></i>
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
                        <div class="input-row">
                            <div class="input-icon">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <input type="password" name="pwd" id="pwd" placeholder="Repeat password">
                        </div>
                    </li>
                    <li>
                        <div class="buttons">
                            <button class="button-round-filled" type="submit">Sign in</button>
                            <a href="#" class="button-round-empty">Log in to existing account</a>
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

