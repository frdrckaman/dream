const tx_previous1 = document.getElementById("tx_previous1");
const tx_previous2 = document.getElementById("tx_previous2");

const tx_number1 = document.getElementById("tx_number1");
const tx_number = document.getElementById("tx_number");
const dr_ds1 = document.getElementById("dr_ds1");
const dr_ds = document.getElementById("dr_ds");
const _23_25 = document.getElementById("_23_25");
const tb_category1 = document.getElementById("tb_category1");
const tb_category = document.getElementById("tb_category");
const relapse_years1 = document.getElementById("relapse_years1");
const relapse_years = document.getElementById("relapse_years");
const ltf_months1 = document.getElementById("ltf_months1");
const ltf_months = document.getElementById("ltf_months");

function toggleElementVisibility() {
  if (tx_previous1.checked) {
    tx_number1.style.display = "block";
    tx_number.setAttribute("required", "required");
    dr_ds1.style.display = "block";
    dr_ds.setAttribute("required", "required");
    tb_category1.style.display = "block";
    tb_category.setAttribute("required", "required");
    relapse_years1.style.display = "block";
    relapse_years.setAttribute("required", "required");
    ltf_months1.style.display = "block";
    ltf_months.setAttribute("required", "required");
  } else {
    tx_number1.style.display = "none";
    tx_number.removeAttribute("required");
    dr_ds1.style.display = "none";
    dr_ds.removeAttribute("required");
    tb_category1.style.display = "none";
    tb_category.removeAttribute("required");
    relapse_years1.style.display = "none";
    relapse_years.removeAttribute("required");
    ltf_months1.style.display = "none";
    ltf_months.removeAttribute("required");
  }
}

tx_previous1.addEventListener("change", toggleElementVisibility);
tx_previous2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
