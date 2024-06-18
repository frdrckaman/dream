const regimen_changed1 = document.getElementById("regimen_changed1");
const regimen_changed2 = document.getElementById("regimen_changed2");

const regimen_name1 = document.getElementById("regimen_name1");
const regimen_name = document.getElementById("regimen_name");

function toggleElementVisibility() {
  if (regimen_changed1.checked) {
    regimen_name1.style.display = "block";
    regimen_name.setAttribute("required", "required");
  } else {
    regimen_name1.style.display = "none";
    regimen_name.removeAttribute("required");
  }
}

regimen_changed1.addEventListener("change", toggleElementVisibility);
regimen_changed2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
