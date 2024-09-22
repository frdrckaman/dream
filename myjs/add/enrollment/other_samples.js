const other_samples1 = document.getElementById("other_samples1");
const other_samples2 = document.getElementById("other_samples2");
const other_samples3 = document.getElementById("other_samples3");

const sputum_samples = document.getElementById("sputum_samples");

function toggleElementVisibility() {
  if (other_samples1.checked) {
    sputum_samples.style.display = "block";
    // diseases_medical1.setAttribute("required", "required");
  } else if (other_samples3.checked) {
    sputum_samples.style.display = "block";
    // diseases_medical1.setAttribute("required", "required");
  } else {
    sputum_samples.style.display = "none";
    // diseases_medical1.removeAttribute("required");
  }
}

other_samples1.addEventListener("change", toggleElementVisibility);
other_samples2.addEventListener("change", toggleElementVisibility);
other_samples3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
