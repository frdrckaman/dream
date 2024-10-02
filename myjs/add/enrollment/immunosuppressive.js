const immunosuppressive1 = document.getElementById("immunosuppressive1");
const immunosuppressive2 = document.getElementById("immunosuppressive2");
const immunosuppressive99 = document.getElementById("immunosuppressive99");


const immunosuppressive_specify1 = document.getElementById(
  "immunosuppressive_specify1"
);

function toggleElementVisibility() {
  if (immunosuppressive1.checked) {
    immunosuppressive_specify1.style.display = "block";
  } else {
    immunosuppressive_specify1.style.display = "none";
  }
}

immunosuppressive1.addEventListener("change", toggleElementVisibility);
immunosuppressive2.addEventListener("change", toggleElementVisibility);
immunosuppressive99.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
