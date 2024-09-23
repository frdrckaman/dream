const sample_received1 = document.getElementById("sample_received1");
const sample_received2 = document.getElementById("sample_received2");

const sample_amount = document.getElementById("sample_amount");
const sample_amount1 = document.getElementById("sample_amount1");
const sample_reason = document.getElementById("sample_reason");
const sample_reason1 = document.getElementById("sample_reason1");

function toggleElementVisibility() {
  if (sample_received1.checked) {
    sample_amount.style.display = "block";
    sample_amount1.setAttribute("required", "required");
    sample_reason.style.display = "none";
    sample_reason1.removeAttribute("required");
  } else if (sample_received2.checked) {
    sample_amount.style.display = "none";
    sample_amount1.removeAttribute("required");
    sample_reason.style.display = "block";
    sample_reason1.setAttribute("required", "required");
  } else {
    sample_amount.style.display = "none";
    sample_amount1.removeAttribute("required");
    sample_reason.style.display = "none";
    sample_reason1.removeAttribute("required");
  }
}

sample_received1.addEventListener("change", toggleElementVisibility);
sample_received2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
