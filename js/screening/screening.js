// Function to toggle conset_date visibility
function toggleConsetDate() {
    const consetYes = document.querySelector('input[name="conset"]:checked');
    const consetDateContainer = document.getElementById('conset_date_container');
    if (consetYes && consetYes.value === '1') { // Assuming '1' is the value for 'Yes'
        consetDateContainer.style.display = 'block';
    } else {
        consetDateContainer.style.display = 'none';
    }
}

// Add event listeners to conset radio buttons
document.querySelectorAll('input[name="conset"]').forEach(function (radio) {
    radio.addEventListener('change', toggleConsetDate);
});

// Initial check to set conset_date visibility on page load
toggleConsetDate();

// Form submission validation
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

    // Check if screening date is between 2025-01-20 and today
    const screeningDate = new Date(document.getElementById('screening_date').value);
    const startDate = new Date('2025-01-20'); // Start date
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset time part to ensure comparison is based on date only

    if (screeningDate < startDate || screeningDate > today) {
        document.getElementById('screening_date_error').style.display = 'block';
        isValid = false;
    }

    // Check if consent date is required
    const consetYes = document.querySelector('input[name="conset"]:checked');
    if (consetYes && consetYes.value === '1') { // Assuming '1' is the value for 'Yes'
        const consentDate = document.getElementById('conset_date').value;
        const consentDateObj = new Date(consentDate);

        if (!consentDate) {
            // If consent date is empty
            document.getElementById('conset_date_error').style.display = 'block';
            isValid = false;
        } else if (consentDateObj > today) {
            // If consent date is in the future
            document.getElementById('conset_date_error').textContent = 'Consent date cannot be in the future.';
            document.getElementById('conset_date_error').style.display = 'block';
            isValid = false;
        } else {
            // If consent date is valid (today or earlier)
            document.getElementById('conset_date_error').style.display = 'none';
        }
    }

    // Prevent form submission if any validation fails
    if (!isValid) {
        event.preventDefault();
    }
});