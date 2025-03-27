$(function () {
    const BaseURL = "../includes/encode/facility_api.php?action=";

    $("#generateBtn").on("click", function(){
        console.log("generating...")

        $.ajax({
            url: BaseURL + "fetch_all_book_adm",
            method: "POST",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
            },
        });

    });


});