const amikacin21 = document.getElementById("amikacin21");
const amikacin22 = document.getElementById("amikacin22");
const amikacin23 = document.getElementById("amikacin23");
const amikacin24 = document.getElementById("amikacin24");
const amikacin25 = document.getElementById("amikacin25");
const amikacin26 = document.getElementById("amikacin26");

const amikacin2_error_code1 = document.getElementById(
  "amikacin2_error_code1"
);
const amikacin2_error_code = document.getElementById(
  "amikacin2_error_code"
);

function toggleElementVisibility() {
  if (amikacin26.checked) {
    amikacin2_error_code1.style.display = "block";
    amikacin2_error_code.setAttribute("required", "required");
  } else {
    amikacin2_error_code1.style.display = "none";
    amikacin2_error_code.removeAttribute("required");
  }
}

amikacin21.addEventListener("change", toggleElementVisibility);
amikacin22.addEventListener("change", toggleElementVisibility);
amikacin23.addEventListener("change", toggleElementVisibility);
amikacin24.addEventListener("change", toggleElementVisibility);
amikacin25.addEventListener("change", toggleElementVisibility);
amikacin26.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
