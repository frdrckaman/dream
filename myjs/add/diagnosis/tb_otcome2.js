const tb_otcome21 = document.getElementById("tb_otcome21");
const tb_otcome22 = document.getElementById("tb_otcome22");
const tb_otcome23 = document.getElementById("tb_otcome23");
const tb_otcome24 = document.getElementById("tb_otcome24");
const tb_otcome25 = document.getElementById("tb_otcome25");

const tb_otcome2_date_completed = document.getElementById(
  "tb_otcome2_date_completed"
);
const tb_otcome2_date_died = document.getElementById("tb_otcome2_date_died");
const tb_otcome2_date_ltf = document.getElementById("tb_otcome2_date_ltf");
const tb_otcome2_date = document.getElementById("tb_otcome2_date");

function toggleElementVisibility() {
  if (tb_otcome22.checked) {
    tb_otcome2_date_completed.style.display = "block";
    tb_otcome2_date_died.style.display = "none";
    tb_otcome2_date_ltf.style.display = "none";
    tb_otcome2_date.setAttribute("required", "required");
  } else if (tb_otcome24.checked) {
    tb_otcome2_date_completed.style.display = "none";
    tb_otcome2_date_died.style.display = "none";
    tb_otcome2_date_ltf.style.display = "block";
    tb_otcome2_date.setAttribute("required", "required");
  } else if (tb_otcome25.checked) {
    tb_otcome2_date_completed.style.display = "none";
    tb_otcome2_date_died.style.display = "block";
    tb_otcome2_date_ltf.style.display = "none";
    tb_otcome2_date.setAttribute("required", "required");
  } else {
    tb_otcome2_date_completed.style.display = "none";
    tb_otcome2_date_died.style.display = "none";
    tb_otcome2_date_ltf.style.display = "none";
    tb_otcome2_date.removeAttribute("required");
  }
}

tb_otcome21.addEventListener("change", toggleElementVisibility);
tb_otcome22.addEventListener("change", toggleElementVisibility);
tb_otcome23.addEventListener("change", toggleElementVisibility);
tb_otcome24.addEventListener("change", toggleElementVisibility);
tb_otcome25.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
