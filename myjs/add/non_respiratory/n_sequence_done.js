const sequence_done2_1 = document.getElementById("sequence_done2_1");
const sequence_done2_2 = document.getElementById("sequence_done2_2");

const rif_resistance2_1 = document.getElementById("rif_resistance2_1");
const rif_resistance2_2 = document.getElementById("rif_resistance2_2");
const rif_resistance2_3 = document.getElementById("rif_resistance2_3");

const sequence_date2_1 = document.getElementById("sequence_date2_1");
const sequence_date2_2 = document.getElementById("sequence_date2_2");
const sequence_type2_0 = document.getElementById("sequence_type2_0");

const mtb_detection2_0 = document.getElementById("mtb_detection2_0");
const rif_resistance2_0 = document.getElementById("rif_resistance2_0");
const ct_value2_1 = document.getElementById("ct_value2_1");
const test_repeatition2_0 = document.getElementById("test_repeatition2_0");

function toggleElementVisibility() {
  if (sequence_done2_1.checked) {
    sequence_date2_1.style.display = "block";
    sequence_date2_2.style.display = "block";
    sequence_type2_0.style.display = "block";
    mtb_detection2_0.style.display = "block";
    rif_resistance2_0.style.display = "block";
    ct_value2_1.style.display = "block";
    // test_repeatition2_0.style.display = "block";

    if (rif_resistance2_3.checked) {
      test_repeatition2_0.style.display = "block";
    } else {
      test_repeatition2_0.style.display = "none";
    }
  } else if (sequence_done2_2.checked) {
    sequence_date2_1.style.display = "none";
    sequence_date2_2.style.display = "none";
    sequence_type2_0.style.display = "none";
    mtb_detection2_0.style.display = "none";
    rif_resistance2_0.style.display = "none";
    ct_value2_1.style.display = "none";
  } else {
    sequence_date2_1.style.display = "none";
    sequence_date2_2.style.display = "none";
    sequence_type2_0.style.display = "none";
    mtb_detection2_0.style.display = "none";
    rif_resistance2_0.style.display = "none";
    ct_value2_1.style.display = "none";
    test_repeatition2_0.style.display = "none";
  }
}

sequence_done2_1.addEventListener("change", toggleElementVisibility);
sequence_done2_2.addEventListener("change", toggleElementVisibility);

rif_resistance2_1.addEventListener("change", toggleElementVisibility);
rif_resistance2_2.addEventListener("change", toggleElementVisibility);
rif_resistance2_3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
