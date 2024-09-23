// function checkRadioButtons2() {
//     const elementsToControl2 = {
//       afb_microscopy: {
//         1: ["afb_microscopy_date1", "afb_microscopy_date"],
//         2: ["afb_microscopy_date2", "afb_microscopy_date"],
//       },
//       // phenotypic_method: {
//       //   1: ["apm_date_1", "apm_date"],
//       //   2: ["mgit_date2_1", "mgit_date2"],
//       // },
//       // question2: {
//       //     '1': ['element4'],
//       //     '2': ['element5']
//       // },
//       // question3: {
//       //     '1': [],
//       //     '0': []
//       // }
//     };

//   function handleVisibility2() {
//     // Hide all controlled elements
//     Object.values(elementsToControl2)
//       .flatMap((condition) => Object.values(condition).flat())
//       .forEach((elementId) => {
//         document.getElementById(elementId).classList.add("hidden");
//       });

//     // Iterate through all questions
//     Object.keys(elementsToControl2).forEach((question) => {
//       const radios = document.getElementsByName(question);
//       let selectedValue = null;

//       // Find the checked radio button
//       radios.forEach((radio) => {
//         if (radio.checked) {
//           selectedValue = radio.value;
//         }

//         // Add event listener for changes
//         radio.addEventListener("change", () => {
//           handleVisibility2();
//         });
//       });

//       // Show elements based on the selected value
//       if (selectedValue && elementsToControl2[question][selectedValue]) {
//         elementsToControl2[question][selectedValue].forEach((elementId) => {
//           document.getElementById(elementId).classList.remove("hidden");
//         });
//       }
//     });
//   }

//   // Initial visibility check on page load
//   window.onload = handleVisibility2;
// }

// checkRadioButtons2();
