document.addEventListener("DOMContentLoaded", function () {
    const sampleReceivedRadios = document.getElementsByName("sample_received");
    const sampleReasonRadios = document.getElementsByName("sample_reason");
    const newSampleRadios = document.getElementsByName("new_sample");
    const ctValueInput = document.getElementById("ct_value");
    const ctNotApplicableCheckbox = document.getElementById("ct_na");

    function toggleFields() {
        const isSampleReceivedYes = document.querySelector('input[name="sample_received"]:checked')?.value === "1";
        const isSampleReceivedNo = document.querySelector('input[name="sample_received"]:checked')?.value === "2";
        const isNewSampleYes = document.querySelector('input[name="new_sample"]:checked')?.value === "1";

        // Fields to show when sample is received OR a new sample is collected
        const showFields = ["date_collected", "date_received", "appearance", "sample_volume", "afb_microscopy"];
        const hideFields = ["sample_reason", "new_sample"];

        const shouldShowSampleFields = isSampleReceivedYes || (isSampleReceivedNo && isNewSampleYes);

        showFields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.style.display = shouldShowSampleFields ? "block" : "none";
                element.querySelectorAll("input").forEach(input => input.required = shouldShowSampleFields);
            }
        });

        hideFields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.style.display = isSampleReceivedYes ? "none" : "block";
                element.querySelectorAll("input").forEach(input => input.required = !isSampleReceivedYes);
            }
        });

        // Toggle "other_reason" visibility only when "sample_reason" is shown and selected as "96"
        const sampleReasonElement = document.getElementById("sample_reason");
        const otherReasonElement = document.getElementById("other_reason");
        if (otherReasonElement) {
            const sampleReasonValue = document.querySelector('input[name="sample_reason"]:checked')?.value;
            const shouldShowOtherReason = isSampleReceivedNo && sampleReasonElement.style.display !== "none" && sampleReasonValue === "96";
            otherReasonElement.style.display = shouldShowOtherReason ? "block" : "none";
            otherReasonElement.required = shouldShowOtherReason;
        }

        // Toggle "new_reason" visibility based on new_sample
        const newReasonElement = document.getElementById("new_reason");
        if (newReasonElement) {
            newReasonElement.style.display = isSampleReceivedNo && !isNewSampleYes ? "block" : "none";
            newReasonElement.required = isSampleReceivedNo && !isNewSampleYes;
        }

        // ---- Xpert MTB/RIF (Ultra) Test Section ----
        const xpertSection = document.getElementById("xpert_rif_test_section");
        const xpertSectionResults = document.getElementById("xpert_rif_results_section");

        const xpertFields = [
            "xpert_date_section",
            "xpert_mtb",
            "xpert_rif",
            "ct_value_section"
        ];

        const shouldShowXpert = isSampleReceivedYes || (isSampleReceivedNo && isNewSampleYes);

        if (xpertSection) {
            xpertSection.style.display = shouldShowXpert ? "block" : "none";
        }

        if (xpertSectionResults) {
            xpertSectionResults.style.display = shouldShowXpert ? "block" : "none";
        }
        xpertFields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.style.display = shouldShowXpert ? "block" : "none";
                element.querySelectorAll("input").forEach(input => {
                    input.required = shouldShowXpert;
                });
            }
        });

        // Ensure "remarks" remains optional
        const remarksField = document.getElementById("remarks");
        if (remarksField) {
            remarksField.required = false;
        }

        // Handle ct_value and ct_value_not_applicable logic
        handleCtValueRequirement();
    }

    function handleCtValueRequirement() {
        if (ctNotApplicableCheckbox.checked) {
            // Disable and clear ct_value if "Not Applicable" is checked
            ctValueInput.value = "";
            ctValueInput.disabled = true;
            ctValueInput.required = false;
        } else {
            // Make ct_value required if checkbox is unchecked
            ctValueInput.disabled = false;
            ctValueInput.required = document.getElementById("xpert_rif_test_section").style.display === "block";
        }
    }

    // Event Listeners
    sampleReceivedRadios.forEach(radio => radio.addEventListener("change", toggleFields));
    sampleReasonRadios.forEach(radio => radio.addEventListener("change", toggleFields));
    newSampleRadios.forEach(radio => radio.addEventListener("change", toggleFields));
    ctNotApplicableCheckbox.addEventListener("change", handleCtValueRequirement);

    toggleFields(); // Initial call to set the correct visibility state on page load
});



