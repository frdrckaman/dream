const tb_diagnosis_made2111 = document.getElementById("tb_diagnosis_made21");
const tb_diagnosis_made2222 = document.getElementById("tb_diagnosis_made22");

const laboratory_test_used221111 = document.getElementById(
  "laboratory_test_used221111"
);

function toggleElementVisibility() {
  if (tb_diagnosis_made2111.checked) {
    laboratory_test_used221111.style.display = "block";
  } else {
    laboratory_test_used221111.style.display = "none";
  }
}

tb_diagnosis_made2111.addEventListener("change", toggleElementVisibility);
tb_diagnosis_made2222.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
