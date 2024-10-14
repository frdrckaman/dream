const n_afb_microscopy1 = document.getElementById("n_afb_microscopy1");
const n_afb_microscopy2 = document.getElementById("n_afb_microscopy2");
const n_afb_microscopy3 = document.getElementById("n_afb_microscopy3");

const n_afb_microscopy_date1 = document.getElementById(
  "n_afb_microscopy_date1"
);
const n_afb_microscopy_date = document.getElementById("n_afb_microscopy_date");
const n_zn_microscopy_date1 = document.getElementById("n_zn_microscopy_date1");
const n_fm_microscopy_date1 = document.getElementById("n_fm_microscopy_date1");

const n_zn = document.getElementById("n_zn");
const n_zn_results_a = document.getElementById("n_zn_results_a");
const n_zn_results_a1 = document.getElementById("n_zn_results_a1");
const n_zn_results_b = document.getElementById("n_zn_results_b");
const n_zn_results_b1 = document.getElementById("n_zn_results_b1");

const n_fm = document.getElementById("n_fm");
const n_fm_results_a = document.getElementById("n_fm_results_a");
const n_fm_results_a1 = document.getElementById("n_fm_results_a1");
const n_fm_results_b = document.getElementById("n_fm_results_b");
const n_fm_results_b1 = document.getElementById("n_fm_results_b1");

function toggleElementVisibility() {
  if (n_afb_microscopy1.checked) {
    n_zn.style.display = "block";
    n_zn_results_a.style.display = "block";
    n_zn_results_a1.setAttribute("required", "required");
    n_zn_results_b.style.display = "block";
    n_zn_results_b1.setAttribute("required", "required");
    n_fm.style.display = "none";
    n_fm_results_a.style.display = "none";
    n_fm_results_a1.removeAttribute("required");
    n_fm_results_b.style.display = "none";
    n_fm_results_b1.removeAttribute("required");
  } else if (n_afb_microscopy2.checked) {
    n_zn.style.display = "none";
    n_zn_results_a.style.display = "none";
    n_zn_results_a1.removeAttribute("required");
    n_zn_results_b.style.display = "none";
    n_zn_results_b1.removeAttribute("required");
    n_fm.style.display = "block";
    n_fm_results_a.style.display = "block";
    n_fm_results_a1.setAttribute("required", "required");
    n_fm_results_b.style.display = "block";
    n_fm_results_b1.setAttribute("required", "required");
  } else {
    n_zn.style.display = "none";
    n_zn_results_a.style.display = "none";
    n_zn_results_a1.removeAttribute("required");
    n_zn_results_b.style.display = "none";
    n_zn_results_b1.removeAttribute("required");
    n_fm.style.display = "none";
    n_fm_results_a.style.display = "none";
    n_fm_results_a1.removeAttribute("required");
    n_fm_results_b.style.display = "none";
    n_fm_results_b1.removeAttribute("required");
  }
}

n_afb_microscopy1.addEventListener("change", toggleElementVisibility);
n_afb_microscopy2.addEventListener("change", toggleElementVisibility);
n_afb_microscopy3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
