const receive_art1 = document.getElementById("receive_art1");
const receive_art2 = document.getElementById("receive_art2");

const start_art1 = document.getElementById("start_art1");
const start_art = document.getElementById("start_art");

function toggleElementVisibility() {
  if (receive_art1.checked) {
    start_art1.style.display = "block";
    start_art.style.display = "block";
    start_art.setAttribute("required", "required");
  } else {
    start_art1.style.display = "none";
    start_art.style.display = "none";
    start_art.removeAttribute("required");
  }
}

receive_art1.addEventListener("change", toggleElementVisibility);
receive_art2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
