// Function to fetch screening_date and consent_date from the database
function fetchDates() {
    const urlParams = new URLSearchParams(window.location.search);
    clientId = urlParams.get('sid'); // "sid" should match the URL parameter name

    fetch(`fetch_dates.php?client_id=${clientId}`) // Replace with your PHP endpoint
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.screeningDate = new Date(data.screening_date);
                window.consentDate = new Date(data.consent_date);
            } else {
                console.error('Failed to fetch dates:', data.message);
            }
        })
        .catch(error => console.error('Error fetching dates:', error));
}

// Fetch dates when the form is loaded
fetchDates();

// Function to calculate age from date of birth
function updateAge() {
    const dobInput = document.getElementById('dob');
    const ageInput = document.getElementById('age');
    const dobError = document.getElementById('dob_error');

    if (dobInput.value) {
        const dob = new Date(dobInput.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        if (age < 18) {
            dobError.textContent = "Age cannot be less than 18 years.";
            ageInput.value = '';
        } else {
            dobError.textContent = '';
            ageInput.value = age;
        }
    }
}

// Function to calculate date of birth from age
function updateDob() {
    const ageInput = document.getElementById('age');
    const dobInput = document.getElementById('dob');
    const ageError = document.getElementById('age_error');

    if (ageInput.value) {
        const age = parseInt(ageInput.value);
        if (age < 18) {
            ageError.textContent = "Age cannot be less than 18 years.";
            dobInput.value = '';
        } else {
            ageError.textContent = '';
            const today = new Date();
            const birthYear = today.getFullYear() - age;
            dobInput.value = `${birthYear}-01-01`; // Default to January 1st of the calculated year
        }
    }
}

// Function to validate enrollment date
function validateEnrollmentDate() {
    const enrollmentDateInput = document.getElementById('enrollment_date');
    const enrollmentDateError = document.getElementById('enrollment_date_error');

    if (enrollmentDateInput.value && window.screeningDate && window.consentDate) {
        const enrollmentDate = new Date(enrollmentDateInput.value);

        if (enrollmentDate < window.consentDate) {
            enrollmentDateError.textContent = "Enrollment date cannot be less than consent date.";
            // if (enrollmentDate < window.screeningDate || enrollmentDate < window.consentDate) {
            //     enrollmentDateError.textContent = "Enrollment date cannot be less than screening or consent date.";
            return false;
        } else if (enrollmentDate > new Date()) {
            enrollmentDateError.textContent = "Enrollment date cannot be more than today's date.";
            return false;
        } else {
            enrollmentDateError.textContent = '';
            return true;
        }
    }
    return false;
}

// Form submission validation
document.getElementById('enrollment').addEventListener('submit', function (event) {
    if (!validateEnrollmentDate()) {
        event.preventDefault();
    }

    const ageInput = document.getElementById('age');
    if (ageInput.value && ageInput.value < 18) {
        document.getElementById('age_error').textContent = "Age cannot be less than 18 years.";
        event.preventDefault();
    }
});