document.addEventListener("DOMContentLoaded", function () {
    const tbDiagnosisRadios = document.querySelectorAll('input[name="tb_diagnosis"]');
    const tbDiagnosisMadeRadios = document.querySelectorAll('input[name="tb_diagnosis_made"]');
    const tbOtherDiagnosisRadios = document.querySelectorAll('input[name="tb_other_diagnosis"]');
    const tbRegimenRadios = document.querySelectorAll('input[name="tb_regimen"]');
    const tbTreatmentRadios = document.querySelectorAll('input[name="tb_treatment"]');
    const tbDiagnosedClinicallyCheckbox = document.getElementById("tb_diagnosed_clinically96");
    const regimenChangedRadios = document.querySelectorAll('input[name="regimen_changed"]'); // New section for regimen_changed

    const tbDiagnosisSection = document.getElementById("tb_diagnosis_made_section");
    const bacteriologicalDiagnosisSection = document.getElementById("bacteriological_diagnosis_section");
    const clinicianReceivedDateSection = document.getElementById("clinician_received_date_section");
    const diagnosisMadeOtherSection = document.getElementById("diagnosis_made_other_section");
    const tbDiagnosedClinicallySection = document.getElementById("tb_diagnosed_clinically_section");
    const tbClinicallyOtherSection = document.getElementById("tb_clinically_other_section");
    const tbTreatmentSection = document.getElementById("tb_treatment_section");
    const tbOtherSpecifySection = document.getElementById("tb_other_specify_section");
    const tbRegimenOtherSection = document.getElementById("tb_regimen_other_section");
    const tbTreatmentDateSection = document.getElementById("tb_treatment_date_section");
    const tbFacilitySection = document.getElementById("tb_facility_section");
    const tbReasonSection = document.getElementById("tb_reason_section");

    // New sections to show/hide based on tb_treatment=1
    const tbRegisterNumberSection = document.getElementById("tb_register_number_section");
    const tbRegimenPrescribedSection = document.getElementById("tb_regimen_prescribed_section");
    const regimenChangedSection = document.getElementById("regimen_changed_section");
    const tableSection = document.getElementById("table_section"); // The section to show/hide based on regimen_changed

    function toggleTbDiagnosisSection() {
        const selectedValue = document.querySelector('input[name="tb_diagnosis"]:checked')?.value;
        if (selectedValue === "1") {
            tbDiagnosisSection.style.display = "block";
            toggleTbDiagnosisMadeSections(); // Ensure related sections update
            tbTreatmentSection.style.display = "block"; // Show tb_treatment_section if tb_diagnosis=1
        } else {
            tbDiagnosisSection.style.display = "none";
            // Hide all dependent sections when tb_diagnosis is not 1
            bacteriologicalDiagnosisSection.style.display = "none";
            clinicianReceivedDateSection.style.display = "none";
            diagnosisMadeOtherSection.style.display = "none";
            tbDiagnosedClinicallySection.style.display = "none";
            tbClinicallyOtherSection.style.display = "none";
            tbTreatmentSection.style.display = "none"; // Hide tb_treatment_section if tb_diagnosis is not 1
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

    function toggleTbOtherSpecifySection() {
        const selectedValue = document.querySelector('input[name="tb_other_diagnosis"]:checked')?.value;
        tbOtherSpecifySection.style.display = selectedValue === "1" ? "block" : "none"; // Show tb_other_specify_section if tb_other_diagnosis=1
    }

    function toggleTbRegimenOtherSection() {
        const selectedValue = document.querySelector('input[name="tb_regimen"]:checked')?.value;
        // Show tb_regimen_other_section if tb_regimen is 96 or 7
        tbRegimenOtherSection.style.display = selectedValue === "96" || selectedValue === "7" ? "block" : "none";
    }

    function toggleTbTreatmentSections() {
        const selectedValue = document.querySelector('input[name="tb_treatment"]:checked')?.value;

        // Show sections based on tb_treatment selection
        tbTreatmentDateSection.style.display = selectedValue === "1" ? "block" : "none"; // Show tb_treatment_date_section if tb_treatment=1
        tbFacilitySection.style.display = selectedValue === "2" ? "block" : "none"; // Show tb_facility_section if tb_treatment=2
        tbReasonSection.style.display = selectedValue === "3" ? "block" : "none"; // Show tb_reason_section if tb_treatment=3

        // Show or hide the new sections when tb_treatment=1
        tbRegisterNumberSection.style.display = selectedValue === "1" ? "block" : "none";
        tbRegimenPrescribedSection.style.display = selectedValue === "1" ? "block" : "none";
        regimenChangedSection.style.display = selectedValue === "1" ? "block" : "none";
    }

    function toggleTbClinicallyOtherSection() {
        if (tbDiagnosedClinicallyCheckbox.checked) {
            tbClinicallyOtherSection.style.display = "block";
        } else {
            tbClinicallyOtherSection.style.display = "none";
        }
    }

    function toggleTableSection() {
        const selectedValue = document.querySelector('input[name="regimen_changed"]:checked')?.value;
        tableSection.style.display = selectedValue === "1" ? "block" : "none"; // Show table_section if regimen_changed=1
    }

    // Attach event listeners
    tbDiagnosisRadios.forEach(radio => {
        radio.addEventListener("change", toggleTbDiagnosisSection);
    });

    tbDiagnosisMadeRadios.forEach(radio => {
        radio.addEventListener("change", toggleTbDiagnosisMadeSections);
    });

    tbOtherDiagnosisRadios.forEach(radio => {
        radio.addEventListener("change", toggleTbOtherSpecifySection);
    });

    tbRegimenRadios.forEach(radio => {
        radio.addEventListener("change", toggleTbRegimenOtherSection);
    });

    tbTreatmentRadios.forEach(radio => {
        radio.addEventListener("change", toggleTbTreatmentSections);
    });

    tbDiagnosedClinicallyCheckbox.addEventListener("change", toggleTbClinicallyOtherSection);

    regimenChangedRadios.forEach(radio => {
        radio.addEventListener("change", toggleTableSection); // Event listener for regimen_changed
    });

    // Run functions on page load to check initial selections
    toggleTbDiagnosisSection();
    toggleTbDiagnosisMadeSections();
    toggleTbClinicallyOtherSection();
    toggleTbOtherSpecifySection();
    toggleTbRegimenOtherSection();
    toggleTbTreatmentSections(); // Ensure treatment sections are initialized
    toggleTableSection(); // Ensure table_section is initialized based on regimen_changed value
});
