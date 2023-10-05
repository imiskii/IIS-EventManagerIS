<?php
/**
 * @file html-components.php
 * @brief Common html website components
 * @author Michal Ľaš (xlasmi00)
 * @date 05.08.2023
 */


/**
 * Generator for page head
 * 
 * @param string $title title of the page
 * @return void
*/
function makeHead(string $title)
{
    ?>

    <!DOCTYPE html> 
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title ?></title>
        <!-- change styles hardcoded path -->
        <link rel="stylesheet" href="/iis/styles/style.css">
        <script src="https://kit.fontawesome.com/2ff75daa4b.js" crossorigin="anonymous"></script>
        <script src="/iis/js/design-scripts.js"></script>
    </head>
    <body>

    <?php
}


/**
 * Function generates menu for logged in user based on his role
 * 
 * @return void
 */
function generateProfilMenu()
{
    ?>

    <div class="profile-menu">
        <ul>
            <li><i class='fa-solid fa-user'></i><a href="#">Profile</a></li>

    <?php
    /*
    if (user is logged in as moderator)
    {
        echo '<li><i class="fa-solid fa-sun"></i><a href="#">Manage Events</a></li>';
        echo '<li><i class="fa-solid fa-paperclip"></i><a href="#">Manage Categories</a></li>';
        echo '<li><i class="fa-solid fa-location-dot"></i><a href="#">Manage Locations</a></li>';
    }
    if (user is logged in as administrator)
    {
        echo '<li><i class="fa-solid fa-users-gear"></i><a href="#">Manage Accounts</a></li>';
    }
    */
    ?>

            <li><i class="fa-solid fa-right-from-bracket"></i><a href="#">Log out</a></li>
        </ul>
    </div>

    <?php
}


/**
 * Generator for page header
 * 
 * @return void
 */
function makeHeader()
{
    ?>

    <header>
        <div class="top-bar">
            <a id="logo" href="index.php"><p>EVENTER</p></a>
            <div class="search-bar">
                <!-- action is a function in BG that will search the result -->
                <form action="" method="get">
                    <input type="text" placeholder="Search events...">
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <!-- src is profile icon-->
            <div class="profile">
                <?php
                    echo '<div class="profile-icon" onclick="menuToggle();">';
                    /*
                    if (user is logged in )
                    {
                        echo "<img src='profil icon'>";
                        echo "</div>"; 
                        generateProfilMenu();
                    }
                    else
                    {
                        echo "<a href='link to login page'><i class='fa-solid fa-user'></i></a>";
                        echo "</div>"; 
                    }
                    */
                    
                    // tmp: href is link to login page
                    echo "<img src=/iis/1.png>";
                    // echo "<a href=''><i class='fa-solid fa-user'></i></a>";
                    echo "</div>";
                ?>

                <div class="profile-menu">
                    <h3>Name Surname<br><span>Normall user</span></h3>
                    <ul>
                        <li><i class='fa-solid fa-user'></i><a href="#">Profile</a></li>
                        <li><i class="fa-solid fa-right-from-bracket"></i><a href="#">Log out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <?php
}


/**
 * Generator for page footer
 * 
 * @return void
 */
function makeFooter()
{
    ?>

    <footer>
        <div class="footer-top">
            <p> ISS Project 2023 | Team xlasmi00 </p>
        </div>
        <div class="footer-bottom">
            <p>&copy; The best Team</p>
        </div>
    </footer>
    </body>
    </html>

    <?php
}


/**
 * Function generates Event Cards
 * 
 * @param array $events is array of values that are displayed on card like Event name, Location, etc.
 * @param string $card_type is type of card that will be generated, default is "" -> normall card, "owner" -> card for event owners, "participant" -> card for event participant
 * @return void
 * 
 */
function generateEventCards(array $events, string $card_type="")
{
    if ($card_type != "" || $card_type != "owner" || $card_type != "participant")
    {
        $card_type = "";
    }

    if ($card_type != "")
    {
        $card_type = "-" . $card_type;
    }

    /* TEST CODE */
    for ($i = 0; $i <= 10; $i++)
    {
        ?>

        <!-- TEST CODE -->
        <a href="" class="event-card">
            <img src="/iis/1.png">
            <div class="name-rating">
                <h3>Event Name</h3>
                <div class="rating">
                    <p>4/5</p>
                    <i class="fa-regular fa-star"></i>
                </div>
            </div>
            <ul>
                <li><i class="fa-solid fa-calendar-days"></i>30.02.2024-31.03.2024</li>
                <li><i class="fa-solid fa-location-dot"></i>Everywhere</li>
            </ul>
        </a>
        <!-- END OF TEST CODE -->

        <?php
    }

    /*

    foreach($events as $event)
    {
        ?>

        <a href="event-detail.php?id='<?php echo $event['id']?>'" class="<?php echo 'event-card' . $card_type ?>">
            <img src="<?php echo $event['image_url']; ?>">
            <div class="name-rating">
                <h3><?php echo $event['event_name']; ?></h3>
                <div class="rating">
                    <p><?php echo $event['rating']; ?></p>
                    <i class="fa-regular fa-star"></i>
                </div>
            </div>
            <ul>
                <li><i class="fa-solid fa-calendar-days"></i><?php echo $event['date_from'] . $event['date_to']; ?></li>
                <li><i class="fa-solid fa-location-dot"></i><?php echo $event['location']; ?></li>
            </ul>
        </a>

        <?php
    }

    */
}


/**
 * Function generates list of locations
 * 
 * @return void
 */
function generateLocations()
{
    /*
    $locations = getLocations();
    foreach ($locations as $location)
    {
        echo '<li>' . $location . '</li>';
    }
    */
}


/**
 * Function generates tree of categories
 * 
 * @param string|null $parent_category name of parent category
 * @return void
 */
function generateCategoryTree($parent_category = null) {

    // getParentCategories($parent_category = null) is function that return list subcategories of given parent category
    // it has one parameter and it is name of parent category, default value is null

    /*
    $categories = getParentCategories($parent_category);

    echo '<ul class="category-tree">';
    foreach ($categories as $category)
    {
        if ($category['parent_name'] == $parent_category)
        {
            echo '<li>';
            echo '<input type="checkbox" name="categories[]" value="' . $category['name'] . '">';
            echo $category['name'];
            generateCategoryTree($category['name']);
            echo '<\li>';
        }
    }
    echo '</ul>';
    */
}