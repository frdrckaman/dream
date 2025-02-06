document.addEventListener("DOMContentLoaded", function () {
    const sampleReceivedRadios = document.querySelectorAll("input[name='sample_received']"); // sample_received radio group
    const newSampleRadios = document.querySelectorAll("input[name='new_sample']"); // new_sample radio group
    const sampleReasonRadios = document.querySelectorAll("input[name='sample_reason']"); // sample_reason radio group
    const numberReceivedRadios = document.querySelectorAll("input[name='number_received']"); // number_received radio group
    const afbMicroscopyRadios = document.querySelectorAll("input[name='afb_microscopy_conducted']"); // afb_microscopy radio group
    const xpertMtbRifRadios = document.querySelectorAll("input[name='xpert_mtb_rif_conducted']"); // xpert_mtb_rif radio group

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

    function toggleSampleSections() {
        let sampleReceivedValue = Array.from(sampleReceivedRadios).find(radio => radio.checked)?.value;
        let newSampleValue = Array.from(newSampleRadios).find(radio => radio.checked)?.value;

        // Show sample_reason_section and new_sample_section if sample_received is "2"
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
        let newSampleValue = Array.from(newSampleRadios).find(radio => radio.checked)?.value;

        // Show other_new_reason_section ONLY if new_sample is "2", otherwise hide it
        otherNewReasonSection.style.display = newSampleValue === "2" ? "block" : "none";

        toggleNumberReceivedSection();
        toggleSampleReceivedSection();
        toggleSampleNumberSections();
    }

    function toggleNumberReceivedSection() {
        let sampleReceivedValue = Array.from(sampleReceivedRadios).find(radio => radio.checked)?.value;
        let newSampleValue = Array.from(newSampleRadios).find(radio => radio.checked)?.value;

        // Show only when sample_received=1 OR (sample_received=2 AND new_sample=1)
        numberReceivedSection.style.display =
            sampleReceivedValue === "1" || (sampleReceivedValue === "2" && newSampleValue === "1")
                ? "block"
                : "none";

        toggleSampleNumberSections();
    }

    function toggleSampleReceivedSection() {
        let sampleReceivedValue = Array.from(sampleReceivedRadios).find(radio => radio.checked)?.value;
        let newSampleValue = Array.from(newSampleRadios).find(radio => radio.checked)?.value;

        // Show only when sample_received=1 OR (sample_received=2 AND new_sample=1)
        sampleReceivedSection.style.display =
            sampleReceivedValue === "1" || (sampleReceivedValue === "2" && newSampleValue === "1")
                ? "block"
                : "none";
    }

    function toggleSampleNumberSections() {
        let numberReceivedValue = Array.from(numberReceivedRadios).find(radio => radio.checked)?.value;

        // Show only relevant sections based on number_received
        sample1Section.style.display = (numberReceivedValue === "1" || numberReceivedValue === "2") ? "block" : "none";
        sample2Section.style.display = numberReceivedValue === "2" ? "block" : "none";
    }

    function toggleOtherReasonSection() {
        let isSampleReason96 = Array.from(sampleReasonRadios).some(radio => radio.checked && radio.value === "96");

        // Show other_reason if sample_reason is "96"
        otherReasonSection.style.display = isSampleReason96 ? "block" : "none";
    }

    function toggleAfbMicroscopySection() {
        let afbMicroscopyValue = Array.from(afbMicroscopyRadios).find(radio => radio.checked)?.value;

        // Show afb_microscopy_section only if afb_microscopy=1
        afbMicroscopySection.style.display = afbMicroscopyValue === "1" ? "block" : "none";
    }

    function toggleXpertMtbRifSection() {
        let xpertMtbRifValue = Array.from(xpertMtbRifRadios).find(radio => radio.checked)?.value;

        // Show xpert_mtb_rif_section only if xpert_mtb_rif_conducted=1
        xpertMtbRifSection.style.display = xpertMtbRifValue === "1" ? "block" : "none";
    }

    // Attach event listeners
    sampleReceivedRadios.forEach(radio => radio.addEventListener("change", () => {
        toggleSampleSections();
        toggleOtherReasonSection();
        toggleNumberReceivedSection();
        toggleSampleReceivedSection();
        toggleSampleNumberSections();
    }));

    newSampleRadios.forEach(radio => radio.addEventListener("change", () => {
        toggleOtherNewReasonSection();
        toggleNumberReceivedSection();
        toggleSampleReceivedSection();
        toggleSampleNumberSections();
    }));

    numberReceivedRadios.forEach(radio => radio.addEventListener("change", toggleSampleNumberSections));

    sampleReasonRadios.forEach(radio => radio.addEventListener("change", toggleOtherReasonSection));

    afbMicroscopyRadios.forEach(radio => radio.addEventListener("change", toggleAfbMicroscopySection));

    xpertMtbRifRadios.forEach(radio => radio.addEventListener("change", toggleXpertMtbRifSection));

    // Run on page load to initialize the correct visibility
    toggleSampleSections();
    toggleOtherNewReasonSection();
    toggleNumberReceivedSection();
    toggleSampleReceivedSection();
    toggleSampleNumberSections();
    toggleOtherReasonSection();
    toggleAfbMicroscopySection();
    toggleXpertMtbRifSection();
});