document.addEventListener('DOMContentLoaded', function () {
    const afbMicroscopyRadioButtons = document.querySelectorAll('input[name="afb_microscopy"]');
    const afbMicroscopyDiv = document.getElementById('afb_microscopy');
    const afbSectionA = document.getElementById('afb_technique_a_section');
    const afbSectionB = document.getElementById('afb_technique_b_section');
    const afbDateA = document.getElementById('afb_a_date_section');
    const afbDateB = document.getElementById('afb_b_date_section');
    const afbResultsA = document.getElementById('afb_results_a_section');
    const afbResultsB = document.getElementById('afb_results_b_section');
    const afbHeaderA = document.getElementById('afb-header');  // Slide A header
    const afbHeaderB = document.getElementById('afb-header');  // Slide A header
    const afbSubheaderA = document.getElementById('afb-subheader-A');
    const afbSubheaderB = document.getElementById('afb-subheader-B');

    // Function to toggle visibility and required status
    function toggleSections() {
        const afbMicroscopyValue = document.querySelector('input[name="afb_microscopy"]:checked');

        if (afbMicroscopyValue && afbMicroscopyValue.value === "1") {  // "Yes" is selected
            afbSectionA.style.display = 'block';
            afbSectionB.style.display = 'block';
            afbDateA.style.display = 'block';
            afbDateB.style.display = 'block';
            afbResultsA.style.display = 'block';
            afbResultsB.style.display = 'block';
            afbHeaderA.style.display = 'block';  // Show headers
            afbHeaderB.style.display = 'block';  // Show headers

            // Make the fields required
            document.getElementById('afb_a_date').required = true;
            document.getElementById('afb_b_date').required = true;

            const afbMicroscopyARadios = document.querySelectorAll('input[name="technique_a"]');
            const afbMicroscopyBRadios = document.querySelectorAll('input[name="technique_b"]');
            const afbResultsARadios = document.querySelectorAll('input[name="afb_a_results"]');
            const afbResultsBRadios = document.querySelectorAll('input[name="afb_b_results"]');

            afbMicroscopyARadios.forEach(radio => radio.required = true);
            afbMicroscopyBRadios.forEach(radio => radio.required = true);
            afbResultsARadios.forEach(radio => radio.required = true);
            afbResultsBRadios.forEach(radio => radio.required = true);
        } else {
            afbSectionA.style.display = 'none';
            afbSectionB.style.display = 'none';
            afbDateA.style.display = 'none';
            afbDateB.style.display = 'none';
            afbResultsA.style.display = 'none';
            afbResultsB.style.display = 'none';
            afbHeaderA.style.display = 'none';  // Hide headers
            afbHeaderB.style.display = 'none';  // Hide headers
            afbSubheaderA.style.display = 'none';  // Hide headers
            afbSubheaderB.style.display = 'none';  // Hide headers

            // Remove required fields
            document.getElementById('afb_a_date').required = false;
            document.getElementById('afb_b_date').required = false;

            const afbMicroscopyARadios = document.querySelectorAll('input[name="technique_a"]');
            const afbMicroscopyBRadios = document.querySelectorAll('input[name="technique_b"]');
            const afbResultsARadios = document.querySelectorAll('input[name="afb_a_results"]');
            const afbResultsBRadios = document.querySelectorAll('input[name="afb_b_results"]');

            afbMicroscopyARadios.forEach(radio => radio.required = false);
            afbMicroscopyBRadios.forEach(radio => radio.required = false);
            afbResultsARadios.forEach(radio => radio.required = false);
            afbResultsBRadios.forEach(radio => radio.required = false);
        }
    }

    // Event listener for when the user changes their selection
    afbMicroscopyRadioButtons.forEach(radio => {
        radio.addEventListener('change', toggleSections);
    });

    // Call the function on page load to ensure the correct state is applied
    toggleSections();
});



document.addEventListener("DOMContentLoaded", function () {
    const dateCollectedInput = document.getElementById("date_collected_input");
    const dateReceivedInput = document.getElementById("date_received_input");
    const enrollmentDateInput = document.getElementById("enrollment_date_hidded");
    const dateCollectedError = document.getElementById("date_collected_error");
    const dateReceivedError = document.getElementById("date_received_error");
    const form = document.querySelector("form");

    function validateDates() {
        const dateCollected = new Date(dateCollectedInput.value);
        const dateReceived = new Date(dateReceivedInput.value);
        const enrollmentDate = new Date(enrollmentDateInput.value);
        const today = new Date();

        let isValid = true;

        // Reset errors
        dateCollectedError.textContent = "";
        dateReceivedError.textContent = "";

        // Validation: date_collected must not be before enrollment_date
        if (dateCollected < enrollmentDate) {
            dateCollectedError.textContent = "Date collected cannot be before enrollment date.";
            isValid = false;
        }

        // Validation: date_collected must not be after date_received
        if (dateCollectedInput.value && dateReceivedInput.value && dateCollected > dateReceived) {
            dateCollectedError.textContent = "Date collected cannot be after date received.";
            isValid = false;
        }

        // Validation: no future dates allowed
        if (dateCollected > today) {
            dateCollectedError.textContent = "Date collected cannot be a future date.";
            isValid = false;
        }
        if (dateReceived > today) {
            dateReceivedError.textContent = "Date received cannot be a future date.";
            isValid = false;
        }

        return isValid;
    }

    // Add event listeners for validation on input change
    dateCollectedInput.addEventListener("change", validateDates);
    dateReceivedInput.addEventListener("change", validateDates);

    // Prevent form submission if validation fails
    form.addEventListener("submit", function (e) {
        if (!validateDates()) {
            e.preventDefault();
        }
    });
});
