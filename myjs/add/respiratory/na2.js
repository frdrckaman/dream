function handleCheckbox() {
    const ct_value_not_applicablecheckbox2 = document.getElementById('ct_value_not_applicable2');
    const ct_value_repeat = document.getElementById('ct_value_repeat');

    const ct_value_not_applicable = document.getElementById('ct_value_not_applicable');
    const ct_value_not_repeat = document.getElementById('ct_value_not_repeat');
    // Clear the input field if checkbox is checked
    if (ct_value_not_applicablecheckbox2.checked) {
        ct_value_repeat.value = '';
        ct_value_repeat.disabled = true; // Disable the input when checked
    } else if (ct_value_not_applicable.checked) {
        ct_value_not_repeat.value = '';
        ct_value_not_repeat.disabled = true; // Disable the input when checked
    } else {
        ct_value_repeat.disabled = false; // Enable the input when unchecked
        ct_value_not_repeat.disabled = false; // Enable the input when unchecked
    }
}
