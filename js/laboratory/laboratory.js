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
