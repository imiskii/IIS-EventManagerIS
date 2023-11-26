
/**
 * Function show profile menu nav bar
 *
 */
function menuToggle()
{
    const toggleMenu = document.querySelector('.profile-menu');
    toggleMenu.classList.toggle('active');
}


/**
 * Check if filter inputs for rating is from 0 to 5
 *
 */
function checkRatingFilterInput()
{
    const minInput = document.getElementById('min_rating');
    const maxInput = document.getElementById('max_rating');

    min = parseInt(minInput.value);
    max = parseInt(maxInput.value);

    if (min > max && max >= 0)
    {
        minInput.value = max;
    }

    if (isNaN(min) || min < 0)
    {
        minInput.value = 0;
    }
    else if (min > 5)
    {
        minInput.value = 5;
    }

    if (isNaN(max) || max > 5)
    {
        maxInput.value = 5;
    }
    else if (max < 0)
    {
        maxInput.value = 0;
    }
}


/**
 *  Check if input for rating is from 0 to 5
 *
 */
function checkRatingInput()
{
    const ratingInput = document.getElementById('rating');

    val = parseInt(ratingInput.value);

    if (isNaN(val) || val > 5)
    {
        ratingInput.value = 5;
    }
    else if (val < 0)
    {
        ratingInput.value = 0;
    }
}


/**
 * Check if input is positive number or 0
 *
 * @param {*} input
 */
function checkNegativeInput(input)
{
    val = parseInt(input.value);

    console.log(val);

    if (isNaN(val) || val < 0)
    {
        input.value = '';
    }
}


/**
 * Function show ticket types table of given ticked id
 *
 * @param {*} ticketID id of ticket component
 */
function toggleTicketDetail(ticketID)
{
    var TicketTypeContainer = document.getElementById(ticketID)
    var arrowButton = document.querySelector(`[ticket-arrow-button="${ticketID}"]`);

    if (TicketTypeContainer.style.display === 'none' || TicketTypeContainer.style.display === '')
    {
        TicketTypeContainer.style.display = 'block';
        arrowButton.textContent = '▲';
    }
    else
    {
        TicketTypeContainer.style.display = 'none';
        arrowButton.textContent = '▼';
    }
}







/**
 * Show comment edit popup
 *
 * @param {*} commentID id of comment
 * @param {*} commentText text of comment
 */
function toggleEditCommentPopUp(commentID, commentText)
{
    console.log('function called.');
    const popup = document.querySelector('.comment-edit-popup');
    const closeBtn = document.querySelector('.close-edit-btn');
    const commentIdInput = document.getElementById('cid');
    const commentTextInput = document.getElementById('ctext');

    commentIdInput.value = commentID;
    commentTextInput.value = commentText;

    popup.classList.add('active');

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('active');
    });
}


/**
 * Function open a popup with pre filled profile informations
 *
 * @param {*} nick profile nick
 * @param {*} f_name profile first name
 * @param {*} l_name profile last name
 * @param {*} email profile email
 * @param {*} role profile role
 */
function toggleEditProfilePopUp(nick='', f_name='', l_name='', email='', role='')
{
    const popup = document.getElementById('profile-edit-popup');
    const closeBtn = document.getElementById('close-edit-profile-btn');

    const nickInput = document.getElementById('nick');
    const firstNameInput = document.getElementById('fname');
    const lastNameInput = document.getElementById('lname');
    const emailInput = document.getElementById('email');
    const roleInput = document.getElementById('role');

    nickInput.value = nick;
    firstNameInput.value = f_name;
    lastNameInput.value = l_name;
    emailInput.value = email;
    roleInput.value = role;

    popup.classList.add('active');

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('active');
    });
}


/**
 * Show password change popup
 *
 */
function togglePasswordChangeProfilePopUp()
{
    const popup = document.getElementById('profile-password-popup');
    const closeBtn = document.getElementById('close-password-profile-btn');

    popup.classList.add('active');

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('active');
    });
}


/**
 * Show category form popup for creating new category
 *
 */
function toggleAddCategoryPopUp()
{
    const popup = document.getElementById('add-category-popup');
    const closeBtn = document.getElementById('close-category-popup-btn');

    popup.classList.add('active');

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('active');
    });
}


/**
 * Show category form popup for editing existing category
 *
 * @param {*} c_name category name
 * @param {*} parent_id id of parent category
 */
function toggleEditCategoryPopUp(c_name, parent_id)
{
    const popup = document.getElementById('add-category-popup');
    const closeBtn = document.getElementById('close-category-popup-btn');

    const nameInput = document.getElementById('category-name');
    const parentSelect = document.getElementById('category-parent');
    nameInput.value = c_name;
    parentSelect.value = parent_id;

    popup.classList.add('active');

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('active');
    });
}


