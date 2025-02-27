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

    // Initial check on page load
    toggleConsentDate();

    // Add event listeners to consent radios
    document.querySelectorAll('input[name="consent"]').forEach(radio => {
        radio.addEventListener('change', toggleConsentDate);
    });

    // Form validation
    document.getElementById('screening').addEventListener('submit', function (e) {
        const consentYes = document.querySelector('input[name="consent"]:checked')?.value === '1';
        const consentDate = document.getElementById('consent_date').value;
        const screeningDate = document.getElementById('screening_date').value;
        const consentDateErrorElement = document.getElementById('consent_date_error');
        const screeningDateErrorElement = document.getElementById('screening_date_error');

        let valid = true;

        // Validate screening date
        if (screeningDate > '2025-01-20') {
            e.preventDefault();
            screeningDateErrorElement.style.display = 'block';
            screeningDateErrorElement.style.color = 'red';
            screeningDateErrorElement.style.marginTop = '5px';
            screeningDateErrorElement.textContent = 'Screening date must be on or before 2025-01-20.';
            valid = false;
        } else {
            screeningDateErrorElement.style.display = 'none';
            screeningDateErrorElement.textContent = '';
        }

        // Validate consent date
        if (consentYes && (!consentDate || consentDate < screeningDate)) {
            e.preventDefault();
            consentDateErrorElement.style.display = 'block';
            consentDateErrorElement.style.color = 'red';
            consentDateErrorElement.style.marginTop = '5px';
            consentDateErrorElement.textContent = 'Consent date is required and must be on or after the screening date if consent is selected as "Yes".';
            valid = false;
        } else {
            consentDateErrorElement.style.display = 'none';
            consentDateErrorElement.textContent = '';
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
});