const test_repeatition2_1_1 = document.getElementById("test_repeatition2_1");
const test_repeatition2_2_2 = document.getElementById("test_repeatition2_2");

const Repeatable_Table2_1 = document.getElementById("Repeatable_Table2_1");
const microscopy_reason2_0 = document.getElementById("microscopy_reason2_0");

function toggleElementVisibility() {
  if (test_repeatition2_1_1.checked) {
    Repeatable_Table2_1.style.display = "block";
    microscopy_reason2_0.style.display = "none";
  } else if (test_repeatition2_2_2.checked) {
    Repeatable_Table2_1.style.display = "none";
    microscopy_reason2_0.style.display = "block";
  } else {
    Repeatable_Table2_1.style.display = "none";
    microscopy_reason2_0.style.display = "none";
  }
}

test_repeatition2_1_1.addEventListener("change", toggleElementVisibility);
test_repeatition2_2_2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
