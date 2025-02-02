document.addEventListener("DOMContentLoaded", function () {
    const sampleReceivedRadios = document.getElementsByName("sample_received");
    const sampleReasonRadios = document.getElementsByName("sample_reason");
    const newSampleRadios = document.getElementsByName("new_sample");

    function toggleFields() {
        const isSampleReceived = document.querySelector('input[name="sample_received"]:checked')?.value === "1";
        const sampleReasonValue = document.querySelector('input[name="sample_reason"]:checked')?.value;
        const isNewSampleNo = document.querySelector('input[name="new_sample"]:checked')?.value === "2";

        // Fields to show when a sample is received
        const showFields = ["date_collected", "date_received", "appearance", "sample_volume", "afb_microscopy"];
        // Fields to hide when a sample is received
        const hideFields = ["sample_reason", "new_sample"];

        showFields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.style.display = isSampleReceived ? "block" : "none";
                element.querySelectorAll("input").forEach(input => input.required = isSampleReceived);
            }
        });

        hideFields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.style.display = isSampleReceived ? "none" : "block";
                element.querySelectorAll("input").forEach(input => input.required = !isSampleReceived);
            }
        });

        // Toggle "other_reason" visibility based on sample_reason
        const otherReasonElement = document.getElementById("other_reason");
        if (otherReasonElement) {
            otherReasonElement.style.display = (!isSampleReceived || sampleReasonValue === "96") ? "block" : "none";
            otherReasonElement.required = (!isSampleReceived || sampleReasonValue === "96");
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
