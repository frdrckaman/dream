const sequence_type2_1 = document.getElementById("sequence_type2_1");
const sequence_type2_2 = document.getElementById("sequence_type2_2");
const sequence_type2_3 = document.getElementById("sequence_type2_3");
const sequence_type2_4 = document.getElementById("sequence_type2_4");
const sequence_type2_5 = document.getElementById("sequence_type2_5");

const test_repeatition2_1 = document.getElementById("test_repeatition2_1");
const test_repeatition2_2 = document.getElementById("test_repeatition2_2");

const rif_resistance2_1 = document.getElementById("rif_resistance2_1");
const rif_resistance2_2 = document.getElementById("rif_resistance2_2");
const rif_resistance2_3 = document.getElementById("rif_resistance2_3");

const sequence_number2_1 = document.getElementById("sequence_number2_1");
const sequence_number2_2 = document.getElementById("sequence_number2_2");

const mtb_detection2_0 = document.getElementById("mtb_detection2_0");
const rif_resistance2_0 = document.getElementById("rif_resistance2_0");
const ct_value2_1 = document.getElementById("ct_value2_1");
const test_repeatition2_0 = document.getElementById("test_repeatition2_0");

function toggleElementVisibility() {
  if (sequence_type2_1.checked) {
    sequence_number2_1.style.display = "none";
    sequence_number2_2.style.display = "none";
    mtb_detection2_0.style.display = "block";
    rif_resistance2_0.style.display = "block";
    ct_value2_1.style.display = "block";
    test_repeatition2_0.style.display = "block";
  } else if (sequence_type2_1.checked && rif_resistance2_3.checked) {
    sequence_number2_1.style.display = "none";
    sequence_number2_2.style.display = "none";
    mtb_detection2_0.style.display = "block";
    rif_resistance2_0.style.display = "block";
    ct_value2_1.style.display = "block";
    test_repeatition2_0.style.display = "block";
  } else if (sequence_type2_2.checked) {
    sequence_number2_1.style.display = "none";
    sequence_number2_2.style.display = "none";
    mtb_detection2_0.style.display = "none";
    rif_resistance2_0.style.display = "none";
    ct_value2_1.style.display = "none";
    test_repeatition2_0.style.display = "none";
  } else if (sequence_type2_3.checked) {
    sequence_number2_1.style.display = "none";
    sequence_number2_2.style.display = "none";

    mtb_detection2_0.style.display = "none";
    rif_resistance2_0.style.display = "none";
    ct_value2_1.style.display = "none";
    test_repeatition2_0.style.display = "block";
  } else if (sequence_type2_4.checked) {
    sequence_number2_1.style.display = "block";
    sequence_number2_2.style.display = "block";

    mtb_detection2_0.style.display = "none";
    rif_resistance2_0.style.display = "none";
    ct_value2_1.style.display = "none";
    test_repeatition2_0.style.display = "block";
  } else if (sequence_type2_5.checked) {
    sequence_number2_1.style.display = "none";
    sequence_number2_2.style.display = "none";

    mtb_detection2_0.style.display = "none";
    rif_resistance2_0.style.display = "none";
    ct_value2_1.style.display = "none";
    test_repeatition2_0.style.display = "block";
  } else {
    sequence_number2_1.style.display = "none";
    sequence_number2_2.style.display = "none";
    mtb_detection2_0.style.display = "none";
    rif_resistance2_0.style.display = "none";
    ct_value2_1.style.display = "none";
    test_repeatition2_0.style.display = "none";
  }
}

sequence_type2_1.addEventListener("change", toggleElementVisibility);
sequence_type2_2.addEventListener("change", toggleElementVisibility);
sequence_type2_3.addEventListener("change", toggleElementVisibility);
sequence_type2_4.addEventListener("change", toggleElementVisibility);
sequence_type2_5.addEventListener("change", toggleElementVisibility);

test_repeatition2_1.addEventListener("change", toggleElementVisibility);
test_repeatition2_2.addEventListener("change", toggleElementVisibility);

rif_resistance2_1.addEventListener("change", toggleElementVisibility);
rif_resistance2_2.addEventListener("change", toggleElementVisibility);
rif_resistance2_3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
