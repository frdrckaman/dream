document.addEventListener('DOMContentLoaded', function () {
    // Function to toggle consent date visibility
    function toggleConsentDate() {
        const consentYes = document.querySelector('input[name="consent"]:checked')?.value === '1';
        const consentDateSection = document.getElementById('consent_date_section');
        const consentDateInput = document.getElementById('consent_date');

        if (consentYes) {
            consentDateSection.style.display = 'block';
            consentDateInput.required = true;
        } else {
            consentDateSection.style.display = 'none';
            consentDateInput.required = false;
        }
    }

    // Function to update form status visibility
    function updateScreeningFormStatus() {
        const formStatus = document.querySelector('input[id="screening_status"]:checked')?.value;
        const screeningCompleted = document.getElementById('screening_completed');
        const screeningDateCompleted = document.getElementById('screening_date_completed');
        const screeningVerified = document.getElementById('screening_verified');
        const screeningDateVerified = document.getElementById('screening_date_verified');
        const consentDate = document.getElementById('consent_date').value;
        const screeningDate = document.getElementById('screening_date').value;
        const today = new Date().toISOString().split('T')[0];

        if (formStatus == '1') {
            screeningCompleted.style.display = 'none';
            screeningDateCompleted.required = false;
            screeningVerified.style.display = 'none';
            screeningDateVerified.required = false;
        } else if (formStatus == '2') {
            screeningCompleted.style.display = 'block';
            screeningDateCompleted.required = true;
            screeningDateCompleted.min = consentDate ? consentDate : screeningDate;
            screeningDateCompleted.max = today;
            screeningVerified.style.display = 'none';
            screeningDateVerified.required = false;
        } else if (formStatus == '3') {
            screeningCompleted.style.display = 'block';
            screeningDateCompleted.required = true;
            screeningDateCompleted.min = consentDate ? consentDate : screeningDate;
            screeningDateCompleted.max = today;
            screeningVerified.style.display = 'block';
            screeningDateVerified.required = true;
            screeningDateVerified.min = consentDate ? consentDate : screeningDate;
            screeningDateVerified.max = today;
        } else {
            screeningCompleted.style.display = 'none';
            screeningDateCompleted.required = false;
            screeningVerified.style.display = 'none';
            screeningDateVerified.required = false;
        }
    }

    // Initial check on page load
    toggleConsentDate();
    updateScreeningFormStatus();

    // Add event listeners to consent radios
    document.querySelectorAll('input[name="consent"]').forEach(radio => {
        radio.addEventListener('change', toggleConsentDate);
    });

    // Add event listeners to form status radios
    document.querySelectorAll('input[id="screening_status"]').forEach(radio => {
        radio.addEventListener('change', updateScreeningFormStatus);
    });

    // Form validation
    document.getElementById('screening').addEventListener('submit', function (e) {
        const consentYes = document.querySelector('input[name="consent"]:checked')?.value === '1';
        const consentDate = document.getElementById('consent_date').value;
        const screeningDate = document.getElementById('screening_date').value;
        const screeningDateCompleted = document.getElementById('screening_date_completed').value;
        const screeningDateVerified = document.getElementById('screening_date_verified').value;
        const consentDateErrorElement = document.getElementById('consent_date_error');
        const screeningDateErrorElement = document.getElementById('screening_date_error');
        const dateCompletedErrorElement = document.getElementById('date_completed_error');
        const dateVerifiedErrorElement = document.getElementById('screening_date_verified_error');
        const today = new Date().toISOString().split('T')[0];

        let valid = true;

        // Validate screening date
        if (screeningDate < '2025-01-20' || screeningDate > today) {
            e.preventDefault();
            screeningDateErrorElement.style.display = 'block';
            screeningDateErrorElement.style.color = 'red';
            screeningDateErrorElement.style.marginTop = '5px';
            screeningDateErrorElement.textContent = 'Screening date must be between 2025-01-20 and today.';
            valid = false;
        } else {
            screeningDateErrorElement.style.display = 'none';
            screeningDateErrorElement.textContent = '';
        }

        // Validate consent date
        if (consentYes && (!consentDate || consentDate < screeningDate || consentDate > today)) {
            e.preventDefault();
            consentDateErrorElement.style.display = 'block';
            consentDateErrorElement.style.color = 'red';
            consentDateErrorElement.style.marginTop = '5px';
            consentDateErrorElement.textContent = 'Consent date is required, must be on or after the screening date, and not in the future if consent is selected as "Yes".';
            valid = false;
        } else {
            consentDateErrorElement.style.display = 'none';
            consentDateErrorElement.textContent = '';
        }

        // Validate completed date
        if (screeningDateCompleted && (screeningDateCompleted < (consentDate || screeningDate) || screeningDateCompleted > today)) {
            e.preventDefault();
            dateCompletedErrorElement.style.display = 'block';
            dateCompletedErrorElement.style.color = 'red';
            dateCompletedErrorElement.style.marginTop = '5px';
            dateCompletedErrorElement.textContent = 'Completed date must be on or after the screening date and not in the future.';
            valid = false;
        } else {
            dateCompletedErrorElement.style.display = 'none';
            dateCompletedErrorElement.textContent = '';
        }

        // Validate verified date
        if (screeningDateVerified && (screeningDateVerified < screeningDateCompleted || screeningDateVerified > today)) {
            e.preventDefault();
            dateVerifiedErrorElement.style.display = 'block';
            dateVerifiedErrorElement.style.color = 'red';
            dateVerifiedErrorElement.style.marginTop = '5px';
            dateVerifiedErrorElement.textContent = 'Verified date must be on or after the completed date and not in the future.';
            valid = false;
        } else {
            dateVerifiedErrorElement.style.display = 'none';
            dateVerifiedErrorElement.textContent = '';
        }

        // Ensure form status 3 is only checked if screening date completed has value
        if (formStatus == '3' && !screeningDateCompleted) {
            e.preventDefault();
            dateCompletedErrorElement.style.display = 'block';
            dateCompletedErrorElement.style.color = 'red';
            dateCompletedErrorElement.style.marginTop = '5px';
            dateCompletedErrorElement.textContent = 'Completed date is required for form status 3.';
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    // Real-time validation for consent date
    document.getElementById('consent_date').addEventListener('input', function () {
        const consentDateErrorElement = document.getElementById('consent_date_error');
        consentDateErrorElement.style.display = 'none';
        consentDateErrorElement.textContent = '';
    });

    // Real-time validation for screening date
    document.getElementById('screening_date').addEventListener('input', function () {
        const screeningDateErrorElement = document.getElementById('screening_date_error');
        screeningDateErrorElement.style.display = 'none';
        screeningDateErrorElement.textContent = '';
    });

    // Real-time validation for completed date
    document.getElementById('screening_date_completed').addEventListener('input', function () {
        const dateCompletedErrorElement = document.getElementById('date_completed_error');
        dateCompletedErrorElement.style.display = 'none';
        dateCompletedErrorElement.textContent = '';
    });

    // Real-time validation for verified date
    document.getElementById('screening_date_verified').addEventListener('input', function () {
        const dateVerifiedErrorElement = document.getElementById('screening_date_verified_error');
        dateVerifiedErrorElement.style.display = 'none';
        dateVerifiedErrorElement.textContent = '';
    });
});