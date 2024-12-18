const culture_performed1 = document.getElementById("culture_performed1");
const culture_performed2 = document.getElementById("culture_performed2");


const culture_method = document.getElementById("culture_method");
const culture_results = document.getElementById("culture_results");
const phenotypic_performed_r = document.getElementById("phenotypic_performed_r");
const phenotypic_performed = document.getElementById("phenotypic_performed");


function toggleElementVisibility() {
  if (culture_performed1.checked) {
    culture_method.style.display = "block";
    culture_results.style.display = "block";
    phenotypic_performed_r.style.display = "block";
    phenotypic_performed.style.display = "block";
    // qn05_other.setAttribute("required", "required");
  } else {
    culture_method.style.display = "none";
    culture_results.style.display = "none";
    phenotypic_performed_r.style.display = "none";
    phenotypic_performed.style.display = "none";
    // qn05_other.removeAttribute("required");
  }
}

culture_performed1.addEventListener("change", toggleElementVisibility);
culture_performed2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
