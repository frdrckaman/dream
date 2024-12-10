const culture_performed1 = document.getElementById("culture_performed1");
const culture_performed2 = document.getElementById("culture_performed2");

const culture_type = document.getElementById("culture_type");
const sample_methods = document.getElementById("sample_methods");

function toggleElementVisibility() {
  if (culture_performed1.checked) {
    culture_type.style.display = "block";
    // qn05_other.setAttribute("required", "required");
    sample_methods.style.display = "block";
  } else {
    culture_type.style.display = "none";
    // qn05_other.removeAttribute("required");
    sample_methods.style.display = "none";
  }
}

culture_performed1.addEventListener("change", toggleElementVisibility);
culture_performed2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
