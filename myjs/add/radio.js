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

  const test_reasons966 = document.getElementById("test_reasons96");

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

//   if (test_reasons966.checked) {
//     toggleElement("test_reasons96", test_reasons966.value);
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



function unsetRadio(radioGroupName) {
  const radios = document.getElementsByName(radioGroupName);
  radios.forEach((radio) => {
    radio.checked = false;
  });
}
