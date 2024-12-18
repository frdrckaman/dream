const culture_performed1 = document.getElementById("culture_performed1");
const culture_performed2 = document.getElementById("culture_performed2");


const culture_method = document.getElementById("culture_method");
const culture_results = document.getElementById("culture_results");



function toggleElementVisibility() {
  if (culture_performed1.checked) {
    culture_method.style.display = "block";
    culture_results.style.display = "block";
  } else {
    culture_method.style.display = "none";
    culture_results.style.display = "none";
  }
}

culture_performed1.addEventListener("change", toggleElementVisibility);
culture_performed2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
