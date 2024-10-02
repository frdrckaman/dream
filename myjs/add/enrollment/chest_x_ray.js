const chest_x_ray1 = document.getElementById("chest_x_ray1");
const chest_x_ray2 = document.getElementById("chest_x_ray2");


const chest_x_ray_date1 = document.getElementById("chest_x_ray_date1");

function toggleElementVisibility() {
  if (chest_x_ray1.checked) {
    chest_x_ray_date1.style.display = "block";
  } else {
    chest_x_ray_date1.style.display = "none";
  }
}

chest_x_ray1.addEventListener("change", toggleElementVisibility);
chest_x_ray2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();

