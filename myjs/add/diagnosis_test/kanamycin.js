const kanamycin1 = document.getElementById("kanamycin1");
const kanamycin2 = document.getElementById("kanamycin2");
const kanamycin3 = document.getElementById("kanamycin3");
const kanamycin4 = document.getElementById("kanamycin4");
const kanamycin5 = document.getElementById("kanamycin5");
const kanamycin6 = document.getElementById("kanamycin6");

const kanamycin_error_code1 = document.getElementById("kanamycin_error_code1");
const kanamycin_error_code = document.getElementById("kanamycin_error_code");

function toggleElementVisibility() {
  if (kanamycin6.checked) {
    kanamycin_error_code1.style.display = "block";
    kanamycin_error_code.setAttribute("required", "required");
  } else {
    kanamycin_error_code1.style.display = "none";
    kanamycin_error_code.removeAttribute("required");
  }
}

kanamycin1.addEventListener("change", toggleElementVisibility);
kanamycin2.addEventListener("change", toggleElementVisibility);
kanamycin3.addEventListener("change", toggleElementVisibility);
kanamycin4.addEventListener("change", toggleElementVisibility);
kanamycin5.addEventListener("change", toggleElementVisibility);
kanamycin6.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
