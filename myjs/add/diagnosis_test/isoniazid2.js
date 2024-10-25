const isoniazid21 = document.getElementById("isoniazid21");
const isoniazid22 = document.getElementById("isoniazid22");
const isoniazid23 = document.getElementById("isoniazid23");
const isoniazid24 = document.getElementById("isoniazid24");
const isoniazid25 = document.getElementById("isoniazid25");
const isoniazid26 = document.getElementById("isoniazid26");


const isoniazid2_error_code1 = document.getElementById(
  "isoniazid2_error_code1"
);
const isoniazid2_error_code = document.getElementById("isoniazid2_error_code");


function toggleElementVisibility() {
  if (isoniazid26.checked) {
    isoniazid2_error_code1.style.display = "block";
    isoniazid2_error_code.setAttribute("required", "required");
  } else {
    isoniazid2_error_code1.style.display = "none";
    isoniazid2_error_code.removeAttribute("required");
  }
}

isoniazid21.addEventListener("change", toggleElementVisibility);
isoniazid22.addEventListener("change", toggleElementVisibility);
isoniazid23.addEventListener("change", toggleElementVisibility);
isoniazid24.addEventListener("change", toggleElementVisibility);
isoniazid25.addEventListener("change", toggleElementVisibility);
isoniazid26.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
