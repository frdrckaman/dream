const tb_diagnosed_clinically96 = document.getElementById(
  "tb_diagnosed_clinically96"
);

const tb_clinically_other1 = document.getElementById("tb_clinically_other1");
const tb_clinically_other = document.getElementById("tb_clinically_other");

tb_diagnosed_clinically96.addEventListener("change", function () {
  if (this.checked) {
    tb_clinically_other1.style.display = "block";
    tb_clinically_other.style.display = "block";
  } else {
    tb_clinically_other1.style.display = "none";
    tb_clinically_other.style.display = "none";
  }
});

// Initial check
if (tb_diagnosed_clinically96.checked) {
  tb_clinically_other1.style.display = "block";
  tb_clinically_other.style.display = "block";
} else {
  tb_clinically_other1.style.display = "none";
  tb_clinically_other.style.display = "none";
}
