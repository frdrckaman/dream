const tests_conducted1 = document.getElementById("tests_conducted1");
const tests_conducted2 = document.getElementById("tests_conducted2");
const tests_conducted3 = document.getElementById("tests_conducted3");
const tests_conducted4 = document.getElementById("tests_conducted4");
const tests_conducted96 = document.getElementById("tests_conducted96");


const tests_conducted_other1 = document.getElementById(
    "tests_conducted_other1"
);
const tests_conducted_other = document.getElementById(
    "tests_conducted_other"
);


function toggleElementVisibility() {
    if (tests_conducted96.checked) {
        tests_conducted_other1.style.display = "block";
        tests_conducted_other.style.display = "block";
    } else {
        tests_conducted_other1.style.display = "none";
        tests_conducted_other.style.display = "none";
    }
}

tests_conducted1.addEventListener("change", toggleElementVisibility);
tests_conducted2.addEventListener("change", toggleElementVisibility);
tests_conducted3.addEventListener("change", toggleElementVisibility);
tests_conducted4.addEventListener("change", toggleElementVisibility);
tests_conducted96.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
