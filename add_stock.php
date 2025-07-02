<?php
$conn = new mysqli("localhost", "root", "", "garage");

$name = $_POST['name'];
$price = $_POST['price'];
$barcode = $_POST['barcode'];

// ตรวจว่าเคยมีหรือยัง
$result = $conn->query("SELECT * FROM stock WHERE barcode = '$barcode'");
if ($result->num_rows > 0) {
  $conn->query("UPDATE stock SET quantity = quantity + 1 WHERE barcode = '$barcode'");
  echo "เพิ่มจำนวนในสต๊อกแล้ว";
} else {
  $conn->query("INSERT INTO stock (name, price, barcode, quantity) VALUES ('$name', $price, '$barcode', 1)");
  echo "เพิ่มอะไหล่ใหม่เข้าสต๊อกแล้ว";
}
?>