const other_diseases1 = document.getElementById("other_diseases1");
const other_diseases2 = document.getElementById("other_diseases2");
const other_diseases3 = document.getElementById("other_diseases99");

const diseases_medical = document.getElementById("diseases_medical");
const diseases_medical1_1 = document.getElementById("diseases_medical1");

function toggleElementVisibility() {
  if (other_diseases1.checked) {
    diseases_medical.style.display = "block";
  } else {
    diseases_medical.style.display = "none";
  }
}

other_diseases1.addEventListener("change", toggleElementVisibility);
other_diseases2.addEventListener("change", toggleElementVisibility);
other_diseases3.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();

