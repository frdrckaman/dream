const genotyping_done1 = document.getElementById("genotyping_done1");
const genotyping_done2 = document.getElementById("genotyping_done2");

const genotyping_asay = document.getElementById("genotyping_asay");

function toggleElementVisibility() {
  if (genotyping_done1.checked) {
    genotyping_asay.style.display = "block";
    // qn05_other.setAttribute("required", "required");
  } else {
    genotyping_asay.style.display = "none";
    // qn05_other.removeAttribute("required");
  }
}

genotyping_done1.addEventListener("change", toggleElementVisibility);
genotyping_done2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
