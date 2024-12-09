const bacteriological_diagnosis1 = document.getElementById(
  "bacteriological_diagnosis1"
);
const bacteriological_diagnosis2 = document.getElementById(
  "bacteriological_diagnosis2"
);
const bacteriological_diagnosis96 = document.getElementById(
  "bacteriological_diagnosis96"
);

const clinician_received_date1 = document.getElementById("clinician_received_date1");
const xpert_truenat_date1 = document.getElementById("xpert_truenat_date1");
const other_bacteriological_date1 = document.getElementById(
  "other_bacteriological_date1"
);


bacteriological_diagnosis1.addEventListener("change", function () {
  if (this.checked) {
    clinician_received_date1.style.display = "block";
  } else {
    clinician_received_date1.style.display = "none";
  }
});

bacteriological_diagnosis2.addEventListener("change", function () {
  if (this.checked) {
    xpert_truenat_date1.style.display = "block";
  } else {
    xpert_truenat_date1.style.display = "none";
  }
});

bacteriological_diagnosis96.addEventListener("change", function () {
  if (this.checked) {
    other_bacteriological_date1.style.display = "block";
  } else {
    other_bacteriological_date1.style.display = "none";
  }
});


// Initial check
if (bacteriological_diagnosis1.checked) {
  clinician_received_date1.style.display = "block";
} else {
  clinician_received_date1.style.display = "none";
}

if (bacteriological_diagnosis2.checked) {
  xpert_truenat_date1.style.display = "block";
} else {
  xpert_truenat_date1.style.display = "none";
}

if (bacteriological_diagnosis96.checked) {
  other_bacteriological_date1.style.display = "block";
} else {
  other_bacteriological_date1.style.display = "none";
}
