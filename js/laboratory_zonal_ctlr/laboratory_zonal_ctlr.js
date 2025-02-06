document.addEventListener('DOMContentLoaded', function () {
    const culturePerformedRadios = document.getElementsByName('culture_performed'); // Radio buttons for culture_performed
    const phenotypicPerformedRadios = document.getElementsByName('phenotypic_performed'); // Radio buttons for phenotypic_performed
    const cultureIsolateRadios = document.getElementsByName('culture_isolate'); // Radio buttons for culture_isolate
    const cultureResultsRadios = document.getElementsByName('culture_results'); // Radio buttons for culture_results
    const xpertXdrPerformedRadios = document.getElementsByName('xpert_xdr_performed'); // Radio buttons for xpert_xdr_performed
    const firstLineLpaRadios = document.getElementsByName('first_line_lpa'); // Radio buttons for first_line_lpa
    const secondLineLpaRadios = document.getElementsByName('second_line_lpa'); // Radio buttons for second_line_lpa

    const cultureMethodSection = document.getElementById('culture_method_section');
    const cultureTypeSection = document.getElementById('culture_type_section');
    const culturePerformedSection = document.getElementById('culture_performed_section');
    const cultureIsolateSection = document.getElementById('culture_isolate_section');

    const phenotypicDatePerformedSection = document.getElementById('phenotypic_date_performed_section');
    const phenotypicDateResultsSection = document.getElementById('phenotypic_date_results_section');
    const phenotypicPerformedResultsSection = document.getElementById('phenotypic_performed_results_section');
    const phenotypicDstSection = document.getElementById('phenotypic_dst_section');

    const xpertXdrDatePerformedSection = document.getElementById('xpert_xdr_date_performed_section');
    const xpertXdrResultsSection = document.getElementById('xpert_xdr_results_section');

    const firstLineSection = document.getElementById('first_line_section');
    const secondLineSection = document.getElementById('second_line_section');

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
            phenotypicPerformedResultsSection.style.display = 'block'; // Show when phenotypic_performed = 1
        } else {
            phenotypicDatePerformedSection.style.display = 'none';
            phenotypicDateResultsSection.style.display = 'none';
            phenotypicPerformedResultsSection.style.display = 'none'; // Hide when phenotypic_performed is not 1
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

    function toggleXpertXdrSections() {
        const xpertXdrPerformedValue = Array.from(xpertXdrPerformedRadios).find(radio => radio.checked)?.value;

        if (xpertXdrPerformedValue === '1') {
            xpertXdrDatePerformedSection.style.display = 'block';
            xpertXdrResultsSection.style.display = 'block';
        } else {
            xpertXdrDatePerformedSection.style.display = 'none';
            xpertXdrResultsSection.style.display = 'none';
        }
    }

    function toggleFirstLineLpaSection() {
        const firstLineLpaValue = Array.from(firstLineLpaRadios).find(radio => radio.checked)?.value;

        if (firstLineLpaValue === '1') {
            firstLineSection.style.display = 'block';
        } else {
            firstLineSection.style.display = 'none';
        }
    }

    function toggleSecondLineLpaSection() {
        const secondLineLpaValue = Array.from(secondLineLpaRadios).find(radio => radio.checked)?.value;

        if (secondLineLpaValue === '1') {
            secondLineSection.style.display = 'block';
        } else {
            secondLineSection.style.display = 'none';
        }
    }

    // Run toggle functions on page load
    toggleCultureSections();
    togglePhenotypicSections();
    toggleCultureIsolateSection();
    toggleCultureResultsSection();
    toggleXpertXdrSections();
    toggleFirstLineLpaSection();
    toggleSecondLineLpaSection();

    // Check the initial value of phenotypic_performed and show/hide the phenotypic_performed_results_section accordingly
    const phenotypicPerformedValueOnLoad = Array.from(phenotypicPerformedRadios).find(radio => radio.checked)?.value;
    if (phenotypicPerformedValueOnLoad === '1') {
        phenotypicPerformedResultsSection.style.display = 'block';
    } else {
        phenotypicPerformedResultsSection.style.display = 'none';
    }

    // Check the initial value of xpert_xdr_performed and show/hide the related sections accordingly
    const xpertXdrPerformedValueOnLoad = Array.from(xpertXdrPerformedRadios).find(radio => radio.checked)?.value;
    if (xpertXdrPerformedValueOnLoad === '1') {
        xpertXdrDatePerformedSection.style.display = 'block';
        xpertXdrResultsSection.style.display = 'block';
    } else {
        xpertXdrDatePerformedSection.style.display = 'none';
        xpertXdrResultsSection.style.display = 'none';
    }

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

    xpertXdrPerformedRadios.forEach(radio => {
        radio.addEventListener('change', toggleXpertXdrSections);
    });

    firstLineLpaRadios.forEach(radio => {
        radio.addEventListener('change', toggleFirstLineLpaSection);
    });

    secondLineLpaRadios.forEach(radio => {
        radio.addEventListener('change', toggleSecondLineLpaSection);
    });
});
