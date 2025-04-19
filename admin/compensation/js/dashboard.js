let salaryChart;
let allData;

document.addEventListener('DOMContentLoaded', function() {
    // Fetch data from the PHP file
    fetchData();
    
    // Add event listener for position filter
    document.getElementById('positionFilter').addEventListener('change', function() {
        filterByPosition(this.value);
    });
});

function fetchData() {
    // In a real application, this would fetch data from the PHP file
    // For demonstration, we'll use a timeout to simulate an AJAX request
    setTimeout(() => {
        // This would normally come from the PHP response
        allData = {
            positions: [
                { id: 1, position: "Software Developer", date: "2024-01-15", min_salary: 65000, max_salary: 120000 },
                { id: 2, position: "Project Manager", date: "2024-01-15", min_salary: 75000, max_salary: 130000 },
                { id: 3, position: "Data Analyst", date: "2024-01-15", min_salary: 60000, max_salary: 110000 },
                { id: 4, position: "UX Designer", date: "2024-01-15", min_salary: 62000, max_salary: 115000 },
                { id: 5, position: "DevOps Engineer", date: "2024-01-15", min_salary: 70000, max_salary: 125000 },
                { id: 6, position: "Software Developer", date: "2023-07-15", min_salary: 62000, max_salary: 115000 },
                { id: 7, position: "Project Manager", date: "2023-07-15", min_salary: 72000, max_salary: 125000 },
                { id: 8, position: "Data Analyst", date: "2023-07-15", min_salary: 58000, max_salary: 105000 },
                { id: 9, position: "UX Designer", date: "2023-07-15", min_salary: 60000, max_salary: 110000 },
                { id: 10, position: "DevOps Engineer", date: "2023-07-15", min_salary: 68000, max_salary: 120000 },
                { id: 11, position: "Software Developer", date: "2023-01-15", min_salary: 60000, max_salary: 110000 },
                { id: 12, position: "Project Manager", date: "2023-01-15", min_salary: 70000, max_salary: 120000 },
                { id: 13, position: "Data Analyst", date: "2023-01-15", min_salary: 55000, max_salary: 100000 },
                { id: 14, position: "UX Designer", date: "2023-01-15", min_salary: 58000, max_salary: 105000 },
                { id: 15, position: "DevOps Engineer", date: "2023-01-15", min_salary: 65000, max_salary: 115000 }
            ],
            lastUpdated: "2024-04-05 12:30:00"
        };
        
        // Update the last updated timestamp
        document.getElementById('lastUpdated').textContent = allData.lastUpdated;
        
        // Populate position filter
        populatePositionFilter(allData.positions);
        
        // Initialize the chart with all data
        initializeChart(allData.positions);
    }, 500);
}

function populatePositionFilter(data) {
    const positionFilter = document.getElementById('positionFilter');
    const positions = [...new Set(data.map(item => item.position))];
    
    positions.forEach(position => {
        const option = document.createElement('option');
        option.value = position;
        option.textContent = position;
        positionFilter.appendChild(option);
    });
}

function filterByPosition(position) {
    if (position === 'all') {
        initializeChart(allData.positions);
    } else {
        const filteredData = allData.positions.filter(item => item.position === position);
        initializeChart(filteredData);
    }
}

function initializeChart(data) {
    // Group data by date
    const dateGroups = {};
    data.forEach(item => {
        if (!dateGroups[item.date]) {
            dateGroups[item.date] = [];
        }
        dateGroups[item.date].push(item);
    });
    
    // Sort dates
    const sortedDates = Object.keys(dateGroups).sort();
    
    // Prepare chart data
    const chartData = {
        labels: sortedDates.map(date => {
            const d = new Date(date);
            return d.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
        }),
        datasets: []
    };
    
    // Get unique positions from filtered data
    const positions = [...new Set(data.map(item => item.position))];
    
    // Create color pairs for min/max datasets
    const colorPairs = [
        { min: 'rgba(13, 110, 253, 0.6)', max: 'rgba(13, 110, 253, 0.2)' },
        { min: 'rgba(25, 135, 84, 0.6)', max: 'rgba(25, 135, 84, 0.2)' },
        { min: 'rgba(220, 53, 69, 0.6)', max: 'rgba(220, 53, 69, 0.2)' },
        { min: 'rgba(255, 193, 7, 0.6)', max: 'rgba(255, 193, 7, 0.2)' },
        { min: 'rgba(111, 66, 193, 0.6)', max: 'rgba(111, 66, 193, 0.2)' }
    ];
    
    // Create datasets for each position
    positions.forEach((position, index) => {
        const colorIndex = index % colorPairs.length;
        const minSalaryData = [];
        const maxSalaryData = [];
        
        sortedDates.forEach(date => {
            const positionData = dateGroups[date].find(item => item.position === position);
            if (positionData) {
                minSalaryData.push(positionData.min_salary);
                maxSalaryData.push(positionData.max_salary);
            } else {
                minSalaryData.push(null);
                maxSalaryData.push(null);
            }
        });
        
        chartData.datasets.push({
            label: `${position} (Min)`,
            data: minSalaryData,
            borderColor: colorPairs[colorIndex].min,
            backgroundColor: 'transparent',
            borderWidth: 2,
            tension: 0.4
        });
        
        chartData.datasets.push({
            label: `${position} (Max)`,
            data: maxSalaryData,
            borderColor: colorPairs[colorIndex].max,
            backgroundColor: 'transparent',
            borderWidth: 2,
            borderDash: [5, 5],
            tension: 0.4
        });
    });
    
    // Destroy existing chart if it exists
    if (salaryChart) {
        salaryChart.destroy();
    }
    
    // Create the chart
    const ctx = document.getElementById('salaryChart').getContext('2d');
    salaryChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    padding: 10,
                    cornerRadius: 6,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('en-US', {
                                    style: 'currency',
                                    currency: 'USD',
                                    maximumFractionDigits: 0
                                }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                maximumFractionDigits: 0
                            }).format(value);
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    radius: 4,
                    hoverRadius: 6
                }
            }
        }
    });
}

function exportChart() {
    // Get the canvas element
    const canvas = document.getElementById('salaryChart');
    
    // Create a temporary link element
    const link = document.createElement('a');
    link.download = 'salary-rates-chart.png';
    
    // Convert the canvas to a data URL and set it as the link's href
    link.href = canvas.toDataURL('image/png');
    
    // Append the link to the body, click it, and then remove it
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}