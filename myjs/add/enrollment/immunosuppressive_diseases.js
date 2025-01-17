const immunosuppressive_diseases1 = document.getElementById("immunosuppressive_diseases1");
const immunosuppressive_diseases2 = document.getElementById("immunosuppressive_diseases2");
const immunosuppressive_diseases3 = document.getElementById("immunosuppressive_diseases3");
const immunosuppressive_diseases4 = document.getElementById("immunosuppressive_diseases4");
const immunosuppressive_diseases5 = document.getElementById("immunosuppressive_diseases5");
const immunosuppressive_diseases96 = document.getElementById("immunosuppressive_diseases96");

const immunosuppressive_specify1 = document.getElementById("immunosuppressive_specify1");
const immunosuppressive_specify = document.getElementById("immunosuppressive_specify");



immunosuppressive_diseases96.addEventListener("change", function () {
  if (this.checked) {
    immunosuppressive_specify1.style.display = "block";
    immunosuppressive_specify.style.display = "block";
  } else {
    immunosuppressive_specify1.style.display = "none";
    immunosuppressive_specify.style.display = "none";
  }
});



// Initial check

if (immunosuppressive_diseases96.checked) {
  immunosuppressive_specify1.style.display = "block";
  immunosuppressive_specify.style.display = "block";
  // immunosuppressive_specify.setAttribute("required", "required");
} else {
  immunosuppressive_specify1.style.display = "none";
  immunosuppressive_specify.style.display = "none";
  immunosuppressive_specify.removeAttribute("required");
}