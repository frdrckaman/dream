function handleCheckbox() {
    const ct_value_not_applicablecheckbox = document.getElementById('ct_value_not_applicable');
    const inputField = document.getElementById('ct_value');

    // Clear the input field if checkbox is checked
    if (ct_value_not_applicablecheckbox.checked) {
        inputField.value = '';
        inputField.disabled = true; // Disable the input when checked
    } else {
        inputField.disabled = false; // Enable the input when unchecked
    }
}
