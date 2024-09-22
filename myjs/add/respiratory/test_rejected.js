const test_rejected1 = document.getElementById("test_rejected1");
const test_rejected2 = document.getElementById("test_rejected2");

const test_reasons = document.getElementById("test_reasons");
const test_reasons1 = document.getElementById("test_reasons1");


function toggleElementVisibility() {
  if (test_rejected1.checked) {
    test_reasons.style.display = "block";
    // test_reasons1.setAttribute("required", "required");
  } else {
    test_reasons.style.display = "none";
    // test_reasons1.removeAttribute("required");
  }
}

test_rejected1.addEventListener("change", toggleElementVisibility);
test_rejected2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
