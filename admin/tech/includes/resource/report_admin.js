$(function () {
    const API_ENDPOINTS = {
        resources: "../includes/encode/resources_api.php?action=fetch_all_request",
        facility: "../includes/encode/facility_api.php?action=fetch_all_book_adm",
        analytics: "/bcp-hrd/admin/tech/includes/encode/analytic_api.php?action=job_posting",
        generate: "/bcp-hrd/admin/tech/includes/encode/report_api.php?action="
    
    };

    const REPORT_TEMPLATES = {
        resources: {
            title: "assets/resources usage",
            template: `FORMAL : Generate a structured narative summary of assets/resources usage report based only on the provided data.  
            - Date today: {date}  
            - Document Table of Logs (Use only this data, do not invent any additional logs):  
            {logs}  
        
            Follow this format:
              
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
        facility: {
            title: "facility usage",
            template: `Generate a structured narative summary of facility usage report based only on the provided data.  
            - Date today: {date}  
            - Document Table of Logs (Use only this data, do not invent any additional logs):  
            {logs}  
        
            Follow this format:
              
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
        analytics: {
            title: "Job analysis",
            template: `Generate a structured narative summary of Job analysis report based only on the provided data.  
            - Date today: {date}  
            - Document Table of Logs (Use only this data, do not invent any additional logs):  
            {logs}  
        
            Follow this format:
              
            Date: [YYYY-MM-DD]  
        
            Analysis:  
            - Summarize key trends based on the provided data.

            Top 10 Trend Usage Summary (least and most):  
            - Job Title: [Name]  
        
            Suggestions:  
            - Recommend optimizations based on the most and least job opportunity.  
            Do not create new data. Only analyze and summarize the given log data.`
        }
    };

    let generatedReport = "";

    $("#ResourcesGenerateBtn").on("click", () => fetchAndProcessLogs("resources"));
    $("#AnalysisGenerateBtn").on("click", () => fetchAndProcessLogs("analytics"));
    $("#generateBtn").on("click", () => fetchAndProcessLogs("facility"));
    $("#downloadBtn").on("click", downloadReport);

    function fetchAndProcessLogs(type) {
        const filterType = $("#filter").val();
        
        $("#loading").show();
        $("#aiResponse").text("");
        $("#downloadBtn").hide();

        $.ajax({
            url: API_ENDPOINTS[type],
            method: "POST",
            dataType: "JSON",
            success: (logs) => {
                console.log("Logs received:", logs);
                processLogsForAI(logs, filterType, type);
            },
            error: () => {
                alert(`Error fetching ${REPORT_TEMPLATES[type].title} logs.`);
                $("#loading").hide();
            }
        });
    }

    function processLogsForAI(logs, filterType, reportType) {
        const filteredLogs = filterLogs(logs, filterType);
        const logSummary = JSON.stringify(filteredLogs, null, 2);
        const today = new Date().toISOString().split("T")[0];
        
        const message = REPORT_TEMPLATES[reportType].template
            .replace('{date}', today)
            .replace('{logs}', logSummary);

        $.ajax({
            url: API_ENDPOINTS.generate,
            method: "POST",
            data: { message },
            dataType: "json",
            success: function (response) {
                console.log("AI Response:", response);
                if (response.error) {
                    $("#aiResponse").text("AI Error: " + response.error);
                    $("#error").toast("show");
                } else {
                    generatedReport = response.candidates[0].content.parts[0].text;
                    const previewText = generatedReport.substring(0, 200) + "...";
                    $("#aiResponse").text("GENERATE COMPLETE :" + previewText);
                    $("#loading").hide();
                    $("#downloadBtn").show();
                }
            },
            error: function (xhr) {
                console.log("AJAX Error:", xhr.responseText);
                $("#aiResponse").text("Error: " + xhr.responseText);
                $("#loading").hide();
            }
        });
    }

    function filterLogs(logs, type) {
        const today = new Date().toISOString().split("T")[0];
        console.log('filter type', type);
        
        if (type === "today") {
            return logs.filter(log => log.booking_date === today);
        } else if (type === "weekly") {
            const oneWeekAgo = new Date();
            oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
            return logs.filter(log => new Date(log.booking_date) >= oneWeekAgo);
        } else if (type === "monthly") {
            const firstDayOfMonth = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
            return logs.filter(log => new Date(log.booking_date) >= firstDayOfMonth);
        }
        return logs;
    }

    function downloadReport() {
        const blob = new Blob([generatedReport], { type: "text/plain" });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = `Log_Report_${new Date().getDate()}.pdf`;
        link.click();
    }
});