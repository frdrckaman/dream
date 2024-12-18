const tx_previous1 = document.getElementById("tx_previous1");
const tx_previous2 = document.getElementById("tx_previous2");

const tx_number1 = document.getElementById("tx_number1");
const tx_number = document.getElementById("tx_number");
const dr_ds1 = document.getElementById("dr_ds1");
const dr_ds = document.getElementById("dr_ds");
const tb_category = document.getElementById("tb_category");
const relapse_years1_1 = document.getElementById("relapse_years1");
const ltf_months1_1 = document.getElementById("ltf_months1");
const tb_regimen = document.getElementById("tb_regimen");
const regimen_months1 = document.getElementById("regimen_months1");
const regimen_changed = document.getElementById("regimen_changed");
const regimen_name1_1 = document.getElementById("regimen_name1");
const tb_otcome1_1_1_1 = document.getElementById("tb_otcome1_1_1_1");

const tb_category1_1 = document.getElementById("tb_category1");
const tb_category1_2 = document.getElementById("tb_category2");
const tb_category1_3 = document.getElementById("tb_category3");

const regimen_changed1_1 = document.getElementById("regimen_changed1");
const regimen_changed2_1 = document.getElementById("regimen_changed2");

function toggleElementVisibility() {
  if (tx_previous1.checked) {
    tx_number1.style.display = "block";
    dr_ds1.style.display = "block";
    tb_category.style.display = "block";
    tb_regimen.style.display = "block";
    regimen_months1.style.display = "block";
    regimen_changed.style.display = "block";
    tb_otcome1_1_1_1.style.display = "block";
    if (tb_category1_1.checked) {
      relapse_years1_1.style.display = "block";
      ltf_months1_1.style.display = "none";
    } else if (tb_category1_3.checked) {
      relapse_years1_1.style.display = "none";
      ltf_months1_1.style.display = "block";
    }

    if (regimen_changed1_1.checked) {
      regimen_name1_1.style.display = "block";
    } else if (tb_category1_3.checked) {
      regimen_name1_1.style.display = "none";
    }
  } else if (tx_previous2.checked) {
    tx_number1.style.display = "none";
    dr_ds1.style.display = "none";
    tb_category.style.display = "none";
    relapse_years1_1.style.display = "none";
    ltf_months1_1.style.display = "none";
    tb_regimen.style.display = "none";
    regimen_months1.style.display = "none";
    regimen_changed.style.display = "none";
    regimen_name1_1.style.display = "none";
    tb_otcome1_1_1_1.style.display = "none";
  } else {
    tx_number1.style.display = "none";
    dr_ds1.style.display = "none";
    tb_category.style.display = "none";
    relapse_years1_1.style.display = "none";
    ltf_months1_1.style.display = "none";
    tb_regimen.style.display = "none";
    regimen_months1.style.display = "none";
    regimen_changed.style.display = "none";
    regimen_name1_1.style.display = "none";
    tb_otcome1_1_1_1.style.display = "none";
  }
}

tx_previous1.addEventListener("change", toggleElementVisibility);
tx_previous2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
