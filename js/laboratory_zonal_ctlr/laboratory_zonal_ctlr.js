document.addEventListener("DOMContentLoaded", function () {
    const culturePerformedRadios = document.querySelectorAll('input[name="culture_performed"]');
    const cultureMethodSection = document.getElementById("culture_method_section");
    const microscopyTypeSection = document.getElementById("microscopy_type_section");
    const culturePerformedSection = document.getElementById("culture_performed_section");

    const ljResultsRadios = document.querySelectorAll('input[name="lj_results"]');
    const mgitResultsRadios = document.querySelectorAll('input[name="mgit_results"]');
    const cultureIsolateRadios = document.querySelectorAll('input[name="culture_isolate"]');
    const phenotypicPerformedRadios = document.querySelectorAll('input[name="phenotypic_performed"]');

    const cultureIsolateSection = document.getElementById("culture_isolate_section");
    const isolateDateSection = document.getElementById("isolate_date_section");
    const phenotypicDstSection = document.getElementById("phenotypic_dst_section");

    const phenotypicDatePerformedSection = document.getElementById("phenotypic_date_performed_section");
    const phenotypicDateResultsSection = document.getElementById("phenotypic_date_results_section");
    const phenotypicPerformedResultsSection = document.getElementById("phenotypic_performed_results_section");

    function toggleCultureSections() {
        const isCulturePerformed = document.querySelector('input[name="culture_performed"]:checked')?.value === "1";

        const displayStyle = isCulturePerformed ? "block" : "none";
        cultureMethodSection.style.display = displayStyle;
        microscopyTypeSection.style.display = displayStyle;
        culturePerformedSection.style.display = displayStyle;
    }

    function toggleCultureIsolateSection() {
        const ljResults = document.querySelector('input[name="lj_results"]:checked')?.value;
        const mgitResults = document.querySelector('input[name="mgit_results"]:checked')?.value;
        const showIsolate = ["1", "2", "3", "4"].includes(ljResults) || mgitResults === "1";

        cultureIsolateSection.style.display = showIsolate ? "block" : "none";
    }

    function toggleIsolateDetails() {
        const isCultureIsolate = document.querySelector('input[name="culture_isolate"]:checked')?.value === "1";

        const displayStyle = isCultureIsolate ? "block" : "none";
        isolateDateSection.style.display = displayStyle;
        phenotypicDstSection.style.display = displayStyle;
    }

    function togglePhenotypicSections() {
        const isPhenotypicPerformed = document.querySelector('input[name="phenotypic_performed"]:checked')?.value === "1";

        const displayStyle = isPhenotypicPerformed ? "block" : "none";
        phenotypicDatePerformedSection.style.display = displayStyle;
        phenotypicDateResultsSection.style.display = displayStyle;
        phenotypicPerformedResultsSection.style.display = displayStyle;
    }

    // Initialize on page load
    toggleCultureSections();
    toggleCultureIsolateSection();
    toggleIsolateDetails();
    togglePhenotypicSections();

    // Add event listeners
    culturePerformedRadios.forEach(radio => {
        radio.addEventListener("change", toggleCultureSections);
    });

    ljResultsRadios.forEach(radio => {
        radio.addEventListener("change", toggleCultureIsolateSection);
    });

    mgitResultsRadios.forEach(radio => {
        radio.addEventListener("change", toggleCultureIsolateSection);
    });

    cultureIsolateRadios.forEach(radio => {
        radio.addEventListener("change", toggleIsolateDetails);
    });

    phenotypicPerformedRadios.forEach(radio => {
        radio.addEventListener("change", togglePhenotypicSections);
    });
});
