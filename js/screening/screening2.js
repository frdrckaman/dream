document.getElementById('validation').addEventListener('submit', function (event) {
    // Check if PID1 and PID2 match
    const pid1 = document.getElementById('pid1').value;
    const pid2 = document.getElementById('pid2').value;
    if (pid1 !== pid2) {
        alert('PID1 and PID2 do not match. Please re-enter the PID.');
        event.preventDefault();
        return;
    }

    // Check if screening date is not more than today
    const screeningDate = new Date(document.getElementById('screening_date').value);
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset time part to ensure comparison is based on date only
    if (screeningDate > today) {
        alert('Screening date cannot be more than today.');
        event.preventDefault();
        return;
    }

    // Check if consent date is required
    const consentYes = document.querySelector('input[name="conset"]:checked');
    if (consentYes && consentYes.value === '1') { // Assuming '1' is the value for 'Yes'
        const consentDate = document.getElementById('conset_date').value;
        if (!consentDate) {
            alert('Consent date is required if consent is selected as "Yes".');
            event.preventDefault();
            return;
        }
    }
});