const tb_diagnosis_made21 = document.getElementById("tb_diagnosis_made21");
const tb_diagnosis_made22 = document.getElementById("tb_diagnosis_made22");

const laboratory_test_used2 = document.getElementById("laboratory_test_used2");


function toggleElementVisibility() {
  if (tb_diagnosis_made21.checked) {
    laboratory_test_used2.style.display = "block";
  } else {
    laboratory_test_used2.style.display = "none";
  }
}

tb_diagnosis_made21.addEventListener("change", toggleElementVisibility);
tb_diagnosis_made22.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
