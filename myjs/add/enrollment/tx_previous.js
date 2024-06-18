const tx_previous1 = document.getElementById("tx_previous1");
const tx_previous2 = document.getElementById("tx_previous2");

const tx_number1 = document.getElementById("tx_number1");
const tx_number = document.getElementById("tx_number");
const dr_ds1 = document.getElementById("dr_ds1");
const dr_ds = document.getElementById("dr_ds");
const tb_category = document.getElementById("tb_category");

function toggleElementVisibility() {
  if (tx_previous1.checked) {
    tx_number1.style.display = "block";
    tx_number.setAttribute("required", "required");
    dr_ds1.style.display = "block";
    dr_ds.setAttribute("required", "required");
    tb_category.style.display = "block";
  } else {
    tx_number1.style.display = "none";
    tx_number.removeAttribute("required");
    dr_ds1.style.display = "none";
    dr_ds.removeAttribute("required");
    tb_category.style.display = "none";
  }
}

tx_previous1.addEventListener("change", toggleElementVisibility);
tx_previous2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();

