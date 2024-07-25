const culture_done1 = document.getElementById("culture_done1");
const culture_done2 = document.getElementById("culture_done2");

const sample_type2 = document.getElementById("sample_type2");
const sample_methods = document.getElementById("sample_methods");

function toggleElementVisibility() {
  if (culture_done1.checked) {
    sample_type2.style.display = "block";
    // qn05_other.setAttribute("required", "required");
    sample_methods.style.display = "block";
  } else {
    sample_type2.style.display = "none";
    // qn05_other.removeAttribute("required");
    sample_methods.style.display = "none";
  }
}

culture_done1.addEventListener("change", toggleElementVisibility);
culture_done2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
