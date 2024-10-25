const test_reasons96 = document.getElementById("test_reasons96");

const test_reasons_other1 = document.getElementById("test_reasons_other1");
const test_reasons_other = document.getElementById("test_reasons_other");

test_reasons96.addEventListener("change", function () {
  if (this.checked) {
    test_reasons_other1.style.display = "block";
    test_reasons_other.style.display = "block";
  } else {
    test_reasons_other1.style.display = "none";
    test_reasons_other.style.display = "none";
  }
});

// Initial check
if (test_reasons96.checked) {
  test_reasons_other1.style.display = "block";
  test_reasons_other.style.display = "block";
} else {
  test_reasons_other1.style.display = "none";
  test_reasons_other.style.display = "none";
}
