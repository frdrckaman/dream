const test_repeatition1 = document.getElementById("test_repeatition1");
const test_repeatition2 = document.getElementById("test_repeatition2");

const microscopy_reason = document.getElementById("microscopy_reason");


function toggleElementVisibility() {
  if (test_repeatition2.checked) {
    microscopy_reason.style.display = "block";
  } else {
    microscopy_reason.style.display = "none";
  }
}

test_repeatition1.addEventListener("change", toggleElementVisibility);
test_repeatition2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
