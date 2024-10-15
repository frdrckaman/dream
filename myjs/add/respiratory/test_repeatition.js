const test_repeatition1 = document.getElementById("test_repeatition1");
const test_repeatition2 = document.getElementById("test_repeatition2");

const Repeatable_Table = document.getElementById("Repeatable_Table");
const microscopy_reason = document.getElementById("microscopy_reason");

function toggleElementVisibility() {
  if (test_repeatition1.checked) {
    Repeatable_Table.style.display = "block";
    microscopy_reason.style.display = "none";
  } else if (test_repeatition2.checked) {
    Repeatable_Table.style.display = "none";
    microscopy_reason.style.display = "block";
  } else {
    Repeatable_Table.style.display = "none";
    microscopy_reason.style.display = "none";
  }
}

test_repeatition1.addEventListener("change", toggleElementVisibility);
test_repeatition2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
