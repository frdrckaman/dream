// $(document).ready(function () {
//     // Submit Add Form
//     $("#addMedForm_Ajax").submit(function (e) {
//         e.preventDefault();
//         $.ajax({
//             url: "regimes_changes/save_med.php", // Backend PHP file to process form
//             type: "POST",
//             data: $(this).serialize(),
//             success: function (response) {
//                 alert("Regimen added successfully!");
//                 location.reload(); // Reload the page to update table
//             },
//             error: function () {
//                 alert("Error adding regimen.");
//             }
//         });
//     });

//     // Submit Update Form
//     $(".update-form").submit(function (e) {
//         e.preventDefault();
//         let form = $(this);
//         $.ajax({
//             url: "update_med.php", // Backend PHP file to process update
//             type: "POST",
//             data: form.serialize(),
//             success: function (response) {
//                 alert("Regimen updated successfully!");
//                 location.reload();
//             },
//             error: function () {
//                 alert("Error updating regimen.");
//             }
//         });
//     });

//     // Delete Regimen (Without Page Reload)
//     $(".delete-form").submit(function (e) {
//         e.preventDefault();
//         let form = $(this);
//         let confirmed = confirm("Are you sure you want to delete this regimen?");
//         if (confirmed) {
//             $.ajax({
//                 url: "delete_med.php", // Backend PHP file for deletion
//                 type: "POST",
//                 data: form.serialize(),
//                 success: function (response) {
//                     alert("Regimen deleted successfully!");
//                     form.closest(".modal").modal("hide"); // Close modal
//                     location.reload(); // Refresh data
//                 },
//                 error: function () {
//                     alert("Error deleting regimen.");
//                 }
//             });
//         }
//     });
// });
