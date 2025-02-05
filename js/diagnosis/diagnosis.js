document.addEventListener("DOMContentLoaded", function () {
    const tbDiagnosisRadios = document.querySelectorAll('input[name="tb_diagnosis"]');
    const tbDiagnosisMadeRadios = document.querySelectorAll('input[name="tb_diagnosis_made"]');
    const tbDiagnosedClinicallyCheckbox = document.getElementById("tb_diagnosed_clinically_96");

    const tbDiagnosisSection = document.getElementById("tb_diagnosis_made_section");
    const bacteriologicalDiagnosisSection = document.getElementById("bacteriological_diagnosis_section");
    const clinicianReceivedDateSection = document.getElementById("clinician_received_date_section");
    const diagnosisMadeOtherSection = document.getElementById("diagnosis_made_other_section");
    const tbDiagnosedClinicallySection = document.getElementById("tb_diagnosed_clinically_section");
    const tbClinicallyOtherSection = document.getElementById("tb_clinically_other_section");

    function toggleTbDiagnosisSection() {
        const selectedValue = document.querySelector('input[name="tb_diagnosis"]:checked')?.value;
        if (selectedValue === "1") {
            tbDiagnosisSection.style.display = "block";
            toggleTbDiagnosisMadeSections(); // Ensure related sections update
        } else {
            tbDiagnosisSection.style.display = "none";
            // Hide all dependent sections when tb_diagnosis is not 1
            bacteriologicalDiagnosisSection.style.display = "none";
            clinicianReceivedDateSection.style.display = "none";
            diagnosisMadeOtherSection.style.display = "none";
            tbDiagnosedClinicallySection.style.display = "none";
            tbClinicallyOtherSection.style.display = "none";
        }
    }

    function toggleTbDiagnosisMadeSections() {
        const selectedValue = document.querySelector('input[name="tb_diagnosis_made"]:checked')?.value;

        // Show or hide sections based on tb_diagnosis_made selection
        bacteriologicalDiagnosisSection.style.display = selectedValue === "2" ? "block" : "none";
        clinicianReceivedDateSection.style.display = selectedValue === "2" ? "block" : "none";
        diagnosisMadeOtherSection.style.display = selectedValue === "96" ? "block" : "none";
        tbDiagnosedClinicallySection.style.display = selectedValue === "2" ? "block" : "none";  // Show for tb_diagnosis_made=2
        tbDiagnosedClinicallySection.style.display = selectedValue === "1" ? "none" : tbDiagnosedClinicallySection.style.display;  // Hide for tb_diagnosis_made=1

        // Ensure tb_clinically_other_section updates correctly
        toggleTbClinicallyOtherSection();
    }

    function toggleTbClinicallyOtherSection() {
        if (tbDiagnosedClinicallyCheckbox.checked) {
            tbClinicallyOtherSection.style.display = "block";
        } else {
            tbClinicallyOtherSection.style.display = "none";
        }
    }

    // Attach event listeners
    tbDiagnosisRadios.forEach(radio => {
        radio.addEventListener("change", toggleTbDiagnosisSection);
    });

    tbDiagnosisMadeRadios.forEach(radio => {
        radio.addEventListener("change", toggleTbDiagnosisMadeSections);
    });

    tbDiagnosedClinicallyCheckbox.addEventListener("change", toggleTbClinicallyOtherSection);

    // Run functions on page load to check initial selections
    toggleTbDiagnosisSection();
    toggleTbDiagnosisMadeSections();
    toggleTbClinicallyOtherSection();
});
