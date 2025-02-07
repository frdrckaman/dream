document.addEventListener("DOMContentLoaded", function () {
    updateFormStatus();

    // Event listeners
    document.getElementById('date_completed').addEventListener('input', checkDateCompleted);
    document.getElementById('screening').addEventListener('submit', validateForm);

    let formStatusRadios = document.querySelectorAll('input[name="form_status"]');
    formStatusRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value == "3" && !document.getElementById('date_completed').value) {
                alert("You cannot select 'Verified' until 'Completed Date' is filled.");
                this.checked = false;
            } else {
                updateFormStatus();
            }
        });
    });
});

function updateFormStatus() {
    let formStatus = document.querySelector('input[name="form_status"]:checked')?.value;
    let dateCompleted = document.getElementById('date_completed');
    let dateVerified = document.getElementById('date_verified');

    if (formStatus == "1") {
        dateCompleted.disabled = true;
        dateVerified.disabled = true;
        dateCompleted.required = false;
        dateVerified.required = false;
        dateCompleted.value = "";
        dateVerified.value = "";
    } else if (formStatus == "2") {
        dateCompleted.disabled = false;
        dateVerified.disabled = true;
        dateCompleted.required = true;
        dateVerified.required = false;
        dateVerified.value = "";
    } else if (formStatus == "3") {
        dateCompleted.disabled = true;
        dateVerified.disabled = !dateCompleted.value;  // Enable only if date_completed is filled
        dateCompleted.required = false;
        dateVerified.required = !!dateCompleted.value; // Make required only if date_completed is filled
    }

    checkDateCompleted();
}

function checkDateCompleted() {
    let dateCompleted = document.getElementById('date_completed').value;
    let formStatus3 = document.getElementById('form_status3'); // Ensure correct ID based on PHP loop
    let dateVerified = document.getElementById('date_verified');

    if (!dateCompleted) {
        dateVerified.disabled = true;
        dateVerified.required = false;
        dateVerified.value = "";
        if (formStatus3?.checked) {
            formStatus3.checked = false;
        }
    }
}

function validateForm(event) {
    let formStatus = document.querySelector('input[name="form_status"]:checked')?.value;
    let dateCompleted = document.getElementById('date_completed').value;
    let dateVerified = document.getElementById('date_verified').value;
    let dateCompletedError = document.getElementById('date_completed_error');
    let dateVerifiedError = document.getElementById('date_verified_error');
    let isValid = true;

    dateCompletedError.innerText = "";
    dateVerifiedError.innerText = "";

    if (formStatus == "2" && !dateCompleted) {
        dateCompletedError.innerText = "Completed date is required.";
        isValid = false;
    }

    if (formStatus == "3" && !dateCompleted) {
        alert("You cannot select 'Verified' until 'Completed Date' is filled.");
        isValid = false;
    }

    if (formStatus == "3" && !dateVerified) {
        dateVerifiedError.innerText = "Verified date is required.";
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }
}
