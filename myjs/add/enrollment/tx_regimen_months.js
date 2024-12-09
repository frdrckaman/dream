document.addEventListener('DOMContentLoaded', () => {
    const regimen_monthsInput = document.getElementById('regimen_months');
    const regimen_months_unknownCheckbox = document.getElementById('regimen_months_unknown');

    // Toggle Month and Year inputs based on Unknown checkbox
    regimen_months_unknownCheckbox.addEventListener('change', () => {
        if (regimen_months_unknownCheckbox.checked) {
            // Clear and disable inputs when "Unknown" is checked
            regimen_monthsInput.value = '';
            regimen_monthsInput.disabled = true;
        } else {
            // Enable inputs when "Unknown" is unchecked
            regimen_monthsInput.disabled = false;
        }
    });

    // Initial state check (for pre-filled values)
    if (regimen_months_unknownCheckbox.checked) {
        regimen_monthsInput.disabled = true;
    }
});



