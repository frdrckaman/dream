<?php
// // fetch_dates.php
// require_once 'php/core/init.php';
// $user = new User();
// $override = new OverideData();
// $email = new Email();
// $random = new Random();

// header('Content-Type: application/json');

// $clientId = $_GET['client_id']; // Get the client ID from the request

// // Fetch screening_date and consent_date from the database
// $result = $override->get('screening','id', $clientId)[0];

// $screening_date = $result['screening_date'];
// $consent_date = $result['conset_date'];

// // Return the dates as JSON
// if ($screening_date && $consent_date) {
//     echo json_encode([
//         'success' => true,
//         'screening_date' => $screening_date,
//         'consent_date' => $consent_date,
//     ]);
// } else {
//     echo json_encode([
//         'success' => false,
//         'message' => 'Dates not found for the given client ID.',
//     ]);
// }
?>