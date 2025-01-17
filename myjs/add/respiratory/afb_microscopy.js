const afb_microscopy1 = document.getElementById("afb_microscopy1");
const afb_microscopy2 = document.getElementById("afb_microscopy2");


const afb_technique_a_1 = document.getElementById("afb_technique_a_1");
const afb_technique_a = document.getElementById("afb_technique_a");
const afb_results_a_1_1 = document.getElementById("afb_results_a_1_1");
const afb_results_a = document.getElementById("afb_results_a");
const afb_date_a_1 = document.getElementById("afb_date_a_1");

const afb_technique_b_1 = document.getElementById("afb_technique_b_1");
const afb_technique_b = document.getElementById("afb_technique_b");
const afb_results_b_1 = document.getElementById("afb_results_b_1");
const afb_results_b = document.getElementById("afb_results_b");
const afb_date_b_1 = document.getElementById("afb_date_b_1");

function toggleElementVisibility() {
  if (afb_microscopy1.checked) {
    afb_technique_a_1.style.display = "block";
    afb_technique_a.style.display = "block";
    afb_results_a_1_1.style.display = "block";
    afb_results_a.style.display = "block";
    afb_date_a_1.style.display = "block";

    afb_technique_b_1.style.display = "block";
    afb_technique_b.style.display = "block";
    afb_results_b_1.style.display = "block";
    afb_results_b.style.display = "block";
    afb_date_b_1.style.display = "block";
  } else {
    afb_technique_a_1.style.display = "none";
    afb_technique_a.style.display = "none";
    afb_results_a_1_1.style.display = "none";
    afb_results_a.style.display = "none";
    afb_date_a_1.style.display = "none";

    afb_technique_b_1.style.display = "none";
    afb_technique_b.style.display = "none";
    afb_results_b_1.style.display = "none";
    afb_results_b.style.display = "none";
    afb_date_b_1.style.display = "none";
  }
}

afb_microscopy1.addEventListener("change", toggleElementVisibility);
afb_microscopy2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
