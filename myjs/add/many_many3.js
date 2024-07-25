// document.addEventListener("DOMContentLoaded", function () {
//   // Define the elements to control and their corresponding radio button values
//   const elementsToControlMany = {
//     tx_previous: {
//       1: ["tx_number1", "dr_ds1", "tx_previous_hide1", "tx_previous_hide2"],
//     },
//     tb_category: {
//       1: ["relapse_years1"],
//       3: ["ltf_months1"],
//     },
//     regimen_changed: {
//       1: ["regimen_name1"],
//     },
//     immunosuppressive: {
//       1: ["immunosuppressive_specify1"],
//     },
//     other_diseases: {
//       1: ["diseases_medical"],
//     },
//     other_samples: {
//       1: ["sputum_samples"],
//     },
//     chest_x_ray: {
//       1: ["chest_x_ray_date1"],
//     },

//     //TOOL 2
//     sample_received: {
//       1: ["sample_amount", "sample_received_hides1", "sample_received_hides2"],
//       2: ["sample_reason"],
//     },
//     test_rejected: {
//       1: ["test_reasons"],
//     },
//     afb_microscopy: {
//       1: [
//         "afb_microscopy_date0",
//         "afb_microscopy_date1",
//         "afb_microscopy_date",
//         "zn_results",
//         "zn",
//       ],
//       2: [
//         "afb_microscopy_date0",
//         "afb_microscopy_date2",
//         "afb_microscopy_date",
//         "fm_results",
//         "fm",
//       ],
//     },

//     wrd_test: {
//       1: ["wrd_test_date1", "wrd_test_date"],
//       2: ["wrd_test_date1", "wrd_test_date"],
//       3: ["sequence_done"],
//     },

//     sequence_done: {
//       1: ["sequence_date1", "sequence_date", "sequence_type"],
//     },

//     sequence_type: {
//       1: ["mtb_detection"],
//       2: ["rif_resistance"],
//       3: ["test_repeatition"],
//       4: ["sequence_number1", "sequence_number", "test_repeatition"],
//       5: ["test_repeatition"],
//     },

//     test_repeatition: {
//       2: ["microscopy_reason"],
//     },

//     microscopy_reason: {
//       96: ["microscopy_reason_other1", "microscopy_reason_other"],
//     },

//     // TOOL 6
//     testrequest_reason: {
//       3: ["follow_up_months1", "follow_up_months"],
//     },
//     fm_done: {
//       1: ["fm_date", "fm_results", "dec_date"],
//     },
//     lpa2_done: {
//       1: [
//         "lpa2_date1",
//         "lpa2_date",
//         "lpa2_mtbdetected",
//         "lpa2dst_lfx",
//         "lpa2dst_ag_cp",
//         "lpa2dstag_lowkan",
//       ],
//     },
//   };

//   // Load dynamic content from files and append to the document
//   function loadDynamicContent(files, callback) {
//     const promises = files.map((file) =>
//       fetch(file).then((response) => response.text())
//     );
//     Promise.all(promises).then((contents) => {
//       contents.forEach((content, index) => {
//         const div = document.createElement("div");
//         div.id = `dynamicContent${index}`;
//         div.innerHTML = content;
//         document.body.appendChild(div);
//       });
//       if (callback) callback();
//     });
//   }

//   // Handle the visibility of elements based on radio button selections
//   function handleVisibilityMany() {
//     // Hide all controlled elements
//     Object.values(elementsToControlMany)
//       .flatMap((condition) => Object.values(condition).flat())
//       .forEach((elementId) => {
//         const element = document.getElementById(elementId);
//         if (element) {
//           element.classList.add("hidden");
//         }
//       });

//     // Iterate through all questions and manage visibility
//     Object.keys(elementsToControlMany).forEach((question) => {
//       const radios = document.getElementsByName(question);
//       let selectedValue = null;

//       // Find the checked radio button
//       radios.forEach((radio) => {
//         if (radio.checked) {
//           selectedValue = radio.value;
//         }

//         // Add event listener for changes
//         radio.addEventListener("change", () => {
//           handleVisibilityMany();
//         });
//       });

//       // Show elements based on the selected value
//       if (selectedValue && elementsToControlMany[question][selectedValue]) {
//         elementsToControlMany[question][selectedValue].forEach((elementId) => {
//           const element = document.getElementById(elementId);
//           if (element) {
//             element.classList.remove("hidden");
//           }
//         });
//       }
//     });
//   }

//   // Initial visibility check on page load
//   window.onload = () => {
//     const filesToLoad = ["process.php"]; // Add your file paths here
//     loadDynamicContent(filesToLoad, handleVisibilityMany);
//   };
// });

// checkRadioButtonsMany();
