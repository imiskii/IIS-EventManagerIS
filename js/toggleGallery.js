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
