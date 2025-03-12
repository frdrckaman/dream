document.addEventListener("DOMContentLoaded", function () {
    const sampleReceivedRadios = document.querySelectorAll("input[name='sample_received']");
    const newSampleRadios = document.querySelectorAll("input[name='new_sample']");
    const sampleReasonRadios = document.querySelectorAll("input[name='sample_reason']");
    const numberReceivedRadios = document.querySelectorAll("input[name='number_received']");
    const afbMicroscopyRadios = document.querySelectorAll("input[name='afb_microscopy_conducted']");
    const xpertMtbRifRadios = document.querySelectorAll("input[name='xpert_mtb_rif_conducted']");
    const errorCodeFormat = document.getElementById("error_code_format");
    const xpertMtbRadios = document.querySelectorAll("input[name='xpert_mtb']");
    const xpertRifOptions = document.querySelectorAll("#xpert_rif option");
    const afbADateInput = document.getElementById("afb_a_date");
    const afbBDateInput = document.getElementById("afb_b_date");
    const enrollmentDateHiddenInput = document.getElementById("enrollment_date_hidden");
    const afbADateError = document.getElementById("afb_a_date_error");
    const afbBDateError = document.getElementById("afb_b_date_error");
    const dateSample1CollectedInput = document.getElementById("date_sample1_collected");
    const dateSample1ReceivedInput = document.getElementById("date_sample1_received");
    const dateSample2CollectedInput = document.getElementById("date_sample2_collected");
    const dateSample2ReceivedInput = document.getElementById("date_sample2_received");
    const screeningDateClinicInput = document.getElementById("screening_date_clinic");
    const dateSample1CollectedError = document.getElementById("date_sample1_collected_error");
    const dateSample1ReceivedError = document.getElementById("date_sample1_received_error");
    const dateSample2CollectedError = document.getElementById("date_sample2_collected_error");
    const dateSample2ReceivedError = document.getElementById("date_sample2_received_error");
    const xpertDateInput = document.getElementById("xpert_date");
    const xpertDateError = document.getElementById("xpert_date_error");
    const errorCodeInput = document.getElementById("error_code");

    // Sections
    const sampleReceivedSection = document.getElementById("sample_received_section");
    const numberReceivedSection = document.getElementById("number_received_section");
    const sampleReasonSection = document.getElementById("sample_reason_section");
    const newSampleSection = document.getElementById("new_sample_section");
    const otherNewReasonSection = document.getElementById("other_new_reason_section");
    const otherReasonSection = document.getElementById("other_reason");
    const sample1Section = document.getElementById("sample1_section");
    const sample2Section = document.getElementById("sample2_section");
    const afbMicroscopySection = document.getElementById("afb_microscopy_section");
    const xpertMtbRifSection = document.getElementById("xpert_mtb_rif_section");
    const errorCodeSection = document.getElementById("error_code");
    const xpertRifSection = document.getElementById("xpert_rif_section");

    function toggleSampleSections() {
        let sampleReceivedValue = getCheckedValue(sampleReceivedRadios);

        if (sampleReceivedValue === "2") {
            sampleReasonSection.style.display = "block";
            newSampleSection.style.display = "block";
        } else {
            sampleReasonSection.style.display = "none";
            newSampleSection.style.display = "none";
            otherNewReasonSection.style.display = "none";
        }

        toggleOtherNewReasonSection();
    }

    function toggleOtherNewReasonSection() {
        let newSampleValue = getCheckedValue(newSampleRadios);

        otherNewReasonSection.style.display = newSampleValue === "2" ? "block" : "none";

        toggleNumberReceivedSection();
        toggleSampleReceivedSection();
        toggleSampleNumberSections();
    }

    function toggleNumberReceivedSection() {
        let sampleReceivedValue = getCheckedValue(sampleReceivedRadios);
        let newSampleValue = getCheckedValue(newSampleRadios);

        numberReceivedSection.style.display =
            sampleReceivedValue === "1" || (sampleReceivedValue === "2" && newSampleValue === "1")
                ? "block"
                : "none";

        toggleSampleNumberSections();
    }

    function toggleSampleReceivedSection() {
        let sampleReceivedValue = getCheckedValue(sampleReceivedRadios);
        let newSampleValue = getCheckedValue(newSampleRadios);

        sampleReceivedSection.style.display =
            sampleReceivedValue === "1" || (sampleReceivedValue === "2" && newSampleValue === "1")
                ? "block"
                : "none";
    }

    function toggleSampleNumberSections() {
        let numberReceivedValue = getCheckedValue(numberReceivedRadios);

        sample1Section.style.display = ["1", "2"].includes(numberReceivedValue) ? "block" : "none";
        sample2Section.style.display = numberReceivedValue === "2" ? "block" : "none";
    }

    function toggleOtherReasonSection() {
        let isSampleReason96 = Array.from(sampleReasonRadios).some(radio => radio.checked && radio.value === "96");

        otherReasonSection.style.display = isSampleReason96 ? "block" : "none";
    }

    function toggleAfbMicroscopySection() {
        let afbMicroscopyValue = getCheckedValue(afbMicroscopyRadios);

        afbMicroscopySection.style.display = afbMicroscopyValue === "1" ? "block" : "none";
    }

    function toggleXpertMtbRifSection() {
        let xpertMtbRifValue = getCheckedValue(xpertMtbRifRadios);

        xpertMtbRifSection.style.display = xpertMtbRifValue === "1" ? "block" : "none";
    }

    function toggleErrorCodeSection() {
        let xpertMtbValue = getCheckedValue(xpertMtbRadios);

        if (xpertMtbValue === "11") {
            errorCodeSection.style.display = "block";
            errorCodeFormat.style.display = "block";
            errorCodeInput.setAttribute("required", "required");
        } else {
            errorCodeSection.style.display = "none";
            errorCodeFormat.style.display = "none";
            errorCodeInput.removeAttribute("required");
        }

        xpertRifSection.style.display = ["2", "3", "4", "5", "6"].includes(xpertMtbValue) ? "block" : "none";

        filterXpertRifOptions(xpertMtbValue);
    }

    function filterXpertRifOptions() {
        const xpertMtbValue = getCheckedValue(xpertMtbRadios);
        console.log("xpertMtbValue:", xpertMtbValue); // Log the selected value

        xpertMtbRifRadios.forEach(radio => radio.closest('label').style.display = "block"); // Show all radios

        // If selected value is in the range of "3", "4", "5", "6", hide radio "4"
        if (["3", "4", "5", "6"].includes(xpertMtbValue)) {
            hideOption("4");
        }

        // If selected value is "2", hide radios "1", "2", and "3"
        if (xpertMtbValue === "2") {
            ["1", "2", "3"].forEach(hideOption);
        }
    }

    function hideOption(value) {
        const radio = Array.from(xpertMtbRifRadios).find(radio => radio.value === value);
        if (radio) {
            radio.closest('label').style.display = "none"; // Hide the label (which includes the radio button)
        }
    }

    function validateAfbDates(event) {
        const afbMicroscopyValue = getCheckedValue(afbMicroscopyRadios);
        if (afbMicroscopyValue !== "1") {
            return;
        }

        const screeningDate = new Date(screeningDateClinicInput.value);
        const threeDaysBeforeScreening = new Date(screeningDate);
        threeDaysBeforeScreening.setDate(screeningDate.getDate() - 3);
        const today = new Date();
        let isValid = true;

        const afbADate = new Date(afbADateInput.value);
        if (afbADate < threeDaysBeforeScreening || afbADate > screeningDate || afbADate > today) {
            afbADateError.textContent = `AFB A date must be within 3 days from the screening date (${screeningDateClinicInput.value}), not after the screening date, and not in the future.`;
            isValid = false;
        } else {
            afbADateError.textContent = "";
        }

        const afbBDate = new Date(afbBDateInput.value);
        if (afbBDate < threeDaysBeforeScreening || afbBDate > screeningDate || afbBDate > today) {
            afbBDateError.textContent = `AFB B date must be within 3 days from the screening date (${screeningDateClinicInput.value}), not after the screening date, and not in the future.`;
            isValid = false;
        } else {
            afbBDateError.textContent = "";
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are errors
        }
    }

    function validateSampleDates(event) {
        const screeningDate = new Date(screeningDateClinicInput.value);
        const threeDaysBeforeScreening = new Date(screeningDate);
        threeDaysBeforeScreening.setDate(screeningDate.getDate() - 3);
        const today = new Date();
        let isValid = true;

        const numberReceivedValue = getCheckedValue(numberReceivedRadios);

        const dateSample1Collected = new Date(dateSample1CollectedInput.value);
        if (dateSample1Collected < threeDaysBeforeScreening || dateSample1Collected > screeningDate || dateSample1Collected > today) {
            dateSample1CollectedError.textContent = `Sample 1 collected date must be within 3 days from the screening date (${screeningDateClinicInput.value}), not after the screening date, and not in the future.`;
            isValid = false;
        } else {
            dateSample1CollectedError.textContent = "";
        }

        const dateSample1Received = new Date(dateSample1ReceivedInput.value);
        if (dateSample1Received < dateSample1Collected || dateSample1Received > screeningDate || dateSample1Received > today) {
            dateSample1ReceivedError.textContent = `Sample 1 received date must be greater than or equal to the collected date (${dateSample1CollectedInput.value}), not after the screening date, and not in the future.`;
            isValid = false;
        } else {
            dateSample1ReceivedError.textContent = "";
        }

        if (numberReceivedValue === "2") {
            const dateSample2Collected = new Date(dateSample2CollectedInput.value);
            if (dateSample2Collected < threeDaysBeforeScreening || dateSample2Collected > screeningDate || dateSample2Collected > today) {
                dateSample2CollectedError.textContent = `Sample 2 collected date must be within 3 days from the screening date (${screeningDateClinicInput.value}), not after the screening date, and not in the future.`;
                isValid = false;
            } else {
                dateSample2CollectedError.textContent = "";
            }

            const dateSample2Received = new Date(dateSample2ReceivedInput.value);
            if (dateSample2Received < dateSample2Collected || dateSample2Received > screeningDate || dateSample2Received > today) {
                dateSample2ReceivedError.textContent = `Sample 2 received date must be greater than or equal to the collected date (${dateSample2CollectedInput.value}), not after the screening date, and not in the future.`;
                isValid = false;
            } else {
                dateSample2ReceivedError.textContent = "";
            }
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are errors
        }
    }

    function validateXpertDate(event) {
        const xpertMtbRifValue = getCheckedValue(xpertMtbRifRadios);
        if (xpertMtbRifValue !== "1") {
            return;
        }

        const screeningDate = new Date(screeningDateClinicInput.value);
        const threeDaysBeforeScreening = new Date(screeningDate);
        threeDaysBeforeScreening.setDate(screeningDate.getDate() - 3);
        const today = new Date();
        let isValid = true;

        const xpertDate = new Date(xpertDateInput.value);
        if (xpertDate < threeDaysBeforeScreening || xpertDate > screeningDate || xpertDate > today) {
            xpertDateError.textContent = `Xpert date must be within 3 days from the screening date (${screeningDateClinicInput.value}), not after the screening date, and not in the future.`;
            isValid = false;
        } else {
            xpertDateError.textContent = "";
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are errors
        }
    }

    function getCheckedValue(radioNodeList) {
        return Array.from(radioNodeList).find(radio => radio.checked)?.value;
    }

    sampleReceivedRadios.forEach(radio => radio.addEventListener("change", toggleSampleSections));
    newSampleRadios.forEach(radio => radio.addEventListener("change", toggleOtherNewReasonSection));
    numberReceivedRadios.forEach(radio => radio.addEventListener("change", toggleSampleNumberSections));
    sampleReasonRadios.forEach(radio => radio.addEventListener("change", toggleOtherReasonSection));
    afbMicroscopyRadios.forEach(radio => radio.addEventListener("change", toggleAfbMicroscopySection));
    xpertMtbRifRadios.forEach(radio => radio.addEventListener("change", toggleXpertMtbRifSection));
    xpertMtbRadios.forEach(radio => radio.addEventListener("change", toggleErrorCodeSection));

    document.getElementById("labForm_clinic").addEventListener("submit", function (event) {
        validateAfbDates(event);
        validateSampleDates(event);
        validateXpertDate(event);
        validateFormStatusDates(event);
    });

    toggleSampleSections();
    toggleOtherNewReasonSection();
    toggleNumberReceivedSection();
    toggleSampleReceivedSection();
    toggleSampleNumberSections();
    toggleOtherReasonSection();
    toggleAfbMicroscopySection();
    toggleXpertMtbRifSection();
    toggleErrorCodeSection();
    updateFormStatus();
});

