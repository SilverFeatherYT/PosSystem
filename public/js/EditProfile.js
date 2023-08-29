$(document).ready(function () {
    $(document).on("click", ".redeem .pagination a", function (e) {
        e.preventDefault();

        var page = $(this).attr("href").split("page=")[1];

        fetch_data(page);
    });

    function fetch_data(page) {
        var _token = $("input[name=_token]").val();

        $.ajax({
            url: "/EditProfile/Message/Paginate?page=" + page,
            method: "POST",
            data: { _token: _token, page: page },
            success: function (data) {
                $("#redeem").html(data);
            },
        });
    }
    
});

$(document).ready(function () {
    $(document).on("click", ".point .pagination a", function (e) {
        e.preventDefault();

        var page = $(this).attr("href").split("page=")[1];

        fetch_data(page);
    });

    function fetch_data(page) {
        var _token = $("input[name=_token]").val();
    
        $.ajax({
            url: "/EditProfile/Point/Paginate?page=" + page,
            method: "POST",
            data: { _token: _token, page: page },
            success: function (data) {
                $("#point").html(data);
            },
        });
    }
    
});



function tabs(tabIndex) {
    var tabs = document.getElementsByClassName("tabShow");
    var tabButtons = document.getElementsByClassName("tab");

    for (var i = 0; i < tabs.length; i++) {
        if (i === tabIndex) {
            tabs[i].style.display = "block";
            tabButtons[i].classList.add("active");
        } else {
            tabs[i].style.display = "none";
            tabButtons[i].classList.remove("active");
        }
    }
}