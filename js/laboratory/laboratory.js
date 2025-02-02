document.addEventListener("DOMContentLoaded", function () {
    const sampleReceivedRadios = document.getElementsByName("sample_received");
    const sampleReasonRadios = document.getElementsByName("sample_reason");
    const newSampleRadios = document.getElementsByName("new_sample");

    function toggleFields() {
        const isSampleReceived = document.querySelector('input[name="sample_received"]:checked')?.value === "1";
        const sampleReasonValue = document.querySelector('input[name="sample_reason"]:checked')?.value;
        const isNewSampleYes = document.querySelector('input[name="new_sample"]:checked')?.value === "1";
        const isNewSampleNo = document.querySelector('input[name="new_sample"]:checked')?.value === "2";

        // Fields to show when a sample is received or if a new sample is collected
        const showFields = ["date_collected", "date_received", "appearance", "sample_volume", "afb_microscopy"];
        // Fields to hide when a sample is received
        const hideFields = ["sample_reason", "new_sample"];

        const shouldShowSampleFields = isSampleReceived || (!isSampleReceived && isNewSampleYes);

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
                element.style.display = isSampleReceived ? "none" : "block";
                element.querySelectorAll("input").forEach(input => input.required = !isSampleReceived);
            }
        });

        // Toggle "other_reason" visibility only when "sample_reason" is shown and selected as "96"
        const sampleReasonElement = document.getElementById("sample_reason");
        const otherReasonElement = document.getElementById("other_reason");
        if (otherReasonElement) {
            const shouldShowOtherReason = !isSampleReceived && sampleReasonElement.style.display !== "none" && sampleReasonValue === "96";
            otherReasonElement.style.display = shouldShowOtherReason ? "block" : "none";
            otherReasonElement.required = shouldShowOtherReason;
        }

        // Toggle "new_reason" visibility based on new_sample
        const newReasonElement = document.getElementById("new_reason");
        if (newReasonElement) {
            newReasonElement.style.display = (!isSampleReceived && isNewSampleNo) ? "block" : "none";
            newReasonElement.required = (!isSampleReceived && isNewSampleNo);
        }
    }

    sampleReceivedRadios.forEach(radio => radio.addEventListener("change", toggleFields));
    sampleReasonRadios.forEach(radio => radio.addEventListener("change", toggleFields));
    newSampleRadios.forEach(radio => radio.addEventListener("change", toggleFields));

    toggleFields(); // Initial call to set the correct visibility state on page load
});



    document.addEventListener('DOMContentLoaded', function() {
    const afbMicroscopyRadioButtons = document.querySelectorAll('input[name="afb_microscopy"]');
    const afbMicroscopyDiv = document.getElementById('afb_microscopy');
    const afbSectionA = document.getElementById('afb_technique_a_section');
    const afbSectionB = document.getElementById('afb_technique_b_section');
    const afbDateA = document.getElementById('afb_a_date_section');
    const afbDateB = document.getElementById('afb_b_date_section');
    const afbResultsA = document.getElementById('afb_results_a_section');
    const afbResultsB = document.getElementById('afb_results_b_section');
    const afbHeaderA = document.querySelector('h4.afb-subheader[data-slide="A"]');  // Slide A header
    const afbHeaderB = document.querySelector('h4.afb-subheader[data-slide="B"]');  // Slide B header
    const afbSubheaderA = document.querySelector('h4.afb-subheader[data-slide="A"]');
    const afbSubheaderB = document.querySelector('h4.afb-subheader[data-slide="B"]');

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
    document.getElementById('afb_date_a').required = true;
    document.getElementById('afb_date_b').required = true;

    const afbMicroscopyARadios = document.querySelectorAll('input[name="afb_microscopy_a"]');
    const afbMicroscopyBRadios = document.querySelectorAll('input[name="afb_microscopy_b"]');
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

    // Remove required fields
    document.getElementById('afb_date_a').required = false;
    document.getElementById('afb_date_b').required = false;

    const afbMicroscopyARadios = document.querySelectorAll('input[name="afb_microscopy_a"]');
    const afbMicroscopyBRadios = document.querySelectorAll('input[name="afb_microscopy_b"]');
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
