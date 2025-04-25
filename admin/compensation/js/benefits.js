var modal = document.getElementById("myModal");
    var btn = document.getElementById("openModalBtn");
    var closeBtn = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    closeBtn.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editBtn');
    const deleteButtons = document.querySelectorAll('.deleteBtn');
    const modal = document.getElementById('benefitModal');
    const form = document.getElementById('addBenefitForm');
    const benefitTypeInput = document.getElementById('benefitType');
    const amountInput = document.getElementById('amount');
    const cancelBtn = document.getElementById('cancelBtn');
    
    let currentBenefitId = null;

    // Show modal and populate the form for editing
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentBenefitId = this.getAttribute('data-id');
            const benefitType = this.closest('tr').querySelector('td:first-child').textContent;
            const amount = this.closest('tr').querySelector('td:nth-child(2)').textContent;

            benefitTypeInput.value = benefitType;
            amountInput.value = amount;
            modal.style.display = 'block';
        });
    });

    // Handle form submission for both adding and editing
    form.onsubmit = function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        if (currentBenefitId) {
            formData.append('benefitId', currentBenefitId); // Add the current benefit ID if it's an edit
        }

        fetch('benefits.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Benefit ' + (currentBenefitId ? 'updated' : 'added') + ' successfully!');
                modal.style.display = 'none';
                form.reset();
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the benefit');
        });
    };

    // Cancel button to close modal
    cancelBtn.onclick = function() {
        modal.style.display = 'none';
    };

    // Handle delete action
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const benefitId = this.getAttribute('data-id');
            const confirmDelete = confirm("Are you sure you want to delete this benefit?");
            
            if (confirmDelete) {
                fetch('benefits.php', {
                    method: 'POST',
                    body: JSON.stringify({ action: 'delete', benefitId: benefitId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Benefit deleted successfully!');
                        location.reload(); // Reload to reflect changes
                    } else {
                        alert('Error deleting benefit: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the benefit');
                });
            }
        });
    });
});
//edit and delete
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editBtn');
    const deleteButtons = document.querySelectorAll('.deleteBtn');
    const modal = document.getElementById('benefitModal');
    const form = document.getElementById('addBenefitForm');
    const benefitTypeInput = document.getElementById('benefitType');
    const amountInput = document.getElementById('amount');
    const cancelBtn = document.getElementById('cancelBtn');
    
    let currentBenefitId = null;

    // Show modal and populate the form for editing
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentBenefitId = this.getAttribute('data-id');
            const benefitType = this.closest('tr').querySelector('td:first-child').textContent;
            const amount = this.closest('tr').querySelector('td:nth-child(2)').textContent;

            benefitTypeInput.value = benefitType;
            amountInput.value = amount;
            modal.style.display = 'block';
        });
    });

    // Handle form submission for both adding and editing
    form.onsubmit = function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        if (currentBenefitId) {
            formData.append('benefitId', currentBenefitId); // Add the current benefit ID if it's an edit
        }

        fetch('benefits.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Benefit ' + (currentBenefitId ? 'updated' : 'added') + ' successfully!');
                modal.style.display = 'none';
                form.reset();
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the benefit');
        });
    };

    // Cancel button to close modal
    cancelBtn.onclick = function() {
        modal.style.display = 'none';
    };

    // Handle delete action
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const benefitId = this.getAttribute('data-id');
            const confirmDelete = confirm("Are you sure you want to delete this benefit?");
            
            if (confirmDelete) {
                fetch('benefits.php', {
                    method: 'POST',
                    body: JSON.stringify({ action: 'delete', benefitId: benefitId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Benefit deleted successfully!');
                        location.reload(); // Reload to reflect changes
                    } else {
                        alert('Error deleting benefit: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the benefit');
                });
            }
        });
    });
});