/**
 * Show category form popup for creating new location
 *
 */
function toggleAddLocationPopUp()
{
    const popup = document.getElementById('add-location-popup');
    const closeBtn = document.getElementById('close-location-popup-btn');

    popup.classList.add('active');

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('active');
    });
}


/**
 * Show category form popup for editing existing location
 *
 * @param {*} country location country
 * @param {*} city location city
 * @param {*} s_name street name
 * @param {*} s_num street number
 * @param {*} region state/region/province
 * @param {*} zip ZIP code
 */
function toggleEditLocationPopUp(country, city, s_name, s_num, region, zip)
{
    const popup = document.getElementById('add-location-popup');
    const closeBtn = document.getElementById('close-location-popup-btn');

    const countryInput = document.getElementById('country');
    const cityInput = document.getElementById('city');
    const s_nameInput = document.getElementById('s_name');
    const s_numInput = document.getElementById('s_num');
    const regionInput = document.getElementById('region');
    const zipInput = document.getElementById('zip');

    countryInput.value = country;
    cityInput.value = city;
    s_nameInput.value = s_name;
    s_numInput.value = s_num;
    regionInput.value = region;
    zipInput.value = zip;

    popup.classList.add('active');

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('active');
    });
}


/**
 * Create new event instance form
*/
let eventVariantCount = 1;
function addEventVariant() {
    if((eventVariantCount == 1) && (document.getElementById('tickets-variants').childElementCount > 1))7
    {
        eventVariantCount = document.getElementById('tickets-variants').childElementCount;
    }
    eventVariantCount++;

    const variantDiv = document.createElement('div');
    variantDiv.classList.add('ticket');
    variantDiv.id = 'event-variant-' + eventVariantCount;

    variantDiv.innerHTML = `
    <div class="form-block ticket-create">
        <button type="button" class="button-round-filled" onclick="removeEventVariant(${eventVariantCount})"><i class="fa-solid fa-trash"></i></button>
        <div class="ticket-form-inputs">
            <div class="filter-date">
                <label for="e-date-from">Date from:</label>
                <input type="date" id="e-date-from">
            </div>
            <div class="filter-date">
                <label for="e-date-to">Date to:</label>
                <input type="date" id="e-date-to">
            </div>
            <div class="filter-date">
                <label for="e-time-from">Time from:</label>
                <input type="time" id="e-time-from">
            </div>
            <div class="filter-date">
                <label for="e-time-to">Time to:</label>
                <input type="time" id="e-time-to">
            </div>
            <span>
                <label for="location-select">Select location</label>
                <select name="location-select" id="location-select">
                    <?php generateLocationSelectOptions() ?>
                </select>
            </span>
        </div>
        <button type="button" ticket-arrow-button="ticket-${eventVariantCount}" class="arrow-button" onclick="toggleTicketDetail('ticket-${eventVariantCount}')">▼</button>
    </div>
    <div class="ticket-types" id="ticket-${eventVariantCount}">
        <table id="variant-types-${eventVariantCount}">
            <tr>
                <td>Ticket type</td>
                <td class="row-15">Ticket cost in $</td>
                <td class="row-15">Number of tickets</td>
                <td class="row-10"><button type="button" class="button-round-filled" onclick="addTicketType(${eventVariantCount})"><i class="fa-solid fa-plus"></i></button></td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="" id="ticket-type" placeholder="Ticket type name">
                </td>
                <td class="row-15">
                    <input type="number" name="" id="ticket-cost" placeholder="Cost" oninput="checkNegativeInput(this)">
                </td>
                <td class="row-15">
                    <input type="number" name="" id="ticket-cnt" placeholder="Num." oninput="checkNegativeInput(this)">
                </td>
                <td class="row-10"><button type="button" class="button-round-filled" onclick="removeTicketType(this)"><i class="fa-solid fa-trash"></i></button></td>
            </tr>
        </table>
    </div>
    `;

    document.getElementById('tickets-variants').appendChild(variantDiv);
}


/**
 * Add new ticekt type to existing variant of ticket
 *
 * @param {*} variantId id of variant to which new ticket type will be added
 */
function addTicketType(variantId) {
    const typeTable = document.getElementById('variant-types-' + variantId);
    const row = typeTable.insertRow();
    const cell1 = row.insertCell();
    const cell2 = row.insertCell();
    cell2.classList.add('row-15')
    const cell3 = row.insertCell();
    cell3.classList.add('row-15');
    const cell4 = row.insertCell();
    cell4.classList.add('row-10');

    cell1.innerHTML = '<input type="text" name="" id="ticket-type" placeholder="Ticket type name">';
    cell2.innerHTML = '<input type="number" name="" id="ticket-cost" placeholder="Cost" oninput="checkNegativeInput(this)">';
    cell3.innerHTML = '<input type="number" name="" id="ticket-cnt" placeholder="Num." oninput="checkNegativeInput(this)">';
    cell4.innerHTML = '<button type="button" class="button-round-filled" onclick="removeTicketType(this)"><i class="fa-solid fa-trash"></i></button>';
}


