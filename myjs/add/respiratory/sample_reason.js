const sample_reason1 = document.getElementById("sample_reason1");
const sample_reason2 = document.getElementById("sample_reason2");
const sample_reason96 = document.getElementById("sample_reason96");

const sample_reason_other1 = document.getElementById("sample_reason_other1");
const sample_reason_other = document.getElementById("sample_reason_other");

function toggleElementVisibility() {
  if (sample_reason96.checked) {
    sample_reason_other1.style.display = "block";
    sample_reason_other.style.display = "block";
  }  else {
    sample_reason_other1.style.display = "none";
    sample_reason_other.style.display = "none";
  }
}

sample_reason1.addEventListener("change", toggleElementVisibility);
sample_reason2.addEventListener("change", toggleElementVisibility);
sample_reason96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
