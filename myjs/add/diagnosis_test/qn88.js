const genotyping_asay1 = document.getElementById("genotyping_asay1");
const genotyping_asay2 = document.getElementById("genotyping_asay2");
const genotyping_asay3 = document.getElementById("genotyping_asay3");
const genotyping_asay4 = document.getElementById("genotyping_asay4");

const genotyping_done00 = document.getElementById("genotyping_done00");

genotyping_asay1.addEventListener("change", function () {
  if (this.checked) {
    genotyping_done00.style.display = "block";
  } else {
    genotyping_done00.style.display = "none";
  }
});

// Initial check
if (genotyping_asay1.checked) {
  genotyping_done00.style.display = "block";
} else {
  genotyping_done00.style.display = "none";
}
