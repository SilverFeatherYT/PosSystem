// live search function
$(".searchInput").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#table tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
// end live search function


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
                // $('#save_msgList').html("");
                // $('#save_msgList').addClass('alert alert-danger');
                // $.each(data.error, function (key, err_value) {
                //     $('#save_msgList').append('<li>' + err_value + '</li>');
                // });
            } else {
                $(".modal").modal("hide");
                // $("#success_message").addClass("alert alert-success");                 
                // $("#success_message").text(data.msg);
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
//end add product function without refresh

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





// Check the file upload
document.getElementById('uploadForm').addEventListener('submit', function (event) {
    var fileInput = document.getElementById('file');
    if (fileInput.files.length === 0) {
        event.preventDefault(); // Prevent form submission
        toastr.error('Please select a file to import.', 'Error');
    }

    var file = fileInput.files[0]; // Get the selected file

    if (file) {
        var formData = new FormData(this);
        formData.set('file', file); // Append the file to the form data

        // Perform form submission with the updated form data
        fetch(this.action, {
            method: this.method,
            body: formData
        }).then(response => {
            // Handle the response
            console.log(response);
        }).catch(error => {
            // Handle errors
            console.error(error);
        });
    }
});