const tb_category1 = document.getElementById("tb_category1");
const tb_category2 = document.getElementById("tb_category2");
const tb_category3 = document.getElementById("tb_category3");


const relapse_years1 = document.getElementById("relapse_years1");
const relapse_years = document.getElementById("relapse_years");
const ltf_months1 = document.getElementById("ltf_months1");
const ltf_months = document.getElementById("ltf_months");

function toggleElementVisibility() {
  if (tb_category1.checked) {
    relapse_years1.style.display = "block";
    ltf_months1.style.display = "none";
  } else if (tb_category2.checked) {
    relapse_years1.style.display = "none";
    ltf_months1.style.display = "none";
  } else if (tb_category3.checked) {
    relapse_years1.style.display = "none";
    ltf_months1.style.display = "block";
  } else {
    relapse_years1.style.display = "none";
    ltf_months1.style.display = "none";
  }
}

tb_category1.addEventListener("change", toggleElementVisibility);
tb_category2.addEventListener("change", toggleElementVisibility);
tb_category3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();

