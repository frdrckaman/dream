const fluoroquinolones1 = document.getElementById("fluoroquinolones1");
const fluoroquinolones2 = document.getElementById("fluoroquinolones2");
const fluoroquinolones3 = document.getElementById("fluoroquinolones3");
const fluoroquinolones4 = document.getElementById("fluoroquinolones4");
const fluoroquinolones5 = document.getElementById("fluoroquinolones5");
const fluoroquinolones6 = document.getElementById("fluoroquinolones6");

const fluoroquinolones_error_code1 = document.getElementById(
  "fluoroquinolones_error_code1"
);
const fluoroquinolones_error_code = document.getElementById("fluoroquinolones_error_code");

function toggleElementVisibility() {
  if (fluoroquinolones6.checked) {
    fluoroquinolones_error_code1.style.display = "block";
    fluoroquinolones_error_code.setAttribute("required", "required");
  } else {
    fluoroquinolones_error_code1.style.display = "none";
    fluoroquinolones_error_code.removeAttribute("required");
  }
}

fluoroquinolones1.addEventListener("change", toggleElementVisibility);
fluoroquinolones2.addEventListener("change", toggleElementVisibility);
fluoroquinolones3.addEventListener("change", toggleElementVisibility);
fluoroquinolones4.addEventListener("change", toggleElementVisibility);
fluoroquinolones5.addEventListener("change", toggleElementVisibility);
fluoroquinolones6.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
