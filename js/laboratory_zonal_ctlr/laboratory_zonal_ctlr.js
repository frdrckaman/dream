document.addEventListener('DOMContentLoaded', function () {
    const culturePerformedRadios = document.getElementsByName('culture_performed'); // Radio buttons for culture_performed
    const phenotypicPerformedRadios = document.getElementsByName('phenotypic_performed'); // Radio buttons for phenotypic_performed
    const cultureIsolateRadios = document.getElementsByName('culture_isolate'); // Radio buttons for culture_isolate
    const cultureResultsRadios = document.getElementsByName('culture_results'); // Radio buttons for culture_results

    const cultureMethodSection = document.getElementById('culture_method_section');
    const cultureTypeSection = document.getElementById('culture_type_section');
    const culturePerformedSection = document.getElementById('culture_performed_section');
    const cultureIsolateSection = document.getElementById('culture_isolate_section');

    const phenotypicDatePerformedSection = document.getElementById('phenotypic_date_performed_section');
    const phenotypicDateResultsSection = document.getElementById('phenotypic_date_results_section');
    const phenotypicPerformedResultsSection = document.getElementById('phenotypic_performed_results_section');
    const phenotypicDstSection = document.getElementById('phenotypic_dst_section');

    function toggleCultureSections() {
        const culturePerformedValue = Array.from(culturePerformedRadios).find(radio => radio.checked)?.value;

        if (culturePerformedValue === '1') {
            cultureMethodSection.style.display = 'block';
            cultureTypeSection.style.display = 'block';
            culturePerformedSection.style.display = 'block';
        } else {
            cultureMethodSection.style.display = 'none';
            cultureTypeSection.style.display = 'none';
            culturePerformedSection.style.display = 'none';
        }
    }

    function togglePhenotypicSections() {
        const phenotypicPerformedValue = Array.from(phenotypicPerformedRadios).find(radio => radio.checked)?.value;

        if (phenotypicPerformedValue === '1') {
            phenotypicDatePerformedSection.style.display = 'block';
            phenotypicDateResultsSection.style.display = 'block';
            phenotypicPerformedResultsSection.style.display = 'block';
        } else {
            phenotypicDatePerformedSection.style.display = 'none';
            phenotypicDateResultsSection.style.display = 'none';
            phenotypicPerformedResultsSection.style.display = 'none';
        }
    }

    function toggleCultureIsolateSection() {
        const cultureResultsValue = Array.from(cultureResultsRadios).find(radio => radio.checked)?.value;
        const cultureIsolateValue = Array.from(cultureIsolateRadios).find(radio => radio.checked)?.value;

        // Handle culture_isolate section visibility based on culture_results
        if (cultureResultsValue === '1') {
            cultureIsolateSection.style.display = 'block';
        } else {
            cultureIsolateSection.style.display = 'none';
        }

        // Handle phenotypic sections based on culture_isolate value
        if (cultureIsolateValue === '1') {
            phenotypicDstSection.style.display = 'block';
            phenotypicPerformedResultsSection.style.display = 'block';
        } else {
            phenotypicDstSection.style.display = 'none';
            phenotypicPerformedResultsSection.style.display = 'none';
        }
    }

    function toggleCultureResultsSection() {
        const cultureResultsValue = Array.from(cultureResultsRadios).find(radio => radio.checked)?.value;

        if (cultureResultsValue === '1') {
            cultureIsolateSection.style.display = 'block';
        } else {
            cultureIsolateSection.style.display = 'none';
        }
    }

    // Run toggle functions on page load
    toggleCultureSections();
    togglePhenotypicSections();
    toggleCultureIsolateSection();
    toggleCultureResultsSection();

    // Add event listeners to update visibility when any radio button changes
    culturePerformedRadios.forEach(radio => {
        radio.addEventListener('change', toggleCultureSections);
    });

    phenotypicPerformedRadios.forEach(radio => {
        radio.addEventListener('change', togglePhenotypicSections);
    });

    cultureIsolateRadios.forEach(radio => {
        radio.addEventListener('change', toggleCultureIsolateSection);
    });

    cultureResultsRadios.forEach(radio => {
        radio.addEventListener('change', toggleCultureResultsSection);
    });
});
