const sample_type1 = document.getElementById("sample_type1");
const sample_type96 = document.getElementById("sample_type96");

const sample_type_other1 = document.getElementById("sample_type_other1");
const sample_type_other = document.getElementById("sample_type_other");


function toggleElementVisibility() {
  if (sample_type96.checked) {
    sample_type_other1.style.display = "block";
    sample_type_other.setAttribute("required", "required");
  } else {
    sample_type_other1.style.display = "none";
    sample_type_other.removeAttribute("required");
  }
}

sample_type1.addEventListener("change", toggleElementVisibility);
sample_type96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
