const capreomycin1 = document.getElementById("capreomycin1");
const capreomycin2 = document.getElementById("capreomycin2");
const capreomycin3 = document.getElementById("capreomycin3");
const capreomycin4 = document.getElementById("capreomycin4");
const capreomycin5 = document.getElementById("capreomycin5");
const capreomycin6 = document.getElementById("capreomycin6");

const capreomycin_error_code1 = document.getElementById("capreomycin_error_code1");
const capreomycin_error_code = document.getElementById("capreomycin_error_code");

function toggleElementVisibility() {
  if (capreomycin6.checked) {
    capreomycin_error_code1.style.display = "block";
    capreomycin_error_code.setAttribute("required", "required");
  } else {
    capreomycin_error_code1.style.display = "none";
    capreomycin_error_code.removeAttribute("required");
  }
}

capreomycin1.addEventListener("change", toggleElementVisibility);
capreomycin2.addEventListener("change", toggleElementVisibility);
capreomycin3.addEventListener("change", toggleElementVisibility);
capreomycin4.addEventListener("change", toggleElementVisibility);
capreomycin5.addEventListener("change", toggleElementVisibility);
capreomycin6.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
