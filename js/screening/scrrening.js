document.getElementById('validation').addEventListener('submit', function (event) {
    let isValid = true;

    // Clear previous error messages
    document.querySelectorAll('.text-danger').forEach(function (error) {
        error.style.display = 'none';
    });

    // Check if PID1 and PID2 match
    const pid1 = document.getElementById('pid1').value;
    const pid2 = document.getElementById('pid2').value;
    if (pid1 !== pid2) {
        document.getElementById('pid1_error').style.display = 'block';
        document.getElementById('pid2_error').style.display = 'block';
        isValid = false;
    }

    // Check if screening date is not more than today
    const screeningDate = new Date(document.getElementById('screening_date').value);
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset time part to ensure comparison is based on date only
    if (screeningDate > today) {
        document.getElementById('screening_date_error').style.display = 'block';
        isValid = false;
    }

    // Check if consent date is required
    const consentYes = document.querySelector('input[name="conset"]:checked');
    if (consentYes && consentYes.value === '1') { // Assuming '1' is the value for 'Yes'
        const consentDate = document.getElementById('conset_date').value;
        if (!consentDate) {
            document.getElementById('conset_date_error').style.display = 'block';
            isValid = false;
        }
    }

    // Prevent form submission if any validation fails
    if (!isValid) {
        event.preventDefault();
    }
});