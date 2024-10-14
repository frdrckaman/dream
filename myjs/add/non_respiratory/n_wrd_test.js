const wrd_test2_1 = document.getElementById("wrd_test2_1");
const wrd_test2_2 = document.getElementById("wrd_test2_2");
const wrd_test2_3 = document.getElementById("wrd_test2_3");

const wrd_test_date2_1 = document.getElementById("wrd_test_date2_1");
const wrd_test_date2_2 = document.getElementById("wrd_test_date2_2");
const sequence_done2_0 = document.getElementById("sequence_done2_0");

function toggleElementVisibility() {
  if (wrd_test2_3.checked) {
    wrd_test_date2_1.style.display = "block";
    wrd_test_date2_2.style.display = "block";
    sequence_done2_0.style.display = "block";
  } else {
    wrd_test_date2_1.style.display = "none";
    wrd_test_date2_2.style.display = "none";
    sequence_done2_0.style.display = "none";
  }
}

wrd_test2_1.addEventListener("change", toggleElementVisibility);
wrd_test2_2.addEventListener("change", toggleElementVisibility);
wrd_test2_3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
