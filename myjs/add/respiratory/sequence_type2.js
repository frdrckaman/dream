const sequence_type221 = document.getElementById("sequence_type221");
const sequence_type222 = document.getElementById("sequence_type222");
const sequence_type223 = document.getElementById("sequence_type223");
const sequence_type224 = document.getElementById("sequence_type224");
const sequence_type225 = document.getElementById("sequence_type225");

    alert(sequence_type221);



const rif_resistance22233333 = document.getElementById("rif_resistance221");
// const rif_resistance2222222 = document.getElementById("rif_resistance222");
// const rif_resistance2233333 = document.getElementById("rif_resistance223");

const sequence_number221 = document.getElementById("sequence_number221");
const sequence_number22 = document.getElementById("sequence_number22");

const mtb_detection22 = document.getElementById("mtb_detection22");
const rif_resistance22 = document.getElementById("rif_resistance22");
const c2t_value22 = document.getElementById("c2t_value22");

function toggleElementVisibility() {
  if (sequence_type221.checked) {
    sequence_number221.style.display = "none";
    sequence_number22.style.display = "none";
    mtb_detection22.style.display = "block";
    rif_resistance22.style.display = "block";
    c2t_value22.style.display = "block";

  } else if (sequence_type221.checked && rif_resistance22233333.checked) {
    sequence_number221.style.display = "none";
    sequence_number22.style.display = "none";
    mtb_detection22.style.display = "block";
    rif_resistance22.style.display = "block";
    c2t_value22.style.display = "block";
  } else if (sequence_type222.checked) {
    sequence_number221.style.display = "none";
    sequence_number22.style.display = "none";
    mtb_detection22.style.display = "none";
    rif_resistance22.style.display = "none";
    c2t_value22.style.display = "none";
  } else if (sequence_type223.checked) {
    sequence_number221.style.display = "none";
    sequence_number22.style.display = "none";

    mtb_detection22.style.display = "none";
    rif_resistance22.style.display = "none";
    c2t_value22.style.display = "none";

  } else if (sequence_type224.checked) {
    sequence_number221.style.display = "block";
    sequence_number22.style.display = "block";

    mtb_detection22.style.display = "none";
    rif_resistance22.style.display = "none";
    c2t_value22.style.display = "none";
    test_repeatition.style.display = "block";

  } else if (sequence_type225.checked) {
    sequence_number221.style.display = "none";
    sequence_number22.style.display = "none";

    mtb_detection22.style.display = "none";
    rif_resistance22.style.display = "none";
    c2t_value22.style.display = "none";
    test_repeatition.style.display = "block";

  } else {
    sequence_number221.style.display = "none";
    sequence_number22.style.display = "none";
    mtb_detection22.style.display = "none";
    rif_resistance22.style.display = "none";
    c2t_value22.style.display = "none";
    test_repeatition.style.display = "none";
  }
}

sequence_type221.addEventListener("change", toggleElementVisibility);
sequence_type222.addEventListener("change", toggleElementVisibility);
sequence_type223.addEventListener("change", toggleElementVisibility);
sequence_type224.addEventListener("change", toggleElementVisibility);
sequence_type225.addEventListener("change", toggleElementVisibility);

// rif_resistance2211111.addEventListener("change", toggleElementVisibility);
// rif_resistance2222222.addEventListener("change", toggleElementVisibility);
// rif_resistance2233333.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
