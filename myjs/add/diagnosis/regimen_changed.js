const regimen_changed1_1_1 = document.getElementById("regimen_changed1");
const regimen_changed2_2_2 = document.getElementById("regimen_changed2");

const regimen_changed__date1 = document.getElementById(
  "regimen_changed__date1"
);
const regimen_changed__date = document.getElementById("regimen_changed__date");

const regimen_removed_name1 = document.getElementById("regimen_removed_name1");
const regimen_removed_name = document.getElementById("regimen_removed_name");

const regimen_added_name1 = document.getElementById("regimen_added_name1");
const regimen_added_name = document.getElementById("regimen_added_name");

const regimen_changed__reason1 = document.getElementById(
  "regimen_changed__reason1"
);
const regimen_changed__reason = document.getElementById(
  "regimen_changed__reason"
);

function toggleElementVisibility() {
  if (regimen_changed1_1_1.checked) {
    regimen_changed__date1.style.display = "block";
    regimen_changed__date.style.display = "block";
    regimen_removed_name1.style.display = "block";
    regimen_removed_name.style.display = "block";
    regimen_added_name1.style.display = "block";
    regimen_added_name.style.display = "block";
    regimen_changed__reason1.style.display = "block";
    regimen_changed__reason.style.display = "block";
  } else {
    regimen_changed__date1.style.display = "none";
    regimen_changed__date.style.display = "none";
    regimen_removed_name.style.display = "none";
    regimen_removed_name1.style.display = "none";
    regimen_added_name1.style.display = "none";
    regimen_added_name.style.display = "none";
    regimen_changed__reason1.style.display = "none";
    regimen_changed__reason.style.display = "none";
  }
}

regimen_changed1_1_1.addEventListener("change", toggleElementVisibility);
regimen_changed2_2_2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
