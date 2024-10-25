const sample_type96 = document.getElementById("sample_type96");

const sample_type_other1 = document.getElementById("sample_type_other1");
const sample_type_other = document.getElementById("sample_type_other");

sample_type96.addEventListener("change", function () {
  if (this.checked) {
    sample_type_other1.style.display = "block";
    sample_type_other.style.display = "block";
  } else {
    sample_type_other1.style.display = "none";
    sample_type_other.style.display = "none";
  }
});

// Initial check
if (sample_type96.checked) {
  sample_type_other1.style.display = "block";
  sample_type_other.style.display = "block";
} else {
  sample_type_other1.style.display = "none";
  sample_type_other.style.display = "none";
}
