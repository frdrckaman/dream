const wrd_test1 = document.getElementById("wrd_test1");
const wrd_test2 = document.getElementById("wrd_test2");
const wrd_test3 = document.getElementById("wrd_test3");

const wrd_test_date1 = document.getElementById("wrd_test_date1");
const wrd_test_date = document.getElementById("wrd_test_date");
const sequence_done = document.getElementById("sequence_done");

function toggleElementVisibility() {
  if (wrd_test3.checked) {
    wrd_test_date1.style.display = "block";
    wrd_test_date.style.display = "block";
    sequence_done.style.display = "block";
  } else {
    wrd_test_date1.style.display = "none";
    wrd_test_date.style.display = "none";
    sequence_done.style.display = "none";
  }
}

wrd_test1.addEventListener("change", toggleElementVisibility);
wrd_test2.addEventListener("change", toggleElementVisibility);
wrd_test3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
