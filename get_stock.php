<?php
$conn = new mysqli("localhost", "root", "", "garage");
$result = $conn->query("SELECT * FROM stock");
$data = [];

while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

echo json_encode($data);
?>