const sputum_samples1 = document.getElementById("sputum_samples1");
const sputum_samples2 = document.getElementById("sputum_samples2");
const sputum_samples3 = document.getElementById("sputum_samples3");
const sputum_samples4 = document.getElementById("sputum_samples4");
const sputum_samples5 = document.getElementById("sputum_samples5");
const sputum_samples6 = document.getElementById("sputum_samples6");
const sputum_samples96 = document.getElementById("sputum_samples96");

const pleural_fluid1 = document.getElementById("pleural_fluid_date1");
const pleural_fluid = document.getElementById("pleural_fluid_date");
const csf_date1 = document.getElementById("csf_date1");
const csf_date = document.getElementById("csf_date");
const peritoneal_fluid_date1 = document.getElementById(
  "peritoneal_fluid_date1"
);
const peritoneal_fluid_date = document.getElementById("peritoneal_fluid_date");
const pericardial_fluid_date1 = document.getElementById(
  "pericardial_fluid_date1"
);
const pericardial_fluid_date = document.getElementById(
  "pericardial_fluid_date"
);
const lymph_node_aspirate_date1 = document.getElementById(
  "lymph_node_aspirate_date1"
);
const lymph_node_aspirate_date = document.getElementById(
  "lymph_node_aspirate_date"
);
const stool_date1 = document.getElementById("stool_date1");
const stool_date = document.getElementById("stool_date");
const sputum_samples_date1 = document.getElementById("sputum_samples_date1");
const sputum_samples_date = document.getElementById("sputum_samples_date");

sputum_samples1.addEventListener("change", function () {
  if (this.checked) {
    pleural_fluid1.style.display = "block";
    pleural_fluid.setAttribute("required", "required");
  } else {
    pleural_fluid1.style.display = "none";
    pleural_fluid.removeAttribute("required");
  }
});

sputum_samples2.addEventListener("change", function () {
  if (this.checked) {
    csf_date1.style.display = "block";
    csf_date.setAttribute("required", "required");
  } else {
    csf_date1.style.display = "none";
    csf_date.removeAttribute("required");
  }
});

sputum_samples3.addEventListener("change", function () {
  if (this.checked) {
    peritoneal_fluid_date1.style.display = "block";
    peritoneal_fluid_date.setAttribute("required", "required");
  } else {
    peritoneal_fluid_date1.style.display = "none";
    peritoneal_fluid_date.removeAttribute("required");
  }
});

sputum_samples4.addEventListener("change", function () {
  if (this.checked) {
    pericardial_fluid_date1.style.display = "block";
    pericardial_fluid_date.setAttribute("required", "required");
  } else {
    pericardial_fluid_date1.style.display = "none";
    pericardial_fluid_date.removeAttribute("required");
  }
});

sputum_samples5.addEventListener("change", function () {
  if (this.checked) {
    lymph_node_aspirate_date1.style.display = "block";
    lymph_node_aspirate_date.setAttribute("required", "required");
  } else {
    lymph_node_aspirate_date1.style.display = "none";
    lymph_node_aspirate_date.removeAttribute("required");
  }
});

sputum_samples6.addEventListener("change", function () {
  if (this.checked) {
    stool_date1.style.display = "block";
    stool_date.setAttribute("required", "required");
  } else {
    stool_date1.style.display = "none";
    stool_date.removeAttribute("required");
  }
});

sputum_samples96.addEventListener("change", function () {
  if (this.checked) {
    sputum_samples_date1.style.display = "block";
    sputum_samples_date.setAttribute("required", "required");
  } else {
    sputum_samples_date1.style.display = "none";
    sputum_samples_date.removeAttribute("required");
  }
});

// Initial check
if (sputum_samples1.checked) {
  pleural_fluid1.style.display = "block";
  pleural_fluid.setAttribute("required", "required");
} else {
  pleural_fluid1.style.display = "none";
  pleural_fluid.removeAttribute("required");
}

if (sputum_samples2.checked) {
  csf_date1.style.display = "block";
  csf_date.setAttribute("required", "required");
} else {
  csf_date1.style.display = "none";
  csf_date.removeAttribute("required");
}

if (sputum_samples3.checked) {
  peritoneal_fluid_date1.style.display = "block";
  peritoneal_fluid_date.setAttribute("required", "required");
} else {
  peritoneal_fluid_date1.style.display = "none";
  peritoneal_fluid_date.removeAttribute("required");
}

if (sputum_samples4.checked) {
  pericardial_fluid_date1.style.display = "block";
  pericardial_fluid_date.setAttribute("required", "required");
} else {
  pericardial_fluid_date1.style.display = "none";
  pericardial_fluid_date.removeAttribute("required");
}

if (sputum_samples5.checked) {
  lymph_node_aspirate_date1.style.display = "block";
  lymph_node_aspirate_date.setAttribute("required", "required");
} else {
  lymph_node_aspirate_date1.style.display = "none";
  lymph_node_aspirate_date.removeAttribute("required");
}

if (sputum_samples6.checked) {
  stool_date1.style.display = "block";
  stool_date.setAttribute("required", "required");
} else {
  stool_date1.style.display = "none";
  stool_date.removeAttribute("required");
}

if (sputum_samples96.checked) {
  sputum_samples_date1.style.display = "block";
  sputum_samples_date.setAttribute("required", "required");
} else {
  sputum_samples_date1.style.display = "none";
  sputum_samples_date.removeAttribute("required");
}
