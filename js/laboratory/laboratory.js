document.addEventListener("DOMContentLoaded", function () {
    const sampleReceivedRadios = document.getElementsByName("sample_received");
    const sampleReasonRadios = document.getElementsByName("sample_reason");
    const newSampleRadios = document.getElementsByName("new_sample");

    function toggleFields() {
        const isSampleReceived = document.querySelector('input[name="sample_received"]:checked')?.value === "1";
        const sampleReasonValue = document.querySelector('input[name="sample_reason"]:checked')?.value;
        const isNewSampleNo = document.querySelector('input[name="new_sample"]:checked')?.value === "2";

        const showFields = ["date_collected", "date_received", "appearance", "sample_volume", "afb_microscopy"];
        const hideFields = ["other_reason", "new_sample"];

        showFields.forEach(id => {
            document.getElementById(id).style.display = isSampleReceived ? "block" : "none";
            document.querySelectorAll(`#${id} input`).forEach(input => input.required = isSampleReceived);
        });

        hideFields.forEach(id => {
            document.getElementById(id).style.display = isSampleReceived ? "none" : "block";
            document.querySelectorAll(`#${id} input`).forEach(input => input.required = !isSampleReceived);
        });

        document.getElementById("other_reason").style.display = (!isSampleReceived || sampleReasonValue === "96") ? "block" : "none";
        document.querySelectorAll("#other_reason input").forEach(input => input.required = (!isSampleReceived || sampleReasonValue === "96"));

        document.getElementById("new_reason").style.display = (!isSampleReceived && isNewSampleNo) ? "block" : "none";
        document.querySelectorAll("#new_reason input").forEach(input => input.required = (!isSampleReceived && isNewSampleNo));
    }

    sampleReceivedRadios.forEach(radio => radio.addEventListener("change", toggleFields));
    sampleReasonRadios.forEach(radio => radio.addEventListener("change", toggleFields));
    newSampleRadios.forEach(radio => radio.addEventListener("change", toggleFields));

    toggleFields(); // Initial call to set the correct visibility state on page load
});
