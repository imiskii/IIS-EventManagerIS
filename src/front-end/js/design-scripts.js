
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
    const minInput = document.getElementById('min-r');
    const maxInput = document.getElementById('max-r');

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
 * Function calculate final price of registration in choosen ticket type
 * 
 * @param {*} ticketID id of ticket component
 * @param {*} ticketTypesNumber number of ticket types
 */
function calcTicketsVal(ticketID, ticketTypesNumber)
{
    var totalValue = 0;
    for (var i = 1; i <= ticketTypesNumber; i++)
    {
        var quantityInput = document.getElementById(`ticket-${ticketID}-quantity-${i}`);
        var quantity = parseInt(quantityInput.value);
        var price = parseFloat(document.getElementById(`ticket-${ticketID}-price-${i}`).textContent.slice(1));

        if (quantity < 0 || isNaN(quantity))
        {
            quantity = 0;
            quantityInput.value = 0;
        }

        totalValue += (price * quantity);
    }

    var totalPriceElement = document.getElementById(`total-ticket-${ticketID}`);
    totalPriceElement.textContent = `$${totalValue}`;
}


/**
 * Show gallery popup with given imageList
 * 
 * @param {*} imageList list with paths to the images
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


/**
 * Show comment edit popup
 * 
 * @param {*} commentID id of comment
 * @param {*} commentText text of comment
 */
function toggleEditCommentPopUp(commentID, commentText)
{
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



function toggleEditProfilePopUp(nick, f_name, l_name, email, role)
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