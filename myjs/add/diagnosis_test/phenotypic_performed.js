const phenotypic_performed1 = document.getElementById("phenotypic_performed1");
const phenotypic_performed2 = document.getElementById("phenotypic_performed2");

const phenotypic_date_performed1 = document.getElementById("phenotypic_date_performed1");
const phenotypic_date_performed2 = document.getElementById("phenotypic_date_performed2");

const phenotypic_dst_results = document.getElementById("phenotypic_dst_results");

function toggleElementVisibility() {
  if (phenotypic_performed1.checked) {
    phenotypic_date_performed1.style.display = "block";
    phenotypic_date_performed2.style.display = "block";
    phenotypic_dst_results.style.display = "block";
    // phenotypic_date_performed2.setAttribute("required", "required");
  } else {
    phenotypic_date_performed1.style.display = "none";
    phenotypic_date_performed2.style.display = "none";
    phenotypic_dst_results.style.display = "none";
    // phenotypic_date_performed2.removeAttribute("required");
  }
}

phenotypic_performed1.addEventListener("change", toggleElementVisibility);
phenotypic_performed2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
