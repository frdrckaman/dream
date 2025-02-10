<?php
// $data = file_get_contents("https://192.168.100.106/penplus-edc/api.php?api_key=your_secure_api_key");
$data = file_get_contents("http://192.168.100.106/penplus-edc/api.php");

print_r($data);
?>