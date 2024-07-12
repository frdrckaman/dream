// function checkRadioButtonsMany2() {
//   const elementsToControlMany2 = {
//     sample_received: {
//       1: ["sample_amount"],
//       2: ["sample_reason"],
//     },
//     // testrequest_reason: {
//     //   3: ["follow_up_months1", "follow_up_months"],
//     // },
//     // fm_done: {
//     //   1: ["fm_date", "fm_results", "dec_date"],
//     // },
//     // lpa2_done: {
//     //   1: [
//     //     "lpa2_date1",
//     //     "lpa2_date",
//     //     "lpa2_mtbdetected",
//     //     "lpa2dst_lfx",
//     //     "lpa2dst_ag_cp",
//     //     "lpa2dstag_lowkan",
//     //   ],
//     // },
//     // afb_microscopy: {
//     //   1: [
//     //     "n_afb_microscopy_date1",
//         // "n_zn_microscopy_date1",
//     //     "n_afb_microscopy_date",
//     //   ],
//     //   2: [
//     //     "n_afb_microscopy_date1",
//     //     "n_fm_microscopy_date1",
//     //     "n_afb_microscopy_date",
//     //   ],
//     // },
//     // question3: {
//     //     '1': [],
//     //     '0': []
//     // }
//   };

//   function handleVisibilityMany2() {
//     // Hide all controlled elements
//     Object.values(elementsToControlMany2)
//       .flatMap((condition) => Object.values(condition).flat())
//       .forEach((elementId) => {
//         document.getElementById(elementId).classList.add("hidden");
//       });

//     // Iterate through all questions
//     Object.keys(elementsToControlMany2).forEach((question) => {
//       const radios = document.getElementsByName(question);
//       let selectedValue = null;

//       // Find the checked radio button
//       radios.forEach((radio) => {
//         if (radio.checked) {
//           selectedValue = radio.value;
//         }

//         // Add event listener for changes
//         radio.addEventListener("change", () => {
//           handleVisibilityMany2();
//         });
//       });

//       // Show elements based on the selected value
//       if (selectedValue && elementsToControlMany2[question][selectedValue]) {
//         elementsToControlMany2[question][selectedValue].forEach((elementId) => {
//           document.getElementById(elementId).classList.remove("hidden");
//         });
//       }
//     });
//   }

//   // Initial visibility check on page load
//   window.onload = handleVisibilityMany2;
// }

// checkRadioButtonsMany2();
