const phenotypic_method_1 = document.getElementById("phenotypic_method1");
const phenotypic_method_3 = document.getElementById("phenotypic_method3");

const apm_date_1 = document.getElementById("apm_date_1");
const apm_date = document.getElementById("apm_date");

const mgit_date2_1 = document.getElementById("mgit_date2_1");
const mgit_date2 = document.getElementById("mgit_date2");

function toggleElementVisibility() {
  if (phenotypic_method_1.checked) {
    apm_date_1.style.display = "block";
    apm_date.setAttribute("required", "required");
    mgit_date2_1.style.display = "none";
    mgit_date2.removeAttribute("required");
  } else if (phenotypic_method_3.checked) {
    apm_date_1.style.display = "none";
    apm_date.removeAttribute("required");
    mgit_date2_1.style.display = "block";
    mgit_date2.setAttribute("required", "required");
  } else {
    apm_date_1.style.display = "none";
    apm_date.removeAttribute("required");
    mgit_date2_1.style.display = "none";
    mgit_date2.removeAttribute("required");
  }
}

phenotypic_method_1.addEventListener("change", toggleElementVisibility);
phenotypic_method_3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
