
function updateAge() {
    const dobInput = document.getElementById('dob').value;
    const ageInput = document.getElementById('age');

    if (dobInput) {
        const dob = new Date(dobInput);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDifference = today.getMonth() - dob.getMonth();

        // Adjust age if the birthday hasn't occurred yet this year
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        ageInput.value = age;
    }
}

function updateDob() {
    const ageInput = document.getElementById('age').value;
    const dobInput = document.getElementById('dob');

    if (ageInput) {
        const age = parseInt(ageInput, 10);
        const today = new Date();
        const birthYear = today.getFullYear() - age;
        let dob = new Date(birthYear, today.getMonth(), today.getDate());

        // Ensure valid date handling for leap years, etc.
        dobInput.value = dob.toISOString().split('T')[0];
    }
}