function updateFormStatus() {
    let clinicStatusValue = getCheckedValue(clinicStatusRadios);

    if (clinicStatusValue === "1") {
        clinicDateCompletedSection.style.display = "none";
        clinicDateVerifiedSection.style.display = "none";
        clinicDateCompletedInput.removeAttribute("required");
        clinicDateVerifiedInput.removeAttribute("required");
    } else if (clinicStatusValue === "2") {
        clinicDateCompletedSection.style.display = "block";
        clinicDateVerifiedSection.style.display = "none";
        clinicDateCompletedInput.setAttribute("required", "required");
        clinicDateVerifiedInput.removeAttribute("required");
    } else if (clinicStatusValue === "3") {
        clinicDateCompletedSection.style.display = "block";
        clinicDateVerifiedSection.style.display = "block";
        clinicDateCompletedInput.setAttribute("required", "required");
        clinicDateVerifiedInput.setAttribute("required", "required");
    }
}

function validateFormStatusDates(event) {
    let clinicStatusValue = getCheckedValue(clinicStatusRadios);
    const screeningDate = new Date(screeningDateClinicInput.value);
    const today = new Date();
    let isValid = true;

    if (clinicStatusValue === "2" || clinicStatusValue === "3") {
        const clinicDateCompleted = new Date(clinicDateCompletedInput.value);
        if (clinicDateCompleted < screeningDate || clinicDateCompleted > today) {
            clinicDateCompletedError.textContent = `Completed date must be greater than or equal to the screening date (${screeningDateClinicInput.value}) and not in the future.`;
            isValid = false;
        } else {
            clinicDateCompletedError.textContent = "";
        }

        if (clinicStatusValue === "3") {
            const clinicDateVerified = new Date(clinicDateVerifiedInput.value);
            if (clinicDateVerified < clinicDateCompleted || clinicDateVerified > today) {
                clinicDateVerifiedError.textContent = `Verified date must be greater than or equal to the completed date (${clinicDateCompletedInput.value}) and not in the future.`;
                isValid = false;
            } else {
                clinicDateVerifiedError.textContent = "";
            }
        }
    }

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if there are errors
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const clinicStatusRadios = document.querySelectorAll("input[name='clinic_status']");
    const clinicDateCompletedSection = document.getElementById("clinic_date_completed_section");
    const clinicDateVerifiedSection = document.getElementById("clinic_date_verified_section");
    const clinicDateCompletedInput = document.getElementById("clinic_date_completed");
    const clinicDateVerifiedInput = document.getElementById("clinic_date_verified");
    const clinicDateCompletedError = document.getElementById("clinic_date_completed_error");
    const clinicDateVerifiedError = document.getElementById("clinic_date_verified_error");
    const screeningDateClinicInput = document.getElementById("screening_date_clinic");

    clinicStatusRadios.forEach(radio => radio.addEventListener("change", updateFormStatus));

    document.getElementById("labForm_clinic").addEventListener("submit", function (event) {
        validateFormStatusDates(event);
    });

    updateFormStatus(); // Initial call to set the correct visibility based on the current status
});
