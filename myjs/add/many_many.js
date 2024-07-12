function checkRadioButtonsMany() {
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
    // testrequest_reason: {
    //   3: ["follow_up_months1", "follow_up_months"],
    // },
    // fm_done: {
    //   1: ["fm_date", "fm_results", "dec_date"],
    // },
    // lpa2_done: {
    //   1: [
    //     "lpa2_date1",
    //     "lpa2_date",
    //     "lpa2_mtbdetected",
    //     "lpa2dst_lfx",
    //     "lpa2dst_ag_cp",
    //     "lpa2dstag_lowkan",
    //   ],
    // },
    // afb_microscopy: {
    //   1: [
    //     "n_afb_microscopy_date1",
    //     "n_zn_microscopy_date1",
    //     "n_afb_microscopy_date",
    //   ],
    //   2: [
    //     "n_afb_microscopy_date1",
    //     "n_fm_microscopy_date1",
    //     "n_afb_microscopy_date",
    //   ],
    // },
    // question3: {
    //     '1': [],
    //     '0': []
    // }
  };

  function handleVisibilityMany() {
    // Hide all controlled elements
    Object.values(elementsToControlMany)
      .flatMap((condition) => Object.values(condition).flat())
      .forEach((elementId) => {
        document.getElementById(elementId).classList.add("hidden");
      });

    // Iterate through all questions
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

      // Show elements based on the selected value
      if (selectedValue && elementsToControlMany[question][selectedValue]) {
        elementsToControlMany[question][selectedValue].forEach((elementId) => {
          document.getElementById(elementId).classList.remove("hidden");
        });
      }
    });
  }

  // Initial visibility check on page load
  window.onload = handleVisibilityMany;
}

checkRadioButtonsMany();
