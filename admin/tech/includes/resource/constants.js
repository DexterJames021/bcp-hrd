const surveyJson = {
    title: "Assessment Survey",
    pages: [{
        elements: [
            {
                type: "rating",
                name: "workforce",
                title: "How satisfied are you with our current workforce policies and support systems?",
                description: "Consider factors like workload balance, career growth opportunities, and workplace culture.",
                rateMax: 5,
                isRequired: true,
                minRateDescription: "Very Dissatisfied",
                maxRateDescription: "Very Satisfied",
                displayMode: "buttons"

            },
            {
                type: "rating",
                name: "performance",
                title: "How would you rate the overall performance of this employee?",
                description: "Consider factors like productivity, quality of work, and collaboration.",
                rateMax: 5,
                isRequired: true,
                minRateDescription: "Needs Improvement",
                maxRateDescription: "Exceeds Expectations",
                displayMode: "buttons"

            },
            {
                type: "rating",
                name: "efficient",
                title: "How would you rate the efficiency of work processes in your department?",
                description: "Consider factors like workflow design, resource allocation, and time management.",
                rateMax: 5,
                isRequired: true,
                minRateDescription: "Highly Inefficient",
                maxRateDescription: "Highly Efficient",
                displayMode: "buttons"

            },
            {
                type: "rating",
                name: "talent",
                title: "How satisfied are you with our talent development programs and growth opportunities?",
                description: "Consider factors like training programs, career advancement, mentorship, and skill development resources.",
                rateMax: 5,
                isRequired: true,
                "minRateDescription": "Very Dissatisfied",
                "maxRateDescription": "Very Satisfied",     
                displayMode: "buttons"

            },
            {
                type: "rating",
                name: "retention",
                title: "How satisfied are you with your current job and work environment?",
                description: "Consider factors like career growth, work-life balance, compensation, and company culture.",
                rateMax: 5,
                isRequired: true,
                "minRateDescription": "Very Dissatisfied",
                "maxRateDescription": "Very Satisfied",
                displayMode: "buttons"

            },
            {
                type: "rating",
                title: "How would you rate your experience using our application services?",
                description: "Consider factors like ease of use, speed, reliability, and feature availability.",
                rateMax: 5,
                isRequired: true,
                minRateDescription: "Very Difficult",
                maxRateDescription: "Very Easy",
                displayMode: "buttons"

            },
            {
                type: "comment",
                name: "suggestions",
                title: "Additional Comments/Suggestions"
            }
        ]
    }]
};

const REPORT_TEMPLATES = {
    resources: {
        title: "assets/resources usage",
        template: `FORMAL : Generate a structured assets/resources usage report based only on the provided data.  
        - Date today: {date}  
        - Document Table of Logs (Use only this data, do not invent any additional logs):  
        {logs}  
    
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
    facility: {
        title: "facility usage",
        template: `Generate a structured facility usage report based only on the provided data.  
        - Date today: {date}  
        - Document Table of Logs (Use only this data, do not invent any additional logs):  
        {logs}  
    
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
    analytics: {
        title: "Job analysis",
        template: `Generate a structured Job analysis report based only on the provided data.  
        - Date today: {date}  
        - Document Table of Logs (Use only this data, do not invent any additional logs):  
        {logs}  
    
        Follow this format:  
        ----------------------  
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
