
$(document).ready(function () {
    // Function to handle the plus button
    $('.plus').click(function () {
        var itemId = $(this).data('item-id');
        var inputField = $('#quantity_' + itemId);
        var currentValue = parseInt(inputField.val());
        inputField.val(currentValue + 1);
    });

    // Function to handle the minus button
    $('.minus').click(function () {
        var itemId = $(this).data('item-id');
        var inputField = $('#quantity_' + itemId);
        var currentValue = parseInt(inputField.val());
        if (currentValue > 1) {
            inputField.val(currentValue - 1);
        }
    });
});