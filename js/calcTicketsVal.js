/**
 * Function calculate final price of registration in choosen ticket type
 *
 * @param {*} ticketID id of ticket component
 * @param {*} ticketTypesNumber number of ticket types
 */
function calcTicketsVal(ticketID, ticketTypesNumber)
{
    console.log('in function');
    var totalValue = 0;
    for (var i = 1; i <= ticketTypesNumber; i++)
    {
        var quantityInput = document.getElementById(`ticket-${ticketID}-quantity-${i}`);
        var quantity = parseInt(quantityInput.value);
        var priceElement = document.getElementById(`ticket-${ticketID}-price-${i}`);
        var price = parseFloat(priceElement.textContent.replace('$', '')); // Extract numeric value from the price element

        if (quantity < 0 || isNaN(quantity))
        {
            quantity = 0;
            quantityInput.value = 0;
        }

        totalValue += (price * quantity);

    }
    console.log(`price: ${price}, quantity: ${quantity}, totalValue: ${totalValue}`);

    var totalPriceElement = document.getElementById(`total-ticket-${ticketID}`);
    totalPriceElement.textContent = `${totalValue.toFixed(2)},-`;
}
