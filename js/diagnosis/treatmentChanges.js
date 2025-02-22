// Handle Add Medication Form
document.getElementById('addMedForm_Ajax').addEventListener('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    fetch('handle_diagnosis.php', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#addMedModal').modal('hide');
                refreshTable();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
});

// Handle Update Forms using Event Delegation
document.addEventListener('submit', function (e) {
    if (e.target.matches('.update-form')) {
        e.preventDefault();
        let formData = new FormData(e.target);
        formData.append('update_drug_changes', '1');
        fetch('handle_diagnosis.php', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $(e.target).closest('.modal').modal('hide');
                    refreshTable();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

// Handle Delete Forms
document.addEventListener('submit', function (e) {
    if (e.target.matches('.delete-form')) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete this entry?')) return;
        let formData = new FormData(e.target);
        formData.append('delete_drug_changes', '1');
        fetch('handle_diagnosis.php', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $(e.target).closest('.modal').modal('hide');
                    refreshTable();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

// Refresh Table Function
function refreshTable() {
    fetch('get_treatment_changes.php?sid=<?= $_GET['sid'] ?>', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('tbody').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
}