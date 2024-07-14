// function checkRadioButtonsMany2() {
//   const elementsToControlMany2 = {
//     sample_received: {
//       1: ["sample_amount"],
//       2: ["sample_reason"],
//     },
//   };

//   function handleVisibilityMany2() {
//     // Hide all controlled elements
//     Object.values(elementsToControlMany2)
//       .flatMap((condition2) => Object.values(condition2).flat())
//       .forEach((elementId2) => {
//         document.getElementById(elementId2).classList.add("hidden");
//       });

//     // Iterate through all questions
//     Object.keys(elementsToControlMany2).forEach((question2) => {
//       const radios2 = document.getElementsByName(question2);
//       let selectedValue2 = null;

//       // Find the checked radio button
//       radios2.forEach((radio) => {
//         if (radio.checked) {
//           selectedValue2 = radio.value;
//         }

//         // Add event listener for changes
//         radio.addEventListener("change", () => {
//           handleVisibilityMany2();
//         });
//       });

//       // Show elements based on the selected value
//       if (selectedValue2 && elementsToControlMany2[question2][selectedValue2]) {
//         elementsToControlMany2[question2][selectedValue2].forEach(
//           (elementId2) => {
//             document.getElementById(elementId2).classList.remove("hidden");
//           }
//         );
//       }
//     });
//   }

//   // Initial visibility check on page load
//   window.onload = handleVisibilityMany2;
// }

// checkRadioButtonsMany2();
