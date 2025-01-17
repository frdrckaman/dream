const tests_conducted_21 = document.getElementById("tests_conducted_21");
const tests_conducted_22 = document.getElementById("tests_conducted_22");
const tests_conducted_23 = document.getElementById("tests_conducted_23");
const tests_conducted_24 = document.getElementById("tests_conducted_24");
const tests_conducted_296 = document.getElementById("tests_conducted_296");


const tests_conducted_other2_22 = document.getElementById(
    "tests_conducted_other2_22"
);
const tests_conducted_other2 = document.getElementById(
    "tests_conducted_other2"
);


function toggleElementVisibility() {
    if (tests_conducted_296.checked) {
        tests_conducted_other2_22.style.display = "block";
        tests_conducted_other2.style.display = "block";
    } else {
        tests_conducted_other2_22.style.display = "none";
        tests_conducted_other2.style.display = "none";
    }
}

tests_conducted_21.addEventListener("change", toggleElementVisibility);
tests_conducted_22.addEventListener("change", toggleElementVisibility);
tests_conducted_23.addEventListener("change", toggleElementVisibility);
tests_conducted_24.addEventListener("change", toggleElementVisibility);
tests_conducted_296.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
