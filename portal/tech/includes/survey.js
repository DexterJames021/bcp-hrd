document.addEventListener('DOMContentLoaded', function () {
    const surveyJson = {
        title: "Workplace Evaluation Survey",
        pages: [{
            elements: [
                {
                    type: "rating",
                    name: "workplace",
                    title: "Workplace Environment Satisfaction",
                    rateMax: 5
                },
                {
                    type: "rating",
                    name: "facilities",
                    title: "Facilities Quality Rating",
                    rateMax: 5
                },
                {
                    type: "rating",
                    name: "ergonomics",
                    title: "Workstation Ergonomics",
                    rateMax: 5
                },
                {
                    type: "rating",
                    name: "satisfaction",
                    title: "Overall Job Satisfaction",
                    rateMax: 5
                },
                {
                    type: "rating",
                    name: "admin_services",
                    title: "Administrative Services Rating",
                    rateMax: 5
                },
                {
                    type: "comment",
                    name: "suggestions",
                    title: "Additional Comments/Suggestions"
                }
            ]
        }]
    };

    console.log("Survey container:", document.getElementById('surveyContainer'));

    const survey = new Survey.Model(surveyJson);

    // Apply theme correctly (if needed)
    Survey.StylesManager.applyTheme("modern");
    survey.render("surveyContainer");

    survey.onComplete.add((sender) => {
        fetch("save_survey.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(sender.data)
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            survey.showCompletedPage();
        })
        .catch(error => {
            alert("Submission failed: " + error.message);
        });
    });
});