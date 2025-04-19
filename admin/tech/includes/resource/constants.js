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