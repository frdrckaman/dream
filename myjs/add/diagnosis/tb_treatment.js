const tb_treatment_started1 = document.getElementById("tb_treatment_started1");
const tb_treatment_started2 = document.getElementById("tb_treatment_started2");
const tb_treatment_started3 = document.getElementById("tb_treatment_started3");

const tb_regimen_prescribed = document.getElementById("tb_regimen_prescribed");
const tb_regimen_new1 = document.getElementById("tb_regimen_new1");

const tb_regimen_new = document.getElementById("tb_regimen_new");


function toggleElementVisibility() {
  if (tb_treatment_started1.checked) {
    tb_regimen_prescribed.style.display = "block";
    tb_regimen_new1.style.display = "block";
    tb_regimen_new.style.display = "block";
  } else {
    tb_regimen_prescribed.style.display = "none";
    tb_regimen_new1.style.display = "none";
    tb_regimen_new.style.display = "none";
  }
}

tb_treatment_started1.addEventListener("change", toggleElementVisibility);
tb_treatment_started2.addEventListener("change", toggleElementVisibility);
tb_treatment_started3.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
