document.addEventListener('DOMContentLoaded', () => {
    const txMonthInput = document.getElementById('tx_month');
    const txYearInput = document.getElementById('tx_year');
    const txUnknownCheckbox = document.getElementById('tx_unknown');

    // Toggle Month and Year inputs based on Unknown checkbox
    txUnknownCheckbox.addEventListener('change', () => {
        if (txUnknownCheckbox.checked) {
            // Clear and disable inputs when "Unknown" is checked
            txMonthInput.value = '';
            txYearInput.value = '';
            txMonthInput.disabled = true;
            txYearInput.disabled = true;
        } else {
            // Enable inputs when "Unknown" is unchecked
            txMonthInput.disabled = false;
            txYearInput.disabled = false;
        }
    });

    // Initial state check (for pre-filled values)
    if (txUnknownCheckbox.checked) {
        txMonthInput.disabled = true;
        txYearInput.disabled = true;
    }
});
