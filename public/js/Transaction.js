// Date filter function without button
document.getElementById('start_date').addEventListener('change', function () {
    document.getElementById('dateForm').submit();
});

document.getElementById('end_date').addEventListener('change', function () {
    document.getElementById('dateForm').submit();
});

document.getElementById('month').addEventListener('change', function () {
    document.getElementById('monthForm').submit();
});

document.getElementById('payment').addEventListener('change', function () {
    document.getElementById('paymentForm').submit();
});



// Prevent Paginate Reload function
$(document).ready(function () {
    $(document).on("click", ".pagination a", function (e) {
        e.preventDefault();

        var page = $(this).attr("href").split("page=")[1];

        fetch_data(page);
    });

    function fetch_data(page) {
        var _token = $("input[name=_token]").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var month = $("#month").val();
        var payment = $("#payment").val();

        $.ajax({
            url: "/Transaction/Paginate" + "?page=" + page,
            method: "POST",
            data: {
                _token: _token,
                page: page,
                start_date: start_date,
                end_date: end_date,
                month: month,
                payment: payment
            },
            success: function (data) {
                $("#order").html(data);
            },
        });
    }
});

