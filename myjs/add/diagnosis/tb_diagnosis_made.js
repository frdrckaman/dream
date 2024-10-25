const tb_diagnosis_made1 = document.getElementById("tb_diagnosis_made1");
const tb_diagnosis_made2 = document.getElementById("tb_diagnosis_made2");
const tb_diagnosis_made96 = document.getElementById("tb_diagnosis_made96");

const diagnosis_made_other1 = document.getElementById("diagnosis_made_other1");
const diagnosis_made_other = document.getElementById("diagnosis_made_other");

function toggleElementVisibility() {
  if (tb_diagnosis_made96.checked) {
    diagnosis_made_other1.style.display = "block";
    diagnosis_made_other.style.display = "block";
  } else {
    diagnosis_made_other1.style.display = "none";
    diagnosis_made_other.style.display = "none";
  }
}

tb_diagnosis_made1.addEventListener("change", toggleElementVisibility);
tb_diagnosis_made2.addEventListener("change", toggleElementVisibility);
tb_diagnosis_made96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
