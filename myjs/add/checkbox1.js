// function checkCheckboxesOther() {
//     const elementsToControlOther = {
//       diseases_medical: {
//         96: ["diseases_specify1", "diseases_specify"],
//       },
//       sputum_samples: {
//         1: ["pleural_fluid_date1"],
//       },
//       // nanopore_sequencing: {
//       //   2: ["nanopore_sequencing_done00"],
//       // },
//       // question2: {
//       //   1: ["element4"],
//       //   2: ["element5"],
//       // },
//       // question3: {
//       //   1: ["element1", "element4"],
//       //   0: ["element2", "element5"],
//       // },
//     };

//   function handleVisibilityOther() {
//     // Hide all controlled elements
//     Object.values(elementsToControlOther)
//       .flatMap((condition) => Object.values(condition).flat())
//       .forEach((elementId) => {
//         document.getElementById(elementId).classList.add("hidden");
//       });

//     // Iterate through all questions
//     Object.keys(elementsToControlOther).forEach((question) => {
//       const checkboxes = document.getElementsByName(question);

//       // Show elements based on the selected checkboxes
//       checkboxes.forEach((checkbox) => {
//         if (checkbox.checked) {
//           const value = checkbox.value;
//           if (elementsToControlOther[question][value]) {
//             elementsToControlOther[question][value].forEach((elementId) => {
//               document.getElementById(elementId).classList.remove("hidden");
//             });
//           }
//         }

//         // Add event listener for changes
//         checkbox.addEventListener("change", () => {
//           handleVisibilityOther();
//         });
//       });
//     });
//   }

//   // Initial visibility check on page load
//   window.onload = handleVisibilityOther;
// }

// checkCheckboxesOther();
















// // // // // checkCheckboxes1();

// // // // // function checkCheckboxes1() {
// // // // //   const elementsToControl = {
// // // // //     nanopore_sequencing: ["nanopore_sequencing_done00"],
// // // // //     option2: ["element2"],
// // // // //     option3: ["element3"],
// // // // //   };

// // // // //   function handleVisibility() {
// // // // //     // Hide all controlled elements
// // // // //     Object.values(elementsToControl)
// // // // //       .flat()
// // // // //       .forEach((elementId) => {
// // // // //         document.getElementById(elementId).classList.add("hidden");
// // // // //       });

// // // // //     // Show elements based on the selected checkboxes
// // // // //     Object.keys(elementsToControl).forEach((option) => {
// // // // //       const checkbox = document.querySelector(`input[name="${option}"]`);

// // // // //       if (checkbox.checked) {
// // // // //         elementsToControl[option].forEach((elementId) => {
// // // // //           document.getElementById(elementId).classList.remove("hidden");
// // // // //         });
// // // // //       }

// // // // //       // Add event listener for changes
// // // // //       checkbox.addEventListener("change", () => {
// // // // //         handleVisibility();
// // // // //       });
// // // // //     });
// // // // //   }

// // // // //   // Initial visibility check on page load
// // // // //   window.onload = handleVisibility;
// // // // // }

// // // // // checkCheckboxes1();
