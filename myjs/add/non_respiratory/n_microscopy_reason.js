const microscopy_reason2_1 = document.getElementById("microscopy_reason2_1");
const microscopy_reason2_2 = document.getElementById("microscopy_reason2_2");
const microscopy_reason2_3 = document.getElementById("microscopy_reason2_3");
const microscopy_reason2_96 = document.getElementById("microscopy_reason2_96");


const microscopy_reason_other2_1 = document.getElementById(
  "microscopy_reason_other2_1"
);
const microscopy_reason_other2_2 = document.getElementById(
  "microscopy_reason_other2_2"
);


function toggleElementVisibility() {
  if (microscopy_reason2_96.checked) {
    microscopy_reason_other2_1.style.display = "block";
    microscopy_reason_other2_2.style.display = "block";
  } else {
    microscopy_reason_other2_1.style.display = "none";
    microscopy_reason_other2_2.style.display = "none";
  }
}

microscopy_reason2_1.addEventListener("change", toggleElementVisibility);
microscopy_reason2_2.addEventListener("change", toggleElementVisibility);
microscopy_reason2_3.addEventListener("change", toggleElementVisibility);
microscopy_reason2_96.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
