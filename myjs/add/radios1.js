function checkRadioButtons1() {
  const elementsToHide1 = {
    culture_done: ["sample_type2", "sample_methods"],
    phenotypic_done: ["phenotypic_method", "phenotypic_done00"],
    genotyping_done: ["genotyping_asay", "genotyping_done00"],
    nanopore_sequencing_done: [
      "nanopore_sequencing",
      "nanopore_sequencing_done00",
    ],
  };

  Object.keys(elementsToHide1).forEach((question) => {
    const radios = document.getElementsByName(question);
    let value = "";

    radios.forEach((radio) => {
      if (radio.checked) {
        value = radio.value;
      }

      radio.addEventListener("change", () => {
        elementsToHide1[question].forEach((elementId) => {
          if (radio.value === "1" && radio.checked) {
            document.getElementById(elementId).classList.remove("hidden");
          } else {
            document.getElementById(elementId).classList.add("hidden");
          }
        });
      });
    });

    elementsToHide1[question].forEach((elementId) => {
      if (value === "1") {
        document.getElementById(elementId).classList.remove("hidden");
      } else {
        document.getElementById(elementId).classList.add("hidden");
      }
    });
  });
}

window.onload = checkRadioButtons1;
