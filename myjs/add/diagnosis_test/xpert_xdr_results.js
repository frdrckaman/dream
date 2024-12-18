const xpert_xdr_performed1 = document.getElementById("xpert_xdr_performed1");
const xpert_xdr_performed2 = document.getElementById("xpert_xdr_performed2");

const xpert_xdr_results_r = document.getElementById(
  "xpert_xdr_results_r"
);
const xpert_xdr_results= document.getElementById("xpert_xdr_results");


function toggleElementVisibility() {
  if (xpert_xdr_performed1.checked) {
    xpert_xdr_results.style.display = "block";
    xpert_xdr_results_r.style.display = "block";
    // xpert_xdr_resultssetAttribute("required", "required");
  } else {
    xpert_xdr_results.style.display = "none";
    xpert_xdr_results_r.style.display = "none";
    // xpert_xdr_resultsremoveAttribute("required");
  }
}

xpert_xdr_performed1.addEventListener("change", toggleElementVisibility);
xpert_xdr_performed2.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
