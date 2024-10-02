const tb_other_diagnosis1 = document.getElementById("tb_other_diagnosis1");
const tb_other_diagnosis2 = document.getElementById("tb_other_diagnosis2");
const tb_other_diagnosis3 = document.getElementById("tb_other_diagnosis3");
const tb_other_diagnosis4 = document.getElementById("tb_other_diagnosis4");
const tb_other_diagnosis5 = document.getElementById("tb_other_diagnosis5");
const tb_other_diagnosis96 = document.getElementById("tb_other_diagnosis96");



const tb_other_specify1 = document.getElementById("tb_other_specify1");
const tb_other_specify = document.getElementById("tb_other_specify");

function toggleElementVisibility() {
  if (tb_other_diagnosis96.checked) {
    tb_other_specify1.style.display = "block";
    tb_other_specify.style.display = "block";
  } else {
    tb_other_specify.style.display = "none";
    tb_other_specify1.style.display = "none";
  }
}

tb_other_diagnosis1.addEventListener("change", toggleElementVisibility);
tb_other_diagnosis2.addEventListener("change", toggleElementVisibility);
tb_other_diagnosis3.addEventListener("change", toggleElementVisibility);
tb_other_diagnosis4.addEventListener("change", toggleElementVisibility);
tb_other_diagnosis5.addEventListener("change", toggleElementVisibility);
tb_other_diagnosis96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
