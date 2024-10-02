const tb_diagnosis_made211 = document.getElementById("tb_diagnosis_made21");
const tb_diagnosis_made222 = document.getElementById("tb_diagnosis_made22");

const laboratory_test_used2222 = document.getElementById("laboratory_test_used2");


function toggleElementVisibility() {
  if (tb_diagnosis_made211.checked) {
    laboratory_test_used2222.style.display = "block";
  } else {
    laboratory_test_used2222.style.display = "none";
  }
}

tb_diagnosis_made211.addEventListener("change", toggleElementVisibility);
tb_diagnosis_made222.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
