const xpert_mtb_repeat1 = document.getElementById("xpert_mtb_repeat1");
const xpert_mtb_repeat2 = document.getElementById("xpert_mtb_repeat2");
const xpert_mtb_repeat3 = document.getElementById("xpert_mtb_repeat3");
const xpert_mtb_repeat4 = document.getElementById("xpert_mtb_repeat4");
const xpert_mtb_repeat5 = document.getElementById("xpert_mtb_repeat5");
const xpert_mtb_repeat6 = document.getElementById("xpert_mtb_repeat6");
const xpert_mtb_repeat7 = document.getElementById("xpert_mtb_repeat7");
const xpert_mtb_repeat8 = document.getElementById("xpert_mtb_repeat8");
const xpert_mtb_repeat9 = document.getElementById("xpert_mtb_repeat9");

const xpert_error_repeat1 = document.getElementById("xpert_error_repeat1");
const xpert_error_repeat = document.getElementById("xpert_error_repeat");


function toggleElementVisibility() {
    if (xpert_mtb_repeat8.checked) {
        xpert_error_repeat1.style.display = "block";
        xpert_error_repeat.style.display = "block";
    } else {
        xpert_error_repeat1.style.display = "none";
        xpert_error_repeat.style.display = "none";
    }
}


xpert_mtb_repeat1.addEventListener("change", toggleElementVisibility);
xpert_mtb_repeat2.addEventListener("change", toggleElementVisibility);
xpert_mtb_repeat3.addEventListener("change", toggleElementVisibility);
xpert_mtb_repeat4.addEventListener("change", toggleElementVisibility);
xpert_mtb_repeat5.addEventListener("change", toggleElementVisibility);
xpert_mtb_repeat6.addEventListener("change", toggleElementVisibility);
xpert_mtb_repeat7.addEventListener("change", toggleElementVisibility);
xpert_mtb_repeat8.addEventListener("change", toggleElementVisibility);
xpert_mtb_repeat9.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
