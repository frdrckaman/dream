const sequence_type6_7_1 = document.getElementById("sequence_type6_7_1");
const sequence_type6_7_2 = document.getElementById("sequence_type6_7_2");
const sequence_type6_7_3 = document.getElementById("sequence_type6_7_3");
const sequence_type6_7_4 = document.getElementById("sequence_type6_7_4");
const sequence_type6_7_5 = document.getElementById("sequence_type6_7_5");

const sequence_number6_1 = document.getElementById("sequence_number6_1");
const sequence_number6_2 = document.getElementById("sequence_number6_2");

const mtb_detection6_1 = document.getElementById("mtb_detection6_1");
const rif_resistance6_1 = document.getElementById("rif_resistance6_1");
const ct_value6_1 = document.getElementById("ct_value6_1");

function toggleElementVisibility() {
  if (sequence_type6_7_1.checked) {
    mtb_detection6_1.style.display = "block";
    rif_resistance6_1.style.display = "block";
    ct_value6_1.style.display = "block";
    sequence_number6_1.style.display = "none";
    sequence_number6_2.style.display = "none";

  } else if (sequence_type6_7_2.checked) {
    mtb_detection6_1.style.display = "none";
    rif_resistance6_1.style.display = "none";
    ct_value6_1.style.display = "none";
    sequence_number6_1.style.display = "none";
    sequence_number6_2.style.display = "none";

  } else if (sequence_type6_7_3.checked) {
    mtb_detection6_1.style.display = "none";
    rif_resistance6_1.style.display = "none";
    ct_value6_1.style.display = "none";
    sequence_number6_1.style.display = "none";
    sequence_number6_2.style.display = "none";

  } else if (sequence_type6_7_4.checked) {
    mtb_detection6_1.style.display = "none";
    rif_resistance6_1.style.display = "none";
    ct_value6_1.style.display = "none";
    sequence_number6_1.style.display = "block";
    sequence_number6_2.style.display = "block";

  } else if (sequence_type6_7_5.checked) {
    mtb_detection6_1.style.display = "none";
    rif_resistance6_1.style.display = "none";
    ct_value6_1.style.display = "none";
    sequence_number6_1.style.display = "none";
    sequence_number6_2.style.display = "none";

  } else {
    mtb_detection6_1.style.display = "none";
    rif_resistance6_1.style.display = "none";
    ct_value6_1.style.display = "none";
    sequence_number6_1.style.display = "none";
    sequence_number6_2.style.display = "none";

  }
}

sequence_type6_7_1.addEventListener("change", toggleElementVisibility);
sequence_type6_7_2.addEventListener("change", toggleElementVisibility);
sequence_type6_7_3.addEventListener("change", toggleElementVisibility);
sequence_type6_7_4.addEventListener("change", toggleElementVisibility);
sequence_type6_7_5.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
