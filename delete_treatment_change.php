<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$data = json_decode(file_get_contents("php://input"), true);
$response = ['message' => 'No record deleted.'];

if (!empty($data['id'])) {
    $user->deleteRecord('treatment_changes','id',$data['id']);
    $successMessage = 'Position Successful Updated';
    $response['message'] = 'Record deleted successfully!';
}

echo json_encode($response);
?>


<?php
// $pdo = new PDO("mysql:host=localhost;dbname=your_database", "username", "password");

// $id = $_POST['id'];

// $stmt = $pdo->prepare("DELETE FROM treatment_changes WHERE id = ?");
// $stmt->execute([$id]);

// echo "Record deleted successfully!";
?>
