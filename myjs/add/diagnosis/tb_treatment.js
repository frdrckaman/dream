const tb_treatment1_1 = document.getElementById("tb_treatment1");
const tb_treatment2_1 = document.getElementById("tb_treatment2");
const tb_treatment3_1 = document.getElementById("tb_treatment3");

const tb_treatment_date1 = document.getElementById("tb_treatment_date1");
const tb_treatment_date = document.getElementById("tb_treatment_date");

const tb_facility1 = document.getElementById("tb_facility1");
const tb_facility = document.getElementById("tb_facility");

const tb_reason1 = document.getElementById("tb_reason1");
const tb_reason = document.getElementById("tb_reason");

function toggleElementVisibility() {
  if (tb_treatment1_1.checked) {
    tb_treatment_date1.style.display = "block";
    tb_treatment_date.style.display = "block";
    tb_facility1.style.display = "block";
    tb_facility.style.display = "block";
    tb_reason1.style.display = "none";
    tb_reason.style.display = "none";
  } else if (tb_treatment3_1.checked) {
    tb_treatment_date1.style.display = "none";
    tb_treatment_date.style.display = "none";
    tb_facility1.style.display = "none";
    tb_facility.style.display = "none";
    tb_reason1.style.display = "block";
    tb_reason.style.display = "block";
  } else {
    tb_treatment_date1.style.display = "none";
    tb_treatment_date.style.display = "none";
    tb_facility1.style.display = "none";
    tb_facility.style.display = "none";
    tb_reason1.style.display = "none";
    tb_reason.style.display = "none";
  }
}

tb_treatment1_1.addEventListener("change", toggleElementVisibility);
tb_treatment2_1.addEventListener("change", toggleElementVisibility);
tb_treatment3_1.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
