// document.addEventListener('DOMContentLoaded', () => {
//     const dobInput = document.getElementById('dob');
//     const ageInput = document.getElementById('age');

//     // Function to toggle visibility based on input values
//     const toggleFields = () => {
//         if (dobInput.value.trim() !== '') {
//             ageInput.parentElement.parentElement.style.display = 'none'; // Hide Age field
//         } else {
//             ageInput.parentElement.parentElement.style.display = 'block'; // Show Age field
//         }

//         if (ageInput.value.trim() !== '') {
//             dobInput.parentElement.parentElement.style.display = 'none'; // Hide DOB field
//         } else {
//             dobInput.parentElement.parentElement.style.display = 'block'; // Show DOB field
//         }
//     };

//     // Add event listeners
//     dobInput.addEventListener('input', toggleFields);
//     ageInput.addEventListener('input', toggleFields);

//     // Initialize visibility on page load
//     toggleFields();
// });


// document.addEventListener('input', () => {
//     const dobInput = document.getElementById('dob');
//     const ageInput = document.getElementById('age');

//     if (dobInput.value.trim() !== '') {
//         ageInput.parentElement.style.display = 'none'; // Hide the age field
//     } else {
//         ageInput.parentElement.style.display = 'block'; // Show the age field
//     }

//     if (ageInput.value.trim() !== '') {
//         dobInput.parentElement.style.display = 'none'; // Hide the DOB field
//     } else {
//         dobInput.parentElement.style.display = 'block'; // Show the DOB field
//     }
// });
