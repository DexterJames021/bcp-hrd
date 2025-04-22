$(function () {
    const BaseUrl = "./includes/encode/users_api.php?action=";

    function fetchData() {
        return $.post(BaseUrl + "survey_manage_adm")
            .then(response => {
                const surveyData = JSON.parse(response);
                console.log('Data loaded:', surveyData);
                
                return surveyData.map(item => {
                    const data = JSON.parse(item.survey_data);
                    return {
                        ...data,
                        workforce: parseInt(data.workforce),
                        performance: parseInt(data.performance),
                        efficient: parseInt(data.efficient),
                        talent: parseInt(data.talent),
                        retention: parseInt(data.retention),
                        question1: parseInt(data.question1),
                        username: item.username,
                        submissionDate: item.submission_date
                    };
                });
            });
    }

    function createRatingTable(questionName, questionTitle, results) {
        const counts = [0, 0, 0, 0, 0];
        results.forEach(result => {
            const rating = result[questionName];
            if (rating >= 1 && rating <= 5) {
                counts[rating - 1]++;
            }
        });
        
        const totalResponses = results.length;
        
        // Create table HTML
        let tableHTML = `
            <div class="rating-table-container col-lg-12 col-md-12 col-12">
                <h4>${questionTitle}</h4>
                <table class="table table-sm table-bordered table-striped rating-table">
                    <thead class="thead-light">
                        <tr>
                            <th>Rating</th>
                            <th>Responses</th>
                            <th>Percentage</th>
                            <th>Visual</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        // Add rows for each rating level
        const ratingLabels = [
            "1 - Very Dissatisfied",
            "2 - Dissatisfied",
            "3 - Neutral",
            "4 - Satisfied",
            "5 - Very Satisfied"
        ];
        
        ratingLabels.forEach((label, index) => {
            const count = counts[index];
            const percentage = totalResponses > 0 ? ((count / totalResponses) * 100).toFixed(1) : 0;
            
            tableHTML += `
                <tr>
                    <td>${label}</td>
                    <td>${count}</td>
                    <td>${percentage}%</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: ${percentage}%" 
                                 aria-valuenow="${percentage}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        // Add summary row
        const averageRating = totalResponses > 0 
            ? results.reduce((sum, result) => sum + result[questionName], 0) / totalResponses
            : 0;
            
        tableHTML += `
                    <tr class="summary-row">
                        <td><strong>Average</strong></td>
                        <td colspan="3"><strong>${averageRating.toFixed(2)} / 5</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        `;
        
        return tableHTML;
    }

    function initializeAnalytics() {
        fetchData().then(results => {
            const survey = new Survey.Model(surveyJson);
            const container = document.getElementById("surveyDashboardContainer");
            
            // Clear container
            container.innerHTML = `
            <div class="d-flex justify-content-between">
                <h2 class="py-4">Survey Results Dashboard</h2>
                <span>
                    <button class="btn btn-outline-primary " onclick="window.print()">Print</button>
                </span>
            </div>`;
            
            // Create tables for each rating question
            const ratingQuestions = survey.getAllQuestions().filter(q => q.getType() === 'rating');
            
            ratingQuestions.forEach(question => {
                const tableHTML = createRatingTable(question.name, question.title, results);
                container.innerHTML += tableHTML;
            });
            
            // Add the standard visualization panel
            const vizPanel = new SurveyAnalytics.VisualizationPanel(
                survey.getAllQuestions(),
                results,
                { allowHideQuestions: false }
            );
            
            const vizContainer = document.createElement('div');
            vizContainer.className = 'viz-container';
            vizContainer.innerHTML = '<h3>Detailed Visualizations</h3>';
            container.appendChild(vizContainer);
            
            vizPanel.showToolbar = true;
            vizPanel.render(vizContainer);
            
        }).catch(error => {
            console.error('Error loading survey data:', error);
            $('#surveyDashboardContainer').html(`
                <div class="alert alert-danger">
                    <h4>Error loading survey results</h4>
                    <p>${error.message || 'Please try again later.'}</p>
                </div>
            `);
        });
    }

    // Initialize the analytics when the page loads
    initializeAnalytics();
});