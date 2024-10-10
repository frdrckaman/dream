const sequence_type1 = document.getElementById("sequence_type1");
const sequence_type2 = document.getElementById("sequence_type2");
const sequence_type3 = document.getElementById("sequence_type3");
const sequence_type4 = document.getElementById("sequence_type4");
const sequence_type5 = document.getElementById("sequence_type5");

// const sequence_done111 = document.getElementById("sequence_done1");
// const sequence_done222 = document.getElementById("sequence_done2");

const rif_resistance11111 = document.getElementById("rif_resistance1");
const rif_resistance22222 = document.getElementById("rif_resistance2");
const rif_resistance33333 = document.getElementById("rif_resistance3");

const sequence_number1 = document.getElementById("sequence_number1");
const sequence_number = document.getElementById("sequence_number");

const mtb_detection = document.getElementById("mtb_detection");
const rif_resistance = document.getElementById("rif_resistance");
const ct_value1 = document.getElementById("ct_value1");
const test_repeatition = document.getElementById("test_repeatition");

function toggleElementVisibility() {
  if (sequence_type1.checked) {
    sequence_number1.style.display = "none";
    sequence_number.style.display = "none";
    mtb_detection.style.display = "block";
    rif_resistance.style.display = "block";
    ct_value1.style.display = "block";
          if (rif_resistance33333.checked) {
            test_repeatition.style.display = "block";
          } else {
            test_repeatition.style.display = "none";
          }  } else if (sequence_type2.checked) {
    sequence_number1.style.display = "none";
    sequence_number.style.display = "none";
    mtb_detection.style.display = "none";
    rif_resistance.style.display = "none";
    ct_value1.style.display = "block";
    test_repeatition.style.display = "none";
  } else if (sequence_type3.checked) {
    sequence_number1.style.display = "none";
    sequence_number.style.display = "none";
    mtb_detection.style.display = "none";
    rif_resistance.style.display = "none";
    ct_value1.style.display = "none";
    if (rif_resistance33333.checked) {
      test_repeatition.style.display = "block";
    } else {
      test_repeatition.style.display = "none";
    }
  } else if (sequence_type4.checked) {
    sequence_number1.style.display = "block";
    sequence_number.style.display = "block";
    mtb_detection.style.display = "none";
    rif_resistance.style.display = "none";
    ct_value1.style.display = "none";

    if (rif_resistance33333.checked) {
      test_repeatition.style.display = "block";
    } else {
      test_repeatition.style.display = "none";
    }
  } else if (sequence_type5.checked) {
    sequence_number1.style.display = "none";
    sequence_number.style.display = "none";
    mtb_detection.style.display = "none";
    rif_resistance.style.display = "none";
    ct_value1.style.display = "none";
    if (rif_resistance33333.checked) {
      test_repeatition.style.display = "block";
    } else {
      test_repeatition.style.display = "none";
    }
  } else {
    sequence_number1.style.display = "none";
    sequence_number.style.display = "none";
    mtb_detection.style.display = "none";
    rif_resistance.style.display = "none";
    ct_value1.style.display = "none";
    test_repeatition.style.display = "none";
  }
}

sequence_type1.addEventListener("change", toggleElementVisibility);
sequence_type2.addEventListener("change", toggleElementVisibility);
sequence_type3.addEventListener("change", toggleElementVisibility);
sequence_type4.addEventListener("change", toggleElementVisibility);
sequence_type5.addEventListener("change", toggleElementVisibility);

// sequence_done111.addEventListener("change", toggleElementVisibility);
// sequence_done222.addEventListener("change", toggleElementVisibility);

rif_resistance11111.addEventListener("change", toggleElementVisibility);
rif_resistance22222.addEventListener("change", toggleElementVisibility);
rif_resistance33333.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
