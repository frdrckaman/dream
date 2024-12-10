document.addEventListener('DOMContentLoaded', () => {
    const ltf_monthsInput = document.getElementById('ltf_months');
    const ltf_months_unknownCheckbox = document.getElementById('ltf_months_unknown');

    // Toggle Month and Year inputs based on Unknown checkbox
    ltf_months_unknownCheckbox.addEventListener('change', () => {
        if (ltf_months_unknownCheckbox.checked) {
            // Clear and disable inputs when "Unknown" is checked
            ltf_monthsInput.value = '';
            ltf_monthsInput.disabled = true;
        } else {
            // Enable inputs when "Unknown" is unchecked
            ltf_monthsInput.disabled = false;
        }
    });

    // Initial state check (for pre-filled values)
    if (ltf_months_unknownCheckbox.checked) {
        ltf_monthsInput.disabled = true;
    }
});
