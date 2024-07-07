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

document.addEventListener("DOMContentLoaded", function () {
  const yesRadio = document.getElementById("tx_previous1");
  const noRadio = document.getElementById("tx_previous2");
  if (yesRadio.checked) {
    toggleElement("tx_previous_hide", yesRadio.value);
  } else if (noRadio.checked) {
    toggleElement("tx_previous_hide", noRadio.value);
  }
});
