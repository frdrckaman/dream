const laboratory_test_used21 = document.getElementById("laboratory_test_used21");
const laboratory_test_used22 = document.getElementById("laboratory_test_used22");
const laboratory_test_used23 = document.getElementById("laboratory_test_used23");
const laboratory_test_used24 = document.getElementById("laboratory_test_used24");
const laboratory_test_used25 = document.getElementById("laboratory_test_used25");
const laboratory_test_used26 = document.getElementById("laboratory_test_used26");
const laboratory_test_used27 = document.getElementById("laboratory_test_used27");
const laboratory_test_used28 = document.getElementById("laboratory_test_used28");
const laboratory_test_used29 = document.getElementById("laboratory_test_used29");
const laboratory_test_used210 = document.getElementById("laboratory_test_used210");
const laboratory_test_used296 = document.getElementById("laboratory_test_used296");


const tb_other_specify1 = document.getElementById("tb_other_specify1");
const tb_other_specify = document.getElementById("tb_other_specify");

function toggleElementVisibility() {
  if (laboratory_test_used296.checked) {
    tb_other_specify1.style.display = "block";
    tb_other_specify.style.display = "block";
  } else {
    tb_other_specify.style.display = "none";
    tb_other_specify1.style.display = "none";
  }
}

laboratory_test_used21.addEventListener("change", toggleElementVisibility);
laboratory_test_used22.addEventListener("change", toggleElementVisibility);
laboratory_test_used23.addEventListener("change", toggleElementVisibility);
laboratory_test_used24.addEventListener("change", toggleElementVisibility);
laboratory_test_used25.addEventListener("change", toggleElementVisibility);
laboratory_test_used26.addEventListener("change", toggleElementVisibility);
laboratory_test_used27.addEventListener("change", toggleElementVisibility);
laboratory_test_used28.addEventListener("change", toggleElementVisibility);
laboratory_test_used29.addEventListener("change", toggleElementVisibility);
laboratory_test_used210.addEventListener("change", toggleElementVisibility);
laboratory_test_used296.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
