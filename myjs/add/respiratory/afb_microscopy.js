const afb_microscopy1 = document.getElementById("afb_microscopy1");
const afb_microscopy2 = document.getElementById("afb_microscopy2");
const afb_microscopy3 = document.getElementById("afb_microscopy3");

const zn = document.getElementById("zn");
const zn_results_a = document.getElementById("zn_results_a");
const zn_results_a1 = document.getElementById("zn_results_a1");
const zn_results_b = document.getElementById("zn_results_b");
const zn_results_b1 = document.getElementById("zn_results_b1");

function toggleElementVisibility() {
  if (afb_microscopy1.checked) {
    zn.style.display = "block";
    zn_results_a.style.display = "block";
    zn_results_a1.setAttribute("required", "required");
    zn_results_b.style.display = "none";
    zn_results_b1.removeAttribute("required");
  } else if (afb_microscopy1.checked) {
    zn.style.display = "block";
    zn_results_a.style.display = "none";
    zn_results_a1.removeAttribute("required");
    zn_results_b.style.display = "block";
    zn_results_b1.setAttribute("required", "required");
  } else {
    zn.style.display = "none";
    zn_results_a.style.display = "none";
    zn_results_a1.removeAttribute("required");
    zn_results_b.style.display = "none";
    zn_results_b1.removeAttribute("required");
  }
}

afb_microscopy1.addEventListener("change", toggleElementVisibility);
afb_microscopy2.addEventListener("change", toggleElementVisibility);
afb_microscopy3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
