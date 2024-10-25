const microscopy_reason1 = document.getElementById("microscopy_reason1");
const microscopy_reason2 = document.getElementById("microscopy_reason2");
const microscopy_reason3 = document.getElementById("microscopy_reason3");
const microscopy_reason96 = document.getElementById("microscopy_reason96");


const microscopy_reason_other1 = document.getElementById(
  "microscopy_reason_other1"
);
const microscopy_reason_other = document.getElementById(
  "microscopy_reason_other"
);


function toggleElementVisibility() {
  if (microscopy_reason96.checked) {
    microscopy_reason_other1.style.display = "block";
    microscopy_reason_other.style.display = "block";
  } else {
    microscopy_reason_other1.style.display = "none";
    microscopy_reason_other.style.display = "none";
  }
}

microscopy_reason1.addEventListener("change", toggleElementVisibility);
microscopy_reason2.addEventListener("change", toggleElementVisibility);
microscopy_reason3.addEventListener("change", toggleElementVisibility);
microscopy_reason96.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
