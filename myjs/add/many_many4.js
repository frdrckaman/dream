document.addEventListener("DOMContentLoaded", function () {
  // Define the elements to control and their corresponding radio button values
  const elementsToControlMany = {
    tx_previous: {
      1: ["tx_number1", "dr_ds1", "tx_previous_hide1", "tx_previous_hide2"],
    },
    tb_category: {
      1: ["relapse_years1"],
      3: ["ltf_months1"],
    },
    regimen_changed: {
      1: ["regimen_name1"],
    },
    immunosuppressive: {
      1: ["immunosuppressive_specify1"],
    },
    other_diseases: {
      1: ["diseases_medical"],
    },
    other_samples: {
      1: ["sputum_samples"],
    },
    chest_x_ray: {
      1: ["chest_x_ray_date1"],
    },
  };

  const elementsToControlMany2 = {
    sample_received: {
      1: ["sample_amount"],
      2: ["sample_reason"],
    },
  };

  // Load dynamic content from files and append to the document
  function loadDynamicContent(files, callback) {
    const promises = files.map((file) =>
      fetch(file).then((response) => response.text())
    );
    Promise.all(promises).then((contents) => {
      contents.forEach((content, index) => {
        const div = document.createElement("div");
        div.id = `dynamicContent${index}`;
        div.innerHTML = content;
        document.body.appendChild(div);
      });
      if (callback) callback();
    });
  }

  // Handle the visibility and required attribute of elements based on radio button selections
  function handleVisibilityMany() {
    // Hide all controlled elements and remove required attribute
    Object.values(elementsToControlMany)
      .flatMap((condition) => Object.values(condition).flat())
      .forEach((elementId) => {
        const element = document.getElementById(elementId);
        if (element) {
          element.classList.add("hidden");
          element.removeAttribute("required");
        }
      });

    // Iterate through all questions and manage visibility and required attribute
    Object.keys(elementsToControlMany).forEach((question) => {
      const radios = document.getElementsByName(question);
      let selectedValue = null;

      // Find the checked radio button
      radios.forEach((radio) => {
        if (radio.checked) {
          selectedValue = radio.value;
        }

        // Add event listener for changes
        radio.addEventListener("change", () => {
          handleVisibilityMany();
        });
      });

      // Show elements and set required attribute based on the selected value
      if (selectedValue && elementsToControlMany[question][selectedValue]) {
        elementsToControlMany[question][selectedValue].forEach((elementId) => {
          const element = document.getElementById(elementId);
          if (element) {
            element.classList.remove("hidden");
            element.setAttribute("required", "required");
          }
        });
      }
    });
  }

  // Initial visibility check on page load
  window.onload = () => {
    const filesToLoad = ["batch.php"]; // Add your file paths here
    loadDynamicContent(filesToLoad, handleVisibilityMany);
  };

  // Form validation
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
});

checkRadioButtonsMany();
