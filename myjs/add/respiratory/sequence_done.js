const sequence_done1 = document.getElementById("sequence_done1");
const sequence_done2 = document.getElementById("sequence_done2");


const sequence_date1 = document.getElementById("sequence_date1");
const sequence_date = document.getElementById("sequence_date");
const sequence_type = document.getElementById("sequence_type");

const ct_value1 = document.getElementById("ct_value1");

function toggleElementVisibility() {
  if (sequence_done1.checked) {
    sequence_date1.style.display = "block";
    sequence_date.style.display = "block";
    sequence_type.style.display = "none";
    ct_value1.style.display = "block";
  } else {
    sequence_date1.style.display = "none";
    sequence_date.style.display = "none";
    sequence_type.style.display = "none";
    ct_value1.style.display = "none";
  }
}

sequence_done1.addEventListener("change", toggleElementVisibility);
sequence_done2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
