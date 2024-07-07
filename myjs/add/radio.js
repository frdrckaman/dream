// function hideElementOnRadioCheck(radio, elementId) {
//   const element = document.getElementById(elementId);
//   if (element) {
//     if (radio.checked) {
//       element.style.display = "none";
//     }
//   } else {
//     console.error("Element not found");
//   }
// }


function toggleElement(elementId, value) {
  const element = document.getElementById(elementId);
  if (element) {
    if (value === "1") {
      element.style.display = "block";
    } else if (value === "2") {
      element.style.display = "none";
    }
  } else {
    console.error("Element not found");
  }
}
