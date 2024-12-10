const phenotypic_performed1 = document.getElementById("phenotypic_performed1");
const phenotypic_performed2 = document.getElementById("phenotypic_performed2");

const phenotypic_method = document.getElementById("phenotypic_method");
const phenotypic_method1 = document.getElementById("phenotypic_method1");

const phenotypic_done00 = document.getElementById("phenotypic_done00");

function toggleElementVisibility() {
  if (phenotypic_performed1.checked) {
    phenotypic_method.style.display = "block";
    phenotypic_method1.setAttribute("required", "required");
    phenotypic_done00.style.display = "block";
  } else {
    phenotypic_method.style.display = "none";
    phenotypic_method1.removeAttribute("required");
    phenotypic_done00.style.display = "none";
  }
}

phenotypic_performed1.addEventListener("change", toggleElementVisibility);
phenotypic_performed2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
