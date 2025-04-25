$(function () {
    console.log('ID @@@@@@@@@@@@', user_id);
    const baseURI = "../../admin/tech/includes/encode/users_api.php?action=";

    const survey = new Survey.Model(surveyJson);
    // survey_response
    survey.onComplete.add((sender) => {
        const survey_data = sender.data;
        
        console.log('DATA @@@@@@@@@@', sender.data), ", USERID",user_id;

        $.post(baseURI + "survey_response", {
            user_id: user_id,
            survey_data: survey_data
        }, function (response) {
            if (response.message) {
                // $("#added").toast("show")
                console.log("response", response.message)
            } else {
                $("#error").toast("show")
            }
        }, "json")

    });


    $("#startSurveyBtn").on("click", function(){
        survey.render("surveyContainer");
        $("#surveyContainer").show()
        $(".initial").hide();

    })


});