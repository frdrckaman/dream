const nanopore_sequencing_done1 = document.getElementById(
  "nanopore_sequencing_done1"
);
const nanopore_sequencing_done2 = document.getElementById(
  "nanopore_sequencing_done2"
);

const nanopore_sequencing = document.getElementById("nanopore_sequencing");

function toggleElementVisibility() {
  if (nanopore_sequencing_done1.checked) {
    nanopore_sequencing.style.display = "block";
    // qn05_other.setAttribute("required", "required");
  } else {
    nanopore_sequencing.style.display = "none";
    // qn05_other.removeAttribute("required");
  }
}

nanopore_sequencing_done1.addEventListener("change", toggleElementVisibility);
nanopore_sequencing_done2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
