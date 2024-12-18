const culture_results1 = document.getElementById("culture_results1");
const culture_results2 = document.getElementById("culture_results2");
const culture_results3 = document.getElementById("culture_results3");
const culture_results4 = document.getElementById("culture_results4");

const phenotypic_performed_r = document.getElementById("phenotypic_performed_r");
const phenotypic_performed = document.getElementById("phenotypic_performed");

function toggleElementVisibility() {
    if (culture_results1.checked) {
        phenotypic_performed_r.style.display = "block";
        phenotypic_performed.style.display = "block";
        // qn05_other.setAttribute("required", "required");
    } else {
        phenotypic_performed_r.style.display = "none";
        phenotypic_performed.style.display = "none";
        // qn05_other.removeAttribute("required");
    }
}

culture_results1.addEventListener("change", toggleElementVisibility);
culture_results2.addEventListener("change", toggleElementVisibility);
culture_results3.addEventListener("change", toggleElementVisibility);
culture_results4.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
