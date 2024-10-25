const tb_regimen1_1_1 = document.getElementById("tb_regimen1");
const tb_regimen2_2_2 = document.getElementById("tb_regimen2");
const tb_regimen3_3_3 = document.getElementById("tb_regimen3");
const tb_regimen4_4_4 = document.getElementById("tb_regimen4");


const tb_regimen_other1 = document.getElementById("tb_regimen_other1");
const tb_regimen_other = document.getElementById("tb_regimen_other");

function toggleElementVisibility() {
  if (tb_regimen4_4_4.checked) {
    tb_regimen_other1.style.display = "block";
    tb_regimen_other.style.display = "block";
  } else {
    tb_regimen_other1.style.display = "none";
    tb_regimen_other.style.display = "none";
  }
}

tb_regimen1_1_1.addEventListener("change", toggleElementVisibility);
tb_regimen2_2_2.addEventListener("change", toggleElementVisibility);
tb_regimen3_3_3.addEventListener("change", toggleElementVisibility);
tb_regimen4_4_4.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
