const laboratory_test_used96666 = document.getElementById(
  "laboratory_test_used96"
);

const laboratory_test_used_other = document.getElementById(
  "laboratory_test_used_other"
);
const laboratory_test_used_other1 = document.getElementById(
  "laboratory_test_used_other1"
);

laboratory_test_used96666.addEventListener("change", function () {
  if (this.checked) {
    laboratory_test_used_other1.style.display = "block";
    laboratory_test_used_other.style.display = "block";
  } else {
    laboratory_test_used_other.style.display = "none";
    laboratory_test_used_other1.style.display = "none";
  }
});

// Initial check
if (laboratory_test_used96666.checked) {
  laboratory_test_used_other1.style.display = "block";
  laboratory_test_used_other.style.display = "block";
} else {
  laboratory_test_used_other.style.display = "none";
  laboratory_test_used_other1.style.display = "none";
}
