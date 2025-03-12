document.addEventListener("DOMContentLoaded", function () {
    const tbDiagnosisRadios = document.querySelectorAll('input[name="tb_diagnosis"]');
    const tbDiagnosisMadeRadios = document.querySelectorAll('input[name="tb_diagnosis_made"]');
    const tbOtherDiagnosisRadios = document.querySelectorAll('input[name="tb_other_diagnosis"]');
    const tbRegimenRadios = document.querySelectorAll('input[name="tb_regimen"]');
    const tbTreatmentRadios = document.querySelectorAll('input[name="tb_treatment"]');
    const tbDiagnosedClinicallyCheckbox = document.getElementById("tb_diagnosed_clinically96");
    const regimenChangedRadios = document.querySelectorAll('input[name="regimen_changed"]');

    const tbDiagnosisSection = document.getElementById("tb_diagnosis_made_section");
    const tbOtherDiagnosisSection = document.getElementById("tb_other_diagnosis_section");
    const bacteriologicalDiagnosisSection = document.getElementById("bacteriological_diagnosis_section");
    const clinicianReceivedDateSection = document.getElementById("clinician_received_date_section");
    const diagnosisMadeOtherSection = document.getElementById("diagnosis_made_other_section");
    const tbDiagnosedClinicallySection = document.getElementById("tb_diagnosed_clinically_section");
    const tbClinicallyOtherSection = document.getElementById("tb_clinically_other_section");
    const tbTreatmentSection = document.getElementById("tb_treatment_section");
    const tbOtherSpecifySection = document.getElementById("tb_other_specify_section");
    const tbBacterialSection = document.getElementById("tb_bacterial_section"); // New section for tb_other_diagnosis = 3
    const tbOtherSection = document.getElementById("tb_other_section"); // New section for tb_other_diagnosis = 96
    const tbRegimenOtherSection = document.getElementById("tb_regimen_other_section");
    const tbTreatmentDateSection = document.getElementById("tb_treatment_date_section");
    const tbFacilitySection = document.getElementById("tb_facility_section");
    const tbReasonSection = document.getElementById("tb_reason_section");
    const tbOutcomeSection = document.getElementById("tb_otcome_section"); // Ensure correct ID spelling
    const tbDiagnosisDateSection = document.getElementById("tb_diagnosis_date_section");

    const tbRegisterNumberSection = document.getElementById("tb_register_number_section");
    const tbRegimenPrescribedSection = document.getElementById("tb_regimen_prescribed_section");
    const regimenChangedSection = document.getElementById("regimen_changed_section");
    const tableSection = document.getElementById("table_section");

    const tbDiagnosisDateInput = document.getElementById("tb_diagnosis_date");
    const screeningDateDiagnosisInput = document.getElementById("screening_date_diagnosis");
    const tbDiagnosisDateError = document.createElement("span");
    tbDiagnosisDateError.className = "text-danger";
    tbDiagnosisDateInput.parentNode.appendChild(tbDiagnosisDateError);

    const finalDiagnosisForm = document.getElementById("Final_Diagnosis");

    finalDiagnosisForm.addEventListener("submit", function (event) {
        const screeningDateDiagnosis = new Date(screeningDateDiagnosisInput.value);
        const today = new Date();
        let isValid = true;

        const tbDiagnosisDate = new Date(tbDiagnosisDateInput.value);
        if (tbDiagnosisDate < screeningDateDiagnosis) {
            tbDiagnosisDateError.textContent = `TB diagnosis date must be greater than or equal to the screening date (${screeningDateDiagnosisInput.value}).`;
            isValid = false;
        } else if (tbDiagnosisDate > today) {
            tbDiagnosisDateError.textContent = "TB diagnosis date cannot be in the future.";
            isValid = false;
        } else {
            tbDiagnosisDateError.textContent = "";
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are errors
        }
    });

    function toggleTbDiagnosisSection() {
        const selectedValue = document.querySelector('input[name="tb_diagnosis"]:checked')?.value;

        if (selectedValue === "1") {
            tbDiagnosisSection.style.display = "block";
            tbOtherDiagnosisSection.style.display = "none";
            tbTreatmentSection.style.display = "block";
            tbDiagnosisDateSection.style.display = "block"; // Show tb_diagnosis_date_section
            toggleTbDiagnosisMadeSections();
        } else if (selectedValue === "2") {
            tbDiagnosisSection.style.display = "none";
            tbOtherDiagnosisSection.style.display = "block";
            tbOutcomeSection.style.display = "none";
            tbTreatmentSection.style.display = "none";
            tbDiagnosisDateSection.style.display = "none"; // Hide tb_diagnosis_date_section
            bacteriologicalDiagnosisSection.style.display = "none";
            clinicianReceivedDateSection.style.display = "none";
            diagnosisMadeOtherSection.style.display = "none";
            tbDiagnosedClinicallySection.style.display = "none";
            tbClinicallyOtherSection.style.display = "none";
        } else {
            tbDiagnosisSection.style.display = "none";
            tbOtherDiagnosisSection.style.display = "none";
            tbOutcomeSection.style.display = "none";
            tbTreatmentSection.style.display = "none";
            tbDiagnosisDateSection.style.display = "none"; // Hide tb_diagnosis_date_section
        }
    }

    function toggleTbDiagnosisMadeSections() {
        const selectedValue = document.querySelector('input[name="tb_diagnosis_made"]:checked')?.value;
        bacteriologicalDiagnosisSection.style.display = selectedValue === "2" ? "block" : "none";
        clinicianReceivedDateSection.style.display = selectedValue === "2" ? "block" : "none";
        diagnosisMadeOtherSection.style.display = selectedValue === "96" ? "block" : "none";
        tbDiagnosedClinicallySection.style.display = selectedValue === "1" ? "block" : "none";
        toggleTbClinicallyOtherSection();
    }

    function toggleTbOtherSpecifySection() {
        const selectedValue = document.querySelector('input[name="tb_other_diagnosis"]:checked')?.value;
        tbOtherSpecifySection.style.display = selectedValue === "96" || selectedValue === "3" ? "block" : "none";
        tbBacterialSection.style.display = selectedValue === "3" ? "block" : "none"; // Show tb_bacterial_section if value is 3
        tbOtherSection.style.display = selectedValue === "96" ? "block" : "none"; // Show tb_other_section if value is 96
    }

    function toggleTbRegimenOtherSection() {
        const selectedValue = document.querySelector('input[name="tb_regimen"]:checked')?.value;
        tbRegimenOtherSection.style.display = selectedValue === "96" || selectedValue === "7" ? "block" : "none";
    }

    function toggleTbTreatmentSections() {
        const selectedValue = document.querySelector('input[name="tb_treatment"]:checked')?.value;
        tbTreatmentDateSection.style.display = selectedValue === "1" ? "block" : "none";
        tbFacilitySection.style.display = selectedValue === "2" ? "block" : "none";
        tbReasonSection.style.display = selectedValue === "3" ? "block" : "none";
        tbRegisterNumberSection.style.display = selectedValue === "1" ? "block" : "none";
        tbRegimenPrescribedSection.style.display = selectedValue === "1" ? "block" : "none";
        regimenChangedSection.style.display = selectedValue === "1" ? "block" : "none";
        tbOutcomeSection.style.display = selectedValue === "1" && tbTreatmentRadios[0].checked ? "block" : "none"; // Show/Hide based on tb_treatment value and selected option
    }

    function toggleTbClinicallyOtherSection() {
        tbClinicallyOtherSection.style.display = tbDiagnosedClinicallyCheckbox.checked ? "block" : "none";
    }

    function toggleTableSection() {
        const selectedValue = document.querySelector('input[name="regimen_changed"]:checked')?.value;
        tableSection.style.display = selectedValue === "1" ? "block" : "none";
    }

    tbDiagnosisRadios.forEach(radio => radio.addEventListener("change", toggleTbDiagnosisSection));
    tbDiagnosisMadeRadios.forEach(radio => radio.addEventListener("change", toggleTbDiagnosisMadeSections));
    tbOtherDiagnosisRadios.forEach(radio => radio.addEventListener("change", toggleTbOtherSpecifySection));
    tbRegimenRadios.forEach(radio => radio.addEventListener("change", toggleTbRegimenOtherSection));
    tbTreatmentRadios.forEach(radio => radio.addEventListener("change", toggleTbTreatmentSections));
    tbDiagnosedClinicallyCheckbox.addEventListener("change", toggleTbClinicallyOtherSection);
    regimenChangedRadios.forEach(radio => radio.addEventListener("change", toggleTableSection));

    // Initialize section visibility on page load
    toggleTbDiagnosisSection();
    toggleTbDiagnosisMadeSections();
    toggleTbClinicallyOtherSection();
    toggleTbOtherSpecifySection();
    toggleTbRegimenOtherSection();
    toggleTbTreatmentSections();
    toggleTableSection();

    const diagnosisStatusRadios = document.querySelectorAll('input[name="diagnosis_status"]');
    const diagnosisDateCompletedInput = document.getElementById("diagnosis_date_completed");
    const diagnosisDateVerifiedInput = document.getElementById("diagnosis_date_verified");
    const diagnosisDateCompletedByInput = document.getElementById("diagnosis_date_completed_by");
    const diagnosisDateVerifiedByInput = document.getElementById("diagnosis_date_verified_by");
    const enrollmentDateDiagnosisInput = document.querySelector('input[name="enrollment_date_diagnosis"]');
    const dateCompletedError = document.getElementById("date_completed_error");
    const dateVerifiedError = document.getElementById("date_verified_error");
    const diagnosisStatusError = document.getElementById("diagnosis_status_error");

    function updateDiagnosisFormStatus() {
        const selectedStatus = document.querySelector('input[name="diagnosis_status"]:checked')?.value;

        if (selectedStatus === "1") {
            diagnosisDateCompletedInput.value = "";
            diagnosisDateVerifiedInput.value = "";
            diagnosisDateCompletedInput.required = false;
            diagnosisDateVerifiedInput.required = false;
            document.getElementById("diagnosis_date_completed_status").style.display = "none";
            document.getElementById("diagnosis_date_verified_status").style.display = "none";
        } else if (selectedStatus === "2") {
            diagnosisDateCompletedInput.required = true;
            diagnosisDateVerifiedInput.value = "";
            diagnosisDateVerifiedInput.required = false;
            document.getElementById("diagnosis_date_completed_status").style.display = "block";
            document.getElementById("diagnosis_date_verified_status").style.display = "none";
        } else if (selectedStatus === "3") {
            diagnosisDateCompletedInput.required = true;
            diagnosisDateVerifiedInput.required = true;
            document.getElementById("diagnosis_date_completed_status").style.display = "block";
            document.getElementById("diagnosis_date_verified_status").style.display = "block";
            diagnosisStatusError.textContent = "";
        } else {
            diagnosisDateCompletedInput.required = false;
            diagnosisDateVerifiedInput.required = false;
            document.getElementById("diagnosis_date_completed_status").style.display = "none";
            document.getElementById("diagnosis_date_verified_status").style.display = "none";
        }
    }

    function validateDates(event) {
        const selectedStatus = document.querySelector('input[name="diagnosis_status"]:checked')?.value;
        const enrollmentDateDiagnosis = new Date(enrollmentDateDiagnosisInput.value);
        const today = new Date();
        let isValid = true;

        if (selectedStatus === "2") {
            const diagnosisDateCompleted = new Date(diagnosisDateCompletedInput.value);
            if (diagnosisDateCompleted < enrollmentDateDiagnosis) {
                dateCompletedError.textContent = `Completed date must be greater than or equal to the enrollment date (${enrollmentDateDiagnosisInput.value}).`;
                isValid = false;
            } else if (diagnosisDateCompleted > today) {
                dateCompletedError.textContent = "Completed date cannot be in the future.";
                isValid = false;
            } else {
                dateCompletedError.textContent = "";
            }
        }

        if (selectedStatus === "3") {
            const diagnosisDateCompleted = new Date(diagnosisDateCompletedInput.value);
            const diagnosisDateVerified = new Date(diagnosisDateVerifiedInput.value);
            if (diagnosisDateCompleted < enrollmentDateDiagnosis) {
                dateCompletedError.textContent = `Completed date must be greater than or equal to the enrollment date (${enrollmentDateDiagnosisInput.value}).`;
                isValid = false;
            } else if (diagnosisDateVerified < diagnosisDateCompleted) {
                dateVerifiedError.textContent = "Verified date must be greater than or equal to the completed date.";
                isValid = false;
            } else if (diagnosisDateVerified > today) {
                dateVerifiedError.textContent = "Verified date cannot be in the future.";
                isValid = false;
            } else {
                dateVerifiedError.textContent = "";
            }

            if (diagnosisDateCompletedByInput.value === diagnosisDateVerifiedByInput.value) {
                diagnosisStatusError.textContent = "Completed by and Verified by cannot be the same person.";
                isValid = false;
            } else {
                diagnosisStatusError.textContent = "";
            }
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are errors
        }
    }

    diagnosisStatusRadios.forEach(radio => radio.addEventListener("change", updateDiagnosisFormStatus));
    document.getElementById("Final_Diagnosis").addEventListener("submit", validateDates);

    // Initialize section visibility on page load
    updateDiagnosisFormStatus();
});
