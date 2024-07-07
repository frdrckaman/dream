function toggleElement(elementId, value) {
  const element = document.getElementById(elementId);
  if (element) {
    if (value === "1") {
      element.style.display = "block";
    } else if (value === "2") {
      element.style.display = "none";
    } else {
      element.style.display = "none";
    }
  } else {
    console.error("Element not found");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const yesRadio = document.getElementById("tx_previous1");
    const noRadio = document.getElementById("tx_previous2");
    
      const chest_x_ray1 = document.getElementById("chest_x_ray1");
    const chest_x_ray2 = document.getElementById("chest_x_ray2");
    
  if (yesRadio.checked) {
    toggleElement("tx_previous_hide", yesRadio.value);
  } else if (chest_x_ray2.checked) {
    toggleElement("tx_previous_hide", noRadio.value);
  }

//   if (chest_x_ray1.checked) {
//     toggleElement("chest_x_ray1", chest_x_ray1.value);
//   } else if (chest_x_ray2.checked) {
//     toggleElement("chest_x_ray2", chest_x_ray2.value);
//   }
});

// document.addEventListener("DOMContentLoaded", function () {
//   const radios = document.querySelectorAll('input[type="radio"]');
//   radios.forEach(function (radio) {
//     if (radio.checked) {
//       toggleElement(
//         radio.name.replace("toggleRadio-", "content-to-toggle-"),
//         radio.value
//       );
//     }
//   });
// });
