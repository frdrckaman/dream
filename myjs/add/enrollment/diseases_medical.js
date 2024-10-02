const diseases_medical1 = document.getElementById("diseases_medical1");
const diseases_medical2 = document.getElementById("diseases_medical2");
const diseases_medical3 = document.getElementById("diseases_medical3");
const diseases_medical4 = document.getElementById("diseases_medical4");
const diseases_medical5 = document.getElementById("diseases_medical5");
const diseases_medical6 = document.getElementById("diseases_medical6");
const diseases_medical7 = document.getElementById("diseases_medical7");
const diseases_medical96 = document.getElementById("diseases_medical96");

const diseases_specify1 = document.getElementById("diseases_specify1");
const diseases_specify = document.getElementById("diseases_specify");



diseases_medical96.addEventListener("change", function () {
  if (this.checked) {
    diseases_specify1.style.display = "block";
        diseases_specify.style.display = "block";
  } else {
    diseases_specify1.style.display = "none";
        diseases_specify.style.display = "none";
  }
});



// Initial check

if (diseases_medical96.checked) {
  diseases_specify1.style.display = "block";
    diseases_specify.style.display = "block";
  // diseases_specify.setAttribute("required", "required");
} else {
  diseases_specify1.style.display = "none";
    diseases_specify.style.display = "none";
  diseases_specify.removeAttribute("required");
}