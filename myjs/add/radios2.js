// Function to hide elements based on radio button value
function hideElementOnRadioCheck(radioName, valueToCheck, elementId) {
  const radios = document.getElementsByName(radioName);
  const element = document.getElementById(elementId);

  radios.forEach((radio) => {
    if (radio.value === valueToCheck && radio.checked) {
      element.classList.remove("hidden");
    } else {
      element.classList.add("hidden");
    }
  });
}

// Function to check conditions on page load
function checkConditionsOnLoad() {
  // Example: Check condition for question 1
  hideElementOnRadioCheck("sample_received", "1", "test_rejected");

  // Example: Check condition for question 2
  hideElementOnRadioCheck("wrd_test", "3", "sequence_done");

  // Example: Check condition for question 2
  hideElementOnRadioCheck("sequence_done", "1", "sequence_type");

  
}

// Event listener for page load
window.addEventListener("load", checkConditionsOnLoad);
