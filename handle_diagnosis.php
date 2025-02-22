<?php
// Start session and include necessary files

// if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
//     header('Content-Type: application/json');

//     if (isset($_POST['add_drug_changes'])) {
//         // Process add medication logic
//         $result = $user->addTreatmentChanges($_POST);
//         echo json_encode(['success' => $result, 'message' => $result ? 'Added successfully' : 'Error adding']);
//         exit;
//     }

//     if (isset($_POST['update_drug_changes'])) {
//         // Process update logic
//         $result = $user->updateTreatmentChanges($_POST);
//         echo json_encode(['success' => $result, 'message' => $result ? 'Updated successfully' : 'Error updating']);
//         exit;
//     }

//     if (isset($_POST['delete_drug_changes'])) {
//         // Process delete logic
//         $result = $user->deleteTreatmentChanges($_POST['id']);
//         echo json_encode(['success' => $result, 'message' => $result ? 'Deleted successfully' : 'Error deleting']);
//         exit;
//     }
// }

// Handle non-AJAX requests normally
?>