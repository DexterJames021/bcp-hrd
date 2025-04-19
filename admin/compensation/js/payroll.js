function openPaySummaryModal() {
    document.getElementById('paySummaryModal').style.display = 'flex';
}

function closePaySummaryModal() {
    document.getElementById('paySummaryModal').style.display = 'none';
}

// Open the modal and display the employee's name
function openGenerateModal(employeeName) {
    const modal = document.getElementById('generateModal');
    const employeeNameElement = document.getElementById('employeeName');

    employeeNameElement.innerText = `Employee: ${employeeName}`;
    modal.style.display = 'flex'; // Show the modal
}

// Close the modal
function closeGenerateModal() {
    const modal = document.getElementById('generateModal');
    modal.style.display = 'none'; // Hide the modal
}

// Handle Generate button click
function submitGenerateForm() {
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;

    alert(`Generating report for ${month} ${year}`);
    closeGenerateModal(); // Close the modal after generating
}