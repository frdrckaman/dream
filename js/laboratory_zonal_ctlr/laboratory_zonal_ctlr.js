document.addEventListener("DOMContentLoaded", function () {
    const culturePerformedRadios = document.querySelectorAll('input[name="culture_performed"]');
    const cultureMethodCheckboxes = document.querySelectorAll('input[name="culture_method[]"]');

    const cultureMethodSection = document.getElementById("culture_method_section");
    const microscopyTypeSection = document.getElementById("microscopy_type_section");
    const culturePerformedSection = document.getElementById("culture_performed_section");

    const ljResultsRadios = document.querySelectorAll('input[name="lj_results"]');
    const mgitResultsRadios = document.querySelectorAll('input[name="mgit_results"]');
    const cultureIsolateRadios = document.querySelectorAll('input[name="culture_isolate"]');
    const phenotypicPerformedRadios = document.querySelectorAll('input[name="phenotypic_performed"]');
    const xpertXdrPerformedRadios = document.querySelectorAll('input[name="xpert_xdr_performed"]');

    const firstLineLpaRadios = document.querySelectorAll('input[name="first_line_lpa"]');
    const secondLineLpaRadios = document.querySelectorAll('input[name="second_line_lpa"]');
    const firstLineLpaDateInput = document.getElementById("first_line_lpa_date");
    const secondLineLpaDateInput = document.getElementById("second_line_lpa_date");
    const firstLineLpaDateError = document.createElement("span");
    const secondLineLpaDateError = document.createElement("span");
    firstLineLpaDateError.className = "text-danger";
    secondLineLpaDateError.className = "text-danger";
    firstLineLpaDateInput.parentNode.appendChild(firstLineLpaDateError);
    secondLineLpaDateInput.parentNode.appendChild(secondLineLpaDateError);

    const cultureIsolateSection = document.getElementById("culture_isolate_section");
    const isolateDateSection = document.getElementById("isolate_date_section");
    const phenotypicDstSection = document.getElementById("phenotypic_dst_section");

    const phenotypicDatePerformedSection = document.getElementById("phenotypic_date_performed_section");
    const phenotypicDateResultsSection = document.getElementById("phenotypic_date_results_section");
    const phenotypicPerformedResultsSection = document.getElementById("phenotypic_performed_results_section");

    const xpertXdrDatePerformedSection = document.getElementById("xpert_xdr_date_performed_section");
    const xpertXdrResultsSection = document.getElementById("xpert_xdr_results_section");

    const firstLineSection = document.getElementById("first_line_section");
    const secondLineSection = document.getElementById("second_line_section");

    // LJ and MGIT Sections
    const ljInoculationDateSection = document.getElementById("lj_inoculation_date_section");
    const ljResultsDateSection = document.getElementById("lj_results_date_section");
    const ljResultsSection = document.getElementById("lj_results_section");

    const mgitInoculationDateSection = document.getElementById("mgit_inoculation_date_section");
    const mgitResultsDateSection = document.getElementById("mgit_results_date_section");
    const mgitResultsSection = document.getElementById("mgit_results_section");

    // Event listener for nanopore_done
    const nanoporeRadios = document.querySelectorAll('input[name="nanopore_done"]');
    const sequencingResultsSection = document.getElementById("sequencing_results_section");
    const nanoPoreResultsSection = document.getElementById("nano_pore_results");
    const epiToMeSection = document.getElementById("epi_to_me_section");
    const epiToMeSectionVesrionSection = document.getElementById("epi_to_me_version_section");

    const dateSputumReceivedInput = document.getElementById("date_sputum_received");
    const screeningDateCtrlZonalInput = document.getElementById("screening_date_ctrl_zonal");
    const dateSputumReceivedError = document.getElementById("date_sputum_received_error");
    const sampleVolumeInput = document.getElementById("sample_volume");
    const sampleVolumeError = document.getElementById("sample_volume_error");
    const microscopyDateInput = document.getElementById("microscopy_date");
    const microscopyDateError = document.getElementById("microscopy_date_error");
    const ljInoculationDateInput = document.getElementById("lj_inoculation_date");
    const ljResultsDateInput = document.getElementById("lj_results_date");
    const mgitInoculationDateInput = document.getElementById("mgit_inoculation_date");
    const mgitResultsDateInput = document.getElementById("mgit_results_date");
    const isolateDateInput = document.getElementById("isolate_date");
    const isolateDateError = document.createElement("span");
    const ljInoculationDateError = document.createElement("span");
    const ljResultsDateError = document.createElement("span");
    const mgitInoculationDateError = document.createElement("span");
    const mgitResultsDateError = document.createElement("span");
    ljInoculationDateError.className = "text-danger";
    ljResultsDateError.className = "text-danger";
    mgitInoculationDateError.className = "text-danger";
    mgitResultsDateError.className = "text-danger";
    isolateDateError.className = "text-danger";
    ljInoculationDateInput.parentNode.appendChild(ljInoculationDateError);
    ljResultsDateInput.parentNode.appendChild(ljResultsDateError);
    mgitInoculationDateInput.parentNode.appendChild(mgitInoculationDateError);
    mgitResultsDateInput.parentNode.appendChild(mgitResultsDateError);
    isolateDateInput.parentNode.appendChild(isolateDateError);
    const laboratoryZonalCtlrForm = document.getElementById("laboratory_zonal_ctlr");

    const phenotypicDatePerformedInput = document.getElementById("phenotypic_date_performed");
    const phenotypicDateResultsInput = document.getElementById("phenotypic_date_results");
    const phenotypicDatePerformedError = document.createElement("span");
    const phenotypicDateResultsError = document.createElement("span");
    phenotypicDatePerformedError.className = "text-danger";
    phenotypicDateResultsError.className = "text-danger";
    phenotypicDatePerformedInput.parentNode.appendChild(phenotypicDatePerformedError);
    phenotypicDateResultsInput.parentNode.appendChild(phenotypicDateResultsError);

    const xpertXdrDatePerformedInput = document.getElementById("xpert_xdr_date_performed");
    const xpertXdrDatePerformedError = document.createElement("span");
    xpertXdrDatePerformedError.className = "text-danger";
    xpertXdrDatePerformedInput.parentNode.appendChild(xpertXdrDatePerformedError);

    const labCtrlZoneStatusRadios = document.getElementById("lab_ctrl_zone_status");
    const labCtrlZoneDateCompletedInput = document.getElementById("lab_ctrl_zone_date_completed");
    const labCtrlZoneDateVerifiedInput = document.getElementById("lab_ctrl_zone_date_verified");
    const labCtrlZoneDateCompletedError = document.createElement("span");
    const labCtrlZoneDateVerifiedError = document.createElement("span");
    labCtrlZoneDateCompletedError.className = "text-danger";
    labCtrlZoneDateVerifiedError.className = "text-danger";
    labCtrlZoneDateCompletedInput.parentNode.appendChild(labCtrlZoneDateCompletedError);
    labCtrlZoneDateVerifiedInput.parentNode.appendChild(labCtrlZoneDateVerifiedError);

    laboratoryZonalCtlrForm.addEventListener("submit", function (event) {
        const dateSputumReceived = new Date(dateSputumReceivedInput.value);
        const screeningDateCtrlZonal = new Date(screeningDateCtrlZonalInput.value);
        const today = new Date();
        let isValid = true;

        if (dateSputumReceived < screeningDateCtrlZonal) {
            dateSputumReceivedError.textContent = `Date sputum received must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
            isValid = false;
        } else if (dateSputumReceived > today) {
            dateSputumReceivedError.textContent = "Date sputum received cannot be in the future.";
            isValid = false;
        } else {
            dateSputumReceivedError.textContent = "";
        }

        const sampleVolumePattern = /^\d{1,2}(\.\d)?$/;
        const sampleVolumeValue = parseFloat(sampleVolumeInput.value);
        if (!sampleVolumePattern.test(sampleVolumeInput.value) || sampleVolumeValue > 5 || sampleVolumeValue < 0.1) {
            sampleVolumeError.textContent = "Sample volume must be a number between 0.1 and 5 with up to one decimal place.";
            isValid = false;
        } else {
            sampleVolumeError.textContent = "";
        }

        const culturePerformed = document.querySelector('input[name="culture_performed"]:checked')?.value === "1";
        if (culturePerformed) {
            const microscopyDate = new Date(microscopyDateInput.value);
            if (microscopyDate < screeningDateCtrlZonal) {
                microscopyDateError.textContent = `Microscopy date must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
                isValid = false;
            } else if (microscopyDate > today) {
                microscopyDateError.textContent = "Microscopy date cannot be in the future.";
                isValid = false;
            } else {
                microscopyDateError.textContent = "";
            }
        }

        const isLJChecked = Array.from(cultureMethodCheckboxes).some(checkbox => checkbox.checked && checkbox.value === "1");
        if (isLJChecked) {
            const ljInoculationDate = new Date(ljInoculationDateInput.value);
            const ljResultsDate = new Date(ljResultsDateInput.value);
            if (ljInoculationDate < screeningDateCtrlZonal) {
                ljInoculationDateError.textContent = `LJ inoculation date must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
                isValid = false;
            } else if (ljInoculationDate > today) {
                ljInoculationDateError.textContent = "LJ inoculation date cannot be in the future.";
                isValid = false;
            } else {
                ljInoculationDateError.textContent = "";
            }
            if (ljResultsDate < ljInoculationDate) {
                ljResultsDateError.textContent = "LJ results date must be greater than or equal to the LJ inoculation date.";
                isValid = false;
            } else if (ljResultsDate > today) {
                ljResultsDateError.textContent = "LJ results date cannot be in the future.";
                isValid = false;
            } else {
                ljResultsDateError.textContent = "";
            }
        }

        const isMGITChecked = Array.from(cultureMethodCheckboxes).some(checkbox => checkbox.checked && checkbox.value === "2");
        if (isMGITChecked) {
            const mgitInoculationDate = new Date(mgitInoculationDateInput.value);
            const mgitResultsDate = new Date(mgitResultsDateInput.value);
            if (mgitInoculationDate < screeningDateCtrlZonal) {
                mgitInoculationDateError.textContent = `MGIT inoculation date must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
                isValid = false;
            } else if (mgitInoculationDate > today) {
                mgitInoculationDateError.textContent = "MGIT inoculation date cannot be in the future.";
                isValid = false;
            } else {
                mgitInoculationDateError.textContent = "";
            }
            if (mgitResultsDate < mgitInoculationDate) {
                mgitResultsDateError.textContent = "MGIT results date must be greater than or equal to the MGIT inoculation date.";
                isValid = false;
            } else if (mgitResultsDate > today) {
                mgitResultsDateError.textContent = "MGIT results date cannot be in the future.";
                isValid = false;
            } else {
                mgitResultsDateError.textContent = "";
            }
        }

        const cultureIsolate = document.querySelector('input[name="culture_isolate"]:checked')?.value === "1";
        if (cultureIsolate) {
            const isolateDate = new Date(isolateDateInput.value);
            if (isolateDate < screeningDateCtrlZonal) {
                isolateDateError.textContent = `Isolate date must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
                isValid = false;
            } else if (isolateDate > today) {
                isolateDateError.textContent = "Isolate date cannot be in the future.";
                isValid = false;
            } else {
                isolateDateError.textContent = "";
            }
        }

        const phenotypicPerformed = document.querySelector('input[name="phenotypic_performed"]:checked')?.value === "1";
        if (phenotypicPerformed) {
            const phenotypicDatePerformed = new Date(phenotypicDatePerformedInput.value);
            const phenotypicDateResults = new Date(phenotypicDateResultsInput.value);
            if (phenotypicDatePerformed < screeningDateCtrlZonal) {
                phenotypicDatePerformedError.textContent = `Phenotypic date performed must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
                isValid = false;
            } else if (phenotypicDatePerformed > today) {
                phenotypicDatePerformedError.textContent = "Phenotypic date performed cannot be in the future.";
                isValid = false;
            } else {
                phenotypicDatePerformedError.textContent = "";
            }
            if (phenotypicDateResults < phenotypicDatePerformed) {
                phenotypicDateResultsError.textContent = "Phenotypic date results must be greater than or equal to the phenotypic date performed.";
                isValid = false;
            } else if (phenotypicDateResults > today) {
                phenotypicDateResultsError.textContent = "Phenotypic date results cannot be in the future.";
                isValid = false;
            } else {
                phenotypicDateResultsError.textContent = "";
            }
        }

        const xpertXdrPerformed = document.querySelector('input[name="xpert_xdr_performed"]:checked')?.value === "1";
        if (xpertXdrPerformed) {
            const xpertXdrDatePerformed = new Date(xpertXdrDatePerformedInput.value);
            if (xpertXdrDatePerformed < screeningDateCtrlZonal) {
                xpertXdrDatePerformedError.textContent = `Xpert XDR date must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
                isValid = false;
            } else if (xpertXdrDatePerformed > today) {
                xpertXdrDatePerformedError.textContent = "Xpert XDR date cannot be in the future.";
                isValid = false;
            } else {
                xpertXdrDatePerformedError.textContent = "";
            }
        }

        const firstLineLpa = document.querySelector('input[name="first_line_lpa"]:checked')?.value === "1";
        if (firstLineLpa) {
            const firstLineLpaDate = new Date(firstLineLpaDateInput.value);
            if (firstLineLpaDate < screeningDateCtrlZonal) {
                firstLineLpaDateError.textContent = `First-line LPA date must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
                isValid = false;
            } else if (firstLineLpaDate > today) {
                firstLineLpaDateError.textContent = "First-line LPA date cannot be in the future.";
                isValid = false;
            } else {
                firstLineLpaDateError.textContent = "";
            }
        }

        const secondLineLpa = document.querySelector('input[name="second_line_lpa"]:checked')?.value === "1";
        if (secondLineLpa) {
            const secondLineLpaDate = new Date(secondLineLpaDateInput.value);
            if (secondLineLpaDate < screeningDateCtrlZonal) {
                secondLineLpaDateError.textContent = `Second-line LPA date must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
                isValid = false;
            } else if (secondLineLpaDate > today) {
                secondLineLpaDateError.textContent = "Second-line LPA date cannot be in the future.";
                isValid = false;
            } else {
                secondLineLpaDateError.textContent = "";
            }
        }

        const labCtrlZoneStatus = document.querySelector('input[name="form_status"]:checked')?.value;
        if (labCtrlZoneStatus === "1" || labCtrlZoneStatus === "2") {
            const labCtrlZoneDateCompleted = new Date(labCtrlZoneDateCompletedInput.value);
            const labCtrlZoneDateVerified = new Date(labCtrlZoneDateVerifiedInput.value);

            if (labCtrlZoneDateCompleted < screeningDateCtrlZonal) {
                labCtrlZoneDateCompletedError.textContent = `Completed date must be greater than or equal to the screening date (${screeningDateCtrlZonalInput.value}).`;
                isValid = false;
            } else if (labCtrlZoneDateCompleted > today) {
                labCtrlZoneDateCompletedError.textContent = "Completed date cannot be in the future.";
                isValid = false;
            } else {
                labCtrlZoneDateCompletedError.textContent = "";
            }

            if (labCtrlZoneDateVerified < labCtrlZoneDateCompleted) {
                labCtrlZoneDateVerifiedError.textContent = "Verified date must be greater than or equal to the completed date.";
                isValid = false;
            } else if (labCtrlZoneDateVerified > today) {
                labCtrlZoneDateVerifiedError.textContent = "Verified date cannot be in the future.";
                isValid = false;
            } else {
                labCtrlZoneDateVerifiedError.textContent = "";
            }
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are errors
        }
    });

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
        const isCultureIsolate = document.querySelector('input[name="culture_isolate"]:checked')?.value;
        isolateDateSection.style.display = isCultureIsolate === "1" ? "block" : "none";
        phenotypicDstSection.style.display = (isCultureIsolate === "1" || isCultureIsolate === "98") ? "block" : "none";
    }

    function togglePhenotypicSections() {
        const isPhenotypicPerformed = document.querySelector('input[name="phenotypic_performed"]:checked')?.value === "1";

        const displayStyle = isPhenotypicPerformed ? "block" : "none";
        phenotypicDatePerformedSection.style.display = displayStyle;
        phenotypicDateResultsSection.style.display = displayStyle;
        phenotypicPerformedResultsSection.style.display = displayStyle;
    }

    function toggleXpertXdrSections() {
        const isXpertXdrPerformed = document.querySelector('input[name="xpert_xdr_performed"]:checked')?.value === "1";

        const displayStyle = isXpertXdrPerformed ? "block" : "none";
        xpertXdrDatePerformedSection.style.display = displayStyle;
        xpertXdrResultsSection.style.display = displayStyle;
    }

    function toggleLpaSections() {
        const isFirstLineLpa = document.querySelector('input[name="first_line_lpa"]:checked')?.value === "1";
        const isSecondLineLpa = document.querySelector('input[name="second_line_lpa"]:checked')?.value === "1";

        firstLineSection.style.display = isFirstLineLpa ? "block" : "none";
        secondLineSection.style.display = isSecondLineLpa ? "block" : "none";
    }

    function toggleFirstLineLpaSection() {
        const isFirstLineLpa = document.querySelector('input[name="first_line_lpa"]:checked')?.value === "1";
        const displayStyle = isFirstLineLpa ? "block" : "none";
        document.getElementById("first_line_section").style.display = displayStyle;
    }

    function toggleSecondLineLpaSection() {
        const isSecondLineLpa = document.querySelector('input[name="second_line_lpa"]:checked')?.value === "1";
        const displayStyle = isSecondLineLpa ? "block" : "none";
        document.getElementById("second_line_section").style.display = displayStyle;
    }

    function toggleSequencingResults() {
        const isNanoporeDone = document.querySelector('input[name="nanopore_done"]:checked')?.value === "1";
        sequencingResultsSection.style.display = isNanoporeDone ? "block" : "none";
        nanoPoreResultsSection.style.display = isNanoporeDone ? "block" : "none"; // Added for nano_pore_results
        epiToMeSection.style.display = isNanoporeDone ? "block" : "none"; // Added for epiToMeSection
        epiToMeSectionVesrionSection.style.display = isNanoporeDone ? "block" : "none"; // Added for epiToMeSectionVesrionSection

    }

    function toggleCultureMethodSections() {
        const isLJChecked = Array.from(cultureMethodCheckboxes).some(checkbox => checkbox.checked && checkbox.value === "1");
        const isMGITChecked = Array.from(cultureMethodCheckboxes).some(checkbox => checkbox.checked && checkbox.value === "2");

        ljInoculationDateSection.style.display = isLJChecked ? "block" : "none";
        ljResultsDateSection.style.display = isLJChecked ? "block" : "none";
        ljResultsSection.style.display = isLJChecked ? "block" : "none";

        mgitInoculationDateSection.style.display = isMGITChecked ? "block" : "none";
        mgitResultsDateSection.style.display = isMGITChecked ? "block" : "none";
        mgitResultsSection.style.display = isMGITChecked ? "block" : "none";
    }

    // Initialize on page load
    toggleCultureSections();
    toggleCultureIsolateSection();
    toggleIsolateDetails();
    togglePhenotypicSections();
    toggleXpertXdrSections();
    toggleLpaSections();
    toggleFirstLineLpaSection();
    toggleSecondLineLpaSection();
    toggleSequencingResults();
    toggleCultureMethodSections();

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

    xpertXdrPerformedRadios.forEach(radio => {
        radio.addEventListener("change", toggleXpertXdrSections);
    });

    firstLineLpaRadios.forEach(radio => {
        radio.addEventListener("change", toggleLpaSections);
    });

    secondLineLpaRadios.forEach(radio => {
        radio.addEventListener("change", toggleLpaSections);
    });

    firstLineLpaRadios.forEach(radio => {
        radio.addEventListener("change", toggleFirstLineLpaSection);
    });

    secondLineLpaRadios.forEach(radio => {
        radio.addEventListener("change", toggleSecondLineLpaSection);
    });

    nanoporeRadios.forEach(radio => {
        radio.addEventListener("change", toggleSequencingResults);
    });

    cultureMethodCheckboxes.forEach(checkbox => {
        checkbox.addEventListener("change", toggleCultureMethodSections);
    });
});
