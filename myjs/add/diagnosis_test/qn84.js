const phenotypic_done1 = document.getElementById("phenotypic_done1");
const phenotypic_done2 = document.getElementById("phenotypic_done2");

const phenotypic_method = document.getElementById("phenotypic_method");
const phenotypic_method1 = document.getElementById("phenotypic_method1");

const phenotypic_done00 = document.getElementById("phenotypic_done00");

function toggleElementVisibility() {
  if (phenotypic_done1.checked) {
    phenotypic_method.style.display = "block";
    phenotypic_method1.setAttribute("required", "required");
    phenotypic_done00.style.display = "block";
  } else {
    phenotypic_method.style.display = "none";
    phenotypic_method1.removeAttribute("required");
    phenotypic_done00.style.display = "none";
  }
}

phenotypic_done1.addEventListener("change", toggleElementVisibility);
phenotypic_done2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
