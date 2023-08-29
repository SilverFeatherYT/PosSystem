// live search function
$(".searchInput").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#table tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
// end live search function



// Show and close the search input field
const searchContainer = document.querySelector('.search');
const searchIcon = searchContainer.querySelector('.material-symbols-outlined');
const searchInput = searchContainer.querySelector('#searchInput');

searchIcon.addEventListener('click', function () {
    searchContainer.classList.add('active');
    searchInput.focus();
});

searchInput.addEventListener('blur', function () {
    if (searchInput.value === '') {
        searchContainer.classList.remove('active');
    }
});
// Show and close the search input field




// Add an event listener to the Delete All button
document.getElementById('deleteAllForm').addEventListener('submit', function (event) {
    event.preventDefault();

    // Get all the selected checkboxes
    var checkboxes = document.querySelectorAll('.checkboxtd:checked');

    // Check if any checkboxes are selected
    if (checkboxes.length === 0) {
        // Show an error message or handle the case where no checkboxes are selected
        return;
    }

    // Create an array to store the selected product IDs
    var selectedItems = [];

    // Iterate through the selected checkboxes and add their product IDs to the array
    checkboxes.forEach(function (checkbox) {
        selectedItems.push(checkbox.getAttribute('data-item-id'));
    });
    // Set the selected product IDs as the value of the hidden input field
    document.getElementById('selectedItems').value = JSON.stringify(selectedItems);

    // Submit the form to delete all the selected products
    this.submit();
});

// Select all checkbox 
$('#checkboxth').change(function () {

    $('.checkboxtd').prop('checked', $(this).prop('checked'));

    // var checkboxes = $('tbody').find(':checkbox'); // Find all checkboxes within the tbody
    // checkboxes.prop('checked', $(this).is(':checked')); // Set the checked property of checkboxes to the checked property of the select all checkbox
    // var checkedIndividualCheckboxes = $('#table').find('tbody').find(':checkbox:checked');
    // var deleteAllButton = $('#deleteAllButton');
    // if ($(this).is(':checked') || checkedIndividualCheckboxes.length > 1) {
    //         deleteAllButton.show();
    //     } else {
    //         deleteAllButton.hide();
    //     }

    updateDeleteAllButtonVisibility();
});

// Individual checkboxes
$('tbody').on('change', ':checkbox', function () {
    var selectAllCheckbox = $('#checkboxth');
    var allCheckboxes = $('tbody').find(':checkbox');


    // Check if any individual checkbox is unchecked
    var uncheckedCheckboxExists = allCheckboxes.is(':not(:checked)');

    selectAllCheckbox.prop('checked', !uncheckedCheckboxExists);

    updateDeleteAllButtonVisibility();
});

function updateDeleteAllButtonVisibility() {
    var checkboxth = $('#checkboxth');
    var checkboxtdChecked = $('tbody').find('#checkboxtd:checked');
    var deleteAllButton = $('#deleteAllButton');

    if (checkboxth.is(':checked') || checkboxtdChecked.length > 1) {
        deleteAllButton.show();
    } else {
        deleteAllButton.hide();
    }
}





//add product function without refresh
$("#addForm,#updateForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr("action"),
        method: $(this).attr("method"),
        data: new FormData(this),
        processData: false,
        dataType: "json",
        contentType: false,
        beforeSend: function () {
            $(document).find("span.error-text").text("");
            $(document).find("alert.alert-success").text("");
        },
        success: function (data) {
            if (data.status == 0) {
                $.each(data.error, function (prefix, val) {
                    $("span." + prefix + "_error").text(val[0]);
                });
            } else {
                $(".modal").modal("hide");
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true,
                }
                toastr.success(data.msg);
                $(".table-data").load(location.href + " .table-data");

                setTimeout(function () {
                    location.reload();
                }, 3000);
            }
        },
    });
});