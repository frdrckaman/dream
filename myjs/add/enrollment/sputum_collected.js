const sputum_collected1 = document.getElementById("sputum_collected1");
const sputum_collected2 = document.getElementById("sputum_collected2");

const sample_date1 = document.getElementById("sample_date1");
const sample_date = document.getElementById("sample_date");

function toggleElementVisibility() {
  if (sputum_collected1.checked) {
    sample_date1.style.display = "block";
    sample_date.setAttribute("required", "required");
  } else {
    sample_date1.style.display = "none";
    sample_date.removeAttribute("required");
  }
}

sputum_collected1.addEventListener("change", toggleElementVisibility);
sputum_collected2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
