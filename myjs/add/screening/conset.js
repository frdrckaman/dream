const conset1 = document.getElementById("conset1");
const conset2 = document.getElementById("conset2");

const conset_date1 = document.getElementById("conset_date1");
const conset_date = document.getElementById("conset_date");

function toggleElementVisibility() {
  if (conset1.checked) {
    conset_date1.style.display = "block";
    conset_date.style.display = "block";
    conset_date.setAttribute("required", "required");
  } else {
    conset_date1.style.display = "none";
    conset_date.style.display = "none";
    conset_date.removeAttribute("required");
  }
}

conset1.addEventListener("change", toggleElementVisibility);
conset2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
