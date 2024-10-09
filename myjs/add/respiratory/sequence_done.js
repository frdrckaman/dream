const sequence_done1 = document.getElementById("sequence_done1");
const sequence_done2 = document.getElementById("sequence_done2");

const sequence_date1 = document.getElementById("sequence_date1");
const sequence_date = document.getElementById("sequence_date");
const sequence_type = document.getElementById("sequence_type");

const mtb_detection11111111 = document.getElementById("mtb_detection");
const rif_resistance1111111 = document.getElementById("rif_resistance");
const ct_value1111111111111 = document.getElementById("ct_value1");
const test_repeatition11111 = document.getElementById("test_repeatition");

function toggleElementVisibility() {
  if (sequence_done1.checked) {
    sequence_date1.style.display = "block";
    sequence_date.style.display = "block";
    sequence_type.style.display = "block";
    mtb_detection11111111.style.display = "block";
    rif_resistance1111111.style.display = "block";
    ct_value1111111111111.style.display = "block";
    test_repeatition11111.style.display = "block";
  } else {
    sequence_date1.style.display = "none";
    sequence_date.style.display = "none";
    sequence_type.style.display = "none";
    mtb_detection11111111.style.display = "none";
    rif_resistance1111111.style.display = "none";
    ct_value1111111111111.style.display = "none";
    test_repeatition11111.style.display = "none";
  }
}

sequence_done1.addEventListener("change", toggleElementVisibility);
sequence_done2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
