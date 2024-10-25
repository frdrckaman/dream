const ethionamide21 = document.getElementById("ethionamide21");
const ethionamide22 = document.getElementById("ethionamide22");
const ethionamide23 = document.getElementById("ethionamide23");
const ethionamide24 = document.getElementById("ethionamide24");
const ethionamide25 = document.getElementById("ethionamide25");
const ethionamide26 = document.getElementById("ethionamide26");

const ethionamide2_error_code1 = document.getElementById(
  "ethionamide2_error_code1"
);
const ethionamide2_error_code = document.getElementById(
  "ethionamide2_error_code"
);

function toggleElementVisibility() {
  if (ethionamide26.checked) {
    ethionamide2_error_code1.style.display = "block";
    ethionamide2_error_code.setAttribute("required", "required");
  } else {
    ethionamide2_error_code1.style.display = "none";
    ethionamide2_error_code.removeAttribute("required");
  }
}

ethionamide21.addEventListener("change", toggleElementVisibility);
ethionamide22.addEventListener("change", toggleElementVisibility);
ethionamide23.addEventListener("change", toggleElementVisibility);
ethionamide24.addEventListener("change", toggleElementVisibility);
ethionamide25.addEventListener("change", toggleElementVisibility);
ethionamide26.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