/**
 * Remove ticket type of specific ticket variant
 *
 * @param {*} button remove button
 */
function removeTicketType(button) {
    const row = button.parentNode.parentNode;
    if (row.parentNode.parentNode.rows.length > 2)
    {
        row.parentNode.removeChild(row);
    }
}


/**
 *
 *
 * @param {*} variantId id of variant which will be deleted
 */
function removeEventVariant(variantId) {
    if (document.getElementById('tickets-variants').childElementCount > 1)
    {
        const variantDiv = document.getElementById('event-variant-' + variantId);
        variantDiv.parentNode.removeChild(variantDiv);
    }
}

function toggleChildren(checkbox) {
    // Get the data-parent attribute value
    var parentCategory = checkbox.getAttribute('data-parent');

    // Get all checkboxes with the same data-parent value
    var childCheckboxes = document.querySelectorAll('[data-parent="' + parentCategory + '"]');

    // Set the state of child checkboxes to match the parent checkbox
    for (var i = 0; i < childCheckboxes.length; i++) {
        childCheckboxes[i].checked = checkbox.checked;
    }
}

function updateChildCheckboxes(parentCheckbox) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        if (checkbox.getAttribute('parent') === parentCheckbox.value) {
            checkbox.checked = parentCheckbox.checked;
        }
    });
}


/**
 * Show Alert popup message
 * @param {string} type it could be either "warning" | "info" | "success", this make style of the alert popup
 * @param {string} msg message in popup
 */
function showAlert(type, msg)
{
    var alertBox = document.getElementById('alert');
    var closeBtn = document.getElementById('alert-close-btn');
    var alertMsg = document.getElementById('alert-msg');

    // Adjust elements
    if(type === "info")
    {
        alertBox.style.backgroundColor = "#BCFBFF";
        alertBox.style.borderLeft = "8px solid #93F8FF";
        closeBtn.style.background = "#5DF5FF";
        alertMsg.textContent = "Info: " + msg;
    }
    else if(type === "warning")
    {
        alertBox.style.backgroundColor = "#ffdb9b";
        alertBox.style.borderLeft = "8px solid #ffa502";
        closeBtn.style.background = "#ffd080";
        alertMsg.textContent = "Warning: " + msg;
    }
    else if(type === "success")
    {
        alertBox.style.backgroundColor = "#BFFFBB";
        alertBox.style.borderLeft = "8px solid #9CFF95";
        closeBtn.style.background = "#67FF5D";
        alertMsg.textContent = "Success: " + msg;
    }
    else if (type === "error") {
        alertBox.style.backgroundColor = "#ff6442";
        alertBox.style.borderLeft = "8px solid #ff4820";
        closeBtn.style.background = "#ff4820";
        alertMsg.textContent = "Error: " + msg;
    }

    // Show alert
    alertBox.classList.remove('hide');

    // Set timeout on 3 seconds and close the Alert
    setTimeout(function()
    {
        closeAlert();
    }, 3000);
}

/**
 * Close Alert popup message
 */
function closeAlert()
{
    var alertBox = document.getElementById('alert');
    alertBox.classList.add('hide');
}

function previewFile() {
    var preview = document.getElementById('img-preview');
    var fileInput = document.getElementById('file-input');
    var file = fileInput.files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
    }
}

/**
 * Show gallery popup with given imageList
 *
 * @param {*} imageList list with paths to the images
 * @FIXME leave popup emty if no photos are provided
 */
function toggleGallery(imageList)
{
    const popup = document.querySelector('.gallery-popup');
    const closeBtn = document.querySelector('.close-btn');
    const largeImage = document.querySelector('.large-image');
    const imageIndex = document.querySelector('.image-index');
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');

    let index = 0;

    largeImage.src = imageList[index];
    popup.classList.add('active');

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('active');
    });

    const updateImage = (i) => {
        largeImage.src = imageList[i];
        imageIndex.innerHTML = `${i+1}`;
        index = i;
    }

    leftArrow.addEventListener('click', () => {
        updateImage((index - 1 + imageList.length) % imageList.length);
    });

    rightArrow.addEventListener('click', () => {
        updateImage((index + 1) % imageList.length);
    });
}

function refreshImage(id, src) {
    var imageElement = document.getElementById(id);

    imageElement.src = src + '?' + new Date().getTime();
}
