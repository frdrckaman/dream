const bacteriological_diagnosis1 = document.getElementById(
  "bacteriological_diagnosis1"
);
const bacteriological_diagnosis2 = document.getElementById(
  "bacteriological_diagnosis2"
);
const bacteriological_diagnosis3 = document.getElementById(
  "bacteriological_diagnosis3"
);
const bacteriological_diagnosis96 = document.getElementById(
  "bacteriological_diagnosis96"
);

const xpert_ultra_date1 = document.getElementById("xpert_ultra_date1");
const truenat_date1 = document.getElementById("truenat_date1");
const afb_microscope_date1 = document.getElementById("afb_microscope_date1");
const other_bacteriological1 = document.getElementById(
  "other_bacteriological1"
);
const other_bacteriological_date1 = document.getElementById(
  "other_bacteriological_date1"
);


bacteriological_diagnosis1.addEventListener("change", function () {
  if (this.checked) {
    xpert_ultra_date1.style.display = "block";
  } else {
    xpert_ultra_date1.style.display = "none";
  }
});

bacteriological_diagnosis2.addEventListener("change", function () {
  if (this.checked) {
    truenat_date1.style.display = "block";
  } else {
    truenat_date1.style.display = "none";
  }
});

bacteriological_diagnosis3.addEventListener("change", function () {
  if (this.checked) {
    afb_microscope_date1.style.display = "block";
  } else {
    afb_microscope_date1.style.display = "none";
  }
});

bacteriological_diagnosis96.addEventListener("change", function () {
  if (this.checked) {
    other_bacteriological_date1.style.display = "block";
    other_bacteriological1.style.display = "block";
  } else {
    other_bacteriological_date1.style.display = "none";
    other_bacteriological1.style.display = "none";
  }
});


// Initial check
if (bacteriological_diagnosis1.checked) {
  xpert_ultra_date1.style.display = "block";
} else {
  xpert_ultra_date1.style.display = "none";
}

if (bacteriological_diagnosis2.checked) {
  truenat_date1.style.display = "block";
} else {
  truenat_date1.style.display = "none";
}

if (bacteriological_diagnosis3.checked) {
  afb_microscope_date1.style.display = "block";
} else {
  afb_microscope_date1.style.display = "none";
}

if (bacteriological_diagnosis96.checked) {
  other_bacteriological_date1.style.display = "block";
  other_bacteriological1.style.display = "block";
} else {
  other_bacteriological_date1.style.display = "none";
  other_bacteriological1.style.display = "none";
}
