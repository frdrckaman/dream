const nanopore_sequencing1 = document.getElementById("nanopore_sequencing1");
const nanopore_sequencing2 = document.getElementById("nanopore_sequencing2");
const nanopore_sequencing3 = document.getElementById("nanopore_sequencing3");
const nanopore_sequencing4 = document.getElementById("nanopore_sequencing4");

const nanopore_sequencing_done00 = document.getElementById(
  "nanopore_sequencing_done00"
);

nanopore_sequencing2.addEventListener("change", function () {
  if (this.checked) {
    nanopore_sequencing_done00.style.display = "block";
  } else {
    nanopore_sequencing_done00.style.display = "none";
  }
});

// Initial check
if (nanopore_sequencing2.checked) {
  nanopore_sequencing_done00.style.display = "block";
} else {
  nanopore_sequencing_done00.style.display = "none";
}
