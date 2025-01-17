const xpert_mtb_new1 = document.getElementById("xpert_mtb_new1");
const xpert_mtb_new2 = document.getElementById("xpert_mtb_new2");
const xpert_mtb_new3 = document.getElementById("xpert_mtb_new3");
const xpert_mtb_new4 = document.getElementById("xpert_mtb_new4");
const xpert_mtb_new5 = document.getElementById("xpert_mtb_new5");
const xpert_mtb_new6 = document.getElementById("xpert_mtb_new6");
const xpert_mtb_new7 = document.getElementById("xpert_mtb_new7");
const xpert_mtb_new8 = document.getElementById("xpert_mtb_new8");
const xpert_mtb_new9 = document.getElementById("xpert_mtb_new9");

const xpert_error_code_new1 = document.getElementById("xpert_error_code_new1");
const xpert_error_code_new = document.getElementById("xpert_error_code_new");
const xpert_date_repeat_new1 = document.getElementById("xpert_date_repeat_new1");
const xpert_date_repeat_new = document.getElementById("xpert_date_repeat_new");

function toggleElementVisibility() {
    if (xpert_mtb_new7.checked) {
        xpert_error_code_new1.style.display = "none";
        xpert_error_code_new.style.display = "none";
        xpert_date_repeat_new1.style.display = "block";
        xpert_date_repeat_new.style.display = "block";
    } else if (xpert_mtb_new8.checked) {
        xpert_error_code_new1.style.display = "block";
        xpert_error_code_new.style.display = "block";
        xpert_date_repeat_new1.style.display = "block";
        xpert_date_repeat_new.style.display = "block";
    } else if (xpert_mtb_new9.checked) {
        xpert_error_code_new1.style.display = "none";
        xpert_error_code_new.style.display = "none";
        xpert_date_repeat_new1.style.display = "block";
        xpert_date_repeat_new.style.display = "block";
    }else {
        xpert_error_code_new1.style.display = "none";
        xpert_error_code_new.style.display = "none";
        xpert_date_repeat_new1.style.display = "none";
        xpert_date_repeat_new.style.display = "none";
    }
}


xpert_mtb_new1.addEventListener("change", toggleElementVisibility);
xpert_mtb_new2.addEventListener("change", toggleElementVisibility);
xpert_mtb_new3.addEventListener("change", toggleElementVisibility);
xpert_mtb_new4.addEventListener("change", toggleElementVisibility);
xpert_mtb_new5.addEventListener("change", toggleElementVisibility);
xpert_mtb_new6.addEventListener("change", toggleElementVisibility);
xpert_mtb_new7.addEventListener("change", toggleElementVisibility);
xpert_mtb_new8.addEventListener("change", toggleElementVisibility);
xpert_mtb_new9.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();





