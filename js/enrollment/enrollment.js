document.addEventListener("DOMContentLoaded", function () {
    const txPreviousRadios = document.querySelectorAll("input[name='tx_previous']");
    const tbCategoryRadios = document.querySelectorAll("input[name='tb_category']");
    const otherDiseasesRadios = document.querySelectorAll("input[name='other_diseases']");
    const sputumCollectedRadios = document.querySelectorAll("input[name='sputum_collected']");
    const diseasesMedicalCheckboxes = document.querySelectorAll("input[name='diseases_medical[]']"); // Assuming checkbox is an array
    const tbRegimenRadios = document.querySelectorAll("input[name='tb_regimen']"); // Assuming tb_regimen is a radio button group

    const tbCategorySection = document.getElementById("tb_category_section");
    const txNumberSection = document.getElementById("tx_number_section");
    const txPreviousSection = document.getElementById("tx_previous_section");
    const diseasesMedicalSection = document.getElementById("diseases_medical_section");
    const sputumDateSection = document.getElementById("sputum_date_section");
    const sputumReasonsSection = document.getElementById("sputum_reasons_section");
    const diseasesSpecify = document.getElementById("diseases_specify");
    const tbCategorySpecify = document.getElementById("tb_category_specify");
    const ltfMonthsSection = document.getElementById("ltf_months_section"); // Assuming the section ID
    const tbRegimenSpecify = document.getElementById("tb_regimen_specify"); // The section to toggle based on tb_regimen

    const enrollmentDateInput = document.getElementById("enrollment_date");
    const enrollmentDateErrorElement = document.getElementById("enrollment_date_error");
    const consentDateInput = document.getElementById("consent_date_enrollment");
    const screeningDateInput = document.getElementById("screening_date_enrollment");
    const dobInput = document.getElementById("dob");
    const ageInput = document.getElementById("age");
    const ageErrorElement = document.getElementById("age_error");
    const informationDateInput = document.getElementById("date_information_collected");
    const informationDateErrorElement = document.getElementById("information_date_error");
    const txYearInput = document.getElementById("tx_year");
    const txYearErrorElement = document.getElementById("tx_year_error");
    const txMonthInput = document.getElementById("tx_month");
    const sputumDateInput = document.getElementById("sputum_date");
    const sputumDateErrorElement = document.getElementById("sputum_date_error");
    const txUnknownMonth = document.getElementById("tx_unknown_month");
    const txUnknownYear = document.getElementById("tx_unknown_year");
    const regimenMonthsInput = document.getElementById("regimen_months");
    const regimenMonthsUnknown = document.getElementById("regimen_months_unknown");
    const form = document.getElementById("validation");

    function toggleTxSections() {
        let isTxPreviousYes = Array.from(txPreviousRadios).some(radio => radio.checked && radio.value === "1");

        tbCategorySection.style.display = isTxPreviousYes ? "block" : "none";
        txNumberSection.style.display = isTxPreviousYes ? "block" : "none";
        txPreviousSection.style.display = isTxPreviousYes ? "block" : "none";
    }

    function toggleTbCategorySpecify() {
        let isTbCategorySpecify = Array.from(tbCategoryRadios).some(radio => radio.checked && radio.value === "96");

        tbCategorySpecify.style.display = isTbCategorySpecify ? "block" : "none";
    }

    function toggleTbCategoryLtf() {
        let isTbCategoryLtf = Array.from(tbCategoryRadios).some(radio => radio.checked && (radio.value === "2" || radio.value === "3"));

        ltfMonthsSection.style.display = isTbCategoryLtf ? "block" : "none";
    }

    function toggleDiseaseSection() {
        let isOtherDiseasesYes = Array.from(otherDiseasesRadios).some(radio => radio.checked && radio.value === "1");

        diseasesMedicalSection.style.display = isOtherDiseasesYes ? "block" : "none";
    }

    function toggleSputumSection() {
        let isSputumCollectedYes = Array.from(sputumCollectedRadios).some(radio => radio.checked && radio.value === "1");

        sputumDateSection.style.display = isSputumCollectedYes ? "block" : "none";
        sputumReasonsSection.style.display = isSputumCollectedYes ? "none" : "block";
    }

    function toggleDiseasesSpecify() {
        let isDisease96Checked = Array.from(diseasesMedicalCheckboxes).some(checkbox => checkbox.checked && checkbox.value === "96");

        diseasesSpecify.style.display = isDisease96Checked ? "block" : "none";
    }

    function toggleTbRegimenSpecify() {
        let isTbRegimen7 = Array.from(tbRegimenRadios).some(radio => radio.checked && radio.value === "7");

        tbRegimenSpecify.style.display = isTbRegimen7 ? "block" : "none";
    }

    function validateEnrollmentDate() {
        const enrollmentDate = enrollmentDateInput.value;
        const consentDate = consentDateInput.value;
        const today = new Date().toISOString().split('T')[0];

        console.log("Validating enrollment date:", enrollmentDate, "against consent date:", consentDate, "and today's date:", today);

        if (enrollmentDate < consentDate || enrollmentDate > today) {
            enrollmentDateErrorElement.style.display = 'block';
            enrollmentDateErrorElement.style.color = 'red';
            enrollmentDateErrorElement.style.marginTop = '5px';
            enrollmentDateErrorElement.textContent = `Enrollment date must be on or after the consent date (${consentDate}) and not in the future.`;
            return false;
        } else {
            enrollmentDateErrorElement.style.display = 'none';
            enrollmentDateErrorElement.textContent = '';
            return true;
        }
    }

    function calculateAge(dob, referenceDate) {
        const birthDate = new Date(dob);
        const refDate = new Date(referenceDate);
        let age = refDate.getFullYear() - birthDate.getFullYear();
        const monthDifference = refDate.getMonth() - birthDate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && refDate.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    function calculateDob(age, referenceDate) {
        const refDate = new Date(referenceDate);
        const birthYear = refDate.getFullYear() - age;
        const birthDate = new Date(birthYear, refDate.getMonth(), refDate.getDate());
        return birthDate.toISOString().split('T')[0];
    }

    function validateAge() {
        const dob = dobInput.value;
        const screeningDate = screeningDateInput.value;
        const age = calculateAge(dob, screeningDate);
        ageInput.value = age;

        if (age < 18) {
            ageErrorElement.style.display = 'block';
            ageErrorElement.style.color = 'red';
            ageErrorElement.style.marginTop = '5px';
            ageErrorElement.textContent = 'Age must be 18 or older.';
            return false;
        } else {
            ageErrorElement.style.display = 'none';
            ageErrorElement.textContent = '';
            return true;
        }
    }

    function validateInformationDate() {
        const informationDate = new Date(informationDateInput.value);
        const screeningDate = new Date(screeningDateInput.value);
        const threeDaysBeforeScreening = new Date(screeningDate);
        threeDaysBeforeScreening.setDate(screeningDate.getDate() - 3);
        const today = new Date();

        if (informationDate > screeningDate || informationDate < threeDaysBeforeScreening || informationDate > today) {
            informationDateErrorElement.style.display = 'block';
            informationDateErrorElement.textContent = 'Date information collected must be within 3 days before the screening date and not in the future.';
            return false;
        } else {
            informationDateErrorElement.style.display = 'none';
            informationDateErrorElement.textContent = '';
            return true;
        }
    }

    function validateTxYear() {
        const dob = new Date(dobInput.value);
        const dobYear = dob.getFullYear(); // Extract only the year from dob
        const txYear = parseInt(txYearInput.value, 10); // Ensure txYear is treated as an integer
        const currentYear = new Date().getFullYear();

        // Check if txYear is a valid four-digit year
        if (txYear && txYear.toString().length === 4 && !txUnknownYear.checked && (txYear <= dobYear || txYear > currentYear)) {
            txYearErrorElement.textContent = 'Year must be greater than year of birth and not in the future.';
            txYearInput.value = '';
            return false;
        } else {
            txYearErrorElement.textContent = '';
            return true;
        }
    }

    function toggleTxMonth() {
        if (txUnknownMonth.checked) {
            txMonthInput.value = '';
            txMonthInput.disabled = true;
        } else {
            txMonthInput.disabled = false;
        }
    }

    function toggleTxYear() {
        if (txUnknownYear.checked) {
            txUnknownMonth.checked = true;
            txUnknownMonth.disabled = true;
            txYearInput.value = '';
            txMonthInput.value = '';
            txYearInput.disabled = true;
            txMonthInput.disabled = true;
        } else {
            txUnknownMonth.disabled = false;
            txYearInput.disabled = false;
            txMonthInput.disabled = txUnknownMonth.checked; // Keep txMonthInput disabled if txUnknownMonth is checked
        }
    }

    function validateSputumDate() {
        const sputumDate = new Date(sputumDateInput.value);
        const screeningDate = new Date(screeningDateInput.value);
        const threeDaysBeforeScreening = new Date(screeningDate);
        threeDaysBeforeScreening.setDate(screeningDate.getDate() - 3);
        const today = new Date();

        if (sputumDate > screeningDate || sputumDate < threeDaysBeforeScreening || sputumDate > today) {
            sputumDateErrorElement.style.display = 'block';
            sputumDateErrorElement.textContent = 'Date of sputum collection must be within 3 days before the screening date and not in the future.';
            return false;
        } else {
            sputumDateErrorElement.style.display = 'none';
            sputumDateErrorElement.textContent = '';
            return true;
        }
    }

    function toggleRegimenMonths() {
        if (regimenMonthsUnknown.checked) {
            regimenMonthsInput.value = '';
            regimenMonthsInput.disabled = true;
        } else {
            regimenMonthsInput.disabled = false;
        }
    }

    // Attach event listeners
    txPreviousRadios.forEach(radio => radio.addEventListener("change", toggleTxSections));
    tbCategoryRadios.forEach(radio => {
        radio.addEventListener("change", () => {
            toggleTbCategorySpecify();
            toggleTbCategoryLtf();
        });
    });
    otherDiseasesRadios.forEach(radio => radio.addEventListener("change", toggleDiseaseSection));
    sputumCollectedRadios.forEach(radio => radio.addEventListener("change", toggleSputumSection));
    diseasesMedicalCheckboxes.forEach(checkbox => checkbox.addEventListener("change", toggleDiseasesSpecify));
    tbRegimenRadios.forEach(radio => radio.addEventListener("change", toggleTbRegimenSpecify));
    enrollmentDateInput.addEventListener("input", validateEnrollmentDate);
    dobInput.addEventListener("input", validateAge);
    ageInput.addEventListener("input", function () {
        const age = ageInput.value;
        const screeningDate = screeningDateInput.value;
        dobInput.value = calculateDob(age, screeningDate);
        validateAge();
    });
    informationDateInput.addEventListener("input", validateInformationDate);
    txYearInput.addEventListener("input", validateTxYear);
    txUnknownMonth.addEventListener("change", toggleTxMonth);
    txUnknownYear.addEventListener("change", toggleTxYear);
    sputumDateInput.addEventListener("input", validateSputumDate);
    regimenMonthsUnknown.addEventListener("change", toggleRegimenMonths);

    // Prevent form submission if there is an error
    form.addEventListener("submit", function (event) {
        const isEnrollmentDateValid = validateEnrollmentDate();
        const isAgeValid = validateAge();
        const isInformationDateValid = validateInformationDate();
        const isTxYearValid = validateTxYear();
        const isSputumDateValid = validateSputumDate();

        console.log("Enrollment Date Valid:", isEnrollmentDateValid);
        console.log("Age Valid:", isAgeValid);
        console.log("Information Date Valid:", isInformationDateValid);
        console.log("Tx Year Valid:", isTxYearValid);
        console.log("Sputum Date Valid:", isSputumDateValid);

        if (!isEnrollmentDateValid || !isAgeValid || !isInformationDateValid || !isTxYearValid || !isSputumDateValid) {
            event.preventDefault();
        }
    });

    // Run on page load to initialize the correct visibility
    toggleTxSections();
    toggleTbCategorySpecify();
    toggleTbCategoryLtf();
    toggleDiseaseSection();
    toggleSputumSection();
    toggleDiseasesSpecify();
    toggleTbRegimenSpecify();
    validateEnrollmentDate(); // Initial validation
    validateAge(); // Initial validation
    validateInformationDate(); // Initial validation
    validateSputumDate(); // Initial validation
    toggleTxMonth(); // Initial toggle state
    toggleTxYear(); // Initial toggle state
    toggleRegimenMonths(); // Initial toggle state
});