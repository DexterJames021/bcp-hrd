-- Total Number of Employees
-- stat
SELECT 
    COUNT(*) AS TotalEmployees
FROM 
    employees;

-- Total of Department
-- stat
SELECT
  COUNT(*) AS "Department"
FROM
  `bcp-hrd`.departments
LIMIT
  50

--Applicant Status Distribution
--pie chart
  SELECT 
    status, 
    COUNT(*) AS status_count
FROM 
    applicants
GROUP BY 
    status;

--Employee Performance Scores
-- bar chart
    SELECT CONCAT(e.FirstName, ' ', e.LastName) AS FullName,
     pe.Score, pe.EvaluationDate 
     FROM employees e 
     LEFT JOIN performanceevaluations pe ON e.EmployeeID = pe.EmployeeID 
     ORDER BY pe.EvaluationDate; 

-- Employee Performance vs Compensation
--XY chart
SELECT e.EmployeeID, CONCAT(e.FirstName, ' ', e.LastName) AS FullName,
    pe.Score, (cb.BaseSalary + cb.Bonus) AS TotalCompensation
    FROM employees e
   LEFT JOIN performanceevaluations pe ON e.EmployeeID = pe.EmployeeID 
   LEFT JOIN compensationbenefits cb ON e.EmployeeID = cb.EmployeeID 
   ORDER BY pe.Score DESC; 


--Number of Applicants per Job Posting
--var chart
   SELECT 
    jp.job_title, 
    COUNT(a.id) AS applicant_count
FROM 
    job_postings jp
LEFT JOIN 
    applicants a ON jp.id = a.job_id
GROUP BY 
    jp.job_title
ORDER BY 
    applicant_count DESC;

--Employee Attendance and Leave Trends
-- time series
    SELECT Date, SUM(CASE WHEN Status = 'Present' THEN 1 ELSE 0 END) AS Present,
    SUM(CASE WHEN Status = 'Absent' THEN 1 ELSE 0 END) AS `Absent`,
    SUM(CASE WHEN Status = 'Leave' THEN 1 ELSE 0 END) AS `Leave` 
    FROM attendanceleave 
    GROUP BY Date 
    ORDER BY Date; 


-- Employee Compensation and Benefits
-- table
    SELECT e.EmployeeID, CONCAT(e.FirstName, ' ', e.LastName) AS FullName,
     cb.BaseSalary,
     cb.Bonus, 
     cb.BenefitValue 
     FROM employees e 
     LEFT JOIN compensationbenefits cb ON e.EmployeeID = cb.EmployeeID; 