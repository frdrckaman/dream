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
        const errorElement = document.getElementById('consent_date_error');

        if (consentYes && (!consentDate || consentDate < screeningDate)) {
            e.preventDefault();
            errorElement.style.display = 'block';
            errorElement.style.color = 'red';
            errorElement.style.marginTop = '5px';
            errorElement.textContent = 'Consent date is required and must be on or after the screening date if consent is selected as "Yes".';
        } else {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }
    });

    // Real-time validation for consent date
    document.getElementById('consent_date').addEventListener('input', function () {
        const errorElement = document.getElementById('consent_date_error');
        errorElement.style.display = 'none';
        errorElement.textContent = '';
    });
});