$(function () {

    const BaseURLREs = "../includes/encode/resources_api.php?action="

    const BaseURLFac = "../includes/encode/facility_api.php?action="

    const GenURL = "../includes/encode/report_api.php?action="

    let generatedReport = "";

    $("#ResourcesGenerateBtn").on("click", function () {
        let filterType = $("#filter").val();

        $("#loading").show();
        $("#aiResponse").text("");
        $("#downloadBtn").hide();

        $.ajax({
            url: BaseURLREs + "fetch_all_request",
            method: "POST",
            dataType: "JSON",
            success: function (logs) {
                console.log("Logs received:", logs);
                processLogsForAIRes(logs, filterType);
            },
            error: function () {
                alert("Error fetching facility logs.");
                $("#loading").hide();
            }
        });
    });

    $("#generateBtn").on("click", function () {
        let filterType = $("#filter").val();

        $("#loading").show();
        $("#aiResponse").text("");
        $("#downloadBtn").hide();

        $.ajax({
            url: BaseURLFac + "fetch_all_book_adm",
            method: "POST",
            dataType: "JSON",
            success: function (logs) {
                console.log("Logs received:", logs);
                processLogsForAI(logs, filterType);
            },
            error: function () {
                alert("Error fetching facility logs.");
                $("#loading").hide();
            }
        });
    });

    function processLogsForAI(logs, filterType) {
        let filteredLogs = filterLogs(logs, filterType);
        let logSummary = JSON.stringify(filteredLogs, null, 2);

        $.ajax({
            url: GenURL,
            method: "POST",
            data: {
                message: `Generate a structured facility usage report based only on the provided data.  
                - Date today: ${new Date().toISOString().split("T")[0]}  
                - Document Table of Logs (Use only this data, do not invent any additional logs):  
                ${logSummary}  
            
                Follow this format:  
                ----------------------  
                Date: [YYYY-MM-DD]  
            
                Analysis:  
                - Summarize key trends based on the provided data.

                Facility Usage Summary:  
                - Facility: [Name]  
                - Usage: [Purpose]  
                - Time: [Start - End]  
                - Attendees: [Count]    
            
                Suggestions:  
                - Recommend optimizations based on the most and least used facilities.  
                Do not create new data. Only analyze and summarize the given log data.`
            },
            dataType: "json",
            success: function (response) {
                console.log("AI Response:", response);
                if (response.error) {
                    $("#aiResponse").text("AI Error: " + response.error);
                    $("#error").toast("show")
                } else {
                    generatedReport = response.candidates[0].content.parts[0].text;
                    let previewText = generatedReport.substring(0, 200) + "...";
                    $("#aiResponse").text("GENERATE COMPLETE :" + previewText);
                    $("#loading").hide();
                    $("#downloadBtn").show();
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", xhr.responseText);
                $("#aiResponse").text("Error: " + xhr.responseText);
                $("#loading").hide();
            }
        });

    }

    function processLogsForAIRes(logs, filterType) {
        let filteredLogs = filterLogs(logs, filterType);
        let logSummary = JSON.stringify(filteredLogs, null, 2);

        $.ajax({
            url: GenURL,
            method: "POST",
            data: {
                message: `FORMAL : Generate a structured assets/resources usage report based only on the provided data.  
                - Date today: ${new Date().toISOString().split("T")[0]}  
                - Document Table of Logs (Use only this data, do not invent any additional logs):  
                ${logSummary}  
            
                Follow this format:  
                ----------------------  
                Date: [YYYY-MM-DD]  

                Analysis:  
                - Summarize key trends based on the provided data. 
            
                Resources Usage Summary:  
                - assets: [Name]  
                - Usage: [Purpose]  
                - Time: [Start - End]   
            
                Suggestions:  
                - Recommend optimizations based on the most and least used resources.  
                Do not create new data. Only analyze and summarize the given log data.`
            },
            dataType: "json",
            success: function (response) {
                console.log("AI Response:", response);
                if (response.error) {
                    $("#aiResponse").text("AI Error: " + response.error);
                    $("#error").toast("show")
                } else {
                    generatedReport = response.candidates[0].content.parts[0].text;
                    let previewText = generatedReport.substring(0, 200) + "...";
                    $("#aiResponse").text("GENERATE COMPLETE :" + previewText);
                    $("#loading").hide();
                    $("#downloadBtn").show();
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", xhr.responseText);
                $("#aiResponse").text("Error: " + xhr.responseText);
                $("#loading").hide();
            }
        });

    }

    function filterLogs(logs, type) {
        let today = new Date().toISOString().split("T")[0];
        console.log('filter type', type);
        if (type === "today") {
            return logs.filter(log => log.booking_date === today);
        } else if (type === "weekly") {
            let oneWeekAgo = new Date();
            oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
            return logs.filter(log => new Date(log.booking_date) >= oneWeekAgo);
        } else if (type === "monthly") {
            let firstDayOfMonth = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
            return logs.filter(log => new Date(log.booking_date) >= firstDayOfMonth);
        }
        return logs;
    }

    $("#downloadBtn").on("click", function () {
        let blob = new Blob([generatedReport], { type: "text/plain" });
        let link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = `Log_Report ${new Date().getDate()}.pdf`;
        link.click();
    });


});