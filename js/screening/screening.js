$(document).ready(function () {
    // Function to toggle consent_date visibility
    function toggleConsentDate() {
        const consentYes = $('input[name="conset"]:checked').val();
        const consentDateContainer = $('#conset_date_container');
        if (consentYes === '1') { // Assuming '1' is the value for 'Yes'
            consentDateContainer.show();
        } else {
            consentDateContainer.hide();
        }
    }

    // Add event listeners to consent radio buttons
    $('input[name="conset"]').on('change', toggleConsentDate);

    // Initial check to set consent_date visibility on page load
    toggleConsentDate();

    // Function to check if PID exists in the database
    async function checkIfPidExists(pid) {
        try {
            const response = await fetch('check_pid.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ pid: pid }),
            });
            const data = await response.json();
            return data.exists; // Assume the server returns { exists: true/false }
        } catch (error) {
            console.error('Error checking PID:', error);
            return false;
        }
    }

    // Form submission validation
    $('#screening').on('submit', async function (event) {
        try {
            let isValid = true;

            // Clear previous error messages
            $('.text-danger').hide().text('');

            // Retrieve PID1 and PID2 values
            const pid1 = $.trim($('#pid1').val());
            const pid2 = $.trim($('#pid2').val());

            // Validate that PID1 and PID2 are exactly 3 characters long
            // if (pid1.length !== 3 || pid2.length !== 3) {
            //     $('#pid1_error, #pid2_error').text('PID1 and PID2 must be exactly 3 characters long.').show();
            //     isValid = false;
            // }

            if (!/^\d{3}$/.test(pid1) || !/^\d{3}$/.test(pid2)) {
                $('#pid1_error, #pid2_error').text('PID1 and PID2 must be exactly 3 digits.').show();
                isValid = false;
            }


            // Check if PID1 and PID2 match
            if (pid1 !== pid2) {
                $('#pid1_error, #pid2_error').text('PID1 and PID2 do not match.').show();
                isValid = false;
            }

            // Check if PID1 already exists in the database
            if (isValid && pid1) {
                const pidExists = await checkIfPidExists(pid1);
                if (pidExists) {
                    $('#pid1_error').text('PID already exists in the database. Please use a different PID.').show();
                    isValid = false;
                }
            }

            // Validate screening_date
            const screeningDateInput = $('#screening_date').val();
            const screeningDate = new Date(screeningDateInput);
            screeningDate.setHours(0, 0, 0, 0);
            const startDate = new Date('2025-01-20');
            startDate.setHours(0, 0, 0, 0);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (screeningDate < startDate || screeningDate > today) {
                $('#screening_date_error').text('Screening date must be between 2025-01-20 and today.').show();
                isValid = false;
            }

            // Validate consent_date (if consent is "Yes")
            const consentYes = $('input[name="conset"]:checked').val();
            if (consentYes === '1') {
                $('#conset_date').prop('disabled', false);
                const consentDateInput = $('#conset_date').val();
                const consentDate = new Date(consentDateInput);
                consentDate.setHours(0, 0, 0, 0);

                if (!consentDateInput) {
                    $('#conset_date_error').text('Consent date is required if consent is selected as "Yes".').show();
                    isValid = false;
                } else if (consentDate < screeningDate) {
                    $('#conset_date_error').text('Consent date cannot be earlier than the screening date.').show();
                    isValid = false;
                } else if (consentDate > today) {
                    $('#conset_date_error').text('Consent date cannot be in the future.').show();
                    isValid = false;
                } else {
                    $('#conset_date_error').hide();
                }
            } else {
                $('#conset_date').prop('disabled', true);
            }

            console.log('Final validation status:', isValid);

            // Submit the form if all validations pass
            if (isValid) {
                setTimeout(() => {
                    console.log('Form is valid. Submitting now...'); // Debugging line
                    event.target.submit();
                }, 0);
            } else {
                console.log('Form is invalid. Please fix the errors.'); // Debugging line
            }

        } catch (error) {
            console.error('Error during form submission:', error);
        }
    });
});
