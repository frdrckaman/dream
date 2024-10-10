const sequence_done1 = document.getElementById("sequence_done1");
const sequence_done2 = document.getElementById("sequence_done2");

const rif_resistance111 = document.getElementById("rif_resistance1");
const rif_resistance222 = document.getElementById("rif_resistance2");
const rif_resistance333 = document.getElementById("rif_resistance3");

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

    if (rif_resistance333.checked) {
      test_repeatition11111.style.display = "block";
    } else {
      test_repeatition11111.style.display = "none";
    }
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

// function toggleElementVisibility() {
//   if (sequence_done1.checked && sequence_done1.value === 1) {
//     // Show elements when sequence_done1 is "Yes"
//     sequence_date1.style.display = "block";
//     sequence_date.style.display = "block";
//     sequence_type.style.display = "block";
//     mtb_detection11111111.style.display = "block";
//     rif_resistance1111111.style.display = "block";
//     ct_value1111111111111.style.display = "block";

//     // Additional check for rif_resistance333
//     if (rif_resistance333.checked && rif_resistance333.value === 1) {
//       test_repeatition11111.style.display = "block"; // Show test_repeatition when both are "Yes"
//     } else {
//       test_repeatition11111.style.display = "none"; // Hide if only sequence_done1 is "Yes"
//     }
//   } else {
//     // Hide all elements if sequence_done1 is not "Yes"
//     sequence_date1.style.display = "none";
//     sequence_date.style.display = "none";
//     sequence_type.style.display = "none";
//     mtb_detection11111111.style.display = "none";
//     rif_resistance1111111.style.display = "none";
//     ct_value1111111111111.style.display = "none";
//     test_repeatition11111.style.display = "none";
//   }
// }

sequence_done1.addEventListener("change", toggleElementVisibility);
sequence_done2.addEventListener("change", toggleElementVisibility);

rif_resistance111.addEventListener("change", toggleElementVisibility);
rif_resistance222.addEventListener("change", toggleElementVisibility);
rif_resistance333.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
