function checkRadioButtons() {
  const elementsToHide = {
    culture_done: ["sample_type2", "sample_methods"],
    sample_type2: ["sample_type_other2_1", "sample_type_other2_2"],
    question3: ["element4", "element5"],
  };

  Object.keys(elementsToHide).forEach((question) => {
    const radios = document.getElementsByName(question);
    let value = "";

    radios.forEach((radio) => {
      if (radio.checked) {
        value = radio.value;
      }

      radio.addEventListener("change", () => {
        elementsToHide[question].forEach((elementId) => {
          if (radio.value === "1" && radio.checked) {
            document.getElementById(elementId).classList.remove("hidden");
          } else if (radio.value === "96" && radio.checked) {
            document.getElementById(elementId).classList.remove("hidden");
          } else {
            document.getElementById(elementId).classList.add("hidden");
          }
        });
      });
    });

    elementsToHide[question].forEach((elementId) => {
      if (value === "1") {
        document.getElementById(elementId).classList.remove("hidden");
      } else if (value === "96") {
        document.getElementById(elementId).classList.remove("hidden");
      } else {
        document.getElementById(elementId).classList.add("hidden");
      }
    });
  });
}

window.onload = checkRadioButtons;
