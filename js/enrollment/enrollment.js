// Function to validate age and prevent form submission if invalid
function validateAge() {
    const dobInput = document.getElementById('dob');
    const ageInput = document.getElementById('age');
    const dobError = document.getElementById('dob_error');
    const ageError = document.getElementById('age_error');
    const form = document.getElementById('enrollment'); // Replace with your form's ID

    let isValid = true;

    // Clear previous errors when input changes
    dobError.textContent = '';
    ageError.textContent = '';

    // Check if Date of Birth is provided
    if (dobInput.value) {
        const dob = new Date(dobInput.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        // Update age input and check if age is less than 18
        ageInput.value = age;
        if (age < 18) {
            ageError.textContent = "Age cannot be less than 18 years.";
            isValid = false;
        }
    } else if (ageInput.value) {
        // If age input is changed, calculate the date of birth
        const age = parseInt(ageInput.value);
        if (age < 18) {
            ageError.textContent = "Age cannot be less than 18 years.";
            isValid = false;
        } else {
            const today = new Date();
            const birthYear = today.getFullYear() - age;
            dobInput.value = `${birthYear}-01-01`; // Default to January 1st of the calculated year
        }
    }

    // Prevent form submission if age is invalid
    if (!isValid) {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form submission
            alert("Please correct the errors before submitting.");
        });
    } else {
        // Allow form submission if no errors
        form.removeEventListener('submit', preventFormSubmission);
    }
}

// Function to prevent form submission if errors exist
function preventFormSubmission(event) {
    event.preventDefault(); // Prevent form submission if there are errors
}
