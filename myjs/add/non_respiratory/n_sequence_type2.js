const sequence_type3_1 = document.getElementById("sequence_type3_1");
const sequence_type3_2 = document.getElementById("sequence_type3_2");
const sequence_type3_3 = document.getElementById("sequence_type3_3");
const sequence_type3_4 = document.getElementById("sequence_type3_4");
const sequence_type3_5 = document.getElementById("sequence_type3_5");

// const test_repeatition2_1 = document.getElementById("test_repeatition2_1");
// const test_repeatition2_2 = document.getElementById("test_repeatition2_2");

// const rif_resistance2_1 = document.getElementById("rif_resistance2_1");
// const rif_resistance2_2 = document.getElementById("rif_resistance2_2");
// const rif_resistance2_3 = document.getElementById("rif_resistance2_3");

const sequence_number3_1 = document.getElementById("sequence_number3_1");
const sequence_number3_2 = document.getElementById("sequence_number3_2");
const sequence_number3_3 = document.getElementById("sequence_number3_3");

const mtb_detection3_0 = document.getElementById("mtb_detection3_0");
const mtb_detection4_0 = document.getElementById("mtb_detection4_0");
const mtb_detection5_0 = document.getElementById("mtb_detection5_0");

const rif_resistance3_0 = document.getElementById("rif_resistance3_0");
const rif_resistance4_0 = document.getElementById("rif_resistance4_0");
const rif_resistance5_0 = document.getElementById("rif_resistance5_0");

const ct_value3_1 = document.getElementById("ct_value3_1");
const ct_value3_2 = document.getElementById("ct_value3_2");
const ct_value3_3 = document.getElementById("ct_value3_3");

function toggleElementVisibility() {
  if (sequence_type3_1.checked) {
    sequence_number3_1.style.display = "none";
    sequence_number3_2.style.display = "none";
    sequence_number3_3.style.display = "none";
    mtb_detection3_0.style.display = "block";
    mtb_detection4_0.style.display = "block";
    mtb_detection5_0.style.display = "block";
    rif_resistance3_0.style.display = "block";
    rif_resistance4_0.style.display = "block";
    rif_resistance5_0.style.display = "block";
    ct_value3_1.style.display = "block";
    ct_value3_2.style.display = "block";
    ct_value3_3.style.display = "block";
  } else if (sequence_type3_1.checked && rif_resistance2_3.checked) {
    sequence_number3_1.style.display = "none";
    sequence_number3_2.style.display = "none";
    sequence_number3_3.style.display = "none";
    mtb_detection3_0.style.display = "none";
    mtb_detection4_0.style.display = "none";
    mtb_detection5_0.style.display = "none";
    rif_resistance3_0.style.display = "none";
    rif_resistance4_0.style.display = "none";
    rif_resistance5_0.style.display = "none";
    ct_value3_1.style.display = "none";
    ct_value3_2.style.display = "none";
    ct_value3_3.style.display = "none";
  } else if (sequence_type3_2.checked) {
    sequence_number3_1.style.display = "none";
    sequence_number3_2.style.display = "none";
    sequence_number3_3.style.display = "none";
    mtb_detection3_0.style.display = "none";
    mtb_detection4_0.style.display = "none";
    mtb_detection5_0.style.display = "none";
    rif_resistance3_0.style.display = "none";
    rif_resistance4_0.style.display = "none";
    rif_resistance5_0.style.display = "none";
    ct_value3_1.style.display = "none";
    ct_value3_2.style.display = "none";
    ct_value3_3.style.display = "none";
  } else if (sequence_type3_3.checked) {
    sequence_number3_1.style.display = "none";
    sequence_number3_2.style.display = "none";
    sequence_number3_3.style.display = "none";
    mtb_detection3_0.style.display = "none";
    mtb_detection4_0.style.display = "none";
    mtb_detection5_0.style.display = "none";
    rif_resistance3_0.style.display = "none";
    rif_resistance4_0.style.display = "none";
    rif_resistance5_0.style.display = "none";
    ct_value3_1.style.display = "none";
    ct_value3_2.style.display = "none";
    ct_value3_3.style.display = "none";
  } else if (sequence_type3_4.checked) {
    sequence_number3_1.style.display = "block";
    sequence_number3_2.style.display = "block";
    sequence_number3_3.style.display = "block";
    mtb_detection3_0.style.display = "none";
    mtb_detection4_0.style.display = "none";
    mtb_detection5_0.style.display = "none";
    rif_resistance3_0.style.display = "none";
    rif_resistance4_0.style.display = "none";
    rif_resistance5_0.style.display = "none";
    ct_value3_1.style.display = "none";
    ct_value3_2.style.display = "none";
    ct_value3_3.style.display = "none";
  } else if (sequence_type3_5.checked) {
    sequence_number3_1.style.display = "none";
    sequence_number3_2.style.display = "none";
    sequence_number3_3.style.display = "none";
    mtb_detection3_0.style.display = "none";
    mtb_detection4_0.style.display = "none";
    mtb_detection5_0.style.display = "none";
    rif_resistance3_0.style.display = "none";
    rif_resistance4_0.style.display = "none";
    rif_resistance5_0.style.display = "none";
    ct_value3_1.style.display = "none";
    ct_value3_2.style.display = "none";
    ct_value3_3.style.display = "none";
  } else {
    sequence_number3_1.style.display = "none";
    sequence_number3_2.style.display = "none";
    sequence_number3_3.style.display = "none";
    mtb_detection3_0.style.display = "none";
    mtb_detection4_0.style.display = "none";
    mtb_detection5_0.style.display = "none";
    rif_resistance3_0.style.display = "none";
    rif_resistance4_0.style.display = "none";
    rif_resistance5_0.style.display = "none";
    ct_value3_1.style.display = "none";
    ct_value3_2.style.display = "none";
    ct_value3_3.style.display = "none";
  }
}

sequence_type3_1.addEventListener("change", toggleElementVisibility);
sequence_type3_2.addEventListener("change", toggleElementVisibility);
sequence_type3_3.addEventListener("change", toggleElementVisibility);
sequence_type3_4.addEventListener("change", toggleElementVisibility);
sequence_type3_5.addEventListener("change", toggleElementVisibility);

// test_repeatition2_1.addEventListener("change", toggleElementVisibility);
// test_repeatition2_2.addEventListener("change", toggleElementVisibility);

// rif_resistance2_1.addEventListener("change", toggleElementVisibility);
// rif_resistance2_2.addEventListener("change", toggleElementVisibility);
// rif_resistance2_3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
