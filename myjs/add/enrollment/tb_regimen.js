const tb_regimen_1_1 = document.getElementById("tb_regimen_1_1");
const tb_regimen_1_2 = document.getElementById("tb_regimen_1_2");
const tb_regimen_1_3 = document.getElementById("tb_regimen_1_3");
const tb_regimen_1_4 = document.getElementById("tb_regimen_1_4");
const tb_regimen_1_5 = document.getElementById("tb_regimen_1_5");
const tb_regimen_1_6 = document.getElementById("tb_regimen_1_6");
const tb_regimen_1_96 = document.getElementById("tb_regimen_1_96");


const tb_regimen_1_specify = document.getElementById("tb_regimen_1_specify");
// console.log(tb_regimen_1_1.value);
function toggleElementVisibility() {
  if (tb_regimen_1_96.checked) {
    tb_regimen_1_specify.style.display = "block";
  }else {
    tb_regimen_1_specify.style.display = "none";
  }
}

tb_regimen_1_1.addEventListener("change", toggleElementVisibility);
tb_regimen_1_2.addEventListener("change", toggleElementVisibility);
tb_regimen_1_3.addEventListener("change", toggleElementVisibility);
tb_regimen_1_4.addEventListener("change", toggleElementVisibility);
tb_regimen_1_5.addEventListener("change", toggleElementVisibility);
tb_regimen_1_6.addEventListener("change", toggleElementVisibility);
tb_regimen_1_96.addEventListener("change", toggleElementVisibility);



// Initial check
toggleElementVisibility();

