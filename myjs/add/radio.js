// function unsetRadio(radioGroupName) {
//   const radios = document.getElementsByName(radioGroupName);
//   radios.forEach((radio) => {
//     radio.checked = false;
//   });
// }

// function unsetRadio(radioName) {
//   console.log("Function is being called for:", radioName); // Debugging step
//   const radios = document.getElementsByName(radioName);

//   for (let i = 0; i < radios.length; i++) {
//     radios[i].checked = false;
//   }
// }

function unsetRadio(radioName) {
  const radios = document.getElementsByName(radioName);
  radios.forEach((radio) => console.log(radio.checked)); // Log state of radios

  for (let i = 0; i < radios.length; i++) {
    radios[i].checked = false;
  }
}